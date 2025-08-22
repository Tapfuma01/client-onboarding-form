<?php
if (!defined('ABSPATH')) {
    exit;
}
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
                            <td>
                                <a href="#" class="button button-small"><?php _e('View', 'client-onboarding-form'); ?></a>
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