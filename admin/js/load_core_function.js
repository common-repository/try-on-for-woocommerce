function upload_product_try_on_image(element) {
    var send_attachment_bkp = wp.media.editor.send.attachment;
    wp.media.editor.send.attachment = function(props, attachment) {
        jQuery('#' + element).attr('src', attachment.url);
        wp.media.editor.send.attachment = send_attachment_bkp;
        jQuery('#' + element).focus()
    }
    wp.media.editor.open();
}
function edit_specfit_color(productColorId){
    jQuery('#specfit_color_edit_btn_' + productColorId).css("display","none");
    jQuery('#specfit_color_delete_btn_' + productColorId).css("display","none");
    jQuery('#specfit_color_save_btn_' + productColorId).css("display","block");
    jQuery('#specfit_product_color_' + productColorId).removeAttr('disabled');
    jQuery('#specfit_color_img_upload_icon_uneditable_' + productColorId).css("display","none");
    jQuery('#specfit_color_img_upload_icon_' + productColorId).css("display","block");
    ;
}