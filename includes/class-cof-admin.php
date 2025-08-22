<?php
if (!defined('ABSPATH')) {
    exit;
}

class COF_Admin {
    
    private $database;
    
    public function __construct() {
        $this->database = new COF_Database();
        
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_notices', array($this, 'maybe_show_settings_notices'));
    }

    /** -------------------------
     * Admin Menu
     --------------------------*/
    public function add_admin_menu() {
        add_menu_page(
            __('Client Onboarding', 'client-onboarding-form'),
            __('Client Onboarding', 'client-onboarding-form'),
            'manage_options',
            'client-onboarding',
            array($this, 'render_dashboard'),
            'dashicons-clipboard',
            30
        );
        
        add_submenu_page(
            'client-onboarding',
            __('Dashboard', 'client-onboarding-form'),
            __('Dashboard', 'client-onboarding-form'),
            'manage_options',
            'client-onboarding',
            array($this, 'render_dashboard')
        );
        
        add_submenu_page(
            'client-onboarding',
            __('Submissions', 'client-onboarding-form'),
            __('Submissions', 'client-onboarding-form'),
            'manage_options',
            'cof-submissions',
            array($this, 'render_submissions')
        );
        
        add_submenu_page(
            'client-onboarding',
            __('Settings', 'client-onboarding-form'),
            __('Settings', 'client-onboarding-form'),
            'manage_options',
            'cof-settings',
            array($this, 'render_settings')
        );
        
        add_submenu_page(
            'client-onboarding',
            __('Logs', 'client-onboarding-form'),
            __('Logs', 'client-onboarding-form'),
            'manage_options',
            'cof-logs',
            array($this, 'render_logs')
        );

        // Hidden page for submission details
        add_submenu_page(
            null,
            __('Submission Details', 'client-onboarding-form'),
            __('Submission Details', 'client-onboarding-form'),
            'manage_options',
            'cof-submission-detail',
            array($this, 'render_submission_detail')
        );
    }

    /** -------------------------
     * Admin Init (AJAX, etc.)
     --------------------------*/
    public function admin_init() {
        // AJAX: retry email
        add_action('wp_ajax_cof_retry_email', array($this, 'handle_retry_email'));
    }

    public function maybe_show_settings_notices() {
        settings_errors('cof_settings');
    }
    
    /** -------------------------
     * Dashboard
     --------------------------*/
    public function render_dashboard() {
        $total_submissions     = $this->database->get_total_submissions();
        $completed_submissions = $this->database->get_submission_count_by_status('completed');
        $draft_submissions     = $this->database->get_submission_count_by_status('draft');
        $recent_submissions    = $this->database->get_submissions(5);
        $recent_stats          = $this->database->get_recent_submissions(7);
        
        $view_file = COF_PLUGIN_DIR . 'admin/views/dashboard-view.php';
        if (file_exists($view_file)) {
            include $view_file;
        } else {
            $this->render_dashboard_inline($total_submissions, $completed_submissions, $draft_submissions, $recent_submissions, $recent_stats);
        }
    }

