<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Thank You for Your Submission</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #0073aa; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; }
        .footer { background: #f1f1f1; padding: 10px; text-align: center; font-size: 12px; }
        .section { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You for Your Submission</h1>
        </div>
        
        <div class="content">
            <p>Dear <?php echo esc_html($contact_name); ?>,</p>
            
            <p>Thank you for choosing <?php echo esc_html($company_name); ?> and taking the time to complete our onboarding form. We're excited to learn more about <?php echo esc_html($business_name); ?> and your project goals.</p>
            
            <div class="section">
                <h3>Submission Summary</h3>
                <p><strong>Reference Number:</strong> #<?php echo $submission_id; ?></p>
                <p><strong>Business Name:</strong> <?php echo esc_html($business_name); ?></p>
                <p><strong>Project Name:</strong> <?php echo esc_html($form_data['project_name']); ?></p>
                <p><strong>Submission Date:</strong> <?php echo date('F j, Y', strtotime($submission_date)); ?></p>
            </div>
            
            <p><strong>What happens next?</strong></p>
            <ol>
                <li>Our team will review your submission within 24-48 hours</li>
                <li>We'll contact you to discuss your project in more detail</li>
                <li>We'll prepare a customized proposal based on your requirements</li>
            </ol>
            
            <p>If you have any immediate questions or need to make changes to your submission, please don't hesitate to contact us at <?php echo esc_html($support_email); ?>.</p>
            
            <p>We look forward to working with you!</p>
            
            <p>Best regards,<br>
            The Team at <?php echo esc_html($company_name); ?></p>
        </div>
        
        <div class="footer">
            <p><?php echo esc_html($company_name); ?> &bull; <?php echo esc_html($support_email); ?></p>
        </div>
    </div>
</body>
</html>