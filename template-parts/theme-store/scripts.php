<?php
/**
 * Theme Store Scripts
 * template-parts/theme-store/scripts.php
 */
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lightbox functionality for images
    window.openLightbox = function(imageUrl, title) {
        const modal = document.getElementById('lightbox-modal');
        const image = document.getElementById('lightbox-image');
        
        image.src = imageUrl;
        image.alt = title;
        modal.style.display = 'block';
        
        document.body.style.overflow = 'hidden';
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });
    };

    window.closeLightbox = function() {
        const modal = document.getElementById('lightbox-modal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    };

    // YouTube modal functionality
    window.openYouTubeModal = function(videoId, title) {
        const modal = document.getElementById('youtube-modal');
        const iframe = document.getElementById('youtube-iframe');
        
        iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
        modal.style.display = 'block';
        
        document.body.style.overflow = 'hidden';
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeYouTubeModal();
            }
        });
    };

    window.closeYouTubeModal = function() {
        const modal = document.getElementById('youtube-modal');
        const iframe = document.getElementById('youtube-iframe');
        
        iframe.src = '';
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    };

    // Close modals when clicking outside content
    const lightboxModal = document.getElementById('lightbox-modal');
    const youtubeModal = document.getElementById('youtube-modal');
    
    if (lightboxModal) {
        lightboxModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });
    }
    
    if (youtubeModal) {
        youtubeModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeYouTubeModal();
            }
        });
    }

    // Enhanced hover effects for buttons and cards
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>