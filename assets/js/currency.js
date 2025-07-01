/**
 * Enhanced Currency System - Guest User Support
 * This file fixes the currency switching for non-logged-in users
 * Add this to your theme's main JS file or enqueue separately
 */

(function($) {
    'use strict';
    
    // Enhanced Currency System with Guest Support
    window.YourSiteCurrency = window.YourSiteCurrency || {
        current: 'USD',
        ajaxUrl: window.location.origin + '/wp-admin/admin-ajax.php',
        nonce: '',
        cookieName: 'yoursite_preferred_currency',
        debug: false,
        currencies: {},
        isLoading: false,
        isGuest: true // Assume guest by default
    };
    
    const CurrencySystem = {
        
        /**
         * Initialize the currency system
         */
        init: function() {
            this.detectUserType();
            this.loadSavedCurrency();
            this.bindEvents();
            this.loadAvailableCurrencies();
            this.initializeFromCookie();
            
            if (window.YourSiteCurrency.debug) {
                console.log('YourSite Currency System Initialized');
                console.log('Current Currency:', window.YourSiteCurrency.current);
                console.log('User Type:', window.YourSiteCurrency.isGuest ? 'Guest' : 'Logged In');
            }
        },
        
        /**
         * Detect if user is logged in or guest
         */
        detectUserType: function() {
            // Check if WordPress admin bar exists or other indicators
            window.YourSiteCurrency.isGuest = !document.body.classList.contains('logged-in') && 
                                             !document.getElementById('wpadminbar') &&
                                             !window.wp;
        },
        
        /**
         * Initialize currency from cookie on page load
         */
        initializeFromCookie: function() {
            const cookieCurrency = this.getCookie(window.YourSiteCurrency.cookieName);
            if (cookieCurrency && cookieCurrency !== window.YourSiteCurrency.current) {
                window.YourSiteCurrency.current = cookieCurrency;
                this.updateAllSelectors(cookieCurrency);
                
                // For guests, immediately update pricing without server call
                if (window.YourSiteCurrency.isGuest) {
                    this.updatePricingDisplaysGuest(cookieCurrency);
                }
                
                if (window.YourSiteCurrency.debug) {
                    console.log('Initialized currency from cookie:', cookieCurrency);
                }
            }
        },
        
        /**
         * Bind all currency-related events
         */
        bindEvents: function() {
            const self = this;
            
            // Handle currency dropdown/selector clicks
            $(document).on('click', '.currency-selector-item, .currency-dropdown-item, .currency-flag-item, .currency-compact-item, [data-currency-code], [data-currency]', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const currencyCode = $(this).data('currency') || $(this).data('currency-code') || $(this).data('currencyCode');
                if (currencyCode && currencyCode !== window.YourSiteCurrency.current) {
                    self.switchCurrency(currencyCode);
                }
            });
            
            // Handle dropdown toggles
            $(document).on('click', '.currency-selector-toggle, .currency-dropdown-toggle', function(e) {
                e.preventDefault();
                e.stopPropagation();
                self.toggleDropdown($(this));
            });
            
            // Close dropdowns when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.currency-selector-container, .fancy-selector-wrapper').length) {
                    self.closeAllDropdowns();
                }
            });
            
            // Keyboard support
            $(document).on('keydown', '.currency-selector-toggle, .currency-dropdown-toggle, [data-currency-code], [data-currency]', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $(this).click();
                } else if (e.key === 'Escape') {
                    self.closeAllDropdowns();
                }
            });
        },
        
        /**
         * Main currency switching function - Enhanced for guests
         */
        switchCurrency: function(currencyCode) {
            if (this.isLoading) {
                console.log('Currency switch already in progress');
                return Promise.resolve();
            }
            
            if (currencyCode === window.YourSiteCurrency.current) {
                console.log('Currency already selected:', currencyCode);
                return Promise.resolve();
            }
            
            this.isLoading = true;
            this.showLoading();
            
            const oldCurrency = window.YourSiteCurrency.current;
            
            // 1. Set cookie immediately (works for both guests and logged-in users)
            this.setCookie(window.YourSiteCurrency.cookieName, currencyCode, 30);
            
            // 2. Update current currency
            window.YourSiteCurrency.current = currencyCode;
            
            // 3. Update UI immediately
            this.updateAllSelectors(currencyCode);
            this.closeAllDropdowns();
            
            // 4. Different handling for guests vs logged-in users
            let updatePromise;
            
            if (window.YourSiteCurrency.isGuest) {
                // For guests: Update pricing using client-side conversion
                updatePromise = this.updatePricingDisplaysGuest(currencyCode);
            } else {
                // For logged-in users: Use server-side update
                updatePromise = this.updateServerCurrency(currencyCode)
                    .then(() => this.updateAllPricing());
            }
            
            return updatePromise
                .then(() => {
                    this.showSuccessMessage(currencyCode);
                    this.triggerCurrencyChangeEvent(oldCurrency, currencyCode);
                })
                .catch((error) => {
                    // Rollback on error
                    window.YourSiteCurrency.current = oldCurrency;
                    this.updateAllSelectors(oldCurrency);
                    this.showErrorMessage('Failed to switch currency: ' + error.message);
                    
                    if (window.YourSiteCurrency.debug) {
                        console.error('Currency switch error:', error);
                    }
                })
                .finally(() => {
                    this.isLoading = false;
                    this.hideLoading();
                });
        },
        
        /**
         * Update pricing displays for guest users (client-side)
         */
        updatePricingDisplaysGuest: function(currencyCode) {
            return new Promise((resolve) => {
                try {
                    // Get currency info
                    const currencyInfo = this.getCurrencyInfo(currencyCode);
                    if (!currencyInfo) {
                        console.warn('Currency info not found for:', currencyCode);
                        resolve();
                        return;
                    }
                    
                    // Update currency symbols and basic formatting
                    this.updateCurrencySymbols(currencyCode, currencyInfo);
                    
                    // For pricing cards, we'll do basic symbol replacement
                    // This is a simplified approach - you might want to implement
                    // proper conversion rates for guest users
                    this.updatePricingSymbols(currencyCode, currencyInfo);
                    
                    // Dispatch event for other components
                    $(document).trigger('currencyChanged', {
                        oldCurrency: window.YourSiteCurrency.current,
                        newCurrency: currencyCode,
                        userType: 'guest'
                    });
                    
                    resolve();
                } catch (error) {
                    console.error('Error updating guest pricing:', error);
                    resolve(); // Don't reject, just continue
                }
            });
        },
        
        /**
         * Update currency symbols throughout the page
         */
        updateCurrencySymbols: function(currencyCode, currencyInfo) {
            if (!currencyInfo) return;
            
            // Update current currency displays
            $('.current-currency, .currency-code').text(currencyCode);
            $('.current-currency-symbol, .currency-symbol').text(currencyInfo.symbol || currencyCode);
            $('.current-currency-flag').text(currencyInfo.flag || '');
            
            if (window.YourSiteCurrency.debug) {
                console.log('Updated currency symbols for:', currencyCode);
            }
        },
        
        /**
         * Update pricing symbols for guest users
         */
        updatePricingSymbols: function(currencyCode, currencyInfo) {
            const symbol = currencyInfo.symbol || currencyCode;
            
            // Simple symbol replacement for pricing displays
            $('.price-amount').each(function() {
                const $el = $(this);
                const currentText = $el.text();
                
                // Extract numeric value
                const numericValue = currentText.replace(/[^\d.,]/g, '');
                
                if (numericValue) {
                    // Apply simple formatting based on currency
                    $el.text(symbol + numericValue);
                }
            });
            
            // Update any currency prefix/suffix elements
            $('.currency-prefix').text(currencyInfo.prefix || symbol);
            $('.currency-suffix').text(currencyInfo.suffix || '');
        },
        
        /**
         * Update server-side currency storage (for logged-in users)
         */
        updateServerCurrency: function(currencyCode) {
            if (window.YourSiteCurrency.isGuest) {
                return Promise.resolve(); // Skip for guests
            }
            
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: window.YourSiteCurrency.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'switch_user_currency',
                        currency: currencyCode,
                        nonce: window.YourSiteCurrency.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            if (window.YourSiteCurrency.debug) {
                                console.log('Server currency updated:', response.data);
                            }
                            resolve(response.data);
                        } else {
                            reject(new Error(response.data || 'Server update failed'));
                        }
                    },
                    error: function(xhr, status, error) {
                        if (window.YourSiteCurrency.debug) {
                            console.warn('Server currency update failed:', error);
                        }
                        resolve(); // Continue with local changes for guests
                    }
                });
            });
        },
        
        /**
         * Update all pricing displays (for logged-in users)
         */
        updateAllPricing: function() {
            if (window.YourSiteCurrency.isGuest) {
                return Promise.resolve(); // Guests use client-side updates
            }
            
            const currencyCode = window.YourSiteCurrency.current;
            const pricingCards = $('.pricing-card, .pricing-plan, [data-plan-id]');
            const updatePromises = [];
            
            pricingCards.each((index, element) => {
                const $card = $(element);
                const planId = $card.data('plan-id') || 
                              $card.find('[data-plan-id]').first().data('plan-id');
                
                if (planId) {
                    updatePromises.push(this.updatePlanPricing($card, planId, currencyCode));
                }
            });
            
            return Promise.all(updatePromises);
        },
        
        /**
         * Update pricing for a specific plan (logged-in users)
         */
        updatePlanPricing: function($card, planId, currencyCode) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: window.YourSiteCurrency.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'get_currency_pricing',
                        plan_id: planId,
                        currency: currencyCode,
                        nonce: window.YourSiteCurrency.nonce
                    },
                    success: (response) => {
                        if (response.success) {
                            this.applyPricingToCard($card, response.data);
                            resolve(response.data);
                        } else {
                            reject(new Error(response.data || 'Pricing update failed'));
                        }
                    },
                    error: (xhr, status, error) => {
                        reject(new Error(error));
                    }
                });
            });
        },
        
        /**
         * Apply pricing data to a card element
         */
        applyPricingToCard: function($card, pricingData) {
            const pricing = pricingData.pricing;
            
            // Update monthly prices
            $card.find('.monthly-price, .price-monthly, [data-price-type="monthly"]')
                .text(pricing.monthly.formatted);
            
            // Update annual prices
            $card.find('.annual-price, .price-annual, [data-price-type="annual"]')
                .text(pricing.annual.formatted);
            
            // Update annual monthly equivalent
            $card.find('.annual-monthly-equivalent, .price-annual-monthly, [data-price-type="annual-monthly"]')
                .text(pricing.annual.monthly_equivalent.formatted);
            
            // Update savings information
            if (pricing.savings && pricing.savings.raw > 0) {
                $card.find('.savings-amount, [data-savings-amount]').text(pricing.savings.formatted);
                $card.find('.savings-percentage').text(pricing.savings.percentage + '%');
                $card.find('.savings-container, .savings-badge').show();
            } else {
                $card.find('.savings-container, .savings-badge').hide();
            }
            
            // Update currency symbols
            const symbol = pricingData.currency.symbol || pricingData.currency.code;
            $card.find('.currency-symbol').text(symbol);
        },
        
        /**
         * Update all currency selectors
         */
        updateAllSelectors: function(currencyCode) {
            // Update dropdown selectors
            $('.currency-selector').val(currencyCode);
            
            // Update button states
            $('.currency-btn, .currency-selector-item, .currency-dropdown-item, .currency-flag-item, .currency-compact-item').removeClass('active selected');
            $(`.currency-btn[data-currency="${currencyCode}"], .currency-selector-item[data-currency-code="${currencyCode}"], .currency-dropdown-item[data-currency-code="${currencyCode}"], .currency-flag-item[data-currency-code="${currencyCode}"], .currency-compact-item[data-currency-code="${currencyCode}"]`).addClass('active selected');
            
            // Update toggle button text
            $('.currency-selector-toggle, .currency-dropdown-toggle').each(function() {
                const $toggle = $(this);
                const $codeSpan = $toggle.find('.currency-code, .selector-text');
                const $symbolSpan = $toggle.find('.currency-symbol');
                
                if ($codeSpan.length) {
                    $codeSpan.text(currencyCode);
                }
                
                const currencyInfo = window.YourSiteCurrency.currencies[currencyCode];
                if (currencyInfo && $symbolSpan.length) {
                    $symbolSpan.text(currencyInfo.symbol || currencyCode);
                }
            });
        },
        
        /**
         * Toggle dropdown functionality
         */
        toggleDropdown: function($toggle) {
            const $wrapper = $toggle.closest('.currency-selector-container, .fancy-selector-wrapper');
            const $dropdown = $wrapper.find('.currency-selector-dropdown, .currency-dropdown, .fancy-dropdown');
            
            if (!$dropdown.length) return;
            
            const isActive = $wrapper.hasClass('active');
            
            // Close all other dropdowns first
            this.closeAllDropdowns();
            
            if (!isActive) {
                $wrapper.addClass('active');
                $toggle.addClass('active').attr('aria-expanded', 'true');
                $dropdown.removeClass('hidden').addClass('active');
                
                // Position dropdown correctly
                this.positionDropdown($wrapper, $dropdown);
            }
        },
        
        /**
         * Position dropdown correctly (especially for footer)
         */
        positionDropdown: function($wrapper, $dropdown) {
            const isInFooter = $wrapper.closest('.site-footer, .footer-currency-selector, footer').length > 0;
            
            if (isInFooter) {
                $dropdown.css({
                    'top': 'auto',
                    'bottom': '100%',
                    'margin-top': '0',
                    'margin-bottom': '4px'
                });
            } else {
                $dropdown.css({
                    'top': '100%',
                    'bottom': 'auto',
                    'margin-top': '4px',
                    'margin-bottom': '0'
                });
            }
        },
        
        /**
         * Close all dropdowns
         */
        closeAllDropdowns: function() {
            $('.currency-selector-container, .fancy-selector-wrapper').removeClass('active');
            $('.currency-selector-toggle, .currency-dropdown-toggle').removeClass('active').attr('aria-expanded', 'false');
            $('.currency-selector-dropdown, .currency-dropdown, .fancy-dropdown').addClass('hidden').removeClass('active');
        },
        
        /**
         * Load available currencies from server or fallback
         */
        loadAvailableCurrencies: function() {
            // Try to load from server
            if (!window.YourSiteCurrency.isGuest && window.YourSiteCurrency.ajaxUrl) {
                $.ajax({
                    url: window.YourSiteCurrency.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'get_available_currencies',
                        nonce: window.YourSiteCurrency.nonce
                    },
                    success: (response) => {
                        if (response.success) {
                            window.YourSiteCurrency.currencies = {};
                            response.data.currencies.forEach(currency => {
                                window.YourSiteCurrency.currencies[currency.code] = currency;
                            });
                            
                            if (window.YourSiteCurrency.debug) {
                                console.log('Available currencies loaded from server:', window.YourSiteCurrency.currencies);
                            }
                        }
                    },
                    error: () => {
                        this.loadFallbackCurrencies();
                    }
                });
            } else {
                this.loadFallbackCurrencies();
            }
        },
        
        /**
         * Load fallback currencies for guests
         */
        loadFallbackCurrencies: function() {
            window.YourSiteCurrency.currencies = {
                'USD': { code: 'USD', name: 'US Dollar', symbol: '$', flag: '🇺🇸' },
                'EUR': { code: 'EUR', name: 'Euro', symbol: '€', flag: '🇪🇺' },
                'GBP': { code: 'GBP', name: 'British Pound', symbol: '£', flag: '🇬🇧' },
                'CAD': { code: 'CAD', name: 'Canadian Dollar', symbol: 'C$', flag: '🇨🇦' },
                'AUD': { code: 'AUD', name: 'Australian Dollar', symbol: 'A$', flag: '🇦🇺' },
                'JPY': { code: 'JPY', name: 'Japanese Yen', symbol: '¥', flag: '🇯🇵' }
            };
            
            if (window.YourSiteCurrency.debug) {
                console.log('Fallback currencies loaded for guest user');
            }
        },
        
        /**
         * Load saved currency from cookie
         */
        loadSavedCurrency: function() {
            const savedCurrency = this.getCookie(window.YourSiteCurrency.cookieName);
            if (savedCurrency) {
                window.YourSiteCurrency.current = savedCurrency;
                
                if (window.YourSiteCurrency.debug) {
                    console.log('Loaded saved currency from cookie:', savedCurrency);
                }
            }
        },
        
        /**
         * Get currency info
         */
        getCurrencyInfo: function(currencyCode) {
            return window.YourSiteCurrency.currencies[currencyCode || window.YourSiteCurrency.current];
        },
        
        /**
         * Cookie management functions
         */
        setCookie: function(name, value, days) {
            const expires = new Date();
            expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
            
            const cookieString = name + '=' + encodeURIComponent(value) + 
                               '; expires=' + expires.toUTCString() + 
                               '; path=/; SameSite=Lax';
            
            document.cookie = cookieString;
            
            if (window.YourSiteCurrency.debug) {
                console.log('Cookie set:', cookieString);
            }
        },
        
        getCookie: function(name) {
            const nameEQ = name + '=';
            const cookies = document.cookie.split(';');
            
            for (let i = 0; i < cookies.length; i++) {
                let cookie = cookies[i].trim();
                if (cookie.indexOf(nameEQ) === 0) {
                    return decodeURIComponent(cookie.substring(nameEQ.length));
                }
            }
            return null;
        },
        
        /**
         * UI feedback functions
         */
        showLoading: function() {
            $('.currency-selector-container, .fancy-selector-wrapper').addClass('currency-loading');
            $('.pricing-card, .pricing-plan').addClass('updating');
        },
        
        hideLoading: function() {
            $('.currency-selector-container, .fancy-selector-wrapper').removeClass('currency-loading');
            $('.pricing-card, .pricing-plan').removeClass('updating');
        },
        
        showSuccessMessage: function(currencyCode) {
            const currencyInfo = this.getCurrencyInfo(currencyCode);
            const message = currencyInfo ? 
                `Currency switched to ${currencyInfo.name} (${currencyCode})` :
                `Currency switched to ${currencyCode}`;
            
            this.showToast(message, 'success');
        },
        
        showErrorMessage: function(message) {
            this.showToast(message, 'error');
        },
        
        showToast: function(message, type = 'info') {
            const toastClass = 'currency-toast-' + type;
            const icon = type === 'success' ? '✓' : type === 'error' ? '✗' : 'ℹ';
            
            const $toast = $(`
                <div class="currency-toast ${toastClass}">
                    <div class="toast-content">
                        <span class="toast-icon">${icon}</span>
                        <span class="toast-message">${message}</span>
                    </div>
                </div>
            `);
            
            $('body').append($toast);
            
            // Animate in
            setTimeout(() => {
                $toast.addClass('show');
            }, 100);
            
            // Animate out
            setTimeout(() => {
                $toast.removeClass('show');
                setTimeout(() => {
                    $toast.remove();
                }, 300);
            }, 3000);
        },
        
        /**
         * Trigger currency change event
         */
        triggerCurrencyChangeEvent: function(oldCurrency, newCurrency) {
            $(document).trigger('currencyChanged', {
                oldCurrency: oldCurrency,
                newCurrency: newCurrency,
                userType: window.YourSiteCurrency.isGuest ? 'guest' : 'logged_in'
            });
            
            // Also trigger custom event for other libraries
            const event = new CustomEvent('currencyChanged', {
                detail: { 
                    currency: newCurrency,
                    oldCurrency: oldCurrency,
                    userType: window.YourSiteCurrency.isGuest ? 'guest' : 'logged_in'
                }
            });
            document.dispatchEvent(event);
        }
    };
    
    // Initialize when document is ready
    $(document).ready(function() {
        CurrencySystem.init();
        
        // Expose to global scope
        window.YourSiteCurrency.CurrencySystem = CurrencySystem;
        
        if (window.YourSiteCurrency.debug) {
            console.log('Enhanced Currency System ready for', window.YourSiteCurrency.isGuest ? 'guest' : 'logged-in', 'user');
        }
    });
    
    // Public API
    window.YourSiteCurrency.switchCurrency = function(currencyCode) {
        return CurrencySystem.switchCurrency(currencyCode);
    };
    
    window.YourSiteCurrency.getCurrentCurrency = function() {
        return window.YourSiteCurrency.current;
    };
    
    window.YourSiteCurrency.getCurrencyInfo = function(currencyCode) {
        return CurrencySystem.getCurrencyInfo(currencyCode);
    };
    
})(jQuery);