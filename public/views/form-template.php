<?php
if (!defined('ABSPATH')) {
    exit;
}

$session_id = $this->get_session_id();
?>

<div class="cof-fullpage-wrapper">
    <!-- Your existing top navbar and form container here -->
<!-- 1. GLOBAL TOP NAVBAR -->
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

<!-- 2. MAIN FORM CONTAINER - centered below navbar -->
<div class="cof-form-container" style="margin-top: 1rem;">
    <div class="cof-form-glass">
        <!-- 3. SIDEBAR NAVIGATION -->
        <div class="cof-form-sidebar">
            <div class="cof-sidebar-header">
                <h2>Client Onboarding</h2>
                <p>Complete your profile in 6 simple steps</p>
            </div>
            
            <div class="cof-progress-steps">
                <div class="cof-step-item" data-step="1">
                    <div class="cof-step-number">1</div>
                    <div class="cof-step-info">
                        <div class="cof-step-title">Welcome</div>
                        <div class="cof-step-desc">Get started</div>
                    </div>
                    <div class="cof-step-indicator"></div>
                </div>
                
                <div class="cof-step-item" data-step="2">
                    <div class="cof-step-number">2</div>
                    <div class="cof-step-info">
                        <div class="cof-step-title">Business Info</div>
                        <div class="cof-step-desc">Company details</div>
                    </div>
                    <div class="cof-step-indicator"></div>
                </div>
                
                <div class="cof-step-item" data-step="3">
                    <div class="cof-step-number">3</div>
                    <div class="cof-step-info">
                        <div class="cof-step-title">Project Details</div>
                        <div class="cof-step-desc">Goals & timeline</div>
                    </div>
                    <div class="cof-step-indicator"></div>
                </div>
                
                <div class="cof-step-item" data-step="4">
                    <div class="cof-step-number">4</div>
                    <div class="cof-step-info">
                        <div class="cof-step-title">Services</div>
                        <div class="cof-step-desc">What you need</div>
                    </div>
                    <div class="cof-step-indicator"></div>
                </div>
                
                <div class="cof-step-item" data-step="5">
                    <div class="cof-step-number">5</div>
                    <div class="cof-step-info">
                        <div class="cof-step-title">Marketing</div>
                        <div class="cof-step-desc">Brand & strategy</div>
                    </div>
                    <div class="cof-step-indicator"></div>
                </div>
                
                <div class="cof-step-item" data-step="6">
                    <div class="cof-step-number">6</div>
                    <div class="cof-step-info">
                        <div class="cof-step-title">Review</div>
                        <div class="cof-step-desc">Final submission</div>
                    </div>
                    <div class="cof-step-indicator"></div>
                </div>
            </div>
            
            <div class="cof-sidebar-footer">
                <div class="cof-progress-bar">
                    <div class="cof-progress-fill"></div>
                </div>
                <div class="cof-progress-text">Step 1 of 6</div>
            </div>
        </div>
        
        <!-- 4. FORM CONTENT AREA -->
        <div class="cof-form-content">
            <form class="cof-form">
                <!-- Step 1: Welcome -->
                <div class="cof-step" data-step="1">
                    <div class="cof-step-header">
                        <h2>Welcome to Client Onboarding</h2>
                        <p>Let's get your project started on the right foot</p>
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
                    
                    <div class="cof-step-footer" style="justify-content: flex-end;">
                        <button type="button" class="cof-btn cof-btn-primary cof-btn-next">
                            Get Started
                            <span class="cof-btn-arrow">→</span>
                        </button>
                    </div>
                </div>
                
                <!-- Step 2: Business Information -->
                <div class="cof-step" data-step="2">
                    <div class="cof-step-header">
                        <h2>Business Information</h2>
                        <p>Tell us about your company</p>
                    </div>
                    
                    <div class="cof-step-body">
                        <div class="cof-form-grid">
                            <div class="cof-form-group">
                                <label for="business_name">Business Name *</label>
                                <input type="text" id="business_name" name="business_name" required class="cof-input-glass">
                            </div>
                            
                            <div class="cof-form-group">
                                <label for="website_url">Website URL</label>
                                <input type="url" id="website_url" name="website_url" placeholder="https://yourcompany.com" class="cof-input-glass">
                            </div>
                            
                            <div class="cof-form-group cof-form-full">
                                <label for="business_address">Business Address</label>
                                <textarea id="business_address" name="business_address" rows="2" class="cof-input-glass" placeholder="Street, City, State, ZIP"></textarea>
                            </div>
                            
                            <div class="cof-form-group cof-form-full">
                                <label for="business_description">Business Description</label>
                                <textarea id="business_description" name="business_description" rows="3" class="cof-input-glass" placeholder="What does your business do?"></textarea>
                            </div>
                            
                            <div class="cof-form-group">
                                <label for="contact_name">Primary Contact Name *</label>
                                <input type="text" id="contact_name" name="contact_name" required class="cof-input-glass">
                            </div>
                            
                            <div class="cof-form-group">
                                <label for="contact_email">Primary Contact Email *</label>
                                <input type="email" id="contact_email" name="contact_email" required class="cof-input-glass">
                            </div>
                            
                            <div class="cof-form-group">
                                <label for="contact_phone">Primary Contact Phone</label>
                                <input type="tel" id="contact_phone" name="contact_phone" class="cof-input-glass" placeholder="+1 (555) 123-4567">
                            </div>
                        </div>
                    </div>
                    
                    <div class="cof-step-footer">
                        <button type="button" class="cof-btn cof-btn-secondary cof-btn-prev">
                            ← Back
                        </button>
                        <button type="button" class="cof-btn cof-btn-primary cof-btn-next">
                            Continue
                            <span class="cof-btn-arrow">→</span>
                        </button>
                    </div>
                </div>
                
                <!-- Step 3: Project Details -->
                <div class="cof-step" data-step="3">
                    <div class="cof-step-header">
                        <h2>Project Details</h2>
                        <p>Tell us about your project requirements</p>
                    </div>
                    
                    <div class="cof-step-body">
                        <div class="cof-form-grid">
                            <div class="cof-form-group">
                                <label for="project_name">Project Name *</label>
                                <input type="text" id="project_name" name="project_name" required class="cof-input-glass">
                            </div>
                            
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
                                <label for="project_goals">Project Goals and Objectives</label>
                                <textarea id="project_goals" name="project_goals" rows="3" class="cof-input-glass" placeholder="What do you want to achieve with this project?"></textarea>
                            </div>
                            
                            <div class="cof-form-group cof-form-full">
                                <label for="target_audience">Target Audience Description</label>
                                <textarea id="target_audience" name="target_audience" rows="3" class="cof-input-glass" placeholder="Who is your target audience?"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="cof-step-footer">
                        <button type="button" class="cof-btn cof-btn-secondary cof-btn-prev">
                            ← Back
                        </button>
                        <button type="button" class="cof-btn cof-btn-primary cof-btn-next">
                            Continue
                            <span class="cof-btn-arrow">→</span>
                        </button>
                    </div>
                </div>
                
                <!-- Step 4: Services & Features -->
                <div class="cof-step" data-step="4">
                    <div class="cof-step-header">
                        <h2>Services & Features</h2>
                        <p>What services do you need?</p>
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
                                <input type="checkbox" name="services[]" value="Branding">
                                <div class="cof-service-content">
                                    <span class="cof-service-icon">✨</span>
                                    <span class="cof-service-name">Branding</span>
                                </div>
                            </label>
                            
                            <label class="cof-service-card">
                                <input type="checkbox" name="services[]" value="Content Creation">
                                <div class="cof-service-content">
                                    <span class="cof-service-icon">📝</span>
                                    <span class="cof-service-name">Content Creation</span>
                                </div>
                            </label>
                            
                            <label class="cof-service-card">
                                <input type="checkbox" name="services[]" value="Maintenance">
                                <div class="cof-service-content">
                                    <span class="cof-service-icon">🔧</span>
                                    <span class="cof-service-name">Maintenance</span>
                                </div>
                            </label>
                            
                            <label class="cof-service-card">
                                <input type="checkbox" name="services[]" value="Hosting">
                                <div class="cof-service-content">
                                    <span class="cof-service-icon">☁️</span>
                                    <span class="cof-service-name">Hosting</span>
                                </div>
                            </label>
                        </div>
                        
                        <div class="cof-form-group cof-form-full">
                            <label for="additional_services">Additional Services Needed</label>
                            <textarea id="additional_services" name="additional_services" rows="3" class="cof-input-glass" placeholder="Any other services not listed above?"></textarea>
                        </div>
                    </div>
                    
                    <div class="cof-step-footer">
                        <button type="button" class="cof-btn cof-btn-secondary cof-btn-prev">
                            ← Back
                        </button>
                        <button type="button" class="cof-btn cof-btn-primary cof-btn-next">
                            Continue
                            <span class="cof-btn-arrow">→</span>
                        </button>
                    </div>
                </div>
                
                <!-- Step 5: Marketing & Brand -->
                <div class="cof-step" data-step="5">
                    <div class="cof-step-header">
                        <h2>Marketing & Brand</h2>
                        <p>Tell us about your brand identity</p>
                    </div>
                    
                    <div class="cof-step-body">
                        <div class="cof-form-grid">
                            <div class="cof-form-group cof-form-full">
                                <label for="brand_personality">Brand Personality</label>
                                <textarea id="brand_personality" name="brand_personality" rows="2" class="cof-input-glass" placeholder="How would you describe your brand's personality?"></textarea>
                            </div>
                            
                            <div class="cof-form-group cof-form-full">
                                <label for="brand_values">Brand Values</label>
                                <textarea id="brand_values" name="brand_values" rows="2" class="cof-input-glass" placeholder="What values are important to your brand?"></textarea>
                            </div>
                            
                            <div class="cof-form-group cof-form-full">
                                <label for="competitor_analysis">Competitor Analysis</label>
                                <textarea id="competitor_analysis" name="competitor_analysis" rows="2" class="cof-input-glass" placeholder="Who are your main competitors?"></textarea>
                            </div>
                            
                            <div class="cof-form-group cof-form-full">
                                <label for="marketing_goals">Marketing Goals</label>
                                <textarea id="marketing_goals" name="marketing_goals" rows="2" class="cof-input-glass" placeholder="What are your marketing objectives?"></textarea>
                            </div>
                            
                            <div class="cof-form-group cof-form-full">
                                <label for="current_challenges">Current Challenges</label>
                                <textarea id="current_challenges" name="current_challenges" rows="2" class="cof-input-glass" placeholder="What challenges are you facing?"></textarea>
                            </div>
                            
                            <div class="cof-form-group cof-form-full">
                                <label for="success_metrics">Success Metrics</label>
                                <textarea id="success_metrics" name="success_metrics" rows="2" class="cof-input-glass" placeholder="How will you measure success?"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="cof-step-footer">
                        <button type="button" class="cof-btn cof-btn-secondary cof-btn-prev">
                            ← Back
                        </button>
                        <button type="button" class="cof-btn cof-btn-primary cof-btn-next">
                            Continue
                            <span class="cof-btn-arrow">→</span>
                        </button>
                    </div>
                </div>
                
                <!-- Step 6: Review & Submit -->
                <div class="cof-step" data-step="6">
                    <div class="cof-step-header">
                        <h2>Review & Submit</h2>
                        <p>Review your information before submitting</p>
                    </div>
                    
                    <div class="cof-step-body">
                        <div id="cof-review-summary">
                            <!-- Summary will be populated by JavaScript -->
                        </div>
                        
                        <div class="cof-form-group cof-form-full">
                            <label for="additional_notes">Additional Notes</label>
                            <textarea id="additional_notes" name="additional_notes" rows="3" class="cof-input-glass" placeholder="Any additional information or special requests?"></textarea>
                        </div>
                    </div>
                    
                    <div class="cof-step-footer">
                        <button type="button" class="cof-btn cof-btn-secondary cof-btn-prev">
                            ← Back
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