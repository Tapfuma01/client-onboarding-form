<?php
if (!defined('ABSPATH')) {
    exit;
}

class COF_Logger {
    
    private $wpdb;
    private $table_name;
    
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $wpdb->prefix . 'cob_logs';
    }
    
    public function log($message, $level = 'info', $source = 'system', $context = array()) {
        $data = array(
            'level' => $this->sanitize_level($level),
            'message' => sanitize_text_field($message),
            'source' => sanitize_text_field($source),
            'context' => $context ? maybe_serialize($context) : null,
            'ip_address' => $this->get_client_ip(),
            'user_id' => get_current_user_id()
        );
        
        return $this->wpdb->insert(
            $this->table_name,
            $data,
            array('%s', '%s', '%s', '%s', '%s', '%d')
        );
    }
    
    public function get_logs($limit = 100, $offset = 0, $level = null, $source = null) {
        $where = array();
        $prepare_args = array();
        
        if ($level) {
            $where[] = 'level = %s';
            $prepare_args[] = $level;
        }
        
        if ($source) {
            $where[] = 'source = %s';
            $prepare_args[] = $source;
        }
        
        $where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        
        $prepare_args[] = $limit;
        $prepare_args[] = $offset;
        
        $query = $this->wpdb->prepare(
            "SELECT * FROM $this->table_name $where_sql ORDER BY created_at DESC LIMIT %d OFFSET %d",
            $prepare_args
        );
        
        return $this->wpdb->get_results($query, ARRAY_A);
    }
    
    public function get_log_count($level = null, $source = null) {
        $where = array();
        $prepare_args = array();
        
        if ($level) {
            $where[] = 'level = %s';
            $prepare_args[] = $level;
        }
        
        if ($source) {
            $where[] = 'source = %s';
            $prepare_args[] = $source;
        }
        
        $where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        
        if ($where_sql) {
            $query = $this->wpdb->prepare(
                "SELECT COUNT(*) FROM $this->table_name $where_sql",
                $prepare_args
            );
        } else {
            $query = "SELECT COUNT(*) FROM $this->table_name";
        }
        
        return $this->wpdb->get_var($query);
    }
    
    public function clear_old_logs($days = 30) {
        $date = date('Y-m-d H:i:s', strtotime("-$days days"));
        
        return $this->wpdb->query(
            $this->wpdb->prepare(
                "DELETE FROM $this->table_name WHERE created_at < %s",
                $date
            )
        );
    }
    
    private function sanitize_level($level) {
        $allowed_levels = array('emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug');
        return in_array($level, $allowed_levels) ? $level : 'info';
    }
    
    private function get_client_ip() {
        $ip = '';
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '';
    }
}

// Helper function for easy logging
function cof_log($message, $source = 'system', $level = 'info', $context = array()) {
    static $logger = null;
    
    if (null === $logger) {
        $logger = new COF_Logger();
    }
    
    return $logger->log($message, $level, $source, $context);
}