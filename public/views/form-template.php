<?php
if (!defined('ABSPATH')) {
    exit;
}

$session_id = $this->get_session_id();
?>

<div class="cof-fullpage-wrapper">
    <!-- Global Top Navbar -->
    <div class="cof-global-navbar">
        <div class="cof-nav-left">
            <span class="cof-logo">FLUX</span>
            <span class="cof-title">CLIENT ONBOARDING FORM</span>
        </div>
        <div class="cof-nav-right">
            <a href="#" class="cof-nav-exit">+ EXIT FORM</a>
            <button type="button" class="cof-nav-savedraft">SAVE DRAFT</button>
        </div>
    </div>

    <!-- Main Form Container -->
    <div class="cof-form-container">
        <div class="cof-form-glass">
            <!-- Left Sidebar Navigation -->
            <div class="cof-form-sidebar">
                <div class="cof-progress-steps">
                    <div class="cof-step-item active" data-step="1">
                        <div class="cof-step-number">1</div>
                        <div class="cof-step-info">
                            <div class="cof-step-title">Welcome</div>
                        </div>
                    </div>
                    
                    <div class="cof-step-item" data-step="2">
                        <div class="cof-step-number">2</div>
                        <div class="cof-step-info">
                            <div class="cof-step-title">Client Information</div>
                        </div>
                    </div>
                    
                    <div class="cof-step-item" data-step="3">
                        <div class="cof-step-number">3</div>
                        <div class="cof-step-info">
                            <div class="cof-step-title">Technical Information</div>
                        </div>
                    </div>
                    
                    <div class="cof-step-item" data-step="4">
                        <div class="cof-step-number">4</div>
                        <div class="cof-step-info">
                            <div class="cof-step-title">Reporting Information</div>
                        </div>
                    </div>
                    
                    <div class="cof-step-item" data-step="5">
                        <div class="cof-step-number">5</div>
                        <div class="cof-step-info">
                            <div class="cof-step-title">Marketing Information</div>
                        </div>
                    </div>
                    
                    <div class="cof-step-item" data-step="6">
                        <div class="cof-step-number">6</div>
                        <div class="cof-step-info">
                            <div class="cof-step-title">Review & Submit</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <div class="cof-form-content">
                <form class="cof-form">
                    <!-- Step 1: Welcome -->
                    <div class="cof-step active" data-step="1">
                        <div class="cof-step-header">
                            <h2>Welcome to Client Onboarding</h2>
                        </div>
                        
                        <div class="cof-step-body">
                            <div class="cof-welcome-content">
                                <div class="cof-welcome-icon">🚀</div>
                                <h3>Ready to Begin?</h3>
                                <p>This onboarding process will help us understand your business needs and create the perfect solution for your project.</p>
                                
                                <div class="cof-feature-list">
                                    <div class="cof-feature">
                                        <span class="cof-feature-icon">✓</span>
                                        <span>6 simple steps</span>
                                    </div>
                                    <div class="cof-feature">
                                        <span class="cof-feature-icon">✓</span>
                                        <span>Auto-save progress</span>
                                    </div>
                                    <div class="cof-feature">
                                        <span class="cof-feature-icon">✓</span>
                                        <span>10-15 minutes completion</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="cof-step-footer">
                            <button type="button" class="cof-btn cof-btn-primary cof-btn-next">
                                Get Started
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 2: Client Information -->
                    <div class="cof-step" data-step="2">
                        <div class="cof-step-header">
                            <h2>Client Information</h2>
                        </div>
                        
                        <div class="cof-step-body">
                            <div class="cof-form-grid">
                                <div class="cof-form-group">
                                    <label for="project_name">Project Name</label>
                                    <input type="text" id="project_name" name="project_name" required class="cof-input-glass">
                                </div>
                                
                                <div class="cof-form-group">
                                    <label for="business_name">Business Name</label>
                                    <input type="text" id="business_name" name="business_name" required class="cof-input-glass">
                                </div>
                                
                                <div class="cof-form-group">
                                    <label for="contact_name">Primary Contact Name</label>
                                    <input type="text" id="contact_name" name="contact_name" required class="cof-input-glass">
                                </div>
                                
                                <div class="cof-form-group">
                                    <label for="contact_email">Primary Contact Email</label>
                                    <input type="email" id="contact_email" name="contact_email" required class="cof-input-glass">
                                </div>
                                
                                <div class="cof-form-group">
                                    <label for="contact_phone">Primary Contact Number</label>
                                    <input type="tel" id="contact_phone" name="contact_phone" class="cof-input-glass">
                                </div>
                                
                                <div class="cof-form-group">
                                    <label for="milestone_approver">Who is the main approver of milestones?</label>
                                    <input type="text" id="milestone_approver" name="milestone_approver" class="cof-input-glass">
                                </div>
                                
                                <div class="cof-form-group">
                                    <label for="billing_email">Billing Email Address</label>
                                    <input type="email" id="billing_email" name="billing_email" class="cof-input-glass">
                                </div>
                                
                                <div class="cof-form-group">
                                    <label for="vat_number">VAT Number (Optional)</label>
                                    <input type="text" id="vat_number" name="vat_number" class="cof-input-glass">
                                </div>
                                
                                <div class="cof-form-group cof-form-full">
                                    <label>Preferred Contact Method</label>
                                    <div class="cof-radio-group">
                                        <div class="cof-radio-item">
                                            <input type="radio" id="contact_phone_radio" name="preferred_contact" value="phone">
                                            <label for="contact_phone_radio">Phone</label>
                                        </div>
                                        <div class="cof-radio-item">
                                            <input type="radio" id="contact_email_radio" name="preferred_contact" value="email">
                                            <label for="contact_email_radio">Email</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="cof-form-group cof-form-full">
                                    <label>Billing Address</label>
                                    <div class="cof-address-grid">
                                        <div class="cof-form-group">
                                            <input type="text" id="address_line1" name="address_line1" placeholder="Address Line 1" class="cof-input-glass">
                                        </div>
                                        <div class="cof-form-group">
                                            <input type="text" id="address_line2" name="address_line2" placeholder="Address Line 2" class="cof-input-glass">
                                        </div>
                                        <div class="cof-form-group">
                                            <input type="text" id="city" name="city" placeholder="City" class="cof-input-glass">
                                        </div>
                                        <div class="cof-address-row">
                                            <input type="text" id="country" name="country" placeholder="Country" class="cof-input-glass">
                                            <input type="text" id="postal_code" name="postal_code" placeholder="Postal Code" class="cof-input-glass">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="cof-step-footer">
                            <button type="button" class="cof-btn cof-btn-secondary cof-btn-prev">
                                Back
                            </button>
                            <button type="button" class="cof-btn cof-btn-primary cof-btn-next">
                                Continue
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 3: Technical Information -->
                    <div class="cof-step" data-step="3">
                        <div class="cof-step-header">
                            <h2>Technical Information</h2>
                        </div>
                        
                        <div class="cof-step-body">
                            <div class="cof-form-grid">
                                <div class="cof-form-group">
                                    <label for="project_budget">Project Budget</label>
                                    <select id="project_budget" name="project_budget" class="cof-input-glass">
                                        <option value="">Select Budget Range</option>
                                        <option value="Under $5K">Under $5K</option>
                                        <option value="$5K-10K">$5K-10K</option>
                                        <option value="$10K-25K">$10K-25K</option>
                                        <option value="$25K-50K">$25K-50K</option>
                                        <option value="$50K+">$50K+</option>
                                    </select>
                                </div>
                                
                                <div class="cof-form-group">
                                    <label for="project_timeline">Project Timeline</label>
                                    <select id="project_timeline" name="project_timeline" class="cof-input-glass">
                                        <option value="">Select Timeline</option>
                                        <option value="1-3 months">1-3 months</option>
                                        <option value="3-6 months">3-6 months</option>
                                        <option value="6-12 months">6-12 months</option>
                                        <option value="12+ months">12+ months</option>
                                    </select>
                                </div>
                                
                                <div class="cof-form-group cof-form-full">
                                    <label for="website_url">Current Website URL</label>
                                    <input type="url" id="website_url" name="website_url" placeholder="https://yourcompany.com" class="cof-input-glass">
                                </div>
                                
                                <div class="cof-form-group cof-form-full">
                                    <label for="project_goals">Project Goals and Objectives</label>
                                    <textarea id="project_goals" name="project_goals" rows="4" class="cof-input-glass" placeholder="What do you want to achieve with this project?"></textarea>
                                </div>
                                
                                <div class="cof-form-group cof-form-full">
                                    <label for="target_audience">Target Audience Description</label>
                                    <textarea id="target_audience" name="target_audience" rows="4" class="cof-input-glass" placeholder="Who is your target audience?"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="cof-step-footer">
                            <button type="button" class="cof-btn cof-btn-secondary cof-btn-prev">
                                Back
                            </button>
                            <button type="button" class="cof-btn cof-btn-primary cof-btn-next">
                                Continue
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 4: Reporting Information -->
                    <div class="cof-step" data-step="4">
                        <div class="cof-step-header">
                            <h2>Reporting Information</h2>
                        </div>
                        
                        <div class="cof-step-body">
                            <div class="cof-services-grid">
                                <label class="cof-service-card">
                                    <input type="checkbox" name="services[]" value="Web Design">
                                    <div class="cof-service-content">
                                        <span class="cof-service-icon">🎨</span>
                                        <span class="cof-service-name">Web Design</span>
                                    </div>
                                </label>
                                
                                <label class="cof-service-card">
                                    <input type="checkbox" name="services[]" value="Development">
                                    <div class="cof-service-content">
                                        <span class="cof-service-icon">💻</span>
                                        <span class="cof-service-name">Development</span>
                                    </div>
                                </label>
                                
                                <label class="cof-service-card">
                                    <input type="checkbox" name="services[]" value="E-commerce">
                                    <div class="cof-service-content">
                                        <span class="cof-service-icon">🛒</span>
                                        <span class="cof-service-name">E-commerce</span>
                                    </div>
                                </label>
                                
                                <label class="cof-service-card">
                                    <input type="checkbox" name="services[]" value="SEO">
                                    <div class="cof-service-content">
                                        <span class="cof-service-icon">🔍</span>
                                        <span class="cof-service-name">SEO</span>
                                    </div>
                                </label>
                                
                                <label class="cof-service-card">
                                    <input type="checkbox" name="services[]" value="Analytics">
                                    <div class="cof-service-content">
                                        <span class="cof-service-icon">📊</span>
                                        <span class="cof-service-name">Analytics</span>
                                    </div>
                                </label>
                                
                                <label class="cof-service-card">
                                    <input type="checkbox" name="services[]" value="Reporting">
                                    <div class="cof-service-content">
                                        <span class="cof-service-icon">📈</span>
                                        <span class="cof-service-name">Reporting</span>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="cof-form-group cof-form-full">
                                <label for="reporting_requirements">Reporting Requirements</label>
                                <textarea id="reporting_requirements" name="reporting_requirements" rows="4" class="cof-input-glass" placeholder="What kind of reporting do you need?"></textarea>
                            </div>
                        </div>
                        
                        <div class="cof-step-footer">
                            <button type="button" class="cof-btn cof-btn-secondary cof-btn-prev">
                                Back
                            </button>
                            <button type="button" class="cof-btn cof-btn-primary cof-btn-next">
                                Continue
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 5: Marketing Information -->
                    <div class="cof-step" data-step="5">
                        <div class="cof-step-header">
                            <h2>Marketing Information</h2>
                        </div>
                        
                        <div class="cof-step-body">
                            <div class="cof-form-grid">
                                <div class="cof-form-group cof-form-full">
                                    <label for="business_description">Business Description</label>
                                    <textarea id="business_description" name="business_description" rows="3" class="cof-input-glass" placeholder="What does your business do?"></textarea>
                                </div>
                                
                                <div class="cof-form-group cof-form-full">
                                    <label for="brand_personality">Brand Personality</label>
                                    <textarea id="brand_personality" name="brand_personality" rows="3" class="cof-input-glass" placeholder="How would you describe your brand's personality?"></textarea>
                                </div>
                                
                                <div class="cof-form-group cof-form-full">
                                    <label for="brand_values">Brand Values</label>
                                    <textarea id="brand_values" name="brand_values" rows="3" class="cof-input-glass" placeholder="What values are important to your brand?"></textarea>
                                </div>
                                
                                <div class="cof-form-group cof-form-full">
                                    <label for="competitor_analysis">Competitor Analysis</label>
                                    <textarea id="competitor_analysis" name="competitor_analysis" rows="3" class="cof-input-glass" placeholder="Who are your main competitors?"></textarea>
                                </div>
                                
                                <div class="cof-form-group cof-form-full">
                                    <label for="marketing_goals">Marketing Goals</label>
                                    <textarea id="marketing_goals" name="marketing_goals" rows="3" class="cof-input-glass" placeholder="What are your marketing objectives?"></textarea>
                                </div>
                                
                                <div class="cof-form-group cof-form-full">
                                    <label for="current_challenges">Current Challenges</label>
                                    <textarea id="current_challenges" name="current_challenges" rows="3" class="cof-input-glass" placeholder="What challenges are you facing?"></textarea>
                                </div>
                                
                                <div class="cof-form-group cof-form-full">
                                    <label for="success_metrics">Success Metrics</label>
                                    <textarea id="success_metrics" name="success_metrics" rows="3" class="cof-input-glass" placeholder="How will you measure success?"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="cof-step-footer">
                            <button type="button" class="cof-btn cof-btn-secondary cof-btn-prev">
                                Back
                            </button>
                            <button type="button" class="cof-btn cof-btn-primary cof-btn-next">
                                Continue
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 6: Review & Submit -->
                    <div class="cof-step" data-step="6">
                        <div class="cof-step-header">
                            <h2>Review & Submit</h2>
                        </div>
                        
                        <div class="cof-step-body">
                            <div id="cof-review-summary">
                                <!-- Summary will be populated by JavaScript -->
                            </div>
                            
                            <div class="cof-form-group cof-form-full">
                                <label for="additional_notes">Additional Notes</label>
                                <textarea id="additional_notes" name="additional_notes" rows="4" class="cof-input-glass" placeholder="Any additional information or special requests?"></textarea>
                            </div>
                        </div>
                        
                        <div class="cof-step-footer">
                            <button type="button" class="cof-btn cof-btn-secondary cof-btn-prev">
                                Back
                            </button>
                            <button type="button" class="cof-btn cof-btn-primary cof-btn-submit">
                                Submit Application
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="cof-modal" id="cof-success-modal">
        <div class="cof-modal-content">
            <div class="cof-modal-success">
                <div class="cof-success-icon">✓</div>
                <h3>Application Submitted!</h3>
                <p>Thank you for completing the onboarding process. We'll review your information and contact you shortly.</p>
                <div class="cof-success-details">
                    <p><strong>Reference ID:</strong> <span id="cof-submission-id"></span></p>
                    <p>You will receive a confirmation email shortly.</p>
                </div>
                <button type="button" class="cof-btn cof-btn-primary cof-modal-close">
                    Done
                </button>
            </div>
        </div>
    </div>
</div>