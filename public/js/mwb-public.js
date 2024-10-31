
function getpageprice( src ) {
	
	
	
	var currency=jQuery('#currency_switcher').val();
	var data = {
		'action': 'mwb_mmcsfw_add_price_through_ajax',	
		'currency': currency,	
	
	}; 
	jQuery.post(mwb_mmcsfw_common_param.ajaxurl, data, function(response) {     
		     
		location.reload();
		});
	
	}



	jQuery(document).ready(function() {

	
		jQuery('.mwb-cs__currency-tag').attr('style','background:'+mmcsfw_public_param_js.currency_background+';color:'+mmcsfw_public_param_js.currency_text); // currency background color
		jQuery(jQuery('.mwb-cs__side-switcher').children()).attr('style','background:'+mmcsfw_public_param_js.switcher_background); // full switcher background color
		jQuery(jQuery('.mwb-cs__sidepopup-wrap p')).attr('style','color:'+mmcsfw_public_param_js.description_color);//description color
		jQuery('.mwb-cs__sidepopup-wrap').attr('style','border:2px solid #aeaeae'+';background:'+mmcsfw_public_param_js.switcher_background);
		jQuery('.mwb-cs__sidepopup-wrap.selected-currency').attr('style','border:3px solid'+mmcsfw_public_param_js.currency_background+';background:'+mmcsfw_public_param_js.switcher_background);
		jQuery('#show_converted_price').attr('disabled','disabled');

		if ( mmcsfw_public_param_js.default_currency != '') {
			jQuery('#currency_switcher').val( mmcsfw_public_param_js.default_currency );
		}
		var switcher_height = jQuery('.mwb-cs__side-switcher').height();
		var windowHeight = window.innerHeight;

		if(switcher_height > windowHeight) {
			jQuery('.mwb-cs__side-switcher').css('position', 'absolute');
		} 
		else {
			jQuery('.mwb-cs__side-switcher').css('position', 'fixed');
		}
	});

