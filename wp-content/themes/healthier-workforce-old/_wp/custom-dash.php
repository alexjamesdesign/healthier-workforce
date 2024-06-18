<?php

class adtrak_custom_dashboard {
 	
	function __construct() {
		add_action('admin_menu', array( &$this,'adtrak_register_menu') );
		add_action('load-index.php', array( &$this,'adtrak_redirect_dashboard') );
 	} 
 
	function adtrak_redirect_dashboard() {
	
		if( is_admin() ) {
			$screen = get_current_screen();
			
			if( $screen->base == 'dashboard' ) {

				wp_redirect( admin_url( 'index.php?page=custom-dashboard' ) );
				
			}
		}

	}
		
	function adtrak_register_menu() {
		add_dashboard_page( 'Dashboard', 'Dashboard', 'read', 'custom-dashboard', array( &$this,'adtrak_create_dashboard') );
	}
	
	function adtrak_create_dashboard() {
		include_once( 'custom-dashboard.php'  );
	}
	
}
 
$GLOBALS['custom_dashboard'] = new adtrak_custom_dashboard();

?>
<?php

add_filter( 'login_headerurl', 'adtrak_loginlogo_url' );
	function adtrak_loginlogo_url($url) {
		return 'http://www.adtrak.co.uk';
	}

function adtrak_footer_admin () {
	echo '<span id="footer-thankyou">Crafted by <a href="http://www.adtrak.co.uk" target="_blank">Adtrak</a></span>';
}
add_filter('admin_footer_text', 'adtrak_footer_admin');

// add_filter( 'contextual_help', 'adtrak_remove_help', 999, 3 );
// 	function adtrak_remove_help($old_help, $screen_id, $screen){
// 	    $screen->remove_help_tabs();
// 	    return $old_help;
// 	}

// 	function adtrak_replace_howdy( $wp_admin_bar ) {
// 		$my_account=$wp_admin_bar->get_node('my-account');
// 		$newtitle = str_replace( 'Howdy,', 'Welcome,', $my_account->title );
// 		$wp_admin_bar->add_node( array(
// 		'id' => 'my-account',
// 		'title' => $newtitle,
// 		) );
// 	}
// add_filter( 'admin_bar_menu', 'adtrak_replace_howdy',25 );

function adtrak_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    $wp_admin_bar->remove_menu('new-content');      // Remove the content link
    $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
}
add_action( 'wp_before_admin_bar_render', 'adtrak_admin_bar_links' );

function remove_menus()
{
    global $menu;
    //global $current_user;
    //get_currentuserinfo();
    //if($current_user->user_login == 'kruger.admin'){
    if( !current_user_can('administrator') ){
        $restricted = array(
                            
                            __('Links'),
     						__('Comments'),
                            __('Widgets'),
                            __('Plugins'),
                            __('Users'),
                            __('Tools'),
                            __('Settings'),
							__('Profile'),
							// __('Dashboard'),
							__('Appearance'),
									
        );
        end ($menu);
        while (prev($menu)){
            $value = explode(' ',$menu[key($menu)][0]);
            if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
        }// end while
    }// end if
}
add_action('admin_menu', 'remove_menus');

function adtrak_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {background: url("http://static.adtrak.co.uk/email/201504/svg/adtrak-logo-white.svg") no-repeat center; background-size: contain; width: 80%;}
		body.login{background:#F15F48!important; margin:0; padding:0}
		#login{width:300px; padding:100px 0 0 0; margin:0 auto;}
		#loginform{padding:0;}
		.login {margin:0; padding:0;}
		.login form{background:#F15F48!important; box-shadow:none!important;}
		.login label{font-size:14px; color:#F9EFD7!important; font-weight:bold;}
		.login form .input, .login input[type="text"] {font-size: 15px!important; line-height: 1.6; margin: 10px 0px 10px 0; width: 100%;}
		.forgetmenot{display:none;}
		#nav{display:none;}
		#backtoblog{display:none;}
		.wp-core-ui .button.button-large, .wp-core-ui .button-group.button-large .button {width: 100%; margin-top:18px; box-shadow:none; border:2px solid #F9EFD7; background:#F15F48; border-radius:0; font-weight:bold; text-transform: uppercase; color: #F9EFD7; height:33px; text-shadow: none; transition: 0.3s;}
		.wp-core-ui .button-primary:hover {background-color:#F9EFD7; border-color:#F9EFD7; color: #F15F48 ;}
		
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'adtrak_login_logo' ); ?>