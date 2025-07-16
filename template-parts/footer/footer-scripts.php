<?php
/**
 * Footer Scripts Template Part
 */
?>

<style>
/* Footer Font Size Improvements */
.site-footer {
    font-size: 16px; /* Increased from default 14px */
}

.site-footer h4 {
    font-size: 18px; /* Section headings larger */
    font-weight: 600;
    margin-bottom: 1rem;
}

.site-footer ul li {
    font-size: 15px; /* Footer links slightly larger */
    line-height: 1.6;
}

.site-footer .newsletter-form input {
    font-size: 16px; /* Newsletter input larger */
}

.site-footer .newsletter-form button {
    font-size: 16px; /* Newsletter button larger */
}

/* Bottom bar text larger */
.site-footer .text-sm {
    font-size: 14px !important; /* Override Tailwind's text-sm */
}

/* Copyright and legal links larger */
.site-footer .border-t:last-child .text-sm {
    font-size: 15px !important;
}

/* Language/Currency Selector Visibility Fixes */
.fancy-selector-wrapper {
    position: relative;
    display: inline-block;
}

.fancy-selector {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    background-color: rgba(55, 65, 81, 1); /* bg-gray-700 */
    border: 1px solid rgba(75, 85, 99, 1); /* border-gray-600 */
    border-radius: 0.5rem;
    color: rgba(229, 231, 235, 1); /* text-gray-200 */
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    min-width: 80px;
    justify-content: space-between;
}

.fancy-selector:hover {
    background-color: rgba(75, 85, 99, 1); /* bg-gray-600 */
    border-color: rgba(107, 114, 128, 1); /* border-gray-500 */
    color: white;
}

.fancy-selector:focus {
    outline: none;
    border-color: rgba(59, 130, 246, 1); /* border-blue-500 */
    box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.5);
}

.fancy-selector[aria-expanded="true"] {
    background-color: rgba(75, 85, 99, 1); /* bg-gray-600 */
    border-color: rgba(59, 130, 246, 1); /* border-blue-500 */
    color: white;
}

.fancy-selector[aria-expanded="true"] .chevron {
    transform: rotate(180deg);
}

.fancy-selector .selector-text {
    color: inherit;
    font-weight: 500;
}

.fancy-selector .chevron {
    transition: transform 0.2s ease-in-out;
    color: rgba(156, 163, 175, 1); /* text-gray-400 */
}

.fancy-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 50;
    margin-top: 0.25rem;
    background-color: rgba(31, 41, 55, 1); /* bg-gray-800 */
    border: 1px solid rgba(75, 85, 99, 1); /* border-gray-600 */
    border-radius: 0.5rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    min-width: 120px;
}

.fancy-dropdown.hidden {
    display: none;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem;
    color: rgba(229, 231, 235, 1); /* text-gray-200 */
    text-decoration: none;
    font-size: 14px;
    transition: all 0.15s ease-in-out;
    border-bottom: 1px solid rgba(55, 65, 81, 0.5);
}

.dropdown-item:last-child {
    border-bottom: none;
}

.dropdown-item:hover {
    background-color: rgba(55, 65, 81, 1); /* bg-gray-700 */
    color: white;
}

.dropdown-item.active {
    background-color: rgba(59, 130, 246, 1) !important; /* bg-blue-500 - force override */
    color: white !important; /* White text on blue background - force override */
    font-weight: 600;
}

.dropdown-item.active:hover {
    background-color: rgba(37, 99, 235, 1) !important; /* bg-blue-600 on hover - force override */
    color: white !important;
}

/* Extra specificity for active items */
.fancy-dropdown .dropdown-item.active {
    background-color: rgba(59, 130, 246, 1) !important;
    color: white !important;
}

.fancy-dropdown .dropdown-item.active .flag {
    color: white !important;
}

/* Flag styling */
.selector-flag {
    font-size: 16px;
    margin-right: 0.25rem;
}

.dropdown-item .flag {
    font-size: 16px;
    margin-right: 0.5rem;
}

/* Trust badges improvements */
.trust-badge svg {
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
}

.trust-badge:hover svg {
    transform: translateY(-1px);
    transition: transform 0.2s ease-in-out;
}

/* Social links improvements */
.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    background-color: rgba(55, 65, 81, 1); /* bg-gray-700 */
    border-radius: 0.5rem;
    color: rgba(156, 163, 175, 1); /* text-gray-400 */
    transition: all 0.2s ease-in-out;
}

.social-link:hover {
    background-color: rgba(75, 85, 99, 1); /* bg-gray-600 */
    color: white;
    transform: translateY(-2px);
}

/* Newsletter form improvements */
.newsletter-form input {
    font-size: 16px !important;
    height: 48px;
}

.newsletter-form button {
    font-size: 16px !important;
    height: 48px;
    padding-left: 1.5rem;
    padding-right: 1.5rem;
}

/* Payment methods improvements */
.payment-methods svg {
    transition: all 0.2s ease-in-out;
}

.payment-methods svg:hover {
    opacity: 1 !important;
    transform: translateY(-1px);
}

/* Footer link styling */
.footer-link {
    color: rgba(156, 163, 175, 1); /* text-gray-400 */
    text-decoration: none;
    transition: color 0.2s ease-in-out;
}

.footer-link:hover {
    color: white;
}

/* Better spacing for mobile */
@media (max-width: 768px) {
    .site-footer {
        font-size: 15px;
    }
    
    .site-footer h4 {
        font-size: 17px;
    }
    
    .fancy-selector {
        min-width: 70px;
        padding: 0.4rem 0.6rem;
        font-size: 13px;
    }
    
    .dropdown-item {
        padding: 0.6rem;
        font-size: 13px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Exchange rates object
    const exchangeRates = {
        'USD': 1.00, 'EUR': 0.85, 'GBP': 0.75, 'CAD': 1.25, 'AUD': 1.35,
        'JPY': 110.0, 'CHF': 0.92, 'SEK': 9.50, 'NOK': 9.80, 'DKK': 6.30,
        'PLN': 3.80, 'CZK': 22.0, 'HUF': 320.0, 'BGN': 1.66, 'RON': 4.20,
        'HRK': 6.40, 'RUB': 75.0, 'CNY': 6.45, 'INR': 74.0, 'KRW': 1180.0,
        'SGD': 1.35, 'HKD': 7.80, 'MXN': 20.0, 'BRL': 5.20, 'ARS': 98.0,
        'CLP': 800.0, 'COP': 3800.0, 'PEN': 3.60, 'UYU': 43.0, 'ZAR': 14.5,
        'EGP': 15.7, 'NGN': 411.0, 'KES': 108.0, 'GHS': 6.10, 'TND': 2.75,
        'MAD': 9.00, 'THB': 33.0, 'PHP': 50.0, 'VND': 23000.0, 'IDR': 14300.0,
        'MYR': 4.15, 'ILS': 3.25, 'AED': 3.67, 'SAR': 3.75, 'QAR': 3.64,
        'KWD': 0.30, 'BHD': 0.38, 'OMR': 0.38, 'JOD': 0.71, 'LBP': 1507.0,
        'TRY': 8.50, 'IRR': 42000.0, 'PKR': 170.0, 'BDT': 85.0, 'LKR': 200.0,
        'NPR': 118.0, 'BTN': 74.0, 'MVR': 15.4, 'AFN': 80.0, 'UZS': 10600.0,
        'KZT': 426.0, 'KGS': 84.0, 'TJS': 11.3, 'TMT': 3.50, 'AZN': 1.70,
        'GEL': 3.30, 'AMD': 522.0, 'BYN': 2.60, 'MDL': 17.8, 'UAH': 27.0,
        'RSD': 100.0, 'MKD': 52.0, 'ALL': 104.0, 'BAM': 1.66, 'ISK': 127.0
    };

   const currencySymbols = {
    'USD': '$', 'EUR': '€', 'GBP': '£', 'CAD': 'C$', 'AUD': 'A$',
    'JPY': '¥', 'CHF': 'CHF', 'SEK': 'kr', 'NOK': 'kr', 'DKK': 'kr',
    'PLN': 'zł', 'CZK': 'Kč', 'HUF': 'Ft', 'BGN': 'лв', 'RON': 'lei',
    'HRK': 'kn', 'RUB': '₽', 'CNY': '¥', 'INR': '₹', 'KRW': '₩',
    'SGD': 'S$', 'HKD': 'HK$', 'MXN': 'MX$', 'BRL': 'R$', 'ARS': 'ARS$',
    'CLP': 'CLP$', 'COP': 'COL$', 'PEN': 'S/', 'UYU': '$U', 'ZAR': 'R',
    'EGP': 'E£', 'NGN': '₦', 'KES': 'KSh', 'GHS': 'GH₵', 'TND': 'د.ت',
    'MAD': 'د.م.', 'THB': '฿', 'PHP': '₱', 'VND': '₫', 'IDR': 'Rp',
    'MYR': 'RM', 'ILS': '₪', 'AED': 'د.إ', 'SAR': '﷼', 'QAR': 'ر.ق',
    'KWD': 'د.ك', 'BHD': '.د.ب', 'OMR': 'ر.ع.', 'JOD': 'د.ا', 'LBP': 'ل.ل',
    'TRY': '₺', 'IRR': '﷼', 'PKR': '₨', 'BDT': '৳', 'LKR': '₨',
    'NPR': '₨', 'BTN': 'Nu.', 'MVR': 'Rf', 'AFN': '؋', 'UZS': 'лв',
    'KZT': '₸', 'KGS': 'лв', 'TJS': 'смн', 'TMT': 'T', 'AZN': '₼',
    'GEL': '₾', 'AMD': '֏', 'BYN': 'Br', 'MDL': 'lei', 'UAH': '₴',
    'RSD': 'дин.', 'MKD': 'ден', 'ALL': 'L', 'BAM': 'КМ', 'ISK': 'kr'
};


    // Initialize selectors
    initializeLanguageSelector();
    initializeCurrencySelector();
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        closeAllDropdowns(event);
    });
    
    // Handle escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeAllDropdowns();
        }
    });

    function initializeLanguageSelector() {
        const languageToggle = document.getElementById('language-toggle');
        const languageDropdown = document.getElementById('language-dropdown');
        
        if (!languageToggle || !languageDropdown) return;
        
        // Toggle dropdown on click
        languageToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isOpen = this.getAttribute('aria-expanded') === 'true';
            
            if (isOpen) {
                closeDropdown(this, languageDropdown);
            } else {
                closeAllDropdowns(null, this);
                openDropdown(this, languageDropdown);
            }
        });
        
        // Handle language selection
        const languageItems = languageDropdown.querySelectorAll('.dropdown-item');
        languageItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                const langCode = this.dataset.code;
                const selectorText = languageToggle.querySelector('.selector-text');
                if (selectorText) {
                    selectorText.textContent = langCode;
                }
                
                // Update active state
                languageItems.forEach(item => item.classList.remove('active'));
                this.classList.add('active');
                
                // Close dropdown
                closeDropdown(languageToggle, languageDropdown);
                
                console.log('Language changed to:', langCode);
            });
        });
        
        // Keyboard navigation
        languageToggle.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    }

    function initializeCurrencySelector() {
        const currencyToggle = document.querySelector('#currency-toggle');
        const currencyDropdown = document.querySelector('#currency-dropdown');
        
        if (!currencyToggle || !currencyDropdown) return;
        
        // Toggle dropdown on click
        currencyToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isOpen = this.getAttribute('aria-expanded') === 'true';
            
            if (isOpen) {
                closeDropdown(this, currencyDropdown);
            } else {
                closeAllDropdowns(null, this);
                openDropdown(this, currencyDropdown);
            }
        });
        
        // Handle currency selection
        const currencyItems = currencyDropdown.querySelectorAll('.dropdown-item');
        currencyItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                const currencyCode = this.dataset.currency;
                const currencySymbol = this.dataset.symbol;
                const currencyFlag = this.dataset.flag;
                
                // Update button text and flag
                const selectorText = currencyToggle.querySelector('.selector-text');
                const selectorFlag = currencyToggle.querySelector('.selector-flag');
                if (selectorText) {
                    selectorText.textContent = currencyCode;
                }
                if (selectorFlag && currencyFlag) {
                    selectorFlag.textContent = currencyFlag;
                }
                
                // Update active state
                currencyItems.forEach(item => item.classList.remove('active'));
                this.classList.add('active');
                
                // Close dropdown
                closeDropdown(currencyToggle, currencyDropdown);
                
                // Update currency throughout the page
                updateCurrency(currencyCode, currencySymbol);
                
                console.log('Currency changed to:', currencyCode);
            });
        });
        
        // Keyboard navigation
        currencyToggle.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    }

    function openDropdown(toggle, dropdown) {
        toggle.setAttribute('aria-expanded', 'true');
        dropdown.classList.remove('hidden');
        dropdown.setAttribute('aria-hidden', 'false');
        
        // Focus first item
        const firstItem = dropdown.querySelector('.dropdown-item');
        if (firstItem) {
            firstItem.focus();
        }
    }

    function closeDropdown(toggle, dropdown) {
        toggle.setAttribute('aria-expanded', 'false');
        dropdown.classList.add('hidden');
        dropdown.setAttribute('aria-hidden', 'true');
    }

    function closeAllDropdowns(event, excludeToggle = null) {
        const allToggles = document.querySelectorAll('.fancy-selector');
        
        allToggles.forEach((toggle) => {
            // Skip the excluded toggle
            if (excludeToggle && toggle === excludeToggle) return;
            
            const dropdown = toggle.parentElement.querySelector('.fancy-dropdown');
            if (dropdown) {
                // If event is provided, check if click is outside
                if (!event || (!toggle.contains(event.target) && !dropdown.contains(event.target))) {
                    closeDropdown(toggle, dropdown);
                }
            }
        });
    }

    // Convert USD to target currency
    function convertUsdToCurrency(usdAmount, targetCurrency) {
        const rate = exchangeRates[targetCurrency] || 1.00;
        const convertedAmount = usdAmount * rate;
        
        // Round based on currency type
        if (['JPY', 'KRW', 'VND', 'IDR', 'IRR', 'UZS', 'LBP', 'CLP', 'COP', 'HUF', 'CZK'].includes(targetCurrency)) {
            return Math.round(convertedAmount);
        } else if (['KWD', 'BHD', 'OMR', 'JOD'].includes(targetCurrency)) {
            return Math.round(convertedAmount * 1000) / 1000;
        } else {
            return Math.round(convertedAmount);
        }
    }

    // Format currency for display
    function formatCurrencyForOffer(amount, currencyCode, symbol) {
        if (['JPY', 'KRW', 'VND', 'IDR', 'IRR', 'UZS', 'LBP', 'CLP', 'COP', 'HUF', 'CZK'].includes(currencyCode)) {
            return symbol + new Intl.NumberFormat().format(amount);
        } else if (['KWD', 'BHD', 'OMR', 'JOD'].includes(currencyCode)) {
            return symbol + new Intl.NumberFormat(undefined, {
                minimumFractionDigits: 3,
                maximumFractionDigits: 3
            }).format(amount);
        } else {
            return symbol + new Intl.NumberFormat().format(amount);
        }
    }

    // Update currency throughout the page
    function updateCurrency(newCurrencyCode, newCurrencySymbol) {
        const symbol = currencySymbols[newCurrencyCode] || newCurrencySymbol || ';
        
        // Update offer amount
        const offerElement = document.querySelector('.limited-time-offer');
        const offerAmountElement = document.querySelector('.offer-amount');
        
        if (offerElement && offerAmountElement) {
            const baseAmount = parseInt(offerElement.dataset.baseAmount) || 200;
            const convertedAmount = convertUsdToCurrency(baseAmount, newCurrencyCode);
            const formattedAmount = formatCurrencyForOffer(convertedAmount, newCurrencyCode, symbol);
            
            offerAmountElement.textContent = formattedAmount;
            offerElement.dataset.currentCurrency = newCurrencyCode;
            offerElement.dataset.currentAmount = convertedAmount;
        }
        
        // Store selection in cookie
        try {
            document.cookie = `selected_currency=${newCurrencyCode}; path=/; max-age=31536000; SameSite=Lax`;
        } catch (e) {
            console.log('Currency preference could not be saved');
        }
    }

    // Newsletter form handling
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            // Here you would typically send the form data to your server
            console.log('Newsletter signup:', formData.get('email'));
            
            // Show success message
            const button = this.querySelector('button');
            const originalText = button.textContent;
            button.textContent = 'Subscribed!';
            button.style.backgroundColor = '#10b981';
            
            setTimeout(() => {
                button.textContent = originalText;
                button.style.backgroundColor = '';
            }, 2000);
        });
    }
});
</script>