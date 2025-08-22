<?php
if (!defined('ABSPATH')) {
    exit;
}

class COF_Email {
    
    private $queue;
    private $logger;
    private $database;
    
    public function __construct() {
        $this->queue    = new COF_Email_Queue();
        $this->logger   = new COF_Logger();
        $this->database = new COF_Database();
        
        add_action('cof_form_submitted', array($this, 'handle_form_submission'), 10, 2);
        add_action('cof_process_email_queue', array($this, 'process_queue'));
        
        // Schedule queue processing every 5 minutes
        if (!wp_next_scheduled('cof_process_email_queue')) {
            wp_schedule_event(time(), 'five_minutes', 'cof_process_email_queue');
        }
        
        // Add custom schedule
        add_filter('cron_schedules', array($this, 'add_cron_schedules'));
    }
    
    public function add_cron_schedules($schedules) {
        $schedules['five_minutes'] = array(
            'interval' => 300, // 5 minutes
            'display'  => __('Every 5 Minutes', 'client-onboarding-form')
        );
        return $schedules;
    }
    
    public function handle_form_submission($submission_id, $form_data) {
        if (!get_option('cof_email_notifications', '1')) {
            $this->database->update_submission($submission_id, array(
                'email_status' => 'disabled'
            ));
            return;
        }
        
        // Update status to processing
        $this->database->update_submission($submission_id, array(
            'email_status' => 'processing'
        ));
        
        $admin_sent  = $this->send_admin_notification($submission_id, $form_data);
        $client_sent = $this->send_client_confirmation($submission_id, $form_data);
        
        if ($admin_sent && $client_sent) {
            $this->database->update_submission($submission_id, array(
                'email_status'      => 'sent',
                'email_sent_at'     => current_time('mysql'),
                'admin_notified_at' => current_time('mysql'),
                'client_notified_at'=> current_time('mysql')
            ));
        } else {
            $this->database->update_submission($submission_id, array(
                'email_status' => 'failed'
            ));
        }
    }
    
    public function send_admin_notification($submission_id, $form_data) {
        $admin_email = get_option('cof_admin_email', get_option('admin_email'));
        
        if (empty($admin_email)) {
            $this->logger->log('Admin email not configured', 'error', 'email');
            return false;
        }
        
        $subject = sprintf(__('New Client Onboarding Submission #%d', 'client-onboarding-form'), $submission_id);
        
        $message = $this->render_template('admin-notification', array(
            'submission_id'   => $submission_id,
            'form_data'       => $form_data,
            'submission_date' => current_time('mysql'),
            'site_url'        => get_site_url()
        ));
        
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <' . $admin_email . '>'
        );
        
        // Try direct send first
        $direct_sent = wp_mail($admin_email, $subject, $message, $headers);
        
        if ($direct_sent) {
            $this->logger->log("Admin notification sent directly for submission #$submission_id", 'info', 'email');
            return true;
        }
        
        // Fallback to queue
        $this->logger->log("Direct send failed, queued admin email for submission #$submission_id", 'warning', 'email');
        return $this->queue->add_email($admin_email, $subject, $message, $headers);
    }
    
    public function send_client_confirmation($submission_id, $form_data) {
        $client_email = $form_data['contact_email'];
        
        if (empty($client_email) || !is_email($client_email)) {
            $this->logger->log("Invalid client email for submission #$submission_id", 'error', 'email');
            return false;
        }
        
        $subject = __('Thank You for Your Submission', 'client-onboarding-form');
        
        $message = $this->render_template('client-confirmation', array(
            'submission_id'   => $submission_id,
            'form_data'       => $form_data,
            'contact_name'    => $form_data['contact_name'],
            'business_name'   => $form_data['business_name'],
            'submission_date' => current_time('mysql'),
            'company_name'    => get_bloginfo('name'),
            'support_email'   => get_option('cof_admin_email', get_option('admin_email'))
        ));
        
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <' . get_option('cof_admin_email', get_option('admin_email')) . '>'
        );
        
        // Try direct send first
        $direct_sent = wp_mail($client_email, $subject, $message, $headers);
        
        if ($direct_sent) {
            $this->logger->log("Client confirmation sent directly for submission #$submission_id", 'info', 'email');
            return true;
        }
        
        // Fallback to queue
        $this->logger->log("Direct send failed, queued client email for submission #$submission_id", 'warning', 'email');
        return $this->queue->add_email($client_email, $subject, $message, $headers);
    }
    
    private function render_template($template, $data) {
        $template_file = COF_PLUGIN_DIR . 'templates/' . $template . '-template.php';
        
        if (file_exists($template_file)) {
            ob_start();
            extract($data);
            include $template_file;
            return ob_get_clean();
        }
        
        // fallback
        return $this->get_fallback_template($template, $data);
    }
    
    private function get_fallback_template($template, $data) {
        extract($data);
        
        if ($template === 'admin-notification') {
            return "
            <h2>New Client Onboarding Submission</h2>
            <p><strong>Submission ID:</strong> #$submission_id</p>
            <p><strong>Date:</strong> " . date('F j, Y g:i a', strtotime($submission_date)) . "</p>
            <p><strong>Business:</strong> " . esc_html($form_data['business_name']) . "</p>
            <p><strong>Contact:</strong> " . esc_html($form_data['contact_name']) . " (" . esc_html($form_data['contact_email']) . ")</p>
            <p><strong>Project:</strong> " . esc_html($form_data['project_name']) . "</p>
            <p>View the submission in WordPress admin.</p>";
        }
        
        // client-confirmation fallback
        return "
        <h2>Thank You for Your Submission</h2>
        <p>Dear " . esc_html($contact_name) . ",</p>
        <p>Thank you for submitting your information to " . esc_html($company_name) . ".</p>
        <p>We’ve received your details. Summary:</p>
        <p><strong>Business:</strong> " . esc_html($business_name) . "</p>
        <p><strong>Project:</strong> " . esc_html($form_data['project_name']) . "</p>
        <p><strong>Reference ID:</strong> #$submission_id</p>
        <p>If you have any questions, email us at " . esc_html($support_email) . ".</p>
        <p>Best regards,<br>The " . esc_html($company_name) . " Team</p>";
    }
    
    public function process_queue() {
        $processed = $this->queue->process_queue();
        $this->logger->log("Processed $processed queued emails", 'info', 'email');
    }
}
