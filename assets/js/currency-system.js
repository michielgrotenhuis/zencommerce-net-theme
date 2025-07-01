/**
 * YourSite Currency System - External JavaScript File
 * File: /js/currency-system.js or /assets/js/currency-system.js
 * Version: 1.0.0
 * 
 * This file should be placed in your theme's js directory
 * Dependencies: jQuery
 */

(function($) {
    'use strict';
    
    // Ensure jQuery is available
    if (typeof $ === 'undefined') {
        console.error('YourSite Currency System: jQuery is required but not found.');
        return;
    }
    
    // Prevent multiple initializations
    if (window.YourSiteCurrency && window.YourSiteCurrency.initialized) {
        console.warn('YourSite Currency System: Already initialized.');
        return;
    }
    
    // Initialize namespace
    window.YourSiteCurrency = window.YourSiteCurrency || {};
    
    // Get configuration from localized data
    const config = $.extend({
        current: 'USD',
        ajaxUrl: '/wp-admin/admin-ajax.php',
        nonce: '',
        cookieName: 'yoursite_preferred_currency',
        debug: false,
        timeout: 10000,
        retryAttempts: 2,
        cookieExpiry: 30,
        autoReload: false,
        updateDelay: 300
    }, window.YourSiteCurrencyConfig || {});
    
    // State management
    const state = {
        isLoading: false,
        requestQueue: [],
        lastUpdate: null,
        availableCurrencies: new Map(),
        pricingCache: new Map()
    };
    
    // Enhanced cookie utility functions
    const cookieUtils = {
        set: function(name, value, days) {
            try {
                days = days || config.cookieExpiry;
                const date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                const expires = "; expires=" + date.toUTCString();
                const secure = (location.protocol === 'https:') ? '; Secure' : '';
                
                document.cookie = name + "=" + encodeURIComponent(value || "") + 
                                expires + "; path=/; SameSite=Lax" + secure;
                
                if (config.debug) {
                    console.log('Cookie set:', { name, value, days });
                }
                return true;
            } catch (error) {
                console.error('Failed to set cookie:', error);
                return false;
            }
        },
        
        get: function(name) {
            try {
                const nameEQ = name + "=";
                const cookies = document.cookie.split(';');
                
                for (let i = 0; i < cookies.length; i++) {
                    let cookie = cookies[i];
                    while (cookie.charAt(0) === ' ') {
                        cookie = cookie.substring(1);
                    }
                    if (cookie.indexOf(nameEQ) === 0) {
                        return decodeURIComponent(cookie.substring(nameEQ.length));
                    }
                }
                return null;
            } catch (error) {
                console.error('Failed to get cookie:', error);
                return null;
            }
        },
        
        delete: function(name) {
            return this.set(name, '', -1);
        }
    };
    
    // Session storage helper
    const sessionUtils = {
        isSupported: function() {
            try {
                return typeof(Storage) !== "undefined" && window.sessionStorage;
            } catch (error) {
                return false;
            }
        },
        
        set: function(key, value) {
            if (!this.isSupported()) return false;
            try {
                sessionStorage.setItem(key, JSON.stringify(value));
                return true;
            } catch (error) {
                console.error('Session storage error:', error);
                return false;
            }
        },
        
        get: function(key) {
            if (!this.isSupported()) return null;
            try {
                const item = sessionStorage.getItem(key);
                return item ? JSON.parse(item) : null;
            } catch (error) {
                console.error('Session storage error:', error);
                return null;
            }
        }
    };
    
    // Enhanced AJAX helper with retry logic
    const ajaxHelper = {
        request: function(data, successCallback, errorCallback, attempt) {
            attempt = attempt || 1;
            
            if (state.isLoading && attempt === 1) {
                if (config.debug) {
                    console.warn('Request blocked - another currency operation in progress');
                }
                if (errorCallback) {
                    errorCallback({ message: 'Another request in progress', code: 'request_blocked' });
                }
                return;
            }
            
            state.isLoading = true;
            uiHelpers.showLoading();
            
            $.ajax({
                url: config.ajaxUrl,
                type: 'POST',
                data: $.extend({
                    nonce: config.nonce
                }, data),
                dataType: 'json',
                timeout: config.timeout,
                success: function(response) {
                    state.isLoading = false;
                    uiHelpers.hideLoading();
                    
                    if (response && response.success) {
                        if (successCallback) {
                            successCallback(response.data);
                        }
                    } else {
                        const errorData = response ? response.data : {};
                        const errorMsg = errorData.message || 'Unknown server error';
                        console.error('Server error:', errorMsg, errorData);
                        if (errorCallback) {
                            errorCallback(errorData);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    state.isLoading = false;
                    uiHelpers.hideLoading();
                    
                    // Retry logic for network errors
                    if (attempt < config.retryAttempts && (status === 'timeout' || status === 'error')) {
                        if (config.debug) {
                            console.log(`Retrying request (attempt ${attempt + 1}/${config.retryAttempts})`);
                        }
                        setTimeout(() => {
                            ajaxHelper.request(data, successCallback, errorCallback, attempt + 1);
                        }, 1000 * attempt);
                        return;
                    }
                    
                    let errorMessage = 'Network error occurred';
                    let errorCode = status;
                    
                    switch (status) {
                        case 'timeout':
                            errorMessage = 'Request timed out. Please check your connection.';
                            break;
                        case 'abort':
                            errorMessage = 'Request was cancelled';
                            break;
                        case 'parsererror':
                            errorMessage = 'Invalid server response';
                            break;
                        default:
                            if (xhr.status === 403) {
                                errorMessage = 'Access denied. Please refresh the page.';
                                errorCode = 'access_denied';
                            } else if (xhr.status === 500) {
                                errorMessage = 'Server error. Please try again later.';
                                errorCode = 'server_error';
                            } else if (xhr.status === 0) {
                                errorMessage = 'Network connection lost';
                                errorCode = 'connection_lost';
                            }
                    }
                    
                    console.error('AJAX error:', { status, error, httpStatus: xhr.status });
                    if (errorCallback) {
                        errorCallback({ message: errorMessage, code: errorCode });
                    }
                }
            });
        }
    };
    
    // UI helper functions
    const uiHelpers = {
        showLoading: function() {
            $('.currency-switcher select, .currency-button').prop('disabled', true);
            $('.currency-loading').show();
            $('body').addClass('currency-loading-active');
        },
        
        hideLoading: function() {
            $('.currency-switcher select, .currency-button').prop('disabled', false);
            $('.currency-loading').hide();
            $('body').removeClass('currency-loading-active');
        },
        
        showNotification: function(message, type, duration) {
            type = type || 'info';
            duration = duration || 4000;
            
            // Remove existing notifications
            $('.currency-notification').remove();
            
            const bgColors = {
                'error': '#dc3545',
                'success': '#28a745',
                'warning': '#ffc107',
                'info': '#17a2b8'
            };
            
            const notification = $('<div/>', {
                'class': `currency-notification currency-notification--${type}`,
                'css': {
                    'position': 'fixed',
                    'top': '20px',
                    'right': '20px',
                    'background': bgColors[type] || bgColors.info,
                    'color': type === 'warning' ? '#212529' : 'white',
                    'padding': '12px 20px',
                    'border-radius': '6px',
                    'z-index': '9999',
                    'box-shadow': '0 4px 12px rgba(0,0,0,0.15)',
                    'font-size': '14px',
                    'font-family': '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                    'max-width': '350px',
                    'word-wrap': 'break-word',
                    'transform': 'translateX(100%)',
                    'transition': 'transform 0.3s ease-in-out'
                },
                'html': message
            });
            
            $('body').append(notification);
            
            // Animate in
            setTimeout(() => {
                notification.css('transform', 'translateX(0)');
            }, 10);
            
            // Auto-remove
            setTimeout(() => {
                notification.css('transform', 'translateX(100%)');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, duration);
        },
        
        updateCurrencyDisplay: function(currencyCode, currencyData) {
            // Update currency symbols
            $('.currency-symbol').text((currencyData && currencyData.symbol) ? currencyData.symbol : currencyCode);
            
            // Update currency selectors
            $('.currency-switcher select').val(currencyCode);
            
            // Update currency buttons
            $('.currency-button')
                .removeClass('active current selected')
                .filter(`[data-currency="${currencyCode}"]`)
                .addClass('active current selected');
            
            // Update any elements with data-currency-code attribute
            $('[data-currency-code]').attr('data-currency-code', currencyCode);
            
            // Update text content for currency code displays
            $('.current-currency-code').text(currencyCode);
            
            // Trigger UI update event
            $(document).trigger('currencyUIUpdated', [currencyCode, currencyData]);
        }
    };
    
    // Cache management
    const cacheManager = {
        set: function(key, data, ttl) {
            ttl = ttl || 300000; // 5 minutes default
            state.pricingCache.set(key, {
                data: data,
                timestamp: Date.now(),
                ttl: ttl
            });
        },
        
        get: function(key) {
            const cached = state.pricingCache.get(key);
            if (cached && (Date.now() - cached.timestamp) < cached.ttl) {
                return cached.data;
            }
            if (cached) {
                state.pricingCache.delete(key);
            }
            return null;
        },
        
        clear: function(pattern) {
            if (pattern) {
                for (let [key] of state.pricingCache) {
                    if (key.includes(pattern)) {
                        state.pricingCache.delete(key);
                    }
                }
            } else {
                state.pricingCache.clear();
            }
        }
    };
    
    // Main currency switching function
    window.YourSiteCurrency.switchTo = function(currencyCode, callback) {
        // Input validation
        if (!currencyCode || typeof currencyCode !== 'string') {
            const error = { message: 'Invalid currency code provided', code: 'invalid_input' };
            if (callback) callback(false, error);
            return Promise.reject(error);
        }
        
        currencyCode = currencyCode.toUpperCase().trim();
        
        // Validate currency code format
        if (!/^[A-Z]{3}$/.test(currencyCode)) {
            const error = { message: 'Currency code must be 3 letters', code: 'invalid_format' };
            if (callback) callback(false, error);
            return Promise.reject(error);
        }
        
        // Check if it's the same currency
        if (currencyCode === config.current) {
            if (config.debug) {
                console.log('Currency already selected:', currencyCode);
            }
            const result = { message: 'Currency already selected', currency_code: currencyCode };
            if (callback) callback(true, result);
            return Promise.resolve(result);
        }
        
        if (config.debug) {
            console.log('Switching currency to:', currencyCode);
        }
        
        // Return a promise for better async handling
        return new Promise((resolve, reject) => {
            // Set cookie immediately for instant UI feedback
            cookieUtils.set(config.cookieName, currencyCode, config.cookieExpiry);
            sessionUtils.set('preferred_currency', currencyCode);
            
            // Update server-side persistence via AJAX
            ajaxHelper.request(
                {
                    action: 'switch_user_currency',
                    currency: currencyCode
                },
                function(data) {
                    // Success callback
                    config.current = currencyCode;
                    state.lastUpdate = new Date();
                    
                    // Clear pricing cache for old currency
                    cacheManager.clear(config.current);
                    
                    // Update UI
                    uiHelpers.updateCurrencyDisplay(currencyCode, data.currency);
                    
                    // Show success message
                    if (data.message) {
                        uiHelpers.showNotification(data.message, 'success');
                    }
                    
                    if (config.debug) {
                        console.log('Currency switched successfully:', data);
                    }
                    
                    // Call callback
                    if (callback) callback(true, data);
                    
                    // Trigger custom event
                    $(document).trigger('currencyChanged', [currencyCode, data]);
                    
                    // Auto-reload if configured
                    if (config.autoReload) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                    
                    resolve(data);
                },
                function(error) {
                    // Error callback
                    const errorMessage = (error && error.message) ? error.message : 'Failed to switch currency';
                    uiHelpers.showNotification(errorMessage, 'error');
                    
                    console.error('Currency switch failed:', error);
                    
                    // Revert cookie on server error (but keep for network errors)
                    if (error && error.code !== 'timeout' && error.code !== 'connection_lost') {
                        cookieUtils.set(config.cookieName, config.current, config.cookieExpiry);
                    }
                    
                    if (callback) callback(false, error);
                    reject(error);
                }
            );
        });
    };
    
    // Get all available currencies with caching
    window.YourSiteCurrency.getAvailable = function(callback, forceRefresh) {
        if (!forceRefresh && state.availableCurrencies.size > 0) {
            const currencies = Array.from(state.availableCurrencies.values());
            if (callback) callback(currencies);
            return Promise.resolve(currencies);
        }
        
        return new Promise((resolve, reject) => {
            ajaxHelper.request(
                { action: 'get_available_currencies' },
                function(data) {
                    if (data && data.currencies) {
                        state.availableCurrencies.clear();
                        data.currencies.forEach(currency => {
                            state.availableCurrencies.set(currency.code, currency);
                        });
                        
                        if (callback) callback(data.currencies);
                        resolve(data.currencies);
                    } else {
                        if (callback) callback([]);
                        resolve([]);
                    }
                },
                function(error) {
                    console.error('Failed to get available currencies:', error);
                    if (callback) callback([]);
                    reject(error);
                }
            );
        });
    };
    
    // Get pricing for specific plan
    window.YourSiteCurrency.getPricing = function(planId, currencyCode, callback) {
        currencyCode = currencyCode || config.current;
        const cacheKey = `pricing_${planId}_${currencyCode}`;
        
        // Check cache first
        const cached = cacheManager.get(cacheKey);
        if (cached) {
            if (callback) callback(true, cached);
            return Promise.resolve(cached);
        }
        
        return new Promise((resolve, reject) => {
            ajaxHelper.request(
                {
                    action: 'get_currency_pricing',
                    plan_id: planId,
                    currency: currencyCode
                },
                function(data) {
                    // Cache the result
                    cacheManager.set(cacheKey, data);
                    
                    if (callback) callback(true, data);
                    resolve(data);
                },
                function(error) {
                    console.error('Failed to get pricing:', error);
                    if (callback) callback(false, error);
                    reject(error);
                }
            );
        });
    };
    
    // Public API methods
    window.YourSiteCurrency.getCurrent = function() {
        return {
            code: config.current,
            fromCookie: cookieUtils.get(config.cookieName),
            fromSession: sessionUtils.get('preferred_currency'),
            lastUpdate: state.lastUpdate
        };
    };
    
    window.YourSiteCurrency.setCookie = cookieUtils.set;
    window.YourSiteCurrency.getCookie = cookieUtils.get;
    window.YourSiteCurrency.isLoading = function() { return state.isLoading; };
    window.YourSiteCurrency.clearCache = cacheManager.clear;
    window.YourSiteCurrency.getConfig = function(key) { 
        return key ? config[key] : {...config}; 
    };
    window.YourSiteCurrency.setConfig = function(key, value) {
        if (key && typeof key === 'object') {
            $.extend(config, key);
        } else if (key && value !== undefined) {
            config[key] = value;
        }
    };
    
    window.YourSiteCurrency.refresh = function() {
        state.availableCurrencies.clear();
        cacheManager.clear();
        return window.YourSiteCurrency.getAvailable(null, true);
    };
    
    // Initialization function
    function init() {
        if (window.YourSiteCurrency.initialized) {
            return;
        }
        
        try {
            // Sync cookie with current currency
            const cookieCurrency = cookieUtils.get(config.cookieName);
            if (cookieCurrency && cookieCurrency !== config.current) {
                cookieUtils.set(config.cookieName, config.current, config.cookieExpiry);
            }
            
            if (config.debug) {
                console.log('YourSite Currency System Initialized:', {
                    current: config.current,
                    cookie: cookieCurrency,
                    sessionSupported: sessionUtils.isSupported(),
                    timestamp: new Date().toISOString(),
                    version: '1.0.0'
                });
            }
            
            // Set up event handlers
            setupEventHandlers();
            
            // Initialize UI state
            uiHelpers.updateCurrencyDisplay(config.current, null);
            
            // Load available currencies
            window.YourSiteCurrency.getAvailable();
            
            // Mark as initialized
            window.YourSiteCurrency.initialized = true;
            
            // Trigger ready event
            $(document).trigger('currencySystemReady');
            
        } catch (initError) {
            console.error('Currency system initialization failed:', initError);
        }
    }
    
    // Event handlers setup
    function setupEventHandlers() {
        // Debounced update function
        let updateTimeout;
        const debouncedPricingUpdate = function(planId, currencyCode) {
            clearTimeout(updateTimeout);
            updateTimeout = setTimeout(() => {
                window.YourSiteCurrency.getPricing(planId, currencyCode);
            }, config.updateDelay);
        };
        
        // Currency switcher dropdowns
        $(document).on('change', '.currency-switcher select', function(e) {
            e.preventDefault();
            const selectedCurrency = $(this).val();
            if (selectedCurrency && selectedCurrency !== config.current) {
                window.YourSiteCurrency.switchTo(selectedCurrency);
            }
        });
        
        // Currency switcher buttons
        $(document).on('click', '.currency-button', function(e) {
            e.preventDefault();
            const selectedCurrency = $(this).data('currency');
            if (selectedCurrency && selectedCurrency !== config.current) {
                window.YourSiteCurrency.switchTo(selectedCurrency);
            }
        });
        
        // Handle currency changes
        $(document).on('currencyChanged', function(event, currencyCode, data) {
            // Update pricing displays
            $('.pricing-amount, .price, [data-price]').each(function() {
                const $element = $(this);
                const planId = $element.data('plan-id');
                
                if (planId) {
                    $element.addClass('currency-updating');
                    debouncedPricingUpdate(planId, currencyCode);
                }
            });
        });
        
        // Handle page visibility changes
        $(document).on('visibilitychange', function() {
            if (!document.hidden && state.lastUpdate) {
                const timeSinceUpdate = Date.now() - state.lastUpdate.getTime();
                if (timeSinceUpdate > 1800000) { // 30 minutes
                    window.YourSiteCurrency.refresh();
                }
            }
        });
    }
    
    // Auto-initialize when DOM is ready
    $(document).ready(function() {
        init();
    });
    
})(jQuery);