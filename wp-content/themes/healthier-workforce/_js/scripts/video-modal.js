jQuery(function ($) {
    'use strict';

    /**
     * Video Modal
     * 
     * Usage:
     * 1. Create a hidden container with your video content/shortcode.
     *    <div id="video-content-id" style="display:none;"> ... video player ... </div>
     * 
     * 2. Create a trigger link/button.
     *    <a href="#" class="js-open-video-modal" data-target="#video-content-id">Watch Video</a>
     */

    var $body = $('body');
    var modalId = 'generic-video-modal';

    // Inject Modal HTML if not present
    if ($('#' + modalId).length === 0) {
        var modalHTML = [
            '<div id="' + modalId + '" class="video-modal-overlay" aria-hidden="true" role="dialog">',
            '<div class="video-modal-container">',
            '<button class="video-modal-close" aria-label="Close modal">&times;</button>',
            '<div class="video-modal-content"></div>',
            '</div>',
            '</div>'
        ].join('');
        $body.append(modalHTML);
    }

    var $modal = $('#' + modalId);
    var $modalContent = $modal.find('.video-modal-content');
    var $activeSource = null; // To keep track of where the content came from

    // Open Modal
    $body.on('click', '.js-open-video-modal', function (e) {
        e.preventDefault();
        var targetId = $(this).data('target');
        var $source = $(targetId);

        if ($source.length) {
            $activeSource = $source;
            // Remove the helper class so it becomes visible inside the modal
            $source.removeClass('video-modal-hidden-source');

            var content = $source.children().detach(); // Detach to preserve event listeners/data
            $modalContent.empty().append(content);
            $modal.addClass('is-open').attr('aria-hidden', 'false');
            $body.addClass('modal-open');

            // Force Iframe Reload (fixes display:none initialization issues)
            $modalContent.find('iframe').each(function () {
                var src = $(this).attr('src');
                $(this).attr('src', src);
            });

            // Trigger window resize to wake up Video.js / responsive players
            setTimeout(function () {
                window.dispatchEvent(new Event('resize'));
            }, 100);
        }
    });

    // Close Modal Function
    function closeModal() {
        if ($activeSource) {
            var content = $modalContent.children().detach();
            $activeSource.append(content); // Put content back where it came from
            $activeSource.addClass('video-modal-hidden-source'); // Re-hide it
            $activeSource = null;
        }
        $modal.removeClass('is-open').attr('aria-hidden', 'true');
        $body.removeClass('modal-open');

        // Stop any playing iframes (brute force method if moving back didn't stop it)
        $modalContent.find('iframe').each(function () {
            var src = $(this).attr('src');
            $(this).attr('src', src);
        });
        $modalContent.find('video').each(function () {
            this.pause();
        });
    }

    // Close on Click X
    $modal.on('click', '.video-modal-close', function (e) {
        e.preventDefault();
        closeModal();
    });

    // Close on Click Overlay (outside container)
    $modal.on('click', function (e) {
        if ($(e.target).is($modal)) {
            closeModal();
        }
    });

    // Close on Escape Key
    $(document).on('keyup', function (e) {
        if (e.key === "Escape" && $modal.hasClass('is-open')) {
            closeModal();
        }
    });

});
