(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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


function setGlassProperties(name, price, tryon_url, tryon_id,colorDotsArray,relatedProductsArray,currencySign){
	j( ".specfit_color_dot_div").empty();
	j( ".specfit_related_products_list").empty();
	j( "#specfit_product_title").text(name);
	j( "#specfit_product_price").text(price);
	for (let i = 0; i < colorDotsArray.length; i++) {
		j( ".specfit_color_dot_div").append('<span class="specfit_color_dot product_color_balls_'+colorDotsArray[i].productid+'" ontouchstart="change_glass_color_image(this,\''+colorDotsArray[i].tryOnImage+'\')" onclick="change_glass_color_image(this,\''+colorDotsArray[i].tryOnImage+'\')" style="display: none; background-color: '+colorDotsArray[i].tryOnImageColorCode+'"></span>');
	}
	if(!relatedProductsArray.length){
		j("#specfit_you_may_also_like").css("display","none");
	}
	for (let i = 0; i < relatedProductsArray.length; i++) {
		j( ".specfit_related_products_list").append('<div style="cursor: pointer; " class="specfit_replated_product"> <img onclick="change_glass_image(\''+relatedProductsArray[i].name+'\',\''+relatedProductsArray[i].price+'\',\''+relatedProductsArray[i].tryOnImage+'\',\''+relatedProductsArray[i].permaLink+'\',\''+relatedProductsArray[i].postID+'\',\''+currencySign+'\',\''+relatedProductsArray[i].description+'\');" src="'+relatedProductsArray[i].tryOnImage+'" alt="Virtual try On Plugin SpecFit"></div>')
	}
	//document.getElementById('galssimage').src=tryon_url;
	document.getElementById('galssimage_video').src=tryon_url;
	document.getElementById('specfit_img_div_upload').src="";
	
	j(".specfit_color_dot").css("display", "none");
	j(".product_color_balls_"+tryon_id).css("display", "inline-block");
	jQuery("#product_summary_specfit").css("display", "none");
	jQuery("#video_div").css("display", "none");
	jQuery("#galssimage_video").css("display", "none");
	jQuery("#specfit_img_div_upload").css("display", "none");

	tryOnImgUrl=tryon_url;
}
