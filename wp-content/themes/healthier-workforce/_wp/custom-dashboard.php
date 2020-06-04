<?php
/**
 * Our custom dashboard page
 */

/** WordPress Administration Bootstrap */
require_once( ABSPATH . 'wp-load.php' );
require_once( ABSPATH . 'wp-admin/admin.php' );
require_once( ABSPATH . 'wp-admin/admin-header.php' );
?>

<script>

jQuery(function ($) {
    (function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top-50
        }, 1000);
        return false;
      }
    }
  });
    }(jQuery));
});

</script>

<?php
global $current_user;
get_currentuserinfo();

//options for dashboard
$hasPages = true;

//Blog
$hasBlog = false;

//Recent Projects
$hasRecentProjects = false;
$recentProjectsSlug = "recent_projects"; //the slug of the custom post type

//Testimonials
$hasTestimonials = false;
$testimonialsSlug = "testimonials"; //the slug of the custom post type

//Job Listings
$hasJobListings = false;
$jobListingsSlug = "jobs"; //the slug of the custom post type

//Products
$hasProducts = false;
$productsSlug = "products"; //the slug of the custom post type

//Downloads
$hasDownloads = false;
$downloadsSlug = "downloads"; //the slug of the custom post type

//FAQs
$hasFAQs = false;
$FAQSlug = "faqs"; //the slug of the custom post type

//Special Offers
$hasSpecialOffers = false;

?>

<link rel='stylesheet' href='<?php echo get_stylesheet_directory_uri(); ?>/_css/partials/admin.css' type='text/css' media='all' />

