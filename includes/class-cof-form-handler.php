<?php
if (!defined('ABSPATH')) {
    exit;
}

class COF_Form_Handler {
    
    private $database;
    private $logger;
    private $current_step = 1;
    private $form_data = array();
    
    public function __construct() {
        $this->database = new COF_Database();
        $this->logger = new COF_Logger();
        
        add_action('wp_ajax_cof_submit_form', array($this, 'handle_form_submission'));
        add_action('wp_ajax_nopriv_cof_submit_form', array($this, 'handle_form_submission'));
        add_action('wp_ajax_cof_save_draft', array($this, 'handle_draft_save'));
        add_action('wp_ajax_nopriv_cof_save_draft', array($this, 'handle_draft_save'));
    }
    
    public function render_form($atts) {
        wp_enqueue_style('cof-public-style');
        wp_enqueue_script('cof-public-script');
        
        // Get session ID for draft saving
        $session_id = $this->get_session_id();
        
        ob_start();
        include COF_PLUGIN_DIR . 'public/views/form-template.php';
        return ob_get_clean();
    }
    
    public function handle_form_submission() {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'cof_form_nonce')) {
            wp_send_json_error(array('message' => __('Security check failed', 'client-onboarding-form')));
        }
        
        if (!isset($_POST['step']) || !isset($_POST['data'])) {
            wp_send_json_error(array('message' => __('Invalid request', 'client-onboarding-form')));
        }
        
        $step = intval($_POST['step']);
        $data = $this->sanitize_step_data($step, $_POST['data']);
        
        // Validate step data
        $errors = $this->validate_step_data($step, $data);
        if (!empty($errors)) {
            wp_send_json_error(array('message' => implode('<br>', $errors)));
        }
        
        if ($step === 6) {
            // Final submission
            $submission_data = array_merge($this->form_data, $data);
            $submission_data['status'] = 'completed';
            $submission_data['session_id'] = $this->get_session_id();
            $submission_data['ip_address'] = $this->get_client_ip();
            $submission_data['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';
            
            $submission_id = $this->database->create_submission($submission_data);
            
            if ($submission_id) {
                // Trigger email notifications
                do_action('cof_form_submitted', $submission_id, $submission_data);
                
                // Log submission
                $this->logger->log(
                    sprintf('New form submission #%d from %s', $submission_id, $submission_data['business_name'] ?? 'Unknown'),
                    'info',
                    'submission',
                    array('submission_id' => $submission_id)
                );
                
                wp_send_json_success(array(
                    'message' => __('Form submitted successfully!', 'client-onboarding-form'),
                    'submission_id' => $submission_id
                ));
            } else {
                $this->logger->log(
                    'Failed to create submission',
                    'error',
                    'submission',
                    array('data' => $submission_data)
                );
                
                wp_send_json_error(array(
                    'message' => __('Error submitting form. Please try again.', 'client-onboarding-form')
                ));
            }
        } else {
            // Store step data and proceed to next step
            $this->form_data = array_merge($this->form_data, $data);
            
            // Auto-save draft if enabled
            if (get_option('cof_auto_save', '1') && $step > 1) {
                $this->save_draft($this->form_data);
            }
            
            wp_send_json_success(array('next_step' => $step + 1));
        }
    }
    
    public function handle_draft_save() {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'cof_form_nonce')) {
            wp_send_json_error(array('message' => __('Security check failed', 'client-onboarding-form')));
        }
        
        if (!isset($_POST['data'])) {
            wp_send_json_error(array('message' => __('No data to save', 'client-onboarding-form')));
        }
        
        $data = $this->sanitize_draft_data($_POST['data']);
        $result = $this->save_draft($data);
        
        if ($result) {
            wp_send_json_success(array('message' => __('Draft saved successfully', 'client-onboarding-form')));
        } else {
            wp_send_json_error(array('message' => __('Error saving draft', 'client-onboarding-form')));
        }
    }
    
    private function save_draft($data) {
        $draft_data = array_merge($data, array(
            'status' => 'draft',
            'session_id' => $this->get_session_id(),
            'ip_address' => $this->get_client_ip(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
        ));
        
        // Check if draft already exists for this session
        $existing_draft = $this->database->get_draft_by_session($this->get_session_id());
        
        if ($existing_draft) {
            return $this->database->update_submission($existing_draft['id'], $draft_data);
        } else {
            return $this->database->create_submission($draft_data);
        }
    }
    
    private function get_session_id() {
        if (!session_id()) {
            session_start();
        }
        
        if (empty($_SESSION['cof_session_id'])) {
            $_SESSION['cof_session_id'] = wp_generate_password(32, false);
        }
        
        return $_SESSION['cof_session_id'];
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
    
    private function sanitize_step_data($step, $data) {
        $sanitized = array();
        
        switch ($step) {
            case 2: // Business Information
                $sanitized['project_name'] = sanitize_text_field($data['project_name'] ?? '');
                $sanitized['business_name'] = sanitize_text_field($data['business_name'] ?? '');
                $sanitized['contact_name'] = sanitize_text_field($data['contact_name'] ?? '');
                $sanitized['contact_email'] = sanitize_email($data['contact_email'] ?? '');
                $sanitized['contact_phone'] = sanitize_text_field($data['contact_phone'] ?? '');
                $sanitized['milestone_approver'] = sanitize_text_field($data['milestone_approver'] ?? '');
                $sanitized['billing_email'] = sanitize_email($data['billing_email'] ?? '');
                $sanitized['vat_number'] = sanitize_text_field($data['vat_number'] ?? '');
                $sanitized['preferred_contact'] = sanitize_text_field($data['preferred_contact'] ?? '');
                $sanitized['address_line1'] = sanitize_text_field($data['address_line1'] ?? '');
                $sanitized['address_line2'] = sanitize_text_field($data['address_line2'] ?? '');
                $sanitized['city'] = sanitize_text_field($data['city'] ?? '');
                $sanitized['country'] = sanitize_text_field($data['country'] ?? '');
                $sanitized['postal_code'] = sanitize_text_field($data['postal_code'] ?? '');
                break;
                
            case 3: // Technical Information
                $sanitized['project_budget'] = sanitize_text_field($data['project_budget'] ?? '');
                $sanitized['project_timeline'] = sanitize_text_field($data['project_timeline'] ?? '');
                $sanitized['website_url'] = esc_url_raw($data['website_url'] ?? '');
                $sanitized['project_goals'] = sanitize_textarea_field($data['project_goals'] ?? '');
                $sanitized['target_audience'] = sanitize_textarea_field($data['target_audience'] ?? '');
                break;
                
            case 4: // Reporting Information
                $sanitized['services_needed'] = isset($data['services']) ? array_map('sanitize_text_field', $data['services']) : array();
                $sanitized['reporting_requirements'] = sanitize_textarea_field($data['reporting_requirements'] ?? '');
                break;
                
            case 5: // Marketing Information
                $sanitized['business_description'] = sanitize_textarea_field($data['business_description'] ?? '');
                $sanitized['brand_personality'] = sanitize_textarea_field($data['brand_personality'] ?? '');
                $sanitized['brand_values'] = sanitize_textarea_field($data['brand_values'] ?? '');
                $sanitized['competitor_analysis'] = sanitize_textarea_field($data['competitor_analysis'] ?? '');
                $sanitized['marketing_goals'] = sanitize_textarea_field($data['marketing_goals'] ?? '');
                $sanitized['current_challenges'] = sanitize_textarea_field($data['current_challenges'] ?? '');
                $sanitized['success_metrics'] = sanitize_textarea_field($data['success_metrics'] ?? '');
                break;
                
            case 6: // Review & Submit
                $sanitized['additional_notes'] = sanitize_textarea_field($data['additional_notes'] ?? '');
                break;
        }
        
        return $sanitized;
    }
    
    private function validate_step_data($step, $data) {
        $errors = array();
        
        switch ($step) {
            case 2:
                if (empty($data['project_name'])) {
                    $errors[] = __('Project name is required', 'client-onboarding-form');
                }
                if (empty($data['business_name'])) {
                    $errors[] = __('Business name is required', 'client-onboarding-form');
                }
                if (empty($data['contact_name'])) {
                    $errors[] = __('Contact name is required', 'client-onboarding-form');
                }
                if (empty($data['contact_email']) || !is_email($data['contact_email'])) {
                    $errors[] = __('Valid contact email is required', 'client-onboarding-form');
                }
                break;
                
            case 3:
                // Technical information validation can be added here if needed
                break;
        }
        
        return $errors;
    }

    private function sanitize_draft_data($data) {
        // Basic recursive sanitization for drafts
        $sanitized = array();
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = array_map('sanitize_text_field', $value);
            } else {
                $sanitized[$key] = sanitize_text_field($value);
            }
        }
        return $sanitized;
    }
}
