<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
$pcsw_admin_options = get_option('pcsw-admin-options');
?>
<div class="wrap">
	<div class="pcsw-header">
		<h1><?php echo get_admin_page_title(); ?><span class="pcsw-version"><?php echo esc_html($this->version); ?></span></h1>
	</div>
	<div class="pcsw-save-settings"></div>
	<form id="pcsw-settings-form" action="pcsv_save_settings">
		<h3><?php _e( 'General Settings', 'product-coming-soon' ); ?></h3>
		<div class="pcsw-admin-field">
			<label class="pcsw-label" for="pcsw-hide-price">
				<?php _e( 'Hide Product Price', 'product-coming-soon' ) ?>
				<span class="pcsw-field-desc"><?php _e( 'It will hide the price if the product is on Coming Soon mode.', 'product-coming-soon' ) ?></span>
			</label>
			<input type="checkbox" id="pcsw-hide-price" name="pcsw-hide-price"<?php if(!empty($pcsw_admin_options['pcsw-hide-price'])) echo ' checked'; ?>>
		</div>
		<div class="pcsw-admin-field">
			<label class="pcsw-label" for="pcsw-hide-tabs">
				<?php _e( 'Hide Product Tabs', 'product-coming-soon' ) ?>
				<span class="pcsw-field-desc"><?php _e( 'It will hide the product tabs if the product is on Coming Soon mode.', 'product-coming-soon' ) ?></span>
			</label>
			<input type="checkbox" id="pcsw-hide-tabs" name="pcsw-hide-tabs"<?php if(!empty($pcsw_admin_options['pcsw-hide-tabs'])) echo ' checked'; ?>>
		</div>
		<div class="pcsw-admin-field">
			<label class="pcsw-label" for="pcsw-hide-summary">
				<?php _e( 'Hide Product Summary', 'product-coming-soon' ) ?>
				<span class="pcsw-field-desc"><?php _e( 'It will hide the summary if the product is on Coming Soon mode.', 'product-coming-soon' ) ?></span>
			</label>
			<input type="checkbox" id="pcsw-hide-summary" name="pcsw-hide-summary"<?php if(!empty($pcsw_admin_options['pcsw-hide-summary'])) echo ' checked'; ?>>
		</div>
		<div class="pcsw-admin-field pcsw-admin-short-desc-field">
			<label class="pcsw-label" for="pcsw-short-desc">
				<?php _e( 'Short Description', 'product-coming-soon' ) ?>
				<span class="pcsw-field-desc"><?php _e( 'This will replace the summary if you have hidden it.', 'product-coming-soon' ) ?></span>
			</label>
			<textarea id="pcsw-short-desc" name="pcsw-short-desc" rows="8"><?php if(!empty($pcsw_admin_options['pcsw-short-desc'])) echo esc_textarea($pcsw_admin_options['pcsw-short-desc']); ?></textarea>
		</div>
		<div class="pcsw-admin-field premium-field">
			<span class="available-in-premium"><?php _e( 'Available in', 'product-coming-soon' ).'<a>'.__( ' premium addon', 'product-coming-soon' ).'</a>' ?></span>
			<label class="pcsw-label" for="pcsw-coming-soon-heading-placement">
				<?php _e( 'Coming Soon Heading Placement', 'product-coming-soon' ) ?>
				<span class="pcsw-field-desc"><?php _e( 'Location to place the coming soon heading that you set in the product settings. Default: "After Product Summary"', 'product-coming-soon' ) ?></span>
			</label>
			<select name="pcsw-display-coming-soon-placement" id="pcsw-display-coming-soon-placement">
				<option></option>
				<option><?php _e( 'After Product Title', 'product-coming-soon' ); ?></option>
				<option><?php _e( 'After Product Ratings', 'product-coming-soon' ); ?></option>
				<option><?php _e( 'After Product Price', 'product-coming-soon' ); ?></option>
				<option><?php _e( 'After Product Summary', 'product-coming-soon' ); ?></option>
				<option><?php _e( 'After Product Meta', 'product-coming-soon' ); ?></option>
			</select>
		</div>
		<?php do_action( 'pcsw-after-admin-form-fields' ); ?>
		<div class="pcsw-premium-features">
			<h3><?php _e( 'Other features included in premium addon:', 'product-coming-soon' ); ?></h3>
			<ol>
				<li><?php _e( 'Coming soon badge on product image', 'product-coming-soon' ) ?></li>
				<li><?php _e( 'Customize coming soon text colors and size', 'product-coming-soon' ) ?></li>
				<li><?php _e( 'Countdown timer under coming soon heading', 'product-coming-soon' ) ?></li>
				<li><?php _e( 'Coming Soon option for variable products', 'product-coming-soon' ) ?></li>
				<li><?php _e( 'Separate short description for each product', 'product-coming-soon' ) ?></li>
				<li><?php _e( 'Premium Support', 'product-coming-soon' ) ?></li>
				<li><?php _e( 'Lifetime Updates', 'product-coming-soon' ) ?></li>
				<li><?php _e( 'Unlimited websites under one license', 'product-coming-soon' ) ?></li>
			</ol>
			<p>
				<?php _e( 'Send an email to ', 'product-coming-soon' ); ?>
				<a href="mailto:a.hassan@ahmadshyk.com">a.hassan@ahmadshyk.com</a>
				<?php _e( 'to know more about', 'product-coming-soon' ); ?>
				<a href="" target="_blank"><?php _e( 'Premium Addon', 'product-coming-soon' ); ?></a>
			</p>
		</div>
		<div class="pcsw-save-setting">
			<a href="" class="button-primary"><?php _e( 'Save Changes', 'product-coming-soon' ); ?></a>
		</div>
	</form>
</div>