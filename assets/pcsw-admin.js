jQuery(document).ready( function($){
	$('.pcsw-save-setting a').click( function(e){
		e.preventDefault();
		var formData = $('#pcsw-settings-form').serialize();
		jQuery.ajax({
			type: "post",
			url: ajaxurl,
			dataType: "json",
			data: formData + '&action=pcsw_save_settings',
			success: function(response){
				if(response == 'success'){
					$('.pcsw-save-settings').html( pcsw_response_messages.success_message );
					$('.pcsw-save-settings').addClass('pcsw-success');
				}
				else{
					$('.pcsw-save-settings').html( pcsw_response_messages.error_message );
					$('.pcsw-save-settings').addClass('pcsw-error');
				}
				$("html, body").animate({ scrollTop: 0 }, "slow");
			}
		});
	});
	short_desc_field_init();
	function short_desc_field_init(obj){
		if(!obj){
			obj = $('#pcsw-hide-summary');
		}
		if( $(obj).is(':checked') ){
			$('.pcsw-admin-short-desc-field').css('display', 'flex');
		}
		else{
			$('.pcsw-admin-short-desc-field').hide();
		}
	}
	$('#pcsw-hide-summary').change( function() {
		short_desc_field_init($(this));
	});
});