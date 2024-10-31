<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class PCSW_Class{

	public function __construct(){
		if ( defined( 'PCSW_VERSION' ) ) {
			$this->version = PCSW_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		add_filter( 'woocommerce_is_purchasable', array( $this, 'pcsw_is_product_purchasabe' ), 10, 2 );
		add_action( 'woocommerce_single_product_summary', array( $this, 'pcsw_coming_soon_heading' ), 25 );
		$this->options = get_option( 'pcsw-admin-options' );
		if( !empty($this->options['pcsw-hide-price']) || !empty($this->options['pcsw-hide-summary']) || !empty($this->options['pcsw-hide-tabs']) )
			add_action( 'template_redirect', array( $this, 'pcsw_woocommerce_hooks' ) );
		if( !empty($this->options['pcsw-short-desc']) && !empty($this->options['pcsw-hide-summary']) )
			add_action( 'woocommerce_single_product_summary', array( $this, 'pcsw_short_desc' ), 20 );
	}
	
	public function pcsw_is_product_purchasabe( $is_purchasable, $product ) {
		$is_coming_soon = get_post_meta( $product->get_id(), '_is_coming_soon', true );
		if( $is_coming_soon == 'yes' )
			$is_purchasable = false;
		else 
			$is_purchasable = true;
		return $is_purchasable;	
	}
	
	public function pcsw_coming_soon_heading(){
		global $product;
		$is_coming_soon = get_post_meta( $product->get_id(), '_is_coming_soon', true );
		if( $is_coming_soon == 'yes' ){
			if(get_post_meta( $product->get_id(), '_coming_soon_heading', true ))
				$coming_soon_heading = get_post_meta( $product->get_id(), '_coming_soon_heading', true );
			else  
				$coming_soon_heading = __( 'Coming Soon', 'product-coming-soon' );
				
			
		}
			echo '<h2 class="pcsw-heading"><span>'.esc_html($coming_soon_heading).'</span></h2>';
	}
	
	public function pcsw_woocommerce_hooks(){
		global $post;
		$is_coming_soon = get_post_meta( $post->ID, '_is_coming_soon', true );
		if( $is_coming_soon == 'yes' && !empty($this->options['pcsw-hide-price']) )
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		if( $is_coming_soon == 'yes' && !empty($this->options['pcsw-hide-summary']) )
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		if( $is_coming_soon == 'yes' && !empty($this->options['pcsw-hide-tabs']) )
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
	}
	
	public function pcsw_short_desc(){
		echo '<div class="woocommerce-product-details__short-description"><p>'.esc_html($this->options['pcsw-short-desc']).'</p></div>';
	}
}