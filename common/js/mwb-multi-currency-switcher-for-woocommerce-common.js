(function( $ ) {
	'use strict';

	/**
	 * All of the code for your common JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );


jQuery(document).on('click','.currency_switcher_converted_btn',function() {   
	
	jQuery('#show_converted_price').val('');
	var defaultss_currency = jQuery('#currency_switcher_1').val();
	var currency_to_change = jQuery('#currency_switcher_2').val();
	var aggregator = jQuery( "#mwb_mmcsfw_select_aggregator" ).val();
	if( defaultss_currency == "" || currency_to_change == ""  ){
		alert(mwb_mmcsfw_common_param.message);
		return false;
	}

	var data = {
        'action': 'mwb_mmcsfw_admin_fetch_currency_rates',
        'Aggregator': aggregator,
        'currency_to_change': currency_to_change,
        'Default': defaultss_currency,
        'nonce': mwb_mmcsfw_common_param.nonce,
    };
    jQuery.post(mwb_mmcsfw_common_param.ajaxurl, data, function(response) {

        jQuery('#show_converted_price').val('');
        jQuery('#show_converted_price').val(response);
		jQuery('#show_converted_price').attr('disabled',true);

        });
	});




function getpageprice(src){

	var currency=jQuery('#currency_switcher').val();

	var data = {
		'action': 'mwb_mmcsfw_add_price_through_ajax',
		'currency': currency,
		'nonce': mwb_mmcsfw_common_param.nonce,
	};
	jQuery.post(mwb_mmcsfw_common_param.ajaxurl, data, function(response) {

		var url = window.location.href;
		var url_split = url.split('?');
		location.href = url_split[0] +'?currency_name='+response;
		});
}

	
jQuery(document).on('click','.mwb-cs__sidepopup-wrap',function() {   
	let currency = jQuery(this).attr('data-currency'); 
	var data = {
		'action': 'mwb_mmcsfw_add_price_through_ajax',
		'currency': currency,
		'nonce': mwb_mmcsfw_common_param.nonce,
	};
	jQuery.post(mwb_mmcsfw_common_param.ajaxurl, data, function(response) {
	var member_page = '';
	var url = window.location.href;
	var url_split = url.split('?');
	var split_data =url_split[0].split('/');
	if( split_data.length > 0 ){
		split_data.forEach(element => {
			if( element == "membership-plans" ) {
				location.href = url;
				member_page = "membership-plans";
			}
	
		});
	}
	if ( member_page == "membership-plans" ) {
	location.href = url;
	} else {
		location.href = url_split[0] +'?currency_name='+response;
	}
	
		
		});
 });


function getrate(obj,index){

    var default_index=jQuery(jQuery('input[name="mwb_mmcsfw_checkbox"]:checked')).attr('id');
    var defaultss_currency=jQuery('#mwb_mmcsfw_text_currency_'+parseInt(default_index)).val();
    var aggregator= jQuery( "#mwb_mmcsfw_select_aggregator" ).val();
    var currency_to_change=jQuery('#mwb_mmcsfw_text_currency_'+index).val();

	if ( aggregator=="" ) {
		alert(mwb_mmcsfw_common_param.aggre_message);
		return false;
	}
	if( defaultss_currency == "" || currency_to_change == ""  ){
		alert(mwb_mmcsfw_common_param.message);
		return false;

	}
	jQuery(".mwb-loader-overlay").fadeIn(300);　
    var data = {
        'action': 'mwb_mmcsfw_admin_fetch_currency_rates',
        'Aggregator': aggregator,
        'currency_to_change': currency_to_change,
        'Default': defaultss_currency,
        'nonce': mwb_mmcsfw_common_param.nonce,
    };
    jQuery.post(mwb_mmcsfw_common_param.ajaxurl, data, function(response) {


        jQuery('#mwb_mmcsfw_text_rate_'+index).val('');
        jQuery('#mwb_mmcsfw_text_rate_'+index).val(response);
		jQuery(".mwb-loader-overlay").fadeOut(300);
        });

}


function mwb_mmcsfw_feature_saving_throgh_ajax(currency){

	var Image = jQuery('#mwb_mmcsfw_custom_flag_image-img').val();
	var Description = jQuery('#mwb_mmcsfw_description_'+currency).val();
	var Cents = jQuery('#mwb_mmcsfw_cents_'+currency).val();
	var Thousand_separator = jQuery('#mwb_mmcsfw_thousand_separator_'+currency).val();
	var Decimal_separator = jQuery('#mwb_mmcsfw_decimal_separator_'+currency).val();
	var Symbol = jQuery('#mwb_mmcsfw_custom_symbol_'+currency).val();
	var data = {
        'action': 'mwb_mmcsfw_feature_saving_throgh_ajax',
        'symbol': Symbol,
		'currency':currency,
        'thousand_separator': Thousand_separator,
		'decimal_separator': Decimal_separator,
        'image': Image,
		'description': Description,
		'cents': Cents,
        'ajax-nonce': mwb_mmcsfw_common_param.nonce,
    };
    jQuery.post(mwb_mmcsfw_common_param.ajaxurl, data, function(response) {

		location.reload();
        });

}


function set_modal_data_acc_currency(obj,currency,index){

	if( currency=="" ){
		alert(mwb_mmcsfw_common_param.message);
	return false;

	}

	var data = {
        'action': 'mwb_mmcsfw_include_modal_data',
        'currency': currency,
        'index': index,
        'ajax-nonce': mwb_mmcsfw_common_param.nonce,
    };
    jQuery.post(mwb_mmcsfw_common_param.ajaxurl, data, function(response) {

		jQuery('#mwb_modal_body_currency').html('');
		jQuery('#mwb_modal_body_currency').append(response['option-edit']);
		var src=jQuery('.mwb-template-image').attr('src');
		if ( src !='' && src != undefined ) {
			jQuery('.mwb_mmcsfw_custom_flag_image-rmv').attr('style','display:block');
		}

        });

}


function mwb_mmcsfw_geolocation_saving_throgh_ajax(obj){


var tr_length = jQuery(jQuery('#mwb_mmcsfw_table').find('tr')).length;
var different_geolocation=[];
var different_geolocation_name=[];

for (let index = 0; index < tr_length-1; index++) {
	var id = jQuery(jQuery(jQuery('#mwb_mmcsfw_table').find('tr')[index]).find('select')).attr('id');
	var currency_data=jQuery('#'+id).val();
	different_geolocation.push(currency_data);
	different_geolocation_name.push(id);
}

var data = {
	'action': 'mwb_mmcsfw_save_geolocation_data',
	'array_geolocation':different_geolocation,
	'array_geolocation_name':different_geolocation_name,
	'ajax-nonce': mwb_mmcsfw_common_param.nonce,
};
jQuery.post(mwb_mmcsfw_common_param.ajaxurl, data, function(response) {
if( jQuery('#geo_notice').attr('visible') == "false" || jQuery('#geo_notice').attr('visible') ==undefined ) {
	jQuery('<div class="notice notice-success is-dismissible mwb-errorr-8" visible="true" id="geo_notice">'+mwb_mmcsfw_common_param.geo_rules_saving_msg+' </p><button type="button" onclick="hide_notice()" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>').insertBefore("#wpwrap");
}
	});

}

function hide_notice() {
	jQuery('#geo_notice').remove();

}

jQuery(function($){

	// on upload button click
	$('body').on( 'click', '.mwb_mmcsfw_custom_flag_image', function(e){

		e.preventDefault();
	jQuery('.mwb_modal_body_currency_wrap').attr('style','display:none;');
		var button = $(this),
		image_upload=true;
		custom_uploader = wp.media({
			title: 'Insert image',
			library : {
				// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
				type : 'image'
			},
			button: {
				text: 'Use this image' // button label text
			},
			multiple: false
		}).on('select', function() { // it also has "open" and "close" events
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			if ( attachment.subtype == 'png' || attachment.subtype == 'jpg' || attachment.subtype == 'jpeg' ) {
				button.html('<img id="upload_image_option_edit_popup" src="' + attachment.url + '" style=" width: 100px; height: 72px;"   >').next().val(attachment.id).next().show();
				jQuery('#mwb_mmcsfw_custom_flag_image-img').val( attachment.url );
				jQuery('.mwb_modal_body_currency_wrap').attr('style','display:block;');
			}
		
		}).open();

	});

	// on remove button click
	$('body').on('click', '.mwb_mmcsfw_custom_flag_image-rmv', function(e){

		e.preventDefault();

		var button = $(this);
		button.next().val(''); // emptying the hidden field
		button.hide().prev().html(mwb_mmcsfw_common_param.Upload_image);
	});


   });


	
   jQuery(document).ready(function() {
	// it is used to get the price with the help of ajax method
	 jQuery('input.variation_id').change( function(){
		 if( '' != jQuery('input.variation_id').val() ) {

		 var Variation_Id = jQuery('input.variation_id').val();
		 var Old_Price=jQuery('.woocommerce-variation-price').html();

		 jQuery('.woocommerce-variation-price').html('');

		 var data = {
			 'action': 'mwb_mmcsfw_action_to_get_variation_price',
				 'Variation_Id': Variation_Id,
				 'nonce': mwb_mmcsfw_common_param.nonce,
			 };
			 jQuery.post(mwb_mmcsfw_common_param.ajaxurl, data, function(response) {     
				if(response!="" && response!=undefined){
						jQuery('.woocommerce-variation-price').append(response);
						} else {
			
							jQuery('.woocommerce-variation-price').append(Old_Price);
						}
				}); 
		}
	 });

});

