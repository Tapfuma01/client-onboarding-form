<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php _e('Client Onboarding Dashboard', 'client-onboarding-form'); ?></h1>
    
    <div class="cof-dashboard">
        <div class="cof-stats-grid">
            <div class="cof-stat-card">
                <h3><?php echo esc_html($total_submissions); ?></h3>
                <p><?php _e('Total Submissions', 'client-onboarding-form'); ?></p>
            </div>
        </div>
        
        <div class="cof-recent-submissions">
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