/**
 * Domain Archive JavaScript
 * 
 * @package DomainSystem
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // DOM Ready
    $(document).ready(function() {
        initDomainArchive();
    });

    /**
     * Initialize Domain Archive functionality
     */
    function initDomainArchive() {
        initSearchForm();
        initCategoriesToggle();
        initSuggestionButtons();
        initSmoothScroll();
        initFAQToggles();
        initPricingCards();
        initTooltips();
    }

    /**
     * Initialize domain search form
     */
    function initSearchForm() {
        const $form = $('#domain-search-form');
        const $input = $('#domain-name-input');
        const $button = $('#search-btn');
        const $results = $('#domain-search-results');
        const $noResults = $('#no-results-message');

        if (!$form.length) return;

        $form.on('submit', function(e) {
            e.preventDefault();
            
            const domainName = $input.val().trim();
            if (!domainName) {
                showNotification('Please enter a domain name', 'error');
                return;
            }

            // Show loading state
            showLoadingState($button);
            
            // Simulate domain search (replace with actual AJAX call)
            setTimeout(() => {
                searchDomains(domainName);
                hideLoadingState($button);
            }, 1500);
        });

        // Real-time validation
        $input.on('input', function() {
            const value = $(this).val().trim();
            validateDomainInput(value);
        });
    }

    /**
     * Search for domains
     */
    function searchDomains(domainName) {
        const $results = $('#domain-search-results');
        const $resultsGrid = $('#results-grid');
        const $noResults = $('#no-results-message');

        // Hide previous results
        $results.hide();
        $noResults.hide();

        // Sample domain results (replace with actual API call)
        const sampleResults = [
            { tld: '.com', price: '5.99', available: true, popular: true },
            { tld: '.org', price: '6.99', available: true, popular: false },
            { tld: '.net', price: '11.99', available: false, popular: false },
            { tld: '.io', price: '29.99', available: true, popular: true },
            { tld: '.co', price: '8.99', available: true, popular: false },
            { tld: '.app', price: '5.99', available: true, popular: true }
        ];

        // Clear previous results
        $resultsGrid.empty();

        // Filter available domains
        const availableDomains = sampleResults.filter(domain => domain.available);

        if (availableDomains.length === 0) {
            $noResults.fadeIn();
            return;
        }

        // Populate results
        availableDomains.forEach(domain => {
            const resultHTML = createDomainResult(domainName, domain);
            $resultsGrid.append(resultHTML);
        });

        // Show results with animation
        $results.fadeIn();
        
        // Scroll to results
        $('html, body').animate({
            scrollTop: $results.offset().top - 100
        }, 800);
    }

    /**
     * Create domain result HTML
     */
    function createDomainResult(domainName, domain) {
        const popularBadge = domain.popular ? '<span class="popular-badge">Popular</span>' : '';
        
        return `
            <div class="domain-result-card" data-tld="${domain.tld}">
                ${popularBadge}
                <div class="result-header">
                    <h4 class="result-domain">${domainName}${domain.tld}</h4>
                    <div class="result-price">
                        <span class="price-amount">${domain.price}</span>
                        <span class="price-period">/year</span>
                    </div>
                </div>
                <div class="result-features">
                    <span class="feature-item">✓ Free Privacy Protection</span>
                    <span class="feature-item">✓ Free DNS Management</span>
                    <span class="feature-item">✓ 24/7 Support</span>
                </div>
                <button class="register-domain-btn" data-domain="${domainName}${domain.tld}" data-price="${domain.price}">
                    Register Now
                </button>
            </div>
        `;
    }

    /**
     * Initialize categories toggle
     */
    function initCategoriesToggle() {
        const $toggle = $('#categories-toggle');
        const $hiddenCards = $('.category-hidden');

        if (!$toggle.length) return;

        $toggle.on('click', function() {
            const isExpanded = $(this).hasClass('active');
            
            if (isExpanded) {
                // Hide categories
                $hiddenCards.slideUp();
                $(this).removeClass('active');
                $(this).find('.toggle-text').text('Show All Categories');
            } else {
                // Show categories
                $hiddenCards.slideDown();
                $(this).addClass('active');
                $(this).find('.toggle-text').text('Show Less Categories');
            }
        });
    }

    /**
     * Initialize suggestion buttons
     */
    function initSuggestionButtons() {
        $('.suggestion-btn').on('click', function() {
            const extension = $(this).data('extension');
            const $input = $('#domain-name-input');
            
            if ($input.length && extension) {
                // Focus input and trigger search with extension
                $input.focus();
                
                // Add visual feedback
                $(this).addClass('selected');
                setTimeout(() => {
                    $(this).removeClass('selected');
                }, 200);
            }
        });
    }

    /**
     * Initialize smooth scrolling
     */
    function initSmoothScroll() {
        $('.scroll-to').on('click', function(e) {
            e.preventDefault();
            
            const target = $(this).attr('href');
            const $target = $(target);
            
            if ($target.length) {
                $('html, body').animate({
                    scrollTop: $target.offset().top - 80
                }, 800);
            }
        });
    }

    /**
     * Initialize FAQ toggles
     */
    function initFAQToggles() {
        $('.faq-item').each(function() {
            const $item = $(this);
            const $question = $item.find('.faq-question');
            const $answer = $item.find('.faq-answer');
            const $toggle = $item.find('.question-toggle');

            $question.on('click', function() {
                const isOpen = $item.hasClass('open');
                
                // Close all other FAQs
                $('.faq-item').removeClass('open');
                $('.faq-answer').slideUp();
                $('.question-toggle').attr('aria-expanded', 'false');
                
                if (!isOpen) {
                    // Open this FAQ
                    $item.addClass('open');
                    $answer.slideDown();
                    $toggle.attr('aria-expanded', 'true');
                }
            });
        });
    }

    /**
     * Initialize pricing cards interactions
     */
    function initPricingCards() {
        $('.pricing-card').on('mouseenter', function() {
            $(this).addClass('hovered');
        }).on('mouseleave', function() {
            $(this).removeClass('hovered');
        });

        // Register button clicks
        $('.register-btn').on('click', function() {
            const tld = $(this).data('tld');
            showRegistrationModal(tld);
        });

        // Domain result register buttons
        $(document).on('click', '.register-domain-btn', function() {
            const domain = $(this).data('domain');
            const price = $(this).data('price');
            showRegistrationModal(domain, price);
        });
    }

    /**
     * Initialize tooltips
     */
    function initTooltips() {
        // Add tooltips to various elements
        $('[data-tooltip]').each(function() {
            const $element = $(this);
            const tooltipText = $element.data('tooltip');
            
            $element.on('mouseenter', function() {
                showTooltip($element, tooltipText);
            }).on('mouseleave', function() {
                hideTooltip();
            });
        });
    }

    /**
     * Show loading state
     */
    function showLoadingState($button) {
        const $icon = $button.find('.search-icon');
        const $spinner = $button.find('.loading-spinner');
        const $text = $button.find('.btn-text');
        
        $icon.hide();
        $spinner.show();
        $text.text('Searching...');
        $button.prop('disabled', true);
    }

    /**
     * Hide loading state
     */
    function hideLoadingState($button) {
        const $icon = $button.find('.search-icon');
        const $spinner = $button.find('.loading-spinner');
        const $text = $button.find('.btn-text');
        
        $spinner.hide();
        $icon.show();
        $text.text('Search');
        $button.prop('disabled', false);
    }

    /**
     * Validate domain input
     */
    function validateDomainInput(value) {
        const $input = $('#domain-name-input');
        const isValid = /^[a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]$/.test(value) || /^[a-zA-Z0-9]$/.test(value);
        
        if (value.length > 0 && !isValid) {
            $input.addClass('invalid');
            showInputError('Domain name can only contain letters, numbers, and hyphens');
        } else {
            $input.removeClass('invalid');
            hideInputError();
        }
    }

    /**
     * Show input error
     */
    function showInputError(message) {
        let $error = $('.domain-input-error');
        if (!$error.length) {
            $error = $('<div class="domain-input-error"></div>');
            $('#domain-name-input').after($error);
        }
        $error.text(message).slideDown();
    }

    /**
     * Hide input error
     */
    function hideInputError() {
        $('.domain-input-error').slideUp();
    }

    /**
     * Show registration modal
     */
    function showRegistrationModal(domain, price = null) {
        // Create modal HTML
        const modalHTML = `
            <div class="domain-modal-overlay" id="registration-modal">
                <div class="domain-modal">
                    <div class="modal-header">
                        <h3>Register ${domain}</h3>
                        <button class="modal-close">&times;</button>
                    </div>
                    <div class="modal-content">
                        <div class="domain-info">
                            <div class="domain-name">${domain}</div>
                            ${price ? `<div class="domain-price">${price}/year</div>` : ''}
                        </div>
                        <div class="registration-form">
                            <p>Complete your domain registration:</p>
                            <button class="continue-btn">Continue to Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Add modal to page
        $('body').append(modalHTML);
        
        // Show modal with animation
        const $modal = $('#registration-modal');
        $modal.fadeIn();
        
        // Close modal handlers
        $modal.find('.modal-close, .domain-modal-overlay').on('click', function(e) {
            if (e.target === this) {
                closeRegistrationModal();
            }
        });
        
        // Prevent modal content clicks from closing modal
        $modal.find('.domain-modal').on('click', function(e) {
            e.stopPropagation();
        });
    }

    /**
     * Close registration modal
     */
    function closeRegistrationModal() {
        const $modal = $('#registration-modal');
        $modal.fadeOut(function() {
            $modal.remove();
        });
    }

    /**
     * Show tooltip
     */
    function showTooltip($element, text) {
        const tooltip = $('<div class="domain-tooltip"></div>').text(text);
        $('body').append(tooltip);
        
        const elementOffset = $element.offset();
        const elementHeight = $element.outerHeight();
        
        tooltip.css({
            position: 'absolute',
            top: elementOffset.top + elementHeight + 5,
            left: elementOffset.left,
            zIndex: 9999
        }).fadeIn();
    }

    /**
     * Hide tooltip
     */
    function hideTooltip() {
        $('.domain-tooltip').fadeOut(function() {
            $(this).remove();
        });
    }

    /**
     * Show notification
     */
    function showNotification(message, type = 'info') {
        const notificationHTML = `
            <div class="domain-notification ${type}">
                <span class="notification-text">${message}</span>
                <button class="notification-close">&times;</button>
            </div>
        `;
        
        const $notification = $(notificationHTML);
        $('body').append($notification);
        
        // Position notification
        $notification.css({
            position: 'fixed',
            top: '20px',
            right: '20px',
            zIndex: 10000
        });
        
        // Show notification
        $notification.slideDown();
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            $notification.slideUp(function() {
                $notification.remove();
            });
        }, 5000);
        
        // Manual close
        $notification.find('.notification-close').on('click', function() {
            $notification.slideUp(function() {
                $notification.remove();
            });
        });
    }

    /**
     * Debounce function
     */
    function debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction() {
            const context = this;
            const args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    // Expose public methods
    window.DomainArchive = {
        searchDomains: searchDomains,
        showNotification: showNotification,
        showRegistrationModal: showRegistrationModal,
        closeRegistrationModal: closeRegistrationModal
    };

})(jQuery);