<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Client Submission</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #0073aa; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; }
        .footer { background: #f1f1f1; padding: 10px; text-align: center; font-size: 12px; }
        .section { margin-bottom: 20px; }
        .section h3 { border-bottom: 2px solid #0073aa; padding-bottom: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Client Onboarding Submission</h1>
        </div>
        
        <div class="content">
            <div class="section">
                <h3>Submission Details</h3>
                <p><strong>Submission ID:</strong> #<?php echo $submission_id; ?></p>
                <p><strong>Date Received:</strong> <?php echo date('F j, Y g:i a', strtotime($submission_date)); ?></p>
            </div>
            
            <div class="section">
                <h3>Business Information</h3>
                <p><strong>Business Name:</strong> <?php echo esc_html($form_data['business_name']); ?></p>
                <p><strong>Contact Name:</strong> <?php echo esc_html($form_data['contact_name']); ?></p>
                <p><strong>Email:</strong> <?php echo esc_html($form_data['contact_email']); ?></p>
                <p><strong>Phone:</strong> <?php echo esc_html($form_data['contact_phone']); ?></p>
                <?php if ($form_data['website_url']): ?>
                <p><strong>Website:</strong> <?php echo esc_html($form_data['website_url']); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="section">
                <h3>Project Information</h3>
                <p><strong>Project Name:</strong> <?php echo esc_html($form_data['project_name']); ?></p>
                <p><strong>Budget:</strong> <?php echo esc_html($form_data['project_budget']); ?></p>
                <p><strong>Timeline:</strong> <?php echo esc_html($form_data['project_timeline']); ?></p>
            </div>
            
            <p><a href="<?php echo admin_url('admin.php?page=cof-submissions'); ?>">View complete submission details in admin panel</a></p>
        </div>
        
        <div class="footer">
            <p>This email was sent from <?php echo esc_html(get_bloginfo('name')); ?> on <?php echo date('F j, Y'); ?></p>
        </div>
    </div>
</body>
</html>