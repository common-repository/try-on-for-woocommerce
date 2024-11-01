//Product try on images

function addNewProductTryOn(productId,defaultImage) {
    var producTryOnImage = {};
    producTryOnImage.productid = productId;
    producTryOnImage.colorCode = jQuery("#specfit_product_color").val();
    producTryOnImage.colorImage = jQuery("#specfit_color_img_upload_icon").attr('src');
    producTryOnImage.productTryOnImageId = producTryOnImage.productid+"_"+producTryOnImage.colorCode.replace("#","",producTryOnImage.colorCode );
    var productTryOnImageId=producTryOnImage.productid+"_"+producTryOnImage.colorCode.replace("#","",producTryOnImage.colorCode );
    if(producTryOnImage.productid==''|| producTryOnImage.colorCode=='' || producTryOnImage.colorImage==''){
        jQuery("#specfit_add_error").text("Please enter all values & upload image to proceed.");
    }
    else{
        jQuery.ajax({
            type: 'POST',
            data: { "action": "addProductColorTryOn", "data": producTryOnImage },
            url: submitNewType_specfit_Ajax.ajaxurl,
            beforeSend: function() {},
            success: function(data) {
                if(data!=false){
                    jQuery("#specfit_add_info").text("Successfully Added.").show();
                    jQuery("#specfit_add_info").hide(5000);
                    var appendStr = `<div class="specfit_column" id="specfit_product_color_column_`+productTryOnImageId+`">
                            <div class="specfit_card">
                                <img style="display: none;" class="specfit_color_img_upload_icon" onclick="upload_product_color_image('specfit_color_img_upload_icon_`+productTryOnImageId+`');" id="specfit_color_img_upload_icon_`+productTryOnImageId+`" src="`+producTryOnImage.colorImage+`">
                                <img class="specfit_color_img_upload_icon" id="specfit_color_img_upload_icon_uneditable_`+productTryOnImageId+`" src="`+producTryOnImage.colorImage+`">
                                <div class="container">
                                    <b>Color:<input disabled="" value="`+producTryOnImage.colorCode+`" type="color" name="specfit_product_color_`+productTryOnImageId+`" id="specfit_product_color_`+productTryOnImageId+`"></b><br>
                                    <b class="specfit_add_errors" id="specfit_add_error_`+productTryOnImageId+`"></b>
                                    <b class="specfit_add_info" id="specfit_add_info_`+productTryOnImageId+`"></b>
                                    <p><a onclick="edit_specfit_color('`+productTryOnImageId+`')" id="specfit_color_edit_btn_`+productTryOnImageId+`" class="specfit_button">Edit</a></p>
                                    <p><a onclick="deleteProductColorTryOn('`+productTryOnImageId+`','`+producTryOnImage.productid+`','`+producTryOnImage.colorCode+`')" id="specfit_color_delete_btn_`+productTryOnImageId+`" class="specfit_button specfit_color_delete_btn">Delete</a></p>
                                    <p><a onclick="updateProductColorTryOn('`+productTryOnImageId+`','`+producTryOnImage.productid+`','`+producTryOnImage.colorCode+`')" style="display:none;" id="specfit_color_save_btn_`+productTryOnImageId+`" class="specfit_button specfit_color_save_btn">Save</a></p>
                                </div>
                            </div>
                        </div>`;
                        jQuery( "#specfit_product_color_column").after(appendStr).hide().show('slow');
                        jQuery("#specfit_product_color").val("#00000");
                        jQuery("#specfit_color_img_upload_icon").attr('src', defaultImage);
                }
            },
            error: function(data) {
                jQuery("#specfit_add_error").text("Couldn't update the color.Make sure you have entered correct values.").show();
                jQuery("#specfit_add_error").hide(5000);
            }
    
        });
    } 
}

function updateProductColorTryOn(productTryOnImageId,productId){
    var producTryOnImage = {};
    producTryOnImage.productid = productId;
    producTryOnImage.colorCode = jQuery("#specfit_product_color_"+productTryOnImageId).val();
    producTryOnImage.colorImage = jQuery("#specfit_color_img_upload_icon_"+productTryOnImageId).attr('src');
    producTryOnImage.productTryOnImageId = productTryOnImageId;
    if(producTryOnImage.productid==''|| producTryOnImage.colorCode=='' || producTryOnImage.colorImage==''){
        jQuery("#specfit_add_error_"+productTryOnImageId).text("Please enter all values & upload image to proceed.");
    }
    else{
        jQuery.ajax({
            type: 'POST',
            data: { "action": "updateProductColorTryOn", "data": producTryOnImage },
            url: submitNewType_specfit_Ajax.ajaxurl,
            beforeSend: function() {},
            success: function(data) {
                if(data!=false){
                    jQuery('#specfit_color_edit_btn_' + productTryOnImageId).css("display","inline-block");
                    jQuery('#specfit_color_delete_btn_' + productTryOnImageId).css("display","inline-block");
                    jQuery('#specfit_color_save_btn_' + productTryOnImageId).css("display","none");
                   jQuery('#specfit_product_color_' + productTryOnImageId).attr('disabled', 'disabled').val(producTryOnImage.colorCode);
                    jQuery('#specfit_color_img_upload_icon_uneditable_' + productTryOnImageId).css("display","block").attr('src', producTryOnImage.colorImage);;
                    jQuery('#specfit_color_img_upload_icon_' + productTryOnImageId).css("display","none");
                    jQuery("#specfit_add_info_" + productTryOnImageId).text("Updated.").show();
                    jQuery("#specfit_add_info_" + productTryOnImageId).hide(10000);
                }
                else{
                    jQuery("#specfit_add_error_"+productTryOnImageId).text("Couldn't update the color.Make sure you have entered correct values.").show();
                }
            },
            error: function(data) {
                jQuery("#specfit_add_error_"+productTryOnImageId).text("Couldn't update the color.Make sure you have entered correct values.");
            }
        
    
        });
    }
}
function deleteProductColorTryOn(productTryOnImageId,productId){
    var productColor = {};
    productColor.productid = productId;
    productColor.productTryOnImageId = productTryOnImageId;
    jQuery.ajax({
        type: 'POST',
        data: { "action": "deleteProductColorTryOn", "data": productColor },
        url: submitNewType_specfit_Ajax.ajaxurl,
        beforeSend: function() {},
        success: function(data) {
            if(data){
                jQuery("#specfit_add_info_" + productTryOnImageId).text("Successfully Deleted.");
                jQuery("#specfit_product_color_column_"+productTryOnImageId).hide("slow", function(){ jQuery(this).remove(); })
            }
            else{
                jQuery("#specfit_add_error_"+productTryOnImageId).text("Couldn't delete the color.");
            }
        },
        error: function(data) {
            jQuery("#specfit_add_error_"+productTryOnImageId).text("Couldn't delete the color.");
        }
    

    });
}
