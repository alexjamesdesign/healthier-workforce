<div class="container callback-form-container">
    <span class="callback-form-show-hide">
        <div class="callback-img">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/_static/images/icon-incoming.svg" alt="Incoming Call Icon">
        </div>
        <p class="title">Request a Callback</p>
    </span>
    <div class="callback-hidden">
        <div class="callback-form">
            <?php echo do_shortcode( '[ninja_form id=2]' ); ?>
        </div>
    </div>
</div>