    private function render_dashboard_inline($total_submissions, $completed_submissions, $draft_submissions, $recent_submissions, $recent_stats) {
        ?>
        <div class="wrap">
            <h1><?php _e('Client Onboarding Dashboard', 'client-onboarding-form'); ?></h1>
            
            <div class="cof-dashboard">
                <div class="cof-stats-grid" style="display:flex;gap:16px;margin-top:16px;">
                    <div class="cof-stat-card" style="background:#fff;padding:16px;border:1px solid #eee;flex:1;">
                        <h3><?php echo esc_html($total_submissions); ?></h3>
                        <p><?php _e('Total Submissions', 'client-onboarding-form'); ?></p>
                    </div>
                    <div class="cof-stat-card" style="background:#fff;padding:16px;border:1px solid #eee;flex:1;">
                        <h3><?php echo esc_html($completed_submissions); ?></h3>
                        <p><?php _e('Completed', 'client-onboarding-form'); ?></p>
                    </div>
                    <div class="cof-stat-card" style="background:#fff;padding:16px;border:1px solid #eee;flex:1;">
                        <h3><?php echo esc_html($draft_submissions); ?></h3>
                        <p><?php _e('Drafts', 'client-onboarding-form'); ?></p>
                    </div>
                </div>
                
                <div class="cof-recent-submissions" style="margin-top:24px;">
                    <h2><?php _e('Recent Submissions', 'client-onboarding-form'); ?></h2>
                    <?php if (!empty($recent_submissions)): ?>
                        <table class="wp-list-table widefat fixed striped">
                            <thead>
                                <tr>
                                    <th><?php _e('ID', 'client-onboarding-form'); ?></th>
                                    <th><?php _e('Business Name', 'client-onboarding-form'); ?></th>
                                    <th><?php _e('Contact Name', 'client-onboarding-form'); ?></th>
                                    <th><?php _e('Project Name', 'client-onboarding-form'); ?></th>
                                    <th><?php _e('Date', 'client-onboarding-form'); ?></th>
                                    <th><?php _e('Actions', 'client-onboarding-form'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_submissions as $submission): ?>
                                    <tr>
                                        <td><?php echo esc_html($submission['id']); ?></td>
                                        <td><?php echo esc_html($submission['business_name']); ?></td>
                                        <td><?php echo esc_html($submission['contact_name']); ?></td>
                                        <td><?php echo esc_html($submission['project_name']); ?></td>
                                        <td><?php echo esc_html(date('M j, Y', strtotime($submission['created_at']))); ?></td>
                                        <td>
                                            <a class="button button-small" href="<?php echo esc_url( admin_url('admin.php?page=cof-submission-detail&id=' . intval($submission['id'])) ); ?>">
                                                <?php _e('View', 'client-onboarding-form'); ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p><?php _e('No submissions yet.', 'client-onboarding-form'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }

    /** -------------------------
     * Submissions
     --------------------------*/
    public function render_submissions() {
        $submissions = $this->database->get_submissions();
        
        $view_file = COF_PLUGIN_DIR . 'admin/views/submissions-view.php';
        if (file_exists($view_file)) {
            include $view_file;
        } else {
            $this->render_submissions_inline($submissions);
        }
    }

    private function render_submissions_inline($submissions) {
        ?>
        <div class="wrap">
            <h1><?php _e('Client Onboarding Submissions', 'client-onboarding-form'); ?></h1>
            <div class="cof-submissions">
                <?php if (!empty($submissions)): ?>
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th><?php _e('ID', 'client-onboarding-form'); ?></th>
                                <th><?php _e('Business Name', 'client-onboarding-form'); ?></th>
                                <th><?php _e('Contact Email', 'client-onboarding-form'); ?></th>
                                <th><?php _e('Project Name', 'client-onboarding-form'); ?></th>
                                <th><?php _e('Budget', 'client-onboarding-form'); ?></th>
                                <th><?php _e('Timeline', 'client-onboarding-form'); ?></th>
                                <th><?php _e('Submitted', 'client-onboarding-form'); ?></th>
                                <th><?php _e('Email Status', 'client-onboarding-form'); ?></th>
                                <th><?php _e('Actions', 'client-onboarding-form'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($submissions as $submission): ?>
                                <tr>
                                    <td><?php echo esc_html($submission['id']); ?></td>
                                    <td><?php echo esc_html($submission['business_name']); ?></td>
                                    <td><?php echo esc_html($submission['contact_email']); ?></td>
                                    <td><?php echo esc_html($submission['project_name']); ?></td>
                                    <td><?php echo esc_html($submission['project_budget']); ?></td>
                                    <td><?php echo esc_html($submission['project_timeline']); ?></td>
                                    <td><?php echo esc_html(date('M j, Y', strtotime($submission['created_at']))); ?></td>
                                    <td><?php echo isset($submission['email_status']) ? esc_html($submission['email_status']) : '-'; ?></td>
                                    <td>
                                        <a class="button button-small" href="<?php echo esc_url( admin_url('admin.php?page=cof-submission-detail&id=' . intval($submission['id'])) ); ?>">
                                            <?php _e('View', 'client-onboarding-form'); ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p><?php _e('No submissions found.', 'client-onboarding-form'); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    /** -------------------------
     * Settings
     --------------------------*/
    public function render_settings() {
        $this->handle_settings_form();
        
        $email_notifications = get_option('cof_email_notifications', '1');
        $auto_save           = get_option('cof_auto_save', '1');
        $auto_save_interval  = get_option('cof_auto_save_interval', '30');
        $admin_email         = get_option('cof_admin_email', get_option('admin_email'));
        
        $view_file = COF_PLUGIN_DIR . 'admin/views/settings-view.php';
        if (file_exists($view_file)) {
            include $view_file;
        } else {
            ?>
            <div class="wrap">
                <h1><?php _e('Client Onboarding Settings', 'client-onboarding-form'); ?></h1>
                <form method="post">
                    <?php wp_nonce_field('cof_save_settings', 'cof_settings_nonce'); ?>
                    
                    <table class="form-table">
                        <tr>
                            <th><?php _e('Email Notifications', 'client-onboarding-form'); ?></th>
                            <td><input type="checkbox" name="email_notifications" value="1" <?php checked($email_notifications, '1'); ?>></td>
                        </tr>
                        <tr>
                            <th><?php _e('Enable Auto Save', 'client-onboarding-form'); ?></th>
                            <td><input type="checkbox" name="auto_save" value="1" <?php checked($auto_save, '1'); ?>></td>
                        </tr>
                        <tr>
                            <th><?php _e('Auto Save Interval (seconds)', 'client-onboarding-form'); ?></th>
                            <td><input type="number" name="auto_save_interval" value="<?php echo esc_attr($auto_save_interval); ?>"></td>
                        </tr>
                        <tr>
                            <th><?php _e('Admin Email', 'client-onboarding-form'); ?></th>
                            <td><input type="email" name="admin_email" value="<?php echo esc_attr($admin_email); ?>"></td>
                        </tr>
                    </table>
                    
                    <?php submit_button(__('Save Settings', 'client-onboarding-form')); ?>
                </form>
            </div>
            <?php
        }
    }
    
    private function handle_settings_form() {
        if (isset($_POST['cof_settings_nonce']) && wp_verify_nonce($_POST['cof_settings_nonce'], 'cof_save_settings')) {
            update_option('cof_email_notifications', isset($_POST['email_notifications']) ? '1' : '0');
            update_option('cof_auto_save', isset($_POST['auto_save']) ? '1' : '0');
            update_option('cof_auto_save_interval', max(5, intval($_POST['auto_save_interval']))); // basic sanity
            update_option('cof_admin_email', sanitize_email($_POST['admin_email']));
            
            add_settings_error('cof_settings', 'cof_settings_updated', __('Settings saved successfully.', 'client-onboarding-form'), 'updated');
            
            if (function_exists('cof_log')) {
                cof_log('Settings updated', 'settings', 'info', $_POST);
            }
        }
    }

    /** -------------------------
     * Logs
     --------------------------*/
    public function render_logs() {
        $logger = new COF_Logger();
        $logs = $logger->get_logs(50);
        
        $view_file = COF_PLUGIN_DIR . 'admin/views/logs-view.php';
        if (file_exists($view_file)) {
            include $view_file;
        } else {
            ?>
            <div class="wrap">
                <h1><?php _e('Client Onboarding Logs', 'client-onboarding-form'); ?></h1>
                <?php if (!empty($logs)): ?>
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th><?php _e('Date', 'client-onboarding-form'); ?></th>
                                <th><?php _e('Level', 'client-onboarding-form'); ?></th>
                                <th><?php _e('Message', 'client-onboarding-form'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $log): ?>
                                <tr>
                                    <td><?php echo esc_html($log['created_at']); ?></td>
                                    <td><?php echo esc_html($log['level']); ?></td>
                                    <td><?php echo esc_html($log['message']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p><?php _e('No logs found.', 'client-onboarding-form'); ?></p>
                <?php endif; ?>
            </div>
            <?php
        }
    }

    /** -------------------------
     * Submission Detail (Hidden Page)
     --------------------------*/
    public function render_submission_detail() {
        if (!isset($_GET['id'])) {
            wp_die(__('No submission ID provided.', 'client-onboarding-form'));
        }
        
        $submission_id = intval($_GET['id']);
        $submission = $this->database->get_submission($submission_id);
        
        if (!$submission) {
            wp_die(__('Submission not found.', 'client-onboarding-form'));
        }

        $view_file = COF_PLUGIN_DIR . 'admin/views/submission-detail-view.php';
        if (file_exists($view_file)) {
            include $view_file;
            return;
        }

        // Inline fallback if template is missing
        $nonce = wp_create_nonce('cof_retry_email');
        ?>
        <div class="wrap">
            <h1><?php _e('Submission Details', 'client-onboarding-form'); ?> #<?php echo esc_html($submission_id); ?></h1>
            <table class="form-table">
                <tr>
                    <th><?php _e('Business Name', 'client-onboarding-form'); ?></th>
                    <td><?php echo esc_html($submission['business_name']); ?></td>
                </tr>
                <tr>
                    <th><?php _e('Contact', 'client-onboarding-form'); ?></th>
                    <td><?php echo esc_html($submission['contact_name']); ?> (<?php echo esc_html($submission['contact_email']); ?>)</td>
                </tr>
                <tr>
                    <th><?php _e('Project', 'client-onboarding-form'); ?></th>
                    <td><?php echo esc_html($submission['project_name']); ?></td>
                </tr>
                <tr>
                    <th><?php _e('Email Status', 'client-onboarding-form'); ?></th>
                    <td>
                        <span id="cof-email-status"><?php echo isset($submission['email_status']) ? esc_html($submission['email_status']) : '-'; ?></span>
                        <?php if (!empty($submission['admin_notified_at'])): ?>
                            <div><small><?php _e('Admin notified at:', 'client-onboarding-form'); ?> <?php echo esc_html($submission['admin_notified_at']); ?></small></div>
                        <?php endif; ?>
                        <?php if (!empty($submission['client_notified_at'])): ?>
                            <div><small><?php _e('Client notified at:', 'client-onboarding-form'); ?> <?php echo esc_html($submission['client_notified_at']); ?></small></div>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Created', 'client-onboarding-form'); ?></th>
                    <td><?php echo esc_html($submission['created_at']); ?></td>
                </tr>
            </table>

            <p>
                <button id="cof-retry-email" class="button button-primary"><?php _e('Retry Emails', 'client-onboarding-form'); ?></button>
                <span id="cof-retry-email-msg" style="margin-left:8px;"></span>
            </p>

            <script type="text/javascript">
                (function($){
                    $('#cof-retry-email').on('click', function(e){
                        e.preventDefault();
                        var $btn = $(this);
                        var $msg = $('#cof-retry-email-msg');
                        $btn.prop('disabled', true);
                        $msg.text('<?php echo esc_js(__('Processing...', 'client-onboarding-form')); ?>');

                        $.post(ajaxurl, {
                            action: 'cof_retry_email',
                            submission_id: '<?php echo esc_js($submission_id); ?>',
                            nonce: '<?php echo esc_js($nonce); ?>'
                        })
                        .done(function(resp){
                            if (resp && resp.success) {
                                $msg.text(resp.data && resp.data.message ? resp.data.message : '<?php echo esc_js(__('Success', 'client-onboarding-form')); ?>');
                                // Optionally refresh the Email Status text
                                $('#cof-email-status').text('processing');
                            } else {
                                $msg.text(resp && resp.data && resp.data.message ? resp.data.message : '<?php echo esc_js(__('Failed', 'client-onboarding-form')); ?>');
                            }
                        })
                        .fail(function(){
                            $msg.text('<?php echo esc_js(__('Request failed.', 'client-onboarding-form')); ?>');
                        })
                        .always(function(){
                            $btn.prop('disabled', false);
                        });
                    });
                })(jQuery);
            </script>
        </div>
        <?php
    }

    /** -------------------------
     * AJAX: Retry Email
     --------------------------*/
    public function handle_retry_email() {
        check_ajax_referer('cof_retry_email', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => __('Permission denied.', 'client-onboarding-form')));
        }
        
        $submission_id = isset($_POST['submission_id']) ? intval($_POST['submission_id']) : 0;
        if (!$submission_id) {
            wp_send_json_error(array('message' => __('Invalid submission ID.', 'client-onboarding-form')));
        }

        $submission = $this->database->get_submission($submission_id);
        if (!$submission) {
            wp_send_json_error(array('message' => __('Submission not found.', 'client-onboarding-form')));
        }
        
        // Trigger email sending workflow (COF_Email listens to this action)
        do_action('cof_form_submitted', $submission_id, $submission);
        
        // Optionally update status to processing immediately
        $this->database->update_submission($submission_id, array('email_status' => 'processing'));

        wp_send_json_success(array('message' => __('Emails sent successfully.', 'client-onboarding-form')));
    }
}
