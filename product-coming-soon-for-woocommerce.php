<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Product Coming Soon for WooCommerce
 * Plugin URI:        https://ahmadshyk.com/item/product-coming-soon-pro/
 * Description:       Set your products to coming soon mode.
 * Version:           1.0.0
 * Author:            Ahmad Shyk
 * Author URI:        https://ahmadshyk.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       product-coming-soon
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'PCSW_VERSION', '1.0.0' );

function pcsw_admin_notice(){ ?>
	<div class="error">
		<p><?php _e( 'Product Coming Soon for WooCommerce Plugin is activated but not effective. It requires WooCommerce in order to work.', 'woo-giftcards' ); ?></p>
	</div>
	<?php	
}

function pcsw_activation(){
	$pcsw_admin_options    = array(
		'pcsw-hide-price'   => '',
		'pcsw-hide-summary' => '',
		'pcsw-hide-tabs'    => '',
		'pcsw-short-desc'   => ''
	);
	add_option( 'pcsw-admin-options', $pcsw_admin_options, '', 'yes' );
}

require plugin_dir_path( __FILE__ ) . '/inc/pcsw-class.php';
require plugin_dir_path( __FILE__ ) . '/inc/pcsw-admin-class.php';

function pcsw_run() {

	if ( ! function_exists( 'WC' ) ) {
		add_action( 'admin_notices', 'pcsw_admin_notice' );
	}
	else{
		if( class_exists('PCSW_Class') )
			new PCSW_Class();
		if( class_exists('PCSW_Admin_Class') && current_user_can('manage_woocommerce') )
			new PCSW_Admin_Class();
	}
}
add_action( 'plugins_loaded', 'pcsw_run', 11 );

function pcsw_settings_link($links) { 
	$settings_link = '<a href="admin.php?page=pcsw-settings">'.__('Settings', 'product-coming-soon').'</a>'; 
	array_unshift($links, $settings_link); 
	return $links; 
}
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'pcsw_settings_link' );