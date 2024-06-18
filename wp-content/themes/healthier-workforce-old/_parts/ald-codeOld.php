<?php if (is_singular('locations')) { ?>
    <?php 
    
    $ld_location = get_field('location_name');
    if($ld_location) { ?>

        <?php if ( ( do_shortcode('[ctm_set]') )) : ?>
            <p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <?php echo do_action('ctm_location'); ?> <?php do_action('ald_single', $ld_location, false); ?></p>
        <?php else: ?>
            <p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <?php do_action('ald_single', $ld_location, false); ?></p>
        <?php endif; ?>

    <?php } ?>

<?php } else { ?>
    

    <?php if ( ( do_shortcode('[ctm_set]') )) : ?>
        <p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <?php do_action('ald_default', true, true); ?></p>
    <?php elseif ( ( !do_shortcode('[ctm_set]') )) : ?>
        <p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <?php do_action('ald_default'); ?></p>
    <?php endif; ?>
        
<?php } ?>