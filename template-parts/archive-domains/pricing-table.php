<?php
/**
 * Domain Archive - Pricing Table Section
 * 
 * @package YourSite
 * @since 1.0.0
 */

// Extract data from args
$featured_domains = $args['featured_domains'] ?? array();
$current_currency = $args['current_currency'] ?? array('code' => 'USD', 'symbol' => '$');

?>

<!-- Domain Pricing Table Section -->
<section class="py-20 bg-white dark:bg-gray-800">
    <div class="layout-container">
        
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php _e('Transparent Domain Pricing', 'yoursite'); ?>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                <?php _e('No hidden fees, no surprises. See exactly what you\'ll pay for registration, renewal, and transfers. All prices include free privacy protection and DNS management.', 'yoursite'); ?>
            </p>
        </div>
        
        <!-- Pricing Table -->
        <?php if (!empty($featured_domains)): ?>
        <div class="max-w-7xl mx-auto">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-t-2xl overflow-hidden">
                <div class="grid grid-cols-4 gap-4 p-6 text-white">
                    <div class="font-bold text-lg">
                        <?php _e('Domain Extension', 'yoursite'); ?>
                    </div>
                    <div class="font-bold text-lg text-center">
                        <?php _e('Registration', 'yoursite'); ?>
                    </div>
                    <div class="font-bold text-lg text-center">
                        <?php _e('Renewal', 'yoursite'); ?>
                    </div>
                    <div class="font-bold text-lg text-center">
                        <?php _e('Transfer', 'yoursite'); ?>
                    </div>
                </div>
            </div>
            
            <!-- Table Body -->
            <div class="bg-white dark:bg-gray-900 rounded-b-2xl shadow-xl border-x border-b border-gray-200 dark:border-gray-700">
                <?php foreach ($featured_domains as $index => $domain): ?>
                <div class="grid grid-cols-4 gap-4 p-6 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200 group <?php echo $domain['featured'] ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800' : ''; ?> <?php echo $index === count($featured_domains) - 1 ? 'border-b-0' : ''; ?>">
                    
                    <!-- Domain Extension -->
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                            <span class="text-white font-bold">
                                <?php echo esc_html(strtoupper(substr($domain['tld'], 0, 2))); ?>
                            </span>
                        </div>
                        <div>
                            <div class="font-bold text-xl text-gray-900 dark:text-white">
                                <?php echo esc_html($domain['name']); ?>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <?php if ($domain['popular']): ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                        </svg>
                                        <?php _e('Popular', 'yoursite'); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ($domain['featured']): ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 ml-2">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                        </svg>
                                        <?php _e('Featured', 'yoursite'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Registration Price -->
                    <div class="flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                <?php echo esc_html($current_currency['symbol'] . $domain['register_price']); ?>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <?php _e('first year', 'yoursite'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Renewal Price -->
                    <div class="flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                <?php echo esc_html($current_currency['symbol'] . $domain['renew_price']); ?>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <?php _e('per year', 'yoursite'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Transfer Price -->
                    <div class="flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                <?php echo esc_html($current_currency['symbol'] . $domain['transfer_price']); ?>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <?php _e('one time', 'yoursite'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Pricing Features -->
        <div class="mt-16 grid md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
            <div class="text-center p-6 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-white mb-2"><?php _e('Free Privacy Protection', 'yoursite'); ?></h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm"><?php _e('Keep your personal information private with free WHOIS privacy protection for life.', 'yoursite'); ?></p>
            </div>
            
            <div class="text-center p-6 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-white mb-2"><?php _e('Easy DNS Management', 'yoursite'); ?></h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm"><?php _e('Manage your domain settings with our intuitive control panel and advanced DNS tools.', 'yoursite'); ?></p>
            </div>
            
            <div class="text-center p-6 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-white mb-2"><?php _e('24/7 Expert Support', 'yoursite'); ?></h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm"><?php _e('Get help when you need it with our knowledgeable support team available around the clock.', 'yoursite'); ?></p>
            </div>
            
            <div class="text-center p-6 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900/30 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-white mb-2"><?php _e('Money-Back Guarantee', 'yoursite'); ?></h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm"><?php _e('Not satisfied? Get your money back within 30 days, no questions asked.', 'yoursite'); ?></p>
            </div>
        </div>
        
        <!-- Pricing Notes -->
        <div class="mt-12 bg-blue-50 dark:bg-blue-900/20 rounded-2xl p-8 border border-blue-200 dark:border-blue-800 max-w-4xl mx-auto">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 text-center">
                <?php _e('Pricing Information', 'yoursite'); ?>
            </h3>
            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600 dark:text-gray-300">
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                        <?php _e('What\'s Included', 'yoursite'); ?>
                    </h4>
                    <ul class="space-y-1">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <?php _e('Free WHOIS privacy protection', 'yoursite'); ?>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <?php _e('Free DNS management', 'yoursite'); ?>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <?php _e('Email forwarding', 'yoursite'); ?>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <?php _e('Domain forwarding', 'yoursite'); ?>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                        <?php _e('Important Notes', 'yoursite'); ?>
                    </h4>
                    <ul class="space-y-1">
                        <li><?php _e('• All prices shown in ', 'yoursite'); ?><?php echo esc_html($current_currency['name']); ?></li>
                        <li><?php _e('• ICANN fee of $0.18 applies to some domains', 'yoursite'); ?></li>
                        <li><?php _e('• Transfer includes 1-year extension', 'yoursite'); ?></li>
                        <li><?php _e('• Renewal prices apply after first year', 'yoursite'); ?></li>
                    </ul>
                </div>
            </div>
            
            <!-- CTA -->
            <div class="text-center mt-6">
                <a href="#domain-search" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 scroll-to-search">
                    <?php _e('Start Domain Search', 'yoursite'); ?>
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Responsive Table JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Make pricing table responsive
    function adjustPricingTable() {
        const table = document.querySelector('.grid.grid-cols-4');
        if (table && window.innerWidth < 768) {
            // Convert to mobile-friendly cards on small screens
            table.classList.remove('grid-cols-4');
            table.classList.add('block');
        } else if (table) {
            table.classList.remove('block');
            table.classList.add('grid-cols-4');
        }
    }
    
    // Initial adjustment
    adjustPricingTable();
    
    // Adjust on window resize
    window.addEventListener('resize', adjustPricingTable);
    
    // Track pricing table interactions
    const pricingRows = document.querySelectorAll('.grid.grid-cols-4 > div');
    pricingRows.forEach(function(row, index) {
        row.addEventListener('click', function() {
            if (typeof gtag !== 'undefined') {
                const domainName = this.querySelector('.font-bold.text-xl')?.textContent.trim();
                gtag('event', 'pricing_row_click', {
                    'event_category': 'engagement',
                    'event_label': domainName || `Row ${index + 1}`
                });
            }
        });
    });
});
</script>

<!-- Mobile-Responsive CSS -->
<style>
@media (max-width: 767px) {
    .grid-cols-4 > div {
        display: block !important;
        grid-column: 1 / -1;
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .grid-cols-4 > div:not(:first-child) {
        display: flex !important;
        flex-direction: column;
        gap: 1rem;
        background: #f9fafb;
    }
    
    .dark .grid-cols-4 > div:not(:first-child) {
        background: #1f2937;
    }
    
    .grid-cols-4 > div > div {
        flex: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: white;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
    }
    
    .dark .grid-cols-4 > div > div {
        background: #374151;
        border-color: #4b5563;
    }
    
    .grid-cols-4 > div > div::before {
        content: attr(data-label);
        font-weight: 600;
        color: #374151;
    }
    
    .dark .grid-cols-4 > div > div::before {
        color: #d1d5db;
    }
}

/* Add data labels for mobile */
.grid-cols-4 > div:not(:first-child) > div:nth-child(2)::before { content: "Registration: "; }
.grid-cols-4 > div:not(:first-child) > div:nth-child(3)::before { content: "Renewal: "; }
.grid-cols-4 > div:not(:first-child) > div:nth-child(4)::before { content: "Transfer: "; }
</style>