<?php
/**
 * Theme Store Modals
 * template-parts/theme-store/modals.php
 */
?>

<!-- Lightbox Modal for Images -->
<div id="lightbox-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 10000; cursor: pointer;" onclick="closeLightbox()">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 90%; max-height: 90%;">
        <img id="lightbox-image" src="" alt="" style="max-width: 100%; max-height: 100%; border-radius: var(--zc-radius-sm, 8px); box-shadow: 0 20px 60px rgba(0,0,0,0.5);" />
    </div>
    <button onclick="closeLightbox()" style="position: absolute; top: 20px; right: 30px; background: none; border: none; color: white; font-size: 3rem; cursor: pointer; z-index: 10001;">&times;</button>
</div>

<!-- YouTube Modal -->
<div id="youtube-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 10000;" onclick="closeYouTubeModal()">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 90%; max-width: 800px; aspect-ratio: 16/9;">
        <iframe id="youtube-iframe" src="" frameborder="0" allowfullscreen style="width: 100%; height: 100%; border-radius: var(--zc-radius-sm, 8px);"></iframe>
    </div>
    <button onclick="closeYouTubeModal()" style="position: absolute; top: 20px; right: 30px; background: none; border: none; color: white; font-size: 3rem; cursor: pointer; z-index: 10001;">&times;</button>
</div>