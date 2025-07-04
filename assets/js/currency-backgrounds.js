/**
 * Currency Dynamic Backgrounds Frontend Script
 * File: assets/js/currency-backgrounds.js
 * 
 * Handles dynamic background image changes based on currency selection
 */

(function($) {
    'use strict';
    
    // Configuration from WordPress
    const config = window.CurrencyBackgrounds || {};
    
    // State management
    let currentCurrency = null;
    let isChanging = false;
    let heroElements = [];
    let imageCache = new Map();
    
    // Initialize when DOM is ready
    $(document).ready(function() {
        initializeCurrencyBackgrounds();
    });
    
    /**
     * Initialize the currency backgrounds system
     */
    function initializeCurrencyBackgrounds() {
        // Check if system is enabled
        if (!config.enabled) {
            logDebug('Currency backgrounds system is disabled');
            return;
        }
        
        // Find hero elements
        findHeroElements();
        
        if (heroElements.length === 0) {
            logDebug('No hero elements found for currency backgrounds');
            return;
        }
        
        // Get initial currency
        currentCurrency = getCurrentCurrency();
        logDebug('Initial currency:', currentCurrency);
        
        // Set initial background
        setInitialBackground();
        
        // Preload background images
        preloadBackgroundImages();
        
        // Listen for currency changes
        setupCurrencyChangeListeners();
        
        // Setup mutation observer for dynamic content
        setupMutationObserver();
        
        logDebug('Currency backgrounds system initialized successfully');
    }
    
    /**
     * Find hero elements on the page
     */
    function findHeroElements() {
        heroElements = [];
        
        // Default selectors
        const defaultSelectors = [
            '.currency-hero',
            '.hero-section', 
            '[data-currency-background]',
            '.hero-banner',
            '.page-header',
            '#hero'
        ];
        
        // Add custom selectors from meta box or configuration
        const customSelector = $('meta[name="currency-background-selector"]').attr('content');
        if (customSelector) {
            defaultSelectors.unshift(customSelector);
        }
        
        // Find elements
        defaultSelectors.forEach(function(selector) {
            $(selector).each(function() {
                if (!heroElements.includes(this)) {
                    heroElements.push(this);
                    $(this).addClass('currency-background-target');
                }
            });
        });
        
        logDebug('Found hero elements:', heroElements.length);
    }
    
    /**
     * Get current currency from various sources
     */
    function getCurrentCurrency() {
        // Try from global currency system
        if (window.YourSiteCurrency && window.YourSiteCurrency.currentCurrency) {
            return window.YourSiteCurrency.currentCurrency;
        }
        
        // Try from cookie
        const cookieCurrency = getCookie('yoursite_preferred_currency');
        if (cookieCurrency) {
            return cookieCurrency;
        }
        
        // Try from data attribute on hero element
        const heroDataCurrency = $(heroElements[0]).data('current-currency');
        if (heroDataCurrency) {
            return heroDataCurrency;
        }
        
        // Default fallback
        return 'USD';
    }
    
    /**
     * Set initial background based on current currency
     */
    function setInitialBackground() {
        const backgroundUrl = getBackgroundForCurrency(currentCurrency);
        
        heroElements.forEach(function(element) {
            const $element = $(element);
            
            // Set background image
            if (backgroundUrl) {
                $element.css('background-image', `url("${backgroundUrl}")`);
                $element.attr('data-current-background', backgroundUrl);
                $element.attr('data-current-currency', currentCurrency);
            }
            
            // Ensure proper CSS classes
            $element.addClass('currency-background-ready');
        });
        
        logDebug(`Set initial background for currency: ${currentCurrency}`, backgroundUrl);
    }
    
    /**
     * Get background image URL for a specific currency
     */
    function getBackgroundForCurrency(currency) {
        // Check if currency has specific background
        if (config.backgrounds && config.backgrounds[currency]) {
            return config.backgrounds[currency].image_url;
        }
        
        // Fallback to default background
        if (config.defaultBackground) {
            return config.defaultBackground;
        }
        
        // No background available
        return null;
    }
    
    /**
     * Preload background images for better performance
     */
    function preloadBackgroundImages() {
        const imagesToPreload = [];
        
        // Add all currency backgrounds
        if (config.backgrounds) {
            Object.values(config.backgrounds).forEach(function(background) {
                if (background.image_url) {
                    imagesToPreload.push(background.image_url);
                }
            });
        }
        
        // Add default background
        if (config.defaultBackground) {
            imagesToPreload.push(config.defaultBackground);
        }
        
        // Preload images
        imagesToPreload.forEach(function(imageUrl) {
            preloadImage(imageUrl);
        });
        
        logDebug('Preloading images:', imagesToPreload.length);
    }
    
    /**
     * Preload a single image
     */
    function preloadImage(imageUrl) {
        if (imageCache.has(imageUrl)) {
            return Promise.resolve(imageCache.get(imageUrl));
        }
        
        return new Promise(function(resolve, reject) {
            const img = new Image();
            
            img.onload = function() {
                imageCache.set(imageUrl, img);
                logDebug('Preloaded image:', imageUrl);
                resolve(img);
            };
            
            img.onerror = function() {
                logDebug('Failed to preload image:', imageUrl);
                reject(new Error(`Failed to load image: ${imageUrl}`));
            };
            
            img.src = imageUrl;
        });
    }
    
    /**
     * Setup listeners for currency changes
     */
    function setupCurrencyChangeListeners() {
        // Listen for custom currency change events
        $(document).on('currencyChanged', function(e) {
            if (e.detail && e.detail.currency) {
                handleCurrencyChange(e.detail.currency);
            }
        });
        
        // Listen for currency selector clicks (backup method)
        $(document).on('click', '[data-currency-code], [data-currency]', function(e) {
            const newCurrency = $(this).data('currency-code') || $(this).data('currency');
            if (newCurrency && newCurrency !== currentCurrency) {
                // Small delay to allow currency switch to complete
                setTimeout(function() {
                    handleCurrencyChange(newCurrency);
                }, 100);
            }
        });
        
        // Listen for changes in global currency state
        if (window.YourSiteCurrency) {
            const originalCurrentCurrency = window.YourSiteCurrency.currentCurrency;
            
            // Poll for changes (fallback method)
            setInterval(function() {
                if (window.YourSiteCurrency.currentCurrency !== currentCurrency) {
                    handleCurrencyChange(window.YourSiteCurrency.currentCurrency);
                }
            }, 1000);
        }
        
        // Listen for cookie changes
        let lastCookieValue = getCookie('yoursite_preferred_currency');
        setInterval(function() {
            const currentCookieValue = getCookie('yoursite_preferred_currency');
            if (currentCookieValue !== lastCookieValue && currentCookieValue !== currentCurrency) {
                lastCookieValue = currentCookieValue;
                if (currentCookieValue) {
                    handleCurrencyChange(currentCookieValue);
                }
            }
        }, 500);
    }
    
    /**
     * Handle currency change
     */
    function handleCurrencyChange(newCurrency) {
        if (isChanging || newCurrency === currentCurrency) {
            return;
        }
        
        logDebug(`Currency changing from ${currentCurrency} to ${newCurrency}`);
        
        isChanging = true;
        const oldCurrency = currentCurrency;
        currentCurrency = newCurrency;
        
        // Get new background
        const newBackgroundUrl = getBackgroundForCurrency(newCurrency);
        
        if (!newBackgroundUrl) {
            logDebug('No background found for currency:', newCurrency);
            isChanging = false;
            return;
        }
        
        // Preload new image before changing
        preloadImage(newBackgroundUrl).then(function() {
            changeBackgroundImage(newBackgroundUrl, oldCurrency, newCurrency);
        }).catch(function(error) {
            logDebug('Error preloading new background:', error);
            // Change anyway, browser will load image
            changeBackgroundImage(newBackgroundUrl, oldCurrency, newCurrency);
        });
    }
    
    /**
     * Change background image with animation
     */
    function changeBackgroundImage(newBackgroundUrl, oldCurrency, newCurrency) {
        const transitionEffect = config.transitionEffect || 'fade';
        
        heroElements.forEach(function(element) {
            const $element = $(element);
            const currentBackgroundUrl = $element.attr('data-current-background');
            
            // Skip if same background
            if (currentBackgroundUrl === newBackgroundUrl) {
                return;
            }
            
            // Add loading state
            $element.addClass('loading');
            
            // Apply transition based on effect type
            switch (transitionEffect) {
                case 'fade':
                    applyFadeTransition($element, newBackgroundUrl, newCurrency);
                    break;
                case 'slide':
                    applySlideTransition($element, newBackgroundUrl, newCurrency);
                    break;
                case 'zoom':
                    applyZoomTransition($element, newBackgroundUrl, newCurrency);
                    break;
                case 'none':
                default:
                    applyInstantTransition($element, newBackgroundUrl, newCurrency);
                    break;
            }
        });
        
        // Dispatch custom event
        $(document).trigger('currencyBackgroundChanged', {
            oldCurrency: oldCurrency,
            newCurrency: newCurrency,
            backgroundUrl: newBackgroundUrl
        });
        
        logDebug(`Background changed to: ${newBackgroundUrl}`);
    }
    
    /**
     * Apply fade transition
     */
    function applyFadeTransition($element, newBackgroundUrl, newCurrency) {
        $element.addClass('changing');
        
        setTimeout(function() {
            $element.css('background-image', `url("${newBackgroundUrl}")`);
            $element.attr('data-current-background', newBackgroundUrl);
            $element.attr('data-current-currency', newCurrency);
            
            setTimeout(function() {
                $element.removeClass('changing loading');
                isChanging = false;
            }, 300);
        }, 300);
    }
    
    /**
     * Apply slide transition
     */
    function applySlideTransition($element, newBackgroundUrl, newCurrency) {
        $element.addClass('changing');
        
        setTimeout(function() {
            $element.css('background-image', `url("${newBackgroundUrl}")`);
            $element.attr('data-current-background', newBackgroundUrl);
            $element.attr('data-current-currency', newCurrency);
            
            setTimeout(function() {
                $element.removeClass('changing loading');
                isChanging = false;
            }, 400);
        }, 400);
    }
    
    /**
     * Apply zoom transition
     */
    function applyZoomTransition($element, newBackgroundUrl, newCurrency) {
        $element.addClass('changing');
        
        setTimeout(function() {
            $element.css('background-image', `url("${newBackgroundUrl}")`);
            $element.attr('data-current-background', newBackgroundUrl);
            $element.attr('data-current-currency', newCurrency);
            
            setTimeout(function() {
                $element.removeClass('changing loading');
                isChanging = false;
            }, 300);
        }, 300);
    }
    
    /**
     * Apply instant transition (no animation)
     */
    function applyInstantTransition($element, newBackgroundUrl, newCurrency) {
        $element.css('background-image', `url("${newBackgroundUrl}")`);
        $element.attr('data-current-background', newBackgroundUrl);
        $element.attr('data-current-currency', newCurrency);
        $element.removeClass('loading');
        isChanging = false;
    }
    
    /**
     * Setup mutation observer for dynamic content
     */
    function setupMutationObserver() {
        if (typeof MutationObserver === 'undefined') {
            return;
        }
        
        const observer = new MutationObserver(function(mutations) {
            let shouldReinitialize = false;
            
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList') {
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1) { // Element node
                            const $node = $(node);
                            
                            // Check if added node or its children match hero selectors
                            if ($node.is('.currency-hero, .hero-section, [data-currency-background]') ||
                                $node.find('.currency-hero, .hero-section, [data-currency-background]').length > 0) {
                                shouldReinitialize = true;
                            }
                        }
                    });
                }
            });
            
            if (shouldReinitialize) {
                logDebug('New hero elements detected, reinitializing...');
                setTimeout(function() {
                    findHeroElements();
                    setInitialBackground();
                }, 100);
            }
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
    
    /**
     * Get cookie value by name
     */
    function getCookie(name) {
        const value = '; ' + document.cookie;
        const parts = value.split('; ' + name + '=');
        if (parts.length === 2) {
            return parts.pop().split(';').shift();
        }
        return null;
    }
    
    /**
     * Debug logging
     */
    function logDebug(message, data) {
        if (config.debug && console && console.log) {
            if (data !== undefined) {
                console.log('[Currency Backgrounds]', message, data);
            } else {
                console.log('[Currency Backgrounds]', message);
            }
        }
    }
    
    /**
     * Public API
     */
    window.CurrencyBackgroundsAPI = {
        /**
         * Manually change background for a specific currency
         */
        changeToCurrency: function(currency) {
            if (currency !== currentCurrency) {
                handleCurrencyChange(currency);
            }
        },
        
        /**
         * Get current currency
         */
        getCurrentCurrency: function() {
            return currentCurrency;
        },
        
        /**
         * Get available backgrounds
         */
        getAvailableBackgrounds: function() {
            return config.backgrounds || {};
        },
        
        /**
         * Refresh hero elements (useful after dynamic content changes)
         */
        refreshElements: function() {
            findHeroElements();
            setInitialBackground();
        },
        
        /**
         * Force background change to specific URL
         */
        setCustomBackground: function(imageUrl) {
            heroElements.forEach(function(element) {
                const $element = $(element);
                $element.css('background-image', `url("${imageUrl}")`);
                $element.attr('data-current-background', imageUrl);
            });
        },
        
        /**
         * Reset to currency-based background
         */
        resetToCurrentCurrency: function() {
            setInitialBackground();
        },
        
        /**
         * Check if system is enabled
         */
        isEnabled: function() {
            return config.enabled === true;
        },
        
        /**
         * Get configuration
         */
        getConfig: function() {
            return config;
        }
    };
    
    /**
     * WordPress-specific integration
     */
    if (typeof wp !== 'undefined' && wp.hooks) {
        // Allow other plugins to hook into currency background changes
        wp.hooks.addAction('currencyBackgroundChanged', 'currencyBackgrounds', function(data) {
            logDebug('Currency background changed hook triggered', data);
        });
    }
    
    /**
     * Integration with popular page builders
     */
    
    // Elementor integration
    if (typeof elementorFrontend !== 'undefined') {
        elementorFrontend.hooks.addAction('frontend/element_ready/global', function($scope) {
            // Reinitialize for Elementor widgets
            setTimeout(function() {
                findHeroElements();
                setInitialBackground();
            }, 100);
        });
    }
    
    // Divi integration
    if (typeof window.et_pb_custom !== 'undefined') {
        $(window).on('et_pb_after_init_modules', function() {
            setTimeout(function() {
                findHeroElements();
                setInitialBackground();
            }, 100);
        });
    }
    
    // Beaver Builder integration
    if (typeof FLBuilder !== 'undefined') {
        FLBuilder.addHook('didRenderLayoutComplete', function() {
            setTimeout(function() {
                findHeroElements();
                setInitialBackground();
            }, 100);
        });
    }
    
    /**
     * Handle edge cases and error recovery
     */
    
    // Recover from network errors
    $(window).on('online', function() {
        logDebug('Network connection restored, refreshing backgrounds');
        setTimeout(function() {
            preloadBackgroundImages();
            setInitialBackground();
        }, 1000);
    });
    
    // Handle visibility change (tab switching)
    $(document).on('visibilitychange', function() {
        if (!document.hidden) {
            // Tab became visible, check for currency changes
            const latestCurrency = getCurrentCurrency();
            if (latestCurrency !== currentCurrency) {
                handleCurrencyChange(latestCurrency);
            }
        }
    });
    
    // Handle window resize (for responsive backgrounds)
    let resizeTimeout;
    $(window).on('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            // Refresh background positioning
            heroElements.forEach(function(element) {
                const $element = $(element);
                const currentBackground = $element.attr('data-current-background');
                if (currentBackground) {
                    // Force background refresh
                    $element.css('background-image', '');
                    setTimeout(function() {
                        $element.css('background-image', `url("${currentBackground}")`);
                    }, 10);
                }
            });
        }, 250);
    });
    
    /**
     * Performance optimization
     */
    
    // Throttle rapid currency changes
    let lastChangeTime = 0;
    const originalHandleCurrencyChange = handleCurrencyChange;
    handleCurrencyChange = function(newCurrency) {
        const now = Date.now();
        if (now - lastChangeTime < 500) { // Throttle to max once per 500ms
            return;
        }
        lastChangeTime = now;
        originalHandleCurrencyChange(newCurrency);
    };
    
    // Lazy load images for better performance
    function lazyLoadBackgrounds() {
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const $element = $(entry.target);
                        const backgroundUrl = getBackgroundForCurrency(currentCurrency);
                        if (backgroundUrl && !$element.attr('data-current-background')) {
                            preloadImage(backgroundUrl).then(function() {
                                $element.css('background-image', `url("${backgroundUrl}")`);
                                $element.attr('data-current-background', backgroundUrl);
                            });
                        }
                        observer.unobserve(entry.target);
                    }
                });
            });
            
            heroElements.forEach(function(element) {
                observer.observe(element);
            });
        }
    }
    
    // Initialize lazy loading if elements are found
    $(document).ready(function() {
        if (heroElements.length > 0) {
            lazyLoadBackgrounds();
        }
    });
    
})(jQuery);

/**
 * Fallback for sites not using jQuery
 */
if (typeof jQuery === 'undefined') {
    console.warn('Currency Backgrounds: jQuery not found, using vanilla JS fallback');
    
    // Basic vanilla JS implementation
    document.addEventListener('DOMContentLoaded', function() {
        const config = window.CurrencyBackgrounds || {};
        
        if (!config.enabled) {
            return;
        }
        
        let currentCurrency = 'USD';
        const heroElements = document.querySelectorAll('.currency-hero, .hero-section, [data-currency-background]');
        
        // Get current currency from cookie
        function getCookie(name) {
            const value = '; ' + document.cookie;
            const parts = value.split('; ' + name + '=');
            if (parts.length === 2) {
                return parts.pop().split(';').shift();
            }
            return null;
        }
        
        // Set initial currency
        const cookieCurrency = getCookie('yoursite_preferred_currency');
        if (cookieCurrency) {
            currentCurrency = cookieCurrency;
        }
        
        // Set initial backgrounds
        function setInitialBackground() {
            const backgroundUrl = config.backgrounds && config.backgrounds[currentCurrency] 
                ? config.backgrounds[currentCurrency].image_url 
                : config.defaultBackground;
                
            if (backgroundUrl) {
                heroElements.forEach(function(element) {
                    element.style.backgroundImage = `url("${backgroundUrl}")`;
                    element.setAttribute('data-current-background', backgroundUrl);
                    element.setAttribute('data-current-currency', currentCurrency);
                });
            }
        }
        
        // Listen for currency changes
        document.addEventListener('currencyChanged', function(e) {
            if (e.detail && e.detail.currency) {
                const newCurrency = e.detail.currency;
                const newBackgroundUrl = config.backgrounds && config.backgrounds[newCurrency] 
                    ? config.backgrounds[newCurrency].image_url 
                    : config.defaultBackground;
                    
                if (newBackgroundUrl) {
                    heroElements.forEach(function(element) {
                        element.style.backgroundImage = `url("${newBackgroundUrl}")`;
                        element.setAttribute('data-current-background', newBackgroundUrl);
                        element.setAttribute('data-current-currency', newCurrency);
                    });
                }
                currentCurrency = newCurrency;
            }
        });
        
        // Initialize
        setInitialBackground();
        
        // Expose basic API
        window.CurrencyBackgroundsAPI = {
            changeToCurrency: function(currency) {
                document.dispatchEvent(new CustomEvent('currencyChanged', {
                    detail: { currency: currency }
                }));
            },
            getCurrentCurrency: function() {
                return currentCurrency;
            }
        };
    });
}