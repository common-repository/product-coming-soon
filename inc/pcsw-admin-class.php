<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class PCSW_Admin_Class{

	public function __construct(){
		if ( defined( 'PCSW_VERSION' ) ) {
			$this->version = PCSW_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		add_action( 'woocommerce_product_options_general_product_data', array( $this, 'pcsw_product_meta' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'pcsw_save_product_meta' ) );
		add_action( 'admin_menu', array( $this, 'pcsw_admin_settings' ), 99 );
		add_action( 'admin_enqueue_scripts', array( $this, 'pcsw_admin_scripts' ) );
		add_action( 'wp_ajax_pcsw_save_settings', array( $this, 'pcsw_save_settings' ) );
	}
	
	public function pcsw_product_meta(){
		global $post;
		echo '<div class="pcsw-product-meta">';
		woocommerce_wp_checkbox(array(
			'id'          => '_is_coming_soon',
			'label'       => __( 'Coming Soon?', 'product-coming-soon' ),
			'value'       => get_post_meta( $post->ID, '_is_coming_soon', true )
		));
		woocommerce_wp_text_input(array(
			'id'          => '_coming_soon_heading',
			'placeholder' => 'Coming Soon',
			'label'       => __( 'Coming Soon Heading', 'product-coming-soon' ),
			'value'       => get_post_meta( $post->ID, '_coming_soon_heading', true ),
			'description' => __( 'Text will display after Product short summary', 'product-coming-soon' ),
			'desc_tip'    => 'true'
		));
		echo '</div>';
	}
	
	public function pcsw_save_product_meta($post_id){
		$product = wc_get_product($post_id);
		$is_coming_soon      = isset( $_POST['_is_coming_soon'] ) ? 'yes' : '';
		$coming_soon_heading = isset( $_POST['_coming_soon_heading'] ) ? sanitize_text_field($_POST['_coming_soon_heading']) : '';
		if( $is_coming_soon )
			$product->update_meta_data( '_is_coming_soon', sanitize_text_field( $is_coming_soon ) );
		else 
			$product->update_meta_data( '_is_coming_soon', '' );
		if( $coming_soon_heading )
			$product->update_meta_data( '_coming_soon_heading', $coming_soon_heading );
		else 
			$product->update_meta_data( '_coming_soon_heading', '' );
		$product->save();
	}
	
	public function pcsw_admin_settings() {
		add_submenu_page( 
			'woocommerce', 
			__( 'Product Coming Soon', 'product-coming-soon' ), 
			__( 'Product Coming Soon', 'product-coming-soon' ), 
			'manage_options', 
			'pcsw-settings', 
			array( $this, 'pcsw_admin_settings_callback' ) 
		); 
	}
	
	public function pcsw_admin_settings_callback() {
		require 'pcsw-admin-settings.php';
	}
	
	public function pcsw_admin_scripts( $hook ){
		if( $hook == 'woocommerce_page_pcsw-settings' ) {
			wp_enqueue_style( 'pcsw-admin-css', plugin_dir_url( __FILE__ ) . '../assets/pcsw-admin.css', '', $this->version );
			wp_register_script( 'pcsw-admin-js', plugin_dir_url( __FILE__ ) . '../assets/pcsw-admin.js', array( 'jquery' ), uniqid(), true );
			$pcsw_response_messages = array(
				'success_message' => __( 'Settings successfully saved.', 'product-coming-soon' ),
				'error_message'   => __( 'Something went wrong, please try again later.', 'product-coming-soon' )
			);
			wp_localize_script( 'pcsw-admin-js', 'pcsw_response_messages', $pcsw_response_messages );
			wp_enqueue_script( 'pcsw-admin-js' );
		}
	}
	
	public function pcsw_save_settings(){
		if($_POST['pcsw-hide-price'])
			$pcsw_hide_price   = sanitize_text_field( $_POST['pcsw-hide-price'] );
		else 
			$pcsw_hide_price   = '';
		if($_POST['pcsw-hide-summary'])
			$pcsw_hide_summary = sanitize_text_field( $_POST['pcsw-hide-summary'] );
		else 
			$pcsw_hide_summary = '';
		if($_POST['pcsw-hide-tabs'])
			$pcsw_hide_tabs    = sanitize_text_field( $_POST['pcsw-hide-tabs'] );
		else 
			$pcsw_hide_tabs    = '';
		if($_POST['pcsw-short-desc'] && $_POST['pcsw-hide-summary'])
			$pcsw_short_desc   = sanitize_textarea_field( $_POST['pcsw-short-desc'] );
		else
			$pcsw_short_desc   = '';
		$pcsw_admin_options    = array(
			'pcsw-hide-price'   => $pcsw_hide_price,
			'pcsw-hide-summary' => $pcsw_hide_summary,
			'pcsw-hide-tabs'    => $pcsw_hide_tabs,
			'pcsw-short-desc'   => $pcsw_short_desc
		);
		do_action( 'pcsw-save-admin-form-data' );
		update_option( 'pcsw-admin-options', $pcsw_admin_options );
		echo json_encode('success');
		wp_die();
	}
}