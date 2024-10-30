<?php
/*
Plugin Name: Change Default Email Sender Name
Plugin URI: https://wordpress.org/plugins/change-default-email-sender-name/
Description: Change Default Email Sender Name supports to change sender name and email from WordPress default email sender name and emails.
Version: 1.0.0
Author: tusharknovator
Author URI: https://knovator.com/services/wordpress-plugin-development/
*/    

/**
 * Basic plugin definitions 
 * 
 * @package change mail sender 
 * @since 1.1.0
 */
    
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

global $wpdb; 

if( !defined( 'CH_DEFAULT_EMAIL_SEND_DIR' ) ) {
	define( 'CH_DEFAULT_EMAIL_SEND_DIR', dirname( __FILE__ ) ); // plugin dir
}
if( !defined( 'CH_DEFAULT_EMAIL_SEND_URL' ) ) {
	define( 'CH_DEFAULT_EMAIL_SEND_URL', plugin_dir_url( __FILE__ ) ); // plugin url
}
if( !defined( 'CH_DEFAULT_EMAIL_SEND_DOMAIN' )) {
	define( 'CH_DEFAULT_EMAIL_SEND_DOMAIN', 'CH_DEFAULT_EMAIL_SEND' ); // text domain for languages
}
if( !defined( 'CH_DEFAULT_EMAIL_SEND_PLUGIN_URL' ) ) {
	define( 'CH_DEFAULT_EMAIL_SEND_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); // plugin url
}
if( !defined( 'CH_DEFAULT_EMAIL_SEND_ADMIN_DIR' ) ) {
	define( 'CH_DEFAULT_EMAIL_SEND_ADMIN_DIR', CH_DEFAULT_EMAIL_SEND_DIR . '//admin' ); // plugin admin dir
}
if( !defined( 'CH_DEFAULT_EMAIL_SEND_BASENAME') ) {
	define( 'CH_DEFAULT_EMAIL_SEND_BASENAME', 'cust-li-fi' );
}
//subtitle prefix
if( !defined( 'CH_DEFAULT_EMAIL_SEND_META_PREFIX' )) {
	define( 'CH_DEFAULT_EMAIL_SEND_META_PREFIX', '_CH_DEFAULT_EMAIL_SEND_' );
}

/**
 * Load Text Domain
 * 
 * This gets the plugin ready for translation.
 * 
 * @package change mail sender 
 * @since 1.1.0
 */
load_plugin_textdomain( 'CH_DEFAULT_EMAIL_SEND', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Activation hook
 * 
 * Register plugin activation hook.
 * 
 * @package change mail sender 
 * @since 1.1.0
 */
register_activation_hook( __FILE__, 'CH_DEFAULT_EMAIL_SEND_install' );

/**
 * Deactivation hook
 *
 * Register plugin deactivation hook.
 * 
 * @package change mail sender 
 * @since 1.1.0
 */
register_deactivation_hook( __FILE__, 'CH_DEFAULT_EMAIL_SEND_uninstall' );

/**
 * Plugin Setup Activation hook call back 
 *
 * Initial setup of the plugin setting default options 
 * and database tables creations.
 * 
 * @package change mail sender 
 * @since 1.1.0
 */
function CH_DEFAULT_EMAIL_SEND_install() {
	
	global $wpdb;
		
}

/**
 * Plugin Setup (On Deactivation)
 *
 * Does the drop tables in the database and
 * delete  plugin options.
 *
 * @package change mail sender 
 * @since 1.1.0
 */
function CH_DEFAULT_EMAIL_SEND_uninstall() {
	
	global $wpdb;
			
}

function ch_default_email_send_settings_link($links) { 
  $settings_link = '<a href="admin.php?page=change-sender-name-setting">Settings</a>'; 
  array_unshift($links, $settings_link);   
  return $links; 
}
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'ch_default_email_send_settings_link' );


/**
 * Includes
 *
 * Includes functional code for our plugin
 *
 * @package change mail sender 
 * @since 1.1.0
 */ 

function ch_default_email_send_sender_email( $original_email_address ) {
	//$admin_email = get_option('admin_email');
	$admin_email = get_option('senderemail');
    return $admin_email; 
}
 
// Function to change sender name  
function ch_default_email_send_sender_name( $original_email_from ) {
//	$site_name  = get_bloginfo( 'name' );
	$site_name = get_option('sendername');
    return $site_name; 
	
}
 
// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'ch_default_email_send_sender_email' );
add_filter( 'wp_mail_from_name', 'ch_default_email_send_sender_name' );   

/*
** option page of WooCommerce Auto Delete Status Logs
*/
 	function change_sendername_register_options_page() {
      add_options_page('Change Sender Detail', 'Change Sender Detail', 'manage_options', 'change-sender-name-setting',
	  'change_sendername_options_page');
    }
	add_action('admin_menu', 'change_sendername_register_options_page');

    /*
    ** Creating setting page of WooCommerce Auto Delete Status Logs
    */
    function change_sendername_register_settings() {
       register_setting( 'change_sendername_register_options_group', 'sendername' );
	   register_setting( 'change_sendername_register_options_group', 'senderemail' );
    }
    add_action( 'admin_init', 'change_sendername_register_settings' );

 	function change_sendername_options_page() {?>
        <div class="sys-autodelete-autoexpired-main">
            <div class="sys-autodelete-autoexpired">
            
          <form class="sys-autodelete-clearlog-form" method="post" action="options.php">
            <h1><?php _e('Sender Detail Settings', 'chdefaultemail'); ?></h1>
          <?php settings_fields( 'change_sendername_register_options_group' ); do_settings_sections( 'change_sendername_register_options_group' ); ?>
            <div class="form-field" style="margin-top:50px">
                <label for="chdefaultemail_set_interval"><?php _e('Sender Name', 'chdefaultemail'); ?> </label>
                <input class="sendernamefield" type="text" style="max-width:200px;" id="setname" 
				name="sendername" value="<?php echo get_option('sendername'); ?>" />
            </div>
			 <div class="form-field" style="margin-top:50px">
                <label for="chdefaultemail_set_interval"><?php _e('Sender Email', 'chdefaultemail'); ?> </label>
                <input class="senderemailfield" type="email" style="max-width:200px;" id="setemail" 
				name="senderemail" value="<?php echo get_option('senderemail'); ?>" />
            </div>
          <?php   
           ?>
          <?php submit_button(); ?>
          </form>
          </div>
        </div>
    <?php
    } 