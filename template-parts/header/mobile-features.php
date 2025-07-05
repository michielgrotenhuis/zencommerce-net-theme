<!-- Features Section -->
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <span class="text-lg font-semibold text-zc-primary dark:text-white">Features</span>
        <button class="features-toggle w-8 h-8 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center transition-colors"
                aria-label="Toggle features menu">
            <svg class="w-4 h-4 text-gray-600 dark:text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
    </div>
    
    <!-- Features Submenu -->
    <div class="features-submenu hidden space-y-4 pl-4 border-l-2 border-zc-primary/20">
        
        <!-- Store Setup Section -->
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-zc-secondary dark:text-gray-400 uppercase tracking-wide mb-3 flex items-center">
                <span class="mr-2">🏗️</span>
                Store Setup
            </h4>
            <div class="space-y-2">
                <a href="/features/store-building" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="text-zc-primary dark:text-white font-medium">Store Building</span>
                        <p class="text-xs text-zc-secondary dark:text-gray-400 mt-0.5">Drag-and-drop builder</p>
                    </div>
                </a>
                
                <a href="/features/graphics" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">
                    <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="text-zc-primary dark:text-white font-medium">Graphics & Appearance</span>
                        <p class="text-xs text-zc-secondary dark:text-gray-400 mt-0.5">Brand customization</p>
                    </div>
                </a>
                
                <a href="/templates" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">
                    <div class="w-8 h-8 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="text-zc-primary dark:text-white font-medium">Templates</span>
                        <p class="text-xs text-zc-secondary dark:text-gray-400 mt-0.5">Professional designs</p>
                    </div>
                </a>
                
                <!-- CTA Build Website Button -->
                <a href="/build-website" class="flex items-center space-x-3 p-3 rounded-xl bg-gradient-to-r from-zc-primary to-zc-success text-white hover:shadow-lg transform hover:scale-105 transition-all group">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center group-hover:rotate-12 transition-transform">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="font-semibold flex items-center">
                            Build My Website ✅
                            <svg class="w-3 h-3 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </span>
                        <p class="text-xs text-white/80 mt-0.5">Start building now</p>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Sales Channels Section -->
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-zc-secondary dark:text-gray-400 uppercase tracking-wide mb-3 flex items-center">
                <span class="mr-2">🌐</span>
                Sales Channels
            </h4>
            <div class="space-y-2">
                <a href="/features/mobile" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">
                    <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-rose-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a1 1 0 001-1V4a1 1 0 00-1-1H8a1 1 0 00-1 1v16a1 1 0 001 1z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="text-zc-primary dark:text-white font-medium">Mobile Commerce</span>
                        <p class="text-xs text-zc-secondary dark:text-gray-400 mt-0.5">Progressive web app</p>
                    </div>
                </a>
                
                <a href="/features/social" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">
                    <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="text-zc-primary dark:text-white font-medium">Social Commerce</span>
                        <p class="text-xs text-zc-secondary dark:text-gray-400 mt-0.5">Sell on social platforms</p>
                    </div>
                </a>
                
                <a href="/features/integrations" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">
                    <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a1 1 0 01-1-1V9a1 1 0 011-1h1a2 2 0 100-4H4a1 1 0 01-1-1V4a1 1 0 011-1h3a1 1 0 011 1v1z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="text-zc-primary dark:text-white font-medium">Integrations</span>
                        <p class="text-xs text-zc-secondary dark:text-gray-400 mt-0.5">Connect 200+ apps</p>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Operations Section -->
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-zc-secondary dark:text-gray-400 uppercase tracking-wide mb-3 flex items-center">
                <span class="mr-2">⚙️</span>
                Operations
            </h4>
            <div class="space-y-2">
                <a href="/features/inventory" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="text-zc-primary dark:text-white font-medium">Inventory Management</span>
                        <p class="text-xs text-zc-secondary dark:text-gray-400 mt-0.5">Track stock levels</p>
                    </div>
                </a>
                
                <a href="/features/payments" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">
                    <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="text-zc-primary dark:text-white font-medium">Payment Methods</span>
                        <p class="text-xs text-zc-secondary dark:text-gray-400 mt-0.5">Accept payments worldwide</p>
                    </div>
                </a>
                
                <a href="/features/shipping" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors opacity-75 group">
                    <div class="w-8 h-8 bg-gradient-to-r from-gray-500 to-gray-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="text-zc-primary dark:text-white font-medium">Shipping Integrations</span>
                        <p class="text-xs text-zc-secondary dark:text-gray-400 mt-0.5">Coming soon</p>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Marketing Section -->
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-zc-secondary dark:text-gray-400 uppercase tracking-wide mb-3 flex items-center">
                <span class="mr-2">📈</span>
                Marketing
            </h4>
            <div class="space-y-2">
                <a href="/features/marketing" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">
                    <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-red-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="text-zc-primary dark:text-white font-medium">Marketing & SEO</span>
                        <p class="text-xs text-zc-secondary dark:text-gray-400 mt-0.5">Email marketing & SEO tools</p>
                    </div>
                </a>
                
                <a href="/features/analytics" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">
                    <div class="w-8 h-8 bg-gradient-to-r from-violet-500 to-purple-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="text-zc-primary dark:text-white font-medium">Analytics & Reports</span>
                        <p class="text-xs text-zc-secondary dark:text-gray-400 mt-0.5">Advanced insights</p>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Quick Access Section -->
        <div class="mt-6 pt-4 border-t border-gray-200/50 dark:border-gray-700/50">
            <h4 class="text-sm font-semibold text-zc-secondary dark:text-gray-400 uppercase tracking-wide mb-3">Quick Access</h4>
            <div class="grid grid-cols-2 gap-2">
                <a href="/features" class="flex flex-col items-center p-3 rounded-xl bg-gray-50/50 dark:bg-gray-800/30 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 transition-colors group">
                    <div class="w-6 h-6 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-zc-primary dark:text-white text-center">All Features</span>
                </a>
                
                <a href="/demo" class="flex flex-col items-center p-3 rounded-xl bg-gray-50/50 dark:bg-gray-800/30 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 transition-colors group">
                    <div class="w-6 h-6 bg-gradient-to-r from-green-500 to-teal-500 rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-zc-primary dark:text-white text-center">Live Demo</span>
                </a>
            </div>
        </div>
        
    </div>
</div>