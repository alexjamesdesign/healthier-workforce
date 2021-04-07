<script>
var ld_var = ld_var || {};
ld_var['ld_json'] = '<?php echo get_stylesheet_directory_uri(); ?>/_includes/ld/phonenumbers.json';
ld_var['ld_message'] = 'Call Locally on Mobile';

</script>

<!-- <script src="https://adtrakld.co.uk/ld.js"></script> -->
<?php /*<script>if(!window.ld_ready){document.write('<script src="ld/ld.js"><\/script>');document.write('<script src="http://adtrakld.co.uk/alert.php?url='+encodeURIComponent(location.href)+'&version=Unknown&message=Primary%20script%20fail"><\/script>');}</script>*/ ?>

<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/_js/scripts/ld.js"></script>

<!-- For location pages // NEEDS CUSTOM FIELD TO WORK -->
<?php if (is_singular('locations')) : ?>

    <?php 
        $ld_location = get_field('location_name');

        if($ld_location) :
    ?>

        <script type="text/javascript">var ld_var = ld_var || {}; ld_var['ld_fixed'] = '<?php echo $ld_location; ?>';</script>
            
    <?php endif; ?>    
    
<?php endif ?>