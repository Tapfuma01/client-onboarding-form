<?php
if (!defined('ABSPATH')) {
    exit;
}

class COF_Database {
    
    private $wpdb;
    private $table_name;
    
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $wpdb->prefix . 'cob_submissions';
    }
    
    public function create_submission($data) {
        $defaults = array(
            'status' => 'pending',
            'created_at' => current_time('mysql'),
            'updated_at' => current_time('mysql')
        );
        
        $data = wp_parse_args($data, $defaults);
        $data = $this->sanitize_data($data);
        
        $result = $this->wpdb->insert(
            $this->table_name,
            $data,
            $this->get_format($data)
        );
        
        if ($result) {
            return $this->wpdb->insert_id;
        }
        
        return false;
    }
    
    public function get_submission($id) {
        $query = $this->wpdb->prepare(
            "SELECT * FROM $this->table_name WHERE id = %d",
            $id
        );
        
        return $this->wpdb->get_row($query, ARRAY_A);
    }
    
    public function get_submissions($limit = 20, $offset = 0) {
        $query = $this->wpdb->prepare(
            "SELECT * FROM $this->table_name ORDER BY created_at DESC LIMIT %d OFFSET %d",
            $limit,
            $offset
        );
        
        return $this->wpdb->get_results($query, ARRAY_A);
    }
    
    public function get_total_submissions() {
        return $this->wpdb->get_var("SELECT COUNT(*) FROM $this->table_name");
    }

    /** 🔹 New Methods for Draft Handling & Reporting */

    public function get_draft_by_session($session_id) {
        $query = $this->wpdb->prepare(
            "SELECT * FROM $this->table_name 
             WHERE session_id = %s AND status = 'draft' 
             ORDER BY created_at DESC LIMIT 1",
            $session_id
        );
        
        return $this->wpdb->get_row($query, ARRAY_A);
    }

    public function update_submission($id, $data) {
        $data = $this->sanitize_data($data);
        $data['updated_at'] = current_time('mysql');
        
        $formats = $this->get_format($data);
        
        return $this->wpdb->update(
            $this->table_name,
            $data,
            array('id' => $id),
            $formats,
            array('%d')
        );
    }

    public function get_submissions_by_status($status, $limit = 20, $offset = 0) {
        $query = $this->wpdb->prepare(
            "SELECT * FROM $this->table_name 
             WHERE status = %s 
             ORDER BY created_at DESC LIMIT %d OFFSET %d",
            $status, $limit, $offset
        );
        
        return $this->wpdb->get_results($query, ARRAY_A);
    }

    public function get_submission_count_by_status($status) {
        $query = $this->wpdb->prepare(
            "SELECT COUNT(*) FROM $this->table_name WHERE status = %s",
            $status
        );
        
        return $this->wpdb->get_var($query);
    }

    public function get_recent_submissions($days = 7) {
        $date = date('Y-m-d H:i:s', strtotime("-$days days"));
        
        $query = $this->wpdb->prepare(
            "SELECT DATE(created_at) as date, COUNT(*) as count 
             FROM $this->table_name 
             WHERE created_at >= %s 
             GROUP BY DATE(created_at) 
             ORDER BY date DESC",
            $date
        );
        
        return $this->wpdb->get_results($query, ARRAY_A);
    }
    
    /** 🔹 Utilities */
    
    private function sanitize_data($data) {
        $sanitized = array();
        
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = maybe_serialize(array_map('sanitize_text_field', $value));
            } else if ($key === 'website_url') {
                $sanitized[$key] = esc_url_raw($value);
            } else if ($key === 'contact_email') {
                $sanitized[$key] = sanitize_email($value);
            } else {
                $sanitized[$key] = sanitize_text_field($value);
            }
        }
        
        return $sanitized;
    }
    
    private function get_format($data) {
        $formats = array();
        
        foreach ($data as $value) {
            if (is_numeric($value)) {
                $formats[] = '%d';
            } else {
                $formats[] = '%s';
            }
        }
        
        return $formats;
    }
    
    public function table_exists() {
        return $this->wpdb->get_var("SHOW TABLES LIKE '{$this->table_name}'") === $this->table_name;
    }
}
