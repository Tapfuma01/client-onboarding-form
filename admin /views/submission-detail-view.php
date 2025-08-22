<?php
if (!defined('ABSPATH')) {
    exit;
}

if (empty($submission)) {
    echo '<p>' . __('Submission not found.', 'client-onboarding-form') . '</p>';
    return;
}
?>
<div class="wrap">
    <h1><?php _e('Submission Details', 'client-onboarding-form'); ?></h1>
    
    <div class="cof-submission-detail">
        <div class="cof-submission-header">
            <div class="cof-submission-meta">
                <p><strong><?php _e('Submission ID:', 'client-onboarding-form'); ?></strong> #<?php echo $submission['id']; ?></p>
                <p><strong><?php _e('Status:', 'client-onboarding-form'); ?></strong> 
                    <span class="cof-status cof-status-<?php echo esc_attr($submission['status']); ?>">
                        <?php echo esc_html(ucfirst($submission['status'])); ?>
                    </span>
                </p>
                <p><strong><?php _e('Email Status:', 'client-onboarding-form'); ?></strong> 
                    <span class="cof-email-status cof-email-status-<?php echo esc_attr($submission['email_status']); ?>">
                        <?php echo esc_html(ucfirst($submission['email_status'])); ?>
                    </span>
                </p>
                <p><strong><?php _e('Submitted:', 'client-onboarding-form'); ?></strong> <?php echo date('F j, Y g:i a', strtotime($submission['created_at'])); ?></p>
            </div>
            
            <div class="cof-submission-actions">
                <a href="<?php echo admin_url('admin.php?page=cof-submissions'); ?>" class="button">
                    <?php _e('Back to List', 'client-onboarding-form'); ?>
                </a>
                <?php if ($submission['email_status'] === 'failed'): ?>
                    <button type="button" class="button button-primary cof-retry-email" data-submission-id="<?php echo $submission['id']; ?>">
                        <?php _e('Retry Emails', 'client-onboarding-form'); ?>
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <div class="cof-submission-tabs">
            <h2 class="nav-tab-wrapper">
                <a href="#business-info" class="nav-tab nav-tab-active"><?php _e('Business Information', 'client-onboarding-form'); ?></a>
                <a href="#project-details" class="nav-tab"><?php _e('Project Details', 'client-onboarding-form'); ?></a>
                <a href="#services" class="nav-tab"><?php _e('Services', 'client-onboarding-form'); ?></a>
                <a href="#marketing" class="nav-tab"><?php _e('Marketing & Brand', 'client-onboarding-form'); ?></a>
                <a href="#email-info" class="nav-tab"><?php _e('Email Status', 'client-onboarding-form'); ?></a>
            </h2>

            <div id="business-info" class="cof-tab-content">
                <h3><?php _e('Business Information', 'client-onboarding-form'); ?></h3>
                <table class="widefat">
                    <tr><th width="200"><?php _e('Business Name', 'client-onboarding-form'); ?></th><td><?php echo esc_html($submission['business_name']); ?></td></tr>
                    <tr><th><?php _e('Website URL', 'client-onboarding-form'); ?></th><td><?php echo esc_html($submission['website_url']); ?></td></tr>
                    <tr><th><?php _e('Business Address', 'client-onboarding-form'); ?></th><td><?php echo nl2br(esc_html($submission['business_address'])); ?></td></tr>
                    <tr><th><?php _e('Business Description', 'client-onboarding-form'); ?></th><td><?php echo nl2br(esc_html($submission['business_description'])); ?></td></tr>
                    <tr><th><?php _e('Contact Name', 'client-onboarding-form'); ?></th><td><?php echo esc_html($submission['contact_name']); ?></td></tr>
                    <tr><th><?php _e('Contact Email', 'client-onboarding-form'); ?></th><td><?php echo esc_html($submission['contact_email']); ?></td></tr>
                    <tr><th><?php _e('Contact Phone', 'client-onboarding-form'); ?></th><td><?php echo esc_html($submission['contact_phone']); ?></td></tr>
                </table>
            </div>

            <div id="project-details" class="cof-tab-content" style="display:none">
                <h3><?php _e('Project Details', 'client-onboarding-form'); ?></h3>
                <table class="widefat">
                    <tr><th width="200"><?php _e('Project Name', 'client-onboarding-form'); ?></th><td><?php echo esc_html($submission['project_name']); ?></td></tr>
                    <tr><th><?php _e('Project Budget', 'client-onboarding-form'); ?></th><td><?php echo esc_html($submission['project_budget']); ?></td></tr>
                    <tr><th><?php _e('Project Timeline', 'client-onboarding-form'); ?></th><td><?php echo esc_html($submission['project_timeline']); ?></td></tr>
                    <tr><th><?php _e('Project Goals', 'client-onboarding-form'); ?></th><td><?php echo nl2br(esc_html($submission['project_goals'])); ?></td></tr>
                    <tr><th><?php _e('Target Audience', 'client-onboarding-form'); ?></th><td><?php echo nl2br(esc_html($submission['target_audience'])); ?></td></tr>
                </table>
            </div>

            <div id="services" class="cof-tab-content" style="display:none">
                <h3><?php _e('Services & Features', 'client-onboarding-form'); ?></h3>
                <table class="widefat">
                    <tr><th width="200"><?php _e('Services Needed', 'client-onboarding-form'); ?></th>
                        <td>
                            <?php 
                            $services = maybe_unserialize($submission['services_needed']);
                            if (is_array($services) && !empty($services)) {
                                echo esc_html(implode(', ', $services));
                            } else {
                                echo __('No services selected', 'client-onboarding-form');
                            }
                            ?>
                        </td>
                    </tr>
                    <tr><th><?php _e('Additional Services', 'client-onboarding-form'); ?></th><td><?php echo nl2br(esc_html($submission['additional_services'])); ?></td></tr>
                </table>
            </div>

            <div id="marketing" class="cof-tab-content" style="display:none">
                <h3><?php _e('Marketing & Brand', 'client-onboarding-form'); ?></h3>
                <table class="widefat">
                    <tr><th width="200"><?php _e('Brand Personality', 'client-onboarding-form'); ?></th><td><?php echo nl2br(esc_html($submission['brand_personality'])); ?></td></tr>
                    <tr><th><?php _e('Brand Values', 'client-onboarding-form'); ?></th><td><?php echo nl2br(esc_html($submission['brand_values'])); ?></td></tr>
                    <tr><th><?php _e('Competitor Analysis', 'client-onboarding-form'); ?></th><td><?php echo nl2br(esc_html($submission['competitor_analysis'])); ?></td></tr>
                    <tr><th><?php _e('Marketing Goals', 'client-onboarding-form'); ?></th><td><?php echo nl2br(esc_html($submission['marketing_goals'])); ?></td></tr>
                    <tr><th><?php _e('Current Challenges', 'client-onboarding-form'); ?></th><td><?php echo nl2br(esc_html($submission['current_challenges'])); ?></td></tr>
                    <tr><th><?php _e('Success Metrics', 'client-onboarding-form'); ?></th><td><?php echo nl2br(esc_html($submission['success_metrics'])); ?></td></tr>
                    <tr><th><?php _e('Additional Notes', 'client-onboarding-form'); ?></th><td><?php echo nl2br(esc_html($submission['additional_notes'])); ?></td></tr>
                </table>
            </div>

            <div id="email-info" class="cof-tab-content" style="display:none">
                <h3><?php _e('Email Status', 'client-onboarding-form'); ?></h3>
                <table class="widefat">
                    <tr><th width="200"><?php _e('Email Status', 'client-onboarding-form'); ?></th>
                        <td>
                            <span class="cof-email-status cof-email-status-<?php echo esc_attr($submission['email_status']); ?>">
                                <?php echo esc_html(ucfirst($submission['email_status'])); ?>
                            </span>
                        </td>
                    </tr>
                    <tr><th><?php _e('Admin Notified', 'client-onboarding-form'); ?></th>
                        <td>
                            <?php if ($submission['admin_notified_at']): ?>
                                <?php echo date('F j, Y g:i a', strtotime($submission['admin_notified_at'])); ?>
                            <?php else: ?>
                                <span class="description"><?php _e('Not sent yet', 'client-onboarding-form'); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr><th><?php _e('Client Notified', 'client-onboarding-form'); ?></th>
                        <td>
                            <?php if ($submission['client_notified_at']): ?>
                                <?php echo date('F j, Y g:i a', strtotime($submission['client_notified_at'])); ?>
                            <?php else: ?>
                                <span class="description"><?php _e('Not sent yet', 'client-onboarding-form'); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
                
                <?php if ($submission['email_status'] === 'failed'): ?>
                    <div class="notice notice-error">
                        <p><?php _e('Email delivery failed. This could be due to:', 'client-onboarding-form'); ?></p>
                        <ul>
                            <li><?php _e('SMTP configuration issues', 'client-onboarding-form'); ?></li>
                            <li><?php _e('Invalid email addresses', 'client-onboarding-form'); ?></li>
                            <li><?php _e('Email server problems', 'client-onboarding-form'); ?></li>
                        </ul>
                        <p>
                            <button type="button" class="button button-primary cof-retry-email" data-submission-id="<?php echo $submission['id']; ?>">
                                <?php _e('Retry Email Delivery', 'client-onboarding-form'); ?>
                            </button>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    $('.cof-submission-tabs .nav-tab').on('click', function(e) {
        e.preventDefault();
        $('.nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        
        $('.cof-tab-content').hide();
        $($(this).attr('href')).show();
    });
    
    $('.cof-retry-email').on('click', function() {
        var submissionId = $(this).data('submission-id');
        var button = $(this);
        
        button.prop('disabled', true).text('<?php _e('Sending...', 'client-onboarding-form'); ?>');
        
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'cof_retry_email',
                submission_id: submissionId,
                nonce: '<?php echo wp_create_nonce('cof_retry_email'); ?>'
            },
            success: function(response) {
                if (response.success) {
                    alert('<?php _e('Emails sent successfully!', 'client-onboarding-form'); ?>');
                    location.reload();
                } else {
                    alert('<?php _e('Failed to send emails: ', 'client-onboarding-form'); ?>' + response.data.message);
                    button.prop('disabled', false).text('<?php _e('Retry Emails', 'client-onboarding-form'); ?>');
                }
            }
        });
    });
});
</script>