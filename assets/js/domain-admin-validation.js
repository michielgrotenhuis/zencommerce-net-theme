/**
 * Domain Admin Validation JavaScript
 * 
 * Handles real-time validation in the WordPress admin
 */

(function($) {
    'use strict';
    
    // Validation state
    const validationState = {
        errors: {},
        isValidating: {},
        debounceTimers: {}
    };
    
    // Initialize validation when document is ready
    $(document).ready(function() {
        initializeValidation();
        bindValidationEvents();
        setupFormSubmission();
    });
    
    /**
     * Initialize validation system
     */
    function initializeValidation() {
        // Create validation message containers
        createValidationContainers();
        
        // Show existing validation errors
        showExistingErrors();
        
        // Initialize character counters
        initializeCharCounters();
    }
    
    /**
     * Create validation message containers
     */
    function createValidationContainers() {
        const fields = [
            'domain_tld',
            'domain_product_id', 
            'domain_registration_price',
            'domain_renewal_price',
            'domain_transfer_price',
            'domain_restoration_price',
            'domain_hero_h1',
            'domain_hero_subtitle',
            'domain_min_length',
            'domain_max_length',
            'domain_registry'
        ];
        
        fields.forEach(function(fieldId) {
            const field = $('#' + fieldId);
            if (field.length && !field.siblings('.validation-message').length) {
                field.after('<div class="validation-message" id="' + fieldId + '_validation"></div>');
            }
        });
    }
    
    /**
     * Show existing validation errors from server
     */
    function showExistingErrors() {
        if (typeof domainValidationErrors !== 'undefined') {
            Object.keys(domainValidationErrors).forEach(function(field) {
                showFieldError(field, domainValidationErrors[field]);
            });
        }
    }
    
    /**
     * Initialize character counters
     */
    function initializeCharCounters() {
        $('input[maxlength], textarea[maxlength]').each(function() {
            const field = $(this);
            const maxLength = field.attr('maxlength');
            const currentLength = field.val().length;
            
            updateCharCounter(field, currentLength, maxLength);
        });
    }
    
    /**
     * Bind validation events to form fields
     */
    function bindValidationEvents() {
        // TLD validation
        $('#domain_tld').on('blur keyup', function() {
            debounceValidation(this, validateTLD, 500);
        });
        
        // Product ID validation
        $('#domain_product_id').on('blur', function() {
            debounceValidation(this, validateProductId, 300);
        });
        
        // Price field validation
        $('.price-input').on('blur keyup', function() {
            debounceValidation(this, validatePrice, 300);
        });
        
        // Length field validation
        $('#domain_min_length, #domain_max_length').on('blur keyup', function() {
            debounceValidation(this, validateLength, 200);
        });
        
        // Text field validation
        $('#domain_hero_h1, #domain_hero_subtitle').on('keyup', function() {
            debounceValidation(this, validateText, 500);
        });
        
        // Registry validation
        $('#domain_registry').on('blur', function() {
            debounceValidation(this, validateRegistry, 300);
        });
        
        // Character counters
        $('input[maxlength], textarea[maxlength]').on('keyup paste', function() {
            const field = $(this);
            const maxLength = field.attr('maxlength');
            const currentLength = field.val().length;
            
            updateCharCounter(field, currentLength, maxLength);
        });
        
        // FAQ validation
        $(document).on('keyup', '.faq-question-input, .faq-answer-input', function() {
            debounceValidation(this, validateFAQ, 500);
        });
        
        // Cross-field validation
        $('#domain_min_length, #domain_max_length').on('change', function() {
            validateLengthRelationship();
        });
        
        $('#domain_registration_price, #domain_renewal_price').on('change', function() {
            validatePriceRelationship();
        });
    }
    
    /**
     * Debounce validation to avoid excessive API calls
     */
    function debounceValidation(element, validationFunction, delay) {
        const fieldId = $(element).attr('id');
        
        // Clear existing timer
        if (validationState.debounceTimers[fieldId]) {
            clearTimeout(validationState.debounceTimers[fieldId]);
        }
        
        // Set new timer
        validationState.debounceTimers[fieldId] = setTimeout(function() {
            validationFunction(element);
        }, delay);
    }
    
    /**
     * Validate TLD field
     */
    function validateTLD(element) {
        const field = $(element);
        const value = field.val().trim();
        const postId = $('#post_ID').val() || 0;
        
        if (!value) {
            clearFieldValidation(field);
            return;
        }
        
        showFieldLoading(field);
        
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'validate_domain_field',
                field: 'tld',
                value: value,
                post_id: postId,
                nonce: domainAdmin.nonce
            },
            success: function(response) {
                hideFieldLoading(field);
                
                if (response.success) {
                    if (response.data.valid) {
                        showFieldSuccess(field, response.data.message);
                        updateDomainPreview(response.data);
                    } else {
                        showFieldError(field, response.data.message);
                    }
                } else {
                    showFieldError(field, response.data);
                }
            },
            error: function() {
                hideFieldLoading(field);
                showFieldError(field, domainAdmin.strings.error);
            }
        });
    }
    
    /**
     * Validate Product ID field
     */
    function validateProductId(element) {
        const field = $(element);
        const value = field.val().trim();
        const postId = $('#post_ID').val() || 0;
        
        if (!value) {
            clearFieldValidation(field);
            return;
        }
        
        showFieldLoading(field);
        
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'validate_domain_field',
                field: 'product_id',
                value: value,
                post_id: postId,
                nonce: domainAdmin.nonce
            },
            success: function(response) {
                hideFieldLoading(field);
                
                if (response.success) {
                    if (response.data.valid) {
                        showFieldSuccess(field, response.data.message || 'Product ID is available');
                    } else {
                        showFieldError(field, response.data.message);
                    }
                } else {
                    showFieldError(field, response.data);
                }
            },
            error: function() {
                hideFieldLoading(field);
                showFieldError(field, domainAdmin.strings.error);
            }
        });
    }
    
    /**
     * Validate price field
     */
    function validatePrice(element) {
        const field = $(element);
        const value = field.val().trim();
        const fieldName = field.attr('name').replace('domain_', '');
        
        if (!value) {
            clearFieldValidation(field);
            return;
        }
        
        // Client-side validation first
        const numValue = parseFloat(value);
        
        if (isNaN(numValue) || numValue < 0) {
            showFieldError(field, 'Price must be a positive number');
            return;
        }
        
        if (numValue > 99999.99) {
            showFieldError(field, 'Price cannot exceed $99,999.99');
            return;
        }
        
        showFieldSuccess(field, 'Valid price');
        updatePricingSummary();
    }
    
    /**
     * Validate length field
     */
    function validateLength(element) {
        const field = $(element);
        const value = field.val().trim();
        
        if (!value) {
            clearFieldValidation(field);
            return;
        }
        
        const numValue = parseInt(value);
        
        if (isNaN(numValue) || numValue < 1 || numValue > 63) {
            showFieldError(field, 'Length must be between 1 and 63 characters');
            return;
        }
        
        showFieldSuccess(field, 'Valid length');
    }
    
    /**
     * Validate text field
     */
    function validateText(element) {
        const field = $(element);
        const value = field.val().trim();
        
        if (!value) {
            clearFieldValidation(field);
            return;
        }
        
        // Check for suspicious patterns
        const suspiciousPatterns = [
            /\b(viagra|cialis|pharmacy)\b/i,
            /\b(casino|gambling|poker)\b/i,
            /\b(click here|free money)\b/i
        ];
        
        for (let pattern of suspiciousPatterns) {
            if (pattern.test(value)) {
                showFieldError(field, 'Content appears to contain suspicious text');
                return;
            }
        }
        
        // Check excessive capitalization
        if (value.length > 20) {
            const uppercaseRatio = (value.match(/[A-Z]/g) || []).length / value.length;
            if (uppercaseRatio > 0.5) {
                showFieldError(field, 'Too much uppercase text');
                return;
            }
        }
        
        clearFieldValidation(field);
    }
    
    /**
     * Validate registry field
     */
    function validateRegistry(element) {
        const field = $(element);
        const value = field.val().trim();
        
        if (!value) {
            clearFieldValidation(field);
            return;
        }
        
        // Basic format validation
        if (!/^[a-zA-Z0-9\s\-&.,()]+$/.test(value)) {
            showFieldError(field, 'Registry name contains invalid characters');
            return;
        }
        
        clearFieldValidation(field);
    }
    
    /**
     * Validate FAQ field
     */
    function validateFAQ(element) {
        const field = $(element);
        const value = field.val().trim();
        const isQuestion = field.hasClass('faq-question-input');
        const maxLength = isQuestion ? 200 : 1000;
        
        if (value.length > maxLength) {
            showFieldError(field, `Cannot exceed ${maxLength} characters`);
            return;
        }
        
        clearFieldValidation(field);
        updateFAQPreview(field);
    }
    
    /**
     * Validate length relationship
     */
    function validateLengthRelationship() {
        const minField = $('#domain_min_length');
        const maxField = $('#domain_max_length');
        const minValue = parseInt(minField.val());
        const maxValue = parseInt(maxField.val());
        
        if (minValue && maxValue && minValue > maxValue) {
            showFieldError(minField, 'Minimum length cannot be greater than maximum length');
            showFieldError(maxField, 'Maximum length cannot be less than minimum length');
        } else {
            if (minValue && minValue <= 63) clearFieldValidation(minField);
            if (maxValue && maxValue >= 1) clearFieldValidation(maxField);
        }
        
        updatePolicyPreview();
    }
    
    /**
     * Validate price relationship
     */
    function validatePriceRelationship() {
        const regField = $('#domain_registration_price');
        const renewField = $('#domain_renewal_price');
        const regPrice = parseFloat(regField.val());
        const renewPrice = parseFloat(renewField.val());
        
        if (regPrice && renewPrice && Math.abs(regPrice - renewPrice) > (regPrice * 3)) {
            showFieldWarning(renewField, 'Renewal price seems unusually different from registration price');
        }
    }
    
    /**
     * Show field loading state
     */
    function showFieldLoading(field) {
        const fieldId = field.attr('id');
        validationState.isValidating[fieldId] = true;
        
        const message = field.siblings('.validation-message');
        message.html('<span class="validating"><span class="dashicons dashicons-update spin"></span> Validating...</span>');
        message.removeClass('error success warning').addClass('loading');
    }
    
    /**
     * Hide field loading state
     */
    function hideFieldLoading(field) {
        const fieldId = field.attr('id');
        validationState.isValidating[fieldId] = false;
    }
    
    /**
     * Show field success message
     */
    function showFieldSuccess(field, message) {
        const messageContainer = field.siblings('.validation-message');
        messageContainer.html('<span class="success"><span class="dashicons dashicons-yes"></span> ' + message + '</span>');
        messageContainer.removeClass('error loading warning').addClass('success');
        
        delete validationState.errors[field.attr('id')];
    }
    
    /**
     * Show field error message
     */
    function showFieldError(field, message) {
        const fieldId = typeof field === 'string' ? field : field.attr('id');
        const fieldElement = typeof field === 'string' ? $('#' + field) : field;
        
        const messageContainer = fieldElement.siblings('.validation-message');
        messageContainer.html('<span class="error"><span class="dashicons dashicons-warning"></span> ' + message + '</span>');
        messageContainer.removeClass('success loading warning').addClass('error');
        
        validationState.errors[fieldId] = message;
    }
    
    /**
     * Show field warning message
     */
    function showFieldWarning(field, message) {
        const messageContainer = field.siblings('.validation-message');
        messageContainer.html('<span class="warning"><span class="dashicons dashicons-info"></span> ' + message + '</span>');
        messageContainer.removeClass('error loading success').addClass('warning');
    }
    
    /**
     * Clear field validation
     */
    function clearFieldValidation(field) {
        const fieldId = field.attr('id');
        const messageContainer = field.siblings('.validation-message');
        messageContainer.html('').removeClass('error success warning loading');
        
        delete validationState.errors[fieldId];
    }
    
    /**
     * Update character counter
     */
    function updateCharCounter(field, current, max) {
        const counter = field.siblings('.description').find('.char-count');
        if (counter.length) {
            counter.text(current + '/' + max);
            
            if (current > max * 0.9) {
                counter.css('color', '#dc3232');
            } else if (current > max * 0.7) {
                counter.css('color', '#ffb900');
            } else {
                counter.css('color', '#46b450');
            }
        }
    }
    
    /**
     * Update domain preview
     */
    function updateDomainPreview(data) {
        if (data.url && data.slug) {
            $('#preview-url').text(data.url);
            $('#preview-slug').text(data.slug);
            $('#domain-preview').show();
        }
    }
    
    /**
     * Update pricing summary
     */
    function updatePricingSummary() {
        const regPrice = parseFloat($('#domain_registration_price').val()) || 0;
        const renewPrice = parseFloat($('#domain_renewal_price').val()) || 0;
        
        let summary = '';
        if (regPrice > 0) {
            summary += '<p><strong>1st Year:</strong> $' + regPrice.toFixed(2) + '</p>';
            if (renewPrice > 0) {
                summary += '<p><strong>2nd Year:</strong> $' + (regPrice + renewPrice).toFixed(2) + '</p>';
                summary += '<p><strong>3rd Year:</strong> $' + (regPrice + renewPrice * 2).toFixed(2) + '</p>';
            }
        }
        
        $('#pricing-summary .summary-content').html(summary);
    }
    
    /**
     * Update policy preview
     */
    function updatePolicyPreview() {
        const minLength = $('#domain_min_length').val() || 2;
        const maxLength = $('#domain_max_length').val() || 63;
        const numbersAllowed = $('#domain_numbers_allowed').is(':checked');
        const hyphensAllowed = $('#domain_hyphens_allowed').val();
        const idnAllowed = $('#domain_idn_allowed').is(':checked');
        
        let policy = `Length: ${minLength}-${maxLength} characters. `;
        policy += 'Allowed: letters';
        
        if (numbersAllowed) policy += ', numbers';
        if (hyphensAllowed !== 'none') {
            policy += ', hyphens';
            if (hyphensAllowed === 'middle') policy += ' (middle only)';
        }
        if (idnAllowed) policy += ', international characters';
        
        $('#policy-preview-text').text(policy);
    }
    
    /**
     * Update FAQ preview
     */
    function updateFAQPreview(field) {
        const faqItem = field.closest('.faq-item');
        const question = faqItem.find('.faq-question-input').val();
        const answer = faqItem.find('.faq-answer-input').val();
        
        const previewQuestion = faqItem.find('.faq-preview-question');
        const previewAnswer = faqItem.find('.faq-preview-answer');
        
        if (question) {
            previewQuestion.html('<strong>' + escapeHtml(question) + '</strong>');
        } else {
            previewQuestion.html('<em>Question will appear here...</em>');
        }
        
        if (answer) {
            previewAnswer.html(answer); // Allow basic HTML in answers
        } else {
            previewAnswer.html('<em>Answer will appear here...</em>');
        }
        
        // Update status
        const status = faqItem.find('.faq-status span');
        if (question && answer) {
            status.removeClass('status-incomplete').addClass('status-complete');
            status.find('.dashicons').removeClass('dashicons-warning').addClass('dashicons-yes-alt');
        } else {
            status.removeClass('status-complete').addClass('status-incomplete');
            status.find('.dashicons').removeClass('dashicons-yes-alt').addClass('dashicons-warning');
        }
    }
    
    /**
     * Setup form submission validation
     */
    function setupFormSubmission() {
        $('#post').on('submit', function(e) {
            // Check if there are any validation errors
            const hasErrors = Object.keys(validationState.errors).length > 0;
            const isValidating = Object.values(validationState.isValidating).some(Boolean);
            
            if (hasErrors) {
                e.preventDefault();
                alert('Please fix validation errors before saving.');
                
                // Focus on first error field
                const firstErrorField = Object.keys(validationState.errors)[0];
                $('#' + firstErrorField).focus();
                
                return false;
            }
            
            if (isValidating) {
                e.preventDefault();
                alert('Please wait for validation to complete before saving.');
                return false;
            }
        });
    }
    
    /**
     * Escape HTML for safe display
     */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // CSS for validation messages
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .validation-message {
                margin-top: 5px;
                font-size: 13px;
                line-height: 1.4;
            }
            
            .validation-message .success {
                color: #46b450;
            }
            
            .validation-message .error {
                color: #dc3232;
            }
            
            .validation-message .warning {
                color: #ffb900;
            }
            
            .validation-message .validating {
                color: #0073aa;
            }
            
            .validation-message .dashicons {
                font-size: 14px;
                margin-right: 3px;
            }
            
            .validation-message .spin {
                animation: rotation 1s infinite linear;
            }
            
            @keyframes rotation {
                from { transform: rotate(0deg); }
                to { transform: rotate(359deg); }
            }
            
            .char-count {
                font-weight: 600;
            }
        `)
        .appendTo('head');

})(jQuery);