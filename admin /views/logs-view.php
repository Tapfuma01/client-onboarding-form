<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php _e('Client Onboarding Logs', 'client-onboarding-form'); ?></h1>
    
    <div class="cof-logs">
        <?php if (!empty($logs)): ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php _e('Date', 'client-onboarding-form'); ?></th>
                        <th><?php _e('Level', 'client-onboarding-form'); ?></th>
                        <th><?php _e('Message', 'client-onboarding-form'); ?></th>
                        <th><?php _e('Source', 'client-onboarding-form'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?php echo esc_html(date('M j, Y g:i a', strtotime($log['created_at']))); ?></td>
                            <td><span class="cof-log-level cof-log-level-<?php echo esc_attr($log['level']); ?>"><?php echo esc_html($log['level']); ?></span></td>
                            <td><?php echo esc_html($log['message']); ?></td>
                            <td><?php echo esc_html($log['source']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p><?php _e('No logs found.', 'client-onboarding-form'); ?></p>
        <?php endif; ?>
    </div>
</div>