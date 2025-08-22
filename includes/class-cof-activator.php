<?php
if (!defined('ABSPATH')) {
    exit;
}

class COF_Activator {
    
    public static function activate() {
        global $wpdb;
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        
        // Create submissions table
        $table_name = $wpdb->prefix . 'cob_submissions';
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            business_name varchar(255) NOT NULL,
            website_url varchar(255),
            business_address text,
            business_description text,
            contact_name varchar(255) NOT NULL,
            contact_email varchar(255) NOT NULL,
            contact_phone varchar(50),
            project_name varchar(255) NOT NULL,
            project_budget varchar(50),
            project_timeline varchar(50),
            project_goals text,
            target_audience text,
            services_needed text,
            additional_services text,
            brand_personality text,
            brand_values text,
            competitor_analysis text,
            marketing_goals text,
            current_challenges text,
            success_metrics text,
            additional_notes text,
            status varchar(20) DEFAULT 'draft',
            email_status varchar(20) DEFAULT 'pending',
            email_sent_at datetime,
            admin_notified_at datetime,
            client_notified_at datetime,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            session_id varchar(32),
            ip_address varchar(45),
            user_agent text,
            PRIMARY KEY  (id),
            KEY status (status),
            KEY session_id (session_id),
            KEY email_status (email_status)
        ) $charset_collate;";
        
        dbDelta($sql);
        
        // Create queue table for email and webhook queue
        $queue_table = $wpdb->prefix . 'cob_queue';
        $sql_queue = "CREATE TABLE $queue_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            type varchar(20) NOT NULL DEFAULT 'email',
            payload text NOT NULL,
            status varchar(20) DEFAULT 'pending',
            attempts smallint(3) DEFAULT 0,
            max_attempts smallint(3) DEFAULT 3,
            next_attempt datetime,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            processed_at datetime,
            PRIMARY KEY  (id),
            KEY status (status),
            KEY type (type),
            KEY next_attempt (next_attempt)
        ) $charset_collate;";
        
        dbDelta($sql_queue);
        
        // Create logs table
        $logs_table = $wpdb->prefix . 'cob_logs';
        $sql_logs = "CREATE TABLE $logs_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            level varchar(20) NOT NULL DEFAULT 'info',
            message text NOT NULL,
            context text,
            source varchar(100),
            ip_address varchar(45),
            user_id bigint(20),
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            KEY level (level),
            KEY source (source),
            KEY created_at (created_at)
        ) $charset_collate;";
        
        dbDelta($sql_logs);
        
        // Set default options
        update_option('cof_version', COF_VERSION);
        update_option('cof_admin_email', get_option('admin_email'));
        update_option('cof_email_notifications', '1');
        update_option('cof_auto_save', '1');
        update_option('cof_auto_save_interval', '30');
        
        // Flush rewrite rules
        flush_rewrite_rules();
        
        // Log activation
        if (function_exists('cof_log')) {
            cof_log('Plugin activated', 'system', 'activation');
        }
    }
}
