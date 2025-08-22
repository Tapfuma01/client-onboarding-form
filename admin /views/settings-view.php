<?php
if (!defined('ABSPATH')) {
    exit;
}

// Show settings error messages
settings_errors('cof_settings');
?>
<div class="wrap">
    <h1><?php _e('Client Onboarding Settings', 'client-onboarding-form'); ?></h1>
    
    <form method="post" action="">
        <?php wp_nonce_field('cof_save_settings', 'cof_settings_nonce'); ?>
        
        <table class="form-table">
            <tr>
                <th scope="row"><?php _e('Email Notifications', 'client-onboarding-form'); ?></th>
                <td>
                    <label>
                        <input type="checkbox" name="email_notifications" value="1" <?php checked($email_notifications, '1'); ?>>
                        <?php _e('Enable email notifications for new submissions', 'client-onboarding-form'); ?>
                    </label>
                </td>
            </tr>
            
            <tr>
                <th scope="row"><?php _e('Admin Email', 'client-onboarding-form'); ?></th>
                <td>
                    <input type="email" name="admin_email" value="<?php echo esc_attr($admin_email); ?>" class="regular-text">
                    <p class="description"><?php _e('Email address to receive notifications', 'client-onboarding-form'); ?></p>
                </td>
            </tr>
            
            <tr>
                <th scope="row"><?php _e('Draft Auto-save', 'client-onboarding-form'); ?></th>
                <td>
                    <label>
                        <input type="checkbox" name="auto_save" value="1" <?php checked($auto_save, '1'); ?>>
                        <?php _e('Enable auto-save functionality', 'client-onboarding-form'); ?>
                    </label>
                </td>
            </tr>
            
            <tr>
                <th scope="row"><?php _e('Auto-save Interval', 'client-onboarding-form'); ?></th>
                <td>
                    <input type="number" name="auto_save_interval" value="<?php echo esc_attr($auto_save_interval); ?>" min="5" max="300" class="small-text">
                    <span class="description"><?php _e('seconds', 'client-onboarding-form'); ?></span>
                    <p class="description"><?php _e('How often to auto-save form progress (5-300 seconds)', 'client-onboarding-form'); ?></p>
                </td>
            </tr>
        </table>
        
        <?php submit_button(__('Save Settings', 'client-onboarding-form')); ?>
    </form>
</div>

<?php
// Example: Display submission details (with Email Status + Actions)
if (!empty($submission)) : ?>
    <h2><?php _e('Submission Details', 'client-onboarding-form'); ?></h2>
    <table class="widefat fixed striped">
        <tbody>
            <tr>
                <th><?php _e('Submission ID', 'client-onboarding-form'); ?></th>
                <td><?php echo esc_html($submission['id']); ?></td>
            </tr>
            
            <tr>
                <th><?php _e('Email Status', 'client-onboarding-form'); ?></th>
                <td>
                    <span class="cof-email-status cof-email-status-<?php echo esc_attr($submission['email_status']); ?>">
                        <?php echo esc_html(ucfirst($submission['email_status'])); ?>
                    </span>
                </td>
            </tr>
            
            <tr>
                <th><?php _e('Actions', 'client-onboarding-form'); ?></th>
                <td>
                    <a href="<?php echo admin_url('admin.php?page=cof-submission-detail&id=' . $submission['id']); ?>" class="button button-small">
                        <?php _e('View Details', 'client-onboarding-form'); ?>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>
