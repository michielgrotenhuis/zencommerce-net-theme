<?php
/**
 * Trust Badges Template Part
 */
?>

<?php if (get_theme_mod('show_trust_badges', true)) : ?>
<div class="flex flex-wrap gap-4 mb-6">
    <!-- SOC2 Badge -->
    <div class="trust-badge group">
        <svg class="h-10 w-auto" viewBox="0 0 120 40" fill="none">
            <rect x="0.5" y="0.5" width="119" height="39" rx="3.5" fill="#1a1a1a" stroke="#333"/>
            <circle cx="20" cy="20" r="12" fill="#2563eb"/>
            <path d="M18 20l2 2 4-4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <text x="38" y="18" font-family="Arial, sans-serif" font-size="11" font-weight="bold" fill="#2563eb">SOC 2</text>
            <text x="38" y="28" font-family="Arial, sans-serif" font-size="9" fill="#666">Type II Compliant</text>
        </svg>
    </div>
    
    <!-- GDPR Badge -->
    <div class="trust-badge group">
        <svg class="h-10 w-auto" viewBox="0 0 120 40" fill="none">
            <rect x="0.5" y="0.5" width="119" height="39" rx="3.5" fill="#1a1a1a" stroke="#333"/>
            <g transform="translate(12, 8)">
                <circle cx="12" cy="12" r="11" fill="#10b981" stroke="#10b981" stroke-width="2"/>
                <circle cx="12" cy="12" r="8" fill="none" stroke="white" stroke-width="1.5"/>
                <circle cx="12" cy="12" r="5" fill="none" stroke="white" stroke-width="1.5"/>
                <circle cx="12" cy="12" r="2" fill="white"/>
            </g>
            <text x="38" y="18" font-family="Arial, sans-serif" font-size="11" font-weight="bold" fill="#10b981">GDPR</text>
            <text x="38" y="28" font-family="Arial, sans-serif" font-size="9" fill="#666">Compliant</text>
        </svg>
    </div>
    
    <!-- PCI DSS Badge -->
    <div class="trust-badge group">
        <svg class="h-10 w-auto" viewBox="0 0 120 40" fill="none">
            <rect x="0.5" y="0.5" width="119" height="39" rx="3.5" fill="#1a1a1a" stroke="#333"/>
            <g transform="translate(12, 10)">
                <rect x="0" y="0" width="20" height="20" rx="2" fill="#f59e0b"/>
                <path d="M10 5v10m-5-7.5v5m10-5v5" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </g>
            <text x="38" y="18" font-family="Arial, sans-serif" font-size="11" font-weight="bold" fill="#f59e0b">PCI DSS</text>
            <text x="38" y="28" font-family="Arial, sans-serif" font-size="9" fill="#666">Level 1 Certified</text>
        </svg>
    </div>
</div>
<?php endif; ?>