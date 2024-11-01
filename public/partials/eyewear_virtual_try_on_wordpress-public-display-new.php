<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.dugudlabs.com
 * @since      1.0.0
 *
 * @package    Eyewear_virtual_try_on_wordpress
 * @subpackage Eyewear_virtual_try_on_wordpress/public/partials
 */
function example_callback( $value, $arg2 ) {
    return;
}
    
?>
<div class="specfit_container">
    <div class="specfit_modal specfit_fade"  data-backdrop="false" style="display:none;padding-right:0px !important; z-index: 10000000;" id="TryOnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="specfit_modal-dialog" id="SpecdFit_Dialog" style=""  role="document">
            <div class="specfit_modal-content try_on_popup" style="padding:0px;overflow-y: inherit;right: 0px;    position: inherit;">
                <div class="specfit_modal-header">
                <a href="https://www.dugudlabs.com/specfit"><img src="<?php echo plugin_dir_url(__FILE__).'/images/SpecFit-logos_black.png'  ?>" style="box-shadow: rgb(0 0 0 / 25%) 0px 54px 55px, rgb(0 0 0 / 12%) 0px -12px 30px, rgb(0 0 0 / 12%) 0px 4px 6px, rgb(0 0 0 / 17%) 0px 12px 13px, rgb(0 0 0 / 9%) 0px -3px 5px;cursor:pointer;width: 10%;float: left;"alt="virtual try on wordpress"></a>
                    <button type="button" class="specfit_close" onclick="startWebcam_v2(true)" data-dismiss="specfit_modal">&times;</button>
                    <h5 class="specfit_modal-title" id ="specfit_product_title" style="text-align: center"></h5>
                </div>
                <div class="specfit_row" style="margin-right: 0px;margin-left: 0px;">
                            
                    <div class="" id="specfit_img_div">
                        
                        <div id="video_div" style="display: none;">
                            <video  class="specfit_canvas_media specfit_input_video" style="transform: scale(-1, 1); display: none; width: 100% ;" id="specfit_input_video" playsinline></video>

                            <input type ="file" id ="specfit_hidden_uploader"  style="display:none;" /> 
                            <img id="specfit_img_div_upload" class="specfit_img_div_upload" style="z-index: 1;display: none;" src="" >
                            <img id="galssimage_video" style="z-index: 1;display: none; position: absolute;" src="">
                            <div id="specfit_video_loader" class="specfit_loader" >
                                <div id="imageLoader"></div>
                                <p class="specfit_quotes"><?php echo __("Hang On! We are trying to open webcam.","eyewear_virtual_try_on_wordpress")?> <br/>1. <?php echo __("Please allow webcam access when asked.", "eyewear_virtual_try_on_wordpress")?><br/>2. <?php echo __("Keep your head straight and look into webcam.","eyewear_virtual_try_on_wordpress")?></br>3. <?php echo __("Try On will start once we are able to recongnize your face.","eyewear_virtual_try_on_wordpress")?></p>

                            </div>
                            
                        </div>
                        
                    </div>
                    <div id="actionDiv" style="">
                            <?php 
                                do_action( 'specfit_before_camera_button', 0 );
                            ?>
                            <button class="specFitActionbtn" id="specFitActionbtn1" onclick="startWebcam_v2(false);"><i class="fa specfit_fa fa-video-camera fa-video-camera-specfit"></i>&nbsp; <?php echo __("Live","eyewear_virtual_try_on_wordpress")?></button>
                            <button class="specFitActionbtn" id="specFitActionbtn2" onclick="startUploadSpecfit();"><i class="fa specfit_fa fa-upload fa-upload-specfit"></i>&nbsp; <?php echo __("Upload","eyewear_virtual_try_on_wordpress")?></button>
                            <?php 
                                do_action( 'specfit_after_upload_button', 0 );
                            ?>
                    </div>
                    <div id="product_summary_specfit" class="product_summary_specfit" style ="display:none;">
                        <div class="specfit_price">
                            <div class="specfit_price_div">
                                <span class="woocommerce-Price-currencySymbol" id="specfit_product_currencySign"></span>&nbsp;<span id="specfit_product_price"></span>
                            </div>                           
                        </div>                        
                        <div class="specfit_color_dot_div">
                        
                        </div>
                        <div class="specfit_related_products_list">
                            
                        </div>
                    </div>
                        
                </div>
            </div>
        </div>
    </div>
</div>