<div class="wrap about-wrap">

    <h1>Hello<?php if($current_user->user_firstname) { echo " ".$current_user->user_firstname;} else {}; ?>,</h1>

    <h2>Let's get started&hellip;</h2>

    <p>Quick navigation:</p>

    <ul class="quick-nav">
        <?php if($hasPages) : ?>
            <li>&raquo; <a href="#pages">Pages</a></li>
        <?php endif; ?>

        <?php if($hasBlog) : ?>
            <li>&raquo; <a href="#latest_news">Latest News</a></li>
        <?php endif; ?>

        <?php if($hasRecentProjects) : ?>
            <li>&raquo; <a href="#recent_projects">Recent Projects / Case Studies</a></li>
        <?php endif; ?>

        <?php if($hasTestimonials) : ?>
            <li>&raquo; <a href="#testimonials">Testimonials</a></li>
        <?php endif; ?>

        <?php if($hasJobListings) : ?>
            <li>&raquo; <a href="#job_listings">Job Listings</a></li>
        <?php endif; ?>

        <?php if($hasProducts) : ?>
            <li>&raquo; <a href="#products">Products</a></li>
        <?php endif; ?>

        <?php if($hasDownloads) : ?>
            <li>&raquo; <a href="#downloads">Downloads</a></li>
        <?php endif; ?>

        <?php if($hasFAQs) : ?>
            <li>&raquo; <a href="#faqs">FAQs</a></li>
        <?php endif; ?>

        <?php if($hasSpecialOffers) : ?>
            <li>&raquo; <a href="#special_offers">Special Offers</a></li>
        <?php endif; ?>

    </ul>

    <div class="about-text">

        <div class="dash">

            <?php if($hasPages == true) : ?>
        
                <div class="col" id="pages">

                    <h3>Pages</h3>

                    <p>Page content is editable through the <a href="edit.php?post_type=page">Pages</a> menu on the left hand side.</p>
                    <ol>
                        <li>Click on the <a href="edit.php?post_type=page">Pages</a> button on the left hand side of the screen.</li>
                        <li>Select the page you'd like to edit from the pages listed.</li>
                        <li>Scroll to 'Page Content' on the screen and make your edits as required.</li>
                        <li>Once you're finished, scroll to the top of the page and select 'Publish' from the right hand side.</li>
                    </ol>

                    <h4>Page Feature Images</h4>
                    <p>The page header image is the large image located at the top of the page</p>
                    <p>This can be edited, or swapped using the Featured Image section of each page, located on the right hand side.</p>

                    <!-- <h4>Price Listings</h4>
                    <p>The price listings can be found at the bottom of each page it features on.</p>
                    <p>This can be altered by simply replacing text or prices. To remove a product simply hover over a product / price and select the '-' from the options that appear on the right hand side.</p>
                    <p>To add a new row to the listings, select '+' from the options that appear on the right hand side, or select 'add row' from the bottom right corner.</p> -->


                </div><!-- /col2--> 

            <?php endif; ?>

            <?php if($hasSpecialOffers == true) : ?>

                <div class="col" id="special_offers">

                    <h3>Special Offers</h3>

                    <p>Special offers can be found on the Special Offers page.</p>
                    <p>There are various different catgeories to add special offers to, each labelled within the page.</p>
                    
                    <ol>
                        <li>Navigate to the Special Offers page through the <a href="edit.php?post_type=page">Pages</a> menu on the left hand side.</li>
                        <li>Here you will see a Special Offers section.</li>
                        <li>Select the category you would like to add an offer to &amp; select 'Add Offer'</li>
                        <li>Complete the offer details as requested</li>
                    </ol>

                    <p>Once you're finished adding special offers, scroll to the top of the page and select 'Publish' from the right hand side.</p>

                </div><!-- /col3-->

            <?php endif; ?>

            <?php if($hasTestimonials == true) : ?>

                <div class="col" id="testimonials">

                    <h3>Testimonials</h3>

                    <p>Page content is editable through the <a href="edit.php?post_type=<?php echo $testimonialsSlug; ?>">Testimonials</a> menu on the left hand side.</p>
                    
                    <ol>
                        <li>Click on the <a href="edit.php?post_type=<?php echo $testimonialsSlug; ?>">Testimonials</a> button on the left hand side of the screen.</li>
                        <li>Select the testimonial you'd like to edit, or if you're creating a new testimonial, select 'Add New' from the top of the screen.</li>
                        <li>Fill in the testimonial details as needed.</li>
                        <li>Once you're finished, scroll to the top of the page and select 'Publish' from the right hand side.</li>
                    </ol>

                </div><!-- /col3-->

            <?php endif; ?>

            <?php if($hasRecentProjects == true) : ?>

                <div class="col" id="recent_projects">

                    <h3>Recent Projects</h3>
                    <ol>
                        <li>Click on the <a href="edit.php?post_type=<?php echo $recentProjectsSlug; ?>">Recent Projects</a> button on the left hand side of the screen.</li>
                        <li>Select the project you'd like to edit, or if you're creating a new project, select 'Add New' from the top of the screen.</li>
                        <li>Fill in the project details as needed.</li>
                        <li>Once you're finished, scroll to the top of the page and select 'Publish' from the right hand side.</li>
                    </ol>                

                </div><!-- /col1-->    

            <?php endif; ?>

            <?php if($hasBlog == true) : ?>

                <div class="col" id="latest_news">

                    <h3>Latest News</h3>

                    <p>To update, edit or remove a blog post, please visit the <a href="edit.php?post_type=posts">Posts</a> menu.</p>
                    
                    <ol>
                        <li>Navigate to the <a href="edit.php?post_type=posts">Posts</a> menu on the left hand side.</li>
                        <li>Here you will see a list of all current posts.</li>
                    </ol>

                    <h4>Editing An Existing Post</h4>

                    <ol>
                        <li>Click on the post you wish to edit from the list in the <a href="edit.php?post_type=posts">Posts</a> menu.</li>            
                        <li>From the next screen, make your changes to the post</li>
                        <li>Once you've finished making changes to your post scroll to the top and click 'Update' from the right hand side of the screen</li>
                    </ol>

                    <h4>Removing An Existing Post</h4>

                    <ol>
                        <li>Hover over the post you wish to remove from the list in the <a href="edit.php?post_type=posts">Posts</a> menu.</li>            
                        <li>From the options that appear, click 'Bin' (This will move the post to the trash bin)</li>
                        <li>To remove the post permanently, click 'Trash Bin' from the options at the top of the screen</li>
                        <li>Hover over the post you wish to delete and click 'Delete Permanently' from the options that appear</li>
                    </ol>

                    <h4>Adding A New Post</h4>

                    <ol>
                        <li>Click 'Add new' from the <a href="edit.php?post_type=posts">Posts</a> screen.</li>
                        <li>Complete the fields within the posts screen, including Post Title, Content, Category and a Featured Image (if required)</li>
                        <li>Once you've finished adding content to your post, scroll to the top and click 'Publish' from the right hand side of the screen</li>
                    </ol>                     

                </div><!-- /col3-->

            <?php endif; ?>

            <?php if($hasJobListings == true) : ?>

                <div class="col" id="job_listings">

                    <h3>Job Listings</h3>

                    <ol>
                        <li>Click on the <a href="edit.php?post_type=<?php echo $jobListingsSlug; ?>">Jobs</a> button on the left hand side of the screen.</li>
                        <li>Select the job listing you'd like to edit, or if you're creating a new job listing, select 'Add New' from the top of the screen.</li>
                        <li>Fill in the job listing details as needed.</li>
                        <li>Once you're finished, scroll to the top of the page and select 'Publish' from the right hand side.</li>
                    </ol>       

                </div><!-- /col3-->

            <?php endif; ?>

            <?php if($hasProducts == true) : ?>

                <div class="col" id="products">

                    <h3>Products</h3>

                    <ol>
                        <li>Click on the <a href="edit.php?post_type=<?php echo $productsSlug; ?>">Products</a> button on the left hand side of the screen.</li>
                        <li>Select the product you'd like to edit, or if you're creating a new product, select 'Add New' from the top of the screen.</li>
                        <li>Fill in the product details as needed, including Product Title, Description and Product Category (from the right hand side)</li>
                        <li>Once you're finished, scroll to the top of the page and select 'Publish' from the right hand side.</li>
                    </ol>

                </div><!-- /col3-->

            <?php endif; ?>

            <?php if($hasDownloads == true) : ?>

                <div class="col" id="downloads">

                    <h3>Downloads</h3>

                    <ol>
                        <li>Click on the <a href="edit.php?post_type=<?php echo $downloadsSlug; ?>">Downloads</a> button on the left hand side of the screen.</li>
                        <li>Select the download you'd like to edit, or if you're creating a new downloadable file, select 'Add New' from the top of the screen.</li>
                        <li>Fill in the file details as needed, including Download Title</li>
                        <li>Once you're finished, scroll to the top of the page and select 'Publish' from the right hand side.</li>
                    </ol>

                </div><!-- /col3-->

            <?php endif; ?>

            <?php if($hasFAQs == true) : ?>

                <div class="col" id="faqs">

                    <h3>FAQs</h3>

                    <ol>
                        <li>Click on the <a href="edit.php?post_type=<?php echo $FAQslug; ?>">FAQs</a> button on the left hand side of the screen.</li>
                        <li>Select the question you'd like to edit, or if you're creating a new question &amp; answer, select 'Add New' from the top of the screen.</li>
                        <li>Fill in the question and answer details as needed</li>
                        <li>Once you're finished, scroll to the top of the page and select 'Publish' from the right hand side.</li>
                    </ol>

                </div><!-- /col3-->

            <?php endif; ?>

        </div><!-- /feature-section col threecol-->

    </div><!-- /about-text-->

</div><!-- /wrap about-wrap-->

 

<?php include( ABSPATH . 'wp-admin/admin-footer.php' );