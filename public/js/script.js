jQuery(document).ready(function($) {
    'use strict';
    
    // Add these variables at the top
    let autoSaveInterval;
    let lastSaveTime = 0;

    const cofForm = {
        currentStep: 1,
        totalSteps: 6,
        formData: {},
        
        init: function() {
            this.setupEventListeners();
            this.showStep(1);
            this.setupAutoSave(); // enable auto-save
            this.setupSidebarNavigation(); // Add sidebar navigation
        },
        
        setupEventListeners: function() {
            $('.cof-btn-next').on('click', this.handleNextStep.bind(this));
            $('.cof-btn-prev').on('click', this.handlePrevStep.bind(this));
            $('.cof-form input, .cof-form textarea, .cof-form select').on('change', this.handleInputChange.bind(this));
            $('.cof-nav-savedraft').on('click', this.handleSaveDraft.bind(this));
        },
        
        setupSidebarNavigation: function() {
            $('.cof-step-item').on('click', function(e) {
                e.preventDefault();
                const targetStep = parseInt($(this).data('step'));
                
                // Only allow navigation to completed steps or the next step
                if (targetStep <= cofForm.currentStep || targetStep === cofForm.currentStep + 1) {
                    cofForm.showStep(targetStep);
                }
            });
        },
        
        handleSaveDraft: function(e) {
            e.preventDefault();
            this.autoSave();
            
            // Show feedback
            const $btn = $(e.target);
            const originalText = $btn.text();
            $btn.text('SAVED!');
            setTimeout(() => {
                $btn.text(originalText);
            }, 2000);
        },

        // -----------------------------
        // NEW AUTO-SAVE METHODS
        // -----------------------------
        setupAutoSave: function() {
            const autoSaveEnabled = true; // could be configurable in the future
            
            if (autoSaveEnabled) {
                // Auto-save on input change (debounced)
                $('.cof-form input, .cof-form textarea, .cof-form select').on(
                    'change input',
                    _.debounce(function() {
                        cofForm.autoSave();
                    }, 1000)
                );
                
                // Periodic auto-save every 30s
                autoSaveInterval = setInterval(() => {
                    cofForm.autoSave();
                }, 30000);
            }
        },
        
        autoSave: function() {
            const now = Date.now();
            if (now - lastSaveTime < 5000) return; // throttle (5s minimum gap)
            
            const currentData = this.collectStepData(this.currentStep);
            Object.assign(this.formData, currentData);
            
            $.ajax({
                url: cof_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'cof_save_draft',
                    nonce: cof_ajax.nonce,
                    data: this.formData
                },
                success: function(response) {
                    if (response.success) {
                        lastSaveTime = Date.now();
                        // Optional: tiny indicator like "Draft saved"
                        // $('#cof-save-status').text('Draft saved at ' + new Date().toLocaleTimeString());
                    }
                }
            });
        },
        // -----------------------------

        handleNextStep: function(e) {
            e.preventDefault();
            
            const currentStepData = this.collectStepData(this.currentStep);
            const errors = this.validateStepData(this.currentStep, currentStepData);
            
            if (errors.length > 0) {
                this.showErrors(errors);
                return;
            }
            
            Object.assign(this.formData, currentStepData);
            
            if (this.currentStep === this.totalSteps) {
                this.submitForm();
            } else {
                this.showStep(this.currentStep + 1);
            }
        },
        
        handlePrevStep: function(e) {
            e.preventDefault();
            this.showStep(this.currentStep - 1);
        },
        
        handleInputChange: function() {
            $('.cof-error').remove();
        },
        
        collectStepData: function(step) {
            const data = {};
            const $step = $(`.cof-step[data-step="${step}"]`);
            
            switch(step) {
                case 2:
                    data.project_name = $step.find('#project_name').val();
                    data.business_name = $step.find('#business_name').val();
                    data.contact_name = $step.find('#contact_name').val();
                    data.contact_email = $step.find('#contact_email').val();
                    data.contact_phone = $step.find('#contact_phone').val();
                    data.milestone_approver = $step.find('#milestone_approver').val();
                    data.billing_email = $step.find('#billing_email').val();
                    data.vat_number = $step.find('#vat_number').val();
                    data.preferred_contact = $step.find('input[name="preferred_contact"]:checked').val();
                    data.address_line1 = $step.find('#address_line1').val();
                    data.address_line2 = $step.find('#address_line2').val();
                    data.city = $step.find('#city').val();
                    data.country = $step.find('#country').val();
                    data.postal_code = $step.find('#postal_code').val();
                    break;
                    
                case 3:
                    data.project_budget = $step.find('#project_budget').val();
                    data.project_timeline = $step.find('#project_timeline').val();
                    data.website_url = $step.find('#website_url').val();
                    data.project_goals = $step.find('#project_goals').val();
                    data.target_audience = $step.find('#target_audience').val();
                    break;
                    
                case 4:
                    data.services = $step.find('input[name="services[]"]:checked').map(function() {
                        return $(this).val();
                    }).get();
                    data.reporting_requirements = $step.find('#reporting_requirements').val();
                    break;
                    
                case 5:
                    data.business_description = $step.find('#business_description').val();
                    data.brand_personality = $step.find('#brand_personality').val();
                    data.brand_values = $step.find('#brand_values').val();
                    data.competitor_analysis = $step.find('#competitor_analysis').val();
                    data.marketing_goals = $step.find('#marketing_goals').val();
                    data.current_challenges = $step.find('#current_challenges').val();
                    data.success_metrics = $step.find('#success_metrics').val();
                    break;
                    
                case 6:
                    data.additional_notes = $step.find('#additional_notes').val();
                    break;
            }
            
            return data;
        },
        
        validateStepData: function(step, data) {
            const errors = [];
            
            switch(step) {
                case 2:
                    if (!data.project_name) errors.push('Project name is required');
                    if (!data.business_name) errors.push('Business name is required');
                    if (!data.contact_name) errors.push('Contact name is required');
                    if (!data.contact_email) errors.push('Contact email is required');
                    if (data.contact_email && !this.isValidEmail(data.contact_email)) {
                        errors.push('Please enter a valid email address');
                    }
                    break;
                    
                case 3:
                    // Technical information validation can be added here
                    break;
            }
            
            return errors;
        },
        
        isValidEmail: function(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        },
        
        showErrors: function(errors) {
            $('.cof-error').remove();
            
            errors.forEach(error => {
                $('.cof-step.active').prepend(
                    `<div class="cof-error">${error}</div>`
                );
            });
        },
        
        showStep: function(step) {
            $('.cof-step').removeClass('active');
            $(`.cof-step[data-step="${step}"]`).addClass('active');
            
            $('.cof-step-item').removeClass('active completed');
            
            $('.cof-step-item').each(function(index) {
                const stepNumber = index + 1;
                if (stepNumber < step) {
                    $(this).addClass('completed');
                    $(this).find('.cof-step-number').html('✓');
                } else if (stepNumber === step) {
                    $(this).addClass('active');
                    $(this).find('.cof-step-number').html(stepNumber);
                } else {
                    $(this).find('.cof-step-number').html(stepNumber);
                }
            });
            
            $('.cof-btn-prev').toggle(step > 1);
            
            if (step === this.totalSteps) {
                $('.cof-btn-next').text('Submit').addClass('cof-btn-submit');
                this.updateReviewSummary();
            } else {
                $('.cof-btn-next').text('Next →').removeClass('cof-btn-submit');
            }
            
            this.currentStep = step;
        },
        
        updateReviewSummary: function() {
            const summaryHtml = `
                <h3>Client Information</h3>
                <p><strong>Project Name:</strong> ${this.formData.project_name || 'Not provided'}</p>
                <p><strong>Business Name:</strong> ${this.formData.business_name || 'Not provided'}</p>
                <p><strong>Contact:</strong> ${this.formData.contact_name} (${this.formData.contact_email})</p>
                
                <h3>Technical Information</h3>
                <p><strong>Budget:</strong> ${this.formData.project_budget || 'Not specified'}</p>
                <p><strong>Timeline:</strong> ${this.formData.project_timeline || 'Not specified'}</p>
                
                <h3>Services & Reporting</h3>
                <p>${this.formData.services ? this.formData.services.join(', ') : 'No services selected'}</p>
            `;
            
            $('#cof-review-summary').html(summaryHtml);
        },
        
        submitForm: function() {
            const finalData = this.collectStepData(6);
            Object.assign(this.formData, finalData);
            
            $.ajax({
                url: cof_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'cof_submit_form',
                    nonce: cof_ajax.nonce,
                    step: 6,
                    data: this.formData
                },
                beforeSend: function() {
                    $('.cof-btn').prop('disabled', true);
                    $('.cof-btn-next').text('Submitting...');
                },
                success: function(response) {
                    if (response.success) {
                        cofForm.showSuccess();
                    } else {
                        alert('Error: ' + response.data.message);
                        $('.cof-btn').prop('disabled', false);
                        $('.cof-btn-next').text('Submit');
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                    $('.cof-btn').prop('disabled', false);
                    $('.cof-btn-next').text('Submit');
                }
            });
        },
        
        showSuccess: function() {
            if (autoSaveInterval) {
                clearInterval(autoSaveInterval); // stop auto-save on success
            }
            $('.cof-form-container').html(`
                <div class="cof-success-message">
                    <div class="cof-success-icon">✓</div>
                    <h2>Thank You!</h2>
                    <p>Your submission has been received successfully.</p>
                    <p>We'll be in touch with you shortly.</p>
                </div>
            `);
        }
    };
    
    // Initialize the form
    if ($('.cof-form').length) {
        cofForm.init();
    }
    
    // Modal handling
    $('.cof-modal-close').on('click', function() {
        $('#cof-success-modal').fadeOut();
    });

    $(document).on('keyup', function(e) {
        if (e.key === 'Escape') {
            $('#cof-success-modal').fadeOut();
        }
    });

    $(document).on('click', function(e) {
        if ($(e.target).hasClass('cof-modal')) {
            $('#cof-success-modal').fadeOut();
        }
    });
});