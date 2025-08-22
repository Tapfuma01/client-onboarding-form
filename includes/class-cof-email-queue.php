<?php
if (!defined('ABSPATH')) {
    exit;
}

class COF_Email_Queue {
    
    private $wpdb;
    private $table_name;
    
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $wpdb->prefix . 'cob_queue';
    }
    
    public function add_email($to, $subject, $message, $headers = array(), $attachments = array(), $priority = 'normal') {
        $payload = array(
            'to' => $to,
            'subject' => $subject,
            'message' => $message,
            'headers' => $headers,
            'attachments' => $attachments,
            'priority' => $priority
        );
        
        return $this->wpdb->insert(
            $this->table_name,
            array(
                'type' => 'email',
                'payload' => maybe_serialize($payload),
                'status' => 'pending',
                'next_attempt' => current_time('mysql')
            ),
            array('%s', '%s', '%s', '%s')
        );
    }
    
    public function process_queue($limit = 10) {
        $now = current_time('mysql');
        
        $items = $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT * FROM $this->table_name 
                 WHERE status = 'pending' AND next_attempt <= %s 
                 ORDER BY created_at ASC LIMIT %d",
                $now, $limit
            ),
            ARRAY_A
        );
        
        $processed = 0;
        
        foreach ($items as $item) {
            if ($this->process_item($item)) {
                $processed++;
            }
        }
        
        return $processed;
    }
    
    private function process_item($item) {
        $this->wpdb->update(
            $this->table_name,
            array(
                'status' => 'processing',
                'attempts' => $item['attempts'] + 1
            ),
            array('id' => $item['id']),
            array('%s', '%d'),
            array('%d')
        );
        
        $payload = maybe_unserialize($item['payload']);
        
        if ($item['type'] === 'email') {
            $success = $this->send_email($payload);
        } else {
            $success = false;
        }
        
        if ($success) {
            $this->wpdb->update(
                $this->table_name,
                array(
                    'status' => 'completed',
                    'processed_at' => current_time('mysql')
                ),
                array('id' => $item['id']),
                array('%s', '%s'),
                array('%d')
            );
            return true;
        } else {
            if ($item['attempts'] + 1 >= $item['max_attempts']) {
                $this->wpdb->update(
                    $this->table_name,
                    array('status' => 'failed'),
                    array('id' => $item['id']),
                    array('%s'),
                    array('%d')
                );
            } else {
                $next_attempt = date('Y-m-d H:i:s', strtotime('+5 minutes'));
                $this->wpdb->update(
                    $this->table_name,
                    array(
                        'status' => 'pending',
                        'next_attempt' => $next_attempt
                    ),
                    array('id' => $item['id']),
                    array('%s', '%s'),
                    array('%d')
                );
            }
            return false;
        }
    }
    
    private function send_email($payload) {
        return wp_mail(
            $payload['to'],
            $payload['subject'],
            $payload['message'],
            $payload['headers'],
            $payload['attachments']
        );
    }
    
    public function get_queue_stats() {
        return $this->wpdb->get_results(
            "SELECT status, COUNT(*) as count 
             FROM $this->table_name 
             GROUP BY status",
            ARRAY_A
        );
    }
    
    public function cleanup_old_items($days = 7) {
        $date = date('Y-m-d H:i:s', strtotime("-$days days"));
        
        return $this->wpdb->query(
            $this->wpdb->prepare(
                "DELETE FROM $this->table_name 
                 WHERE (status = 'completed' OR status = 'failed') 
                 AND created_at < %s",
                $date
            )
        );
    }
}