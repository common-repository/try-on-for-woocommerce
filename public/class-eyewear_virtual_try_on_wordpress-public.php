<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.dugudlabs.com
 * @since      1.0.0
 *
 * @package    Eyewear_virtual_try_on_wordpress
 * @subpackage Eyewear_virtual_try_on_wordpress/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Eyewear_virtual_try_on_wordpress
 * @subpackage Eyewear_virtual_try_on_wordpress/public
 * @author     DugudLabs <ravindrashekhawat5876@gmail.com>
 */
class Eyewear_virtual_try_on_wordpress_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	public function start_specfit_platinum(){
			$accessKey=get_option('specfit_platinum_access_key');
			if($accessKey!= null && $accessKey!=false && $accessKey!="INVALID_ACCESS_KEY"){
				add_action( 'woocommerce_before_add_to_cart_form', 'show_button_specfit_platinum', 32 ,0 );
				add_action( 'woocommerce_after_shop_loop_item', 'show_button_specfit_platinum', 32 ,0);
				add_action( 'wp_footer', 'show_specfit_model', 32 ,0 );
                add_shortcode( 'specfit_platinum_show_faces', 'show_models_faces_specfit_platinum' );
				
				add_filter('script_loader_tag', 'remove_defer_from_jquery', 10, 2);
				
			}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Eyewear_virtual_try_on_wordpress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Eyewear_virtual_try_on_wordpress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Eyewear_virtual_try_on_wordpress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Eyewear_virtual_try_on_wordpress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
	}


}
function load_script_for_shortcode(){
	wp_enqueue_style('jquery');
	wp_enqueue_style( 'SpecFit_Platinum', plugin_dir_url( __FILE__ ) . 'css/eyewear_virtual_try_on_wordpress-public.css', array(), '1.0.4', 'all' );
	wp_enqueue_style( 'SpecFit_Platinum'.'bootstrap', plugin_dir_url( __FILE__ ) . 'bootstrap/bootstrap.css', array(), '1.0.4', 'all' );
	wp_enqueue_style( 'SpecFit_Platinum'.'select', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(),'1.0.4', 'all' );
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'SpecFit_Platinum'.'bootstrapjs', plugin_dir_url( __FILE__ ) . 'bootstrap/bootstrap.js');
	wp_enqueue_script( 'SpecFit_Platinum'.'main', plugin_dir_url( __FILE__ ) . 'js/eyewear_virtual_try_on_wordpress-public.js',false);
	wp_enqueue_script("SpecFit_Platinum_Face_mesh", plugin_dir_url( __FILE__ ) . 'js/face_mesh.js', false );
	wp_enqueue_script("SpecFit_Platinum_Camera_Utils", plugin_dir_url( __FILE__ ) . 'js/camera_utils.js', false );

	
}
function load_script_and_styles_specfit_platinum(){
	wp_enqueue_style('jquery');
	wp_enqueue_style( 'SpecFit_Platinum', plugin_dir_url( __FILE__ ) . 'css/eyewear_virtual_try_on_wordpress-public.css', array(), '1.0.4', 'all' );
	wp_enqueue_style( 'SpecFit_Platinum'.'bootstrap', plugin_dir_url( __FILE__ ) . 'bootstrap/bootstrap.css', array(), '1.0.4', 'all' );
	wp_enqueue_style( 'SpecFit_Platinum'.'select', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(),'1.0.4', 'all' );
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'SpecFit_Platinum'.'main', plugin_dir_url( __FILE__ ) . 'js/eyewear_virtual_try_on_wordpress-public.js',false);
	wp_enqueue_script( 'SpecFit_Platinum'.'bootstrapjs', plugin_dir_url( __FILE__ ) . 'bootstrap/bootstrap.js');
	$accessKey=specfit_validate_input(get_option('specfit_platinum_access_key'));
	$accessEmail=specfit_validate_input(get_option('specfit_platinum_access_email'));
	$url="https://dugudlabs.com/wp-json/specfitcore/v1";
	// wp_enqueue_script("SpecFit_Platinum_Core",	$url.'/core?apikey='.$accessKey.'&email='.$accessEmail.'&host='.get_site_url(),array('jquery'));
	wp_enqueue_script("SpecFit_Platinum_FaceMesh",	$url.'/faceMesh?version=newDesign&apikey='.$accessKey.'&email='.$accessEmail.'&host='.get_site_url(),array('jquery'));

	wp_enqueue_script("SpecFit_Platinum_Face_mesh", plugin_dir_url( __FILE__ ) . 'js/face_mesh.js', false );
	wp_enqueue_script("SpecFit_Platinum_Camera_Utils", plugin_dir_url( __FILE__ ) . 'js/camera_utils.js', false );
	// wp_enqueue_script("SpecFit_Platinum_Face_mesh2", plugin_dir_url( __FILE__ ) . 'js/util.js', false );



}
function specfit_validate_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
  }
function load_script_and_styles_shop_specfit_platinum(){
	wp_enqueue_style( 'SpecFit_Platinum'.'bootstrap', plugin_dir_url( __FILE__ ) . 'bootstrap/bootstrap.css', array(), '1.0.4', 'all' );
}
$productTryOnImages=[];
function show_button_specfit_platinum(){
	
    global $product; 
	global $post;
	$relatedProducts=wc_get_related_products($product->get_id());
	$show_related_product_box_specfit_platinum = false;
	$relatedProductsWithTryOnArray=[];
	$colorDotsArray=[];
	foreach ( $relatedProducts as $postID ){
		$flag=true;
		$relatedProductTryOnImageKeys = get_post_meta($postID , 'specfit_product_try_on_color_keys' ,true);
		if($relatedProductTryOnImageKeys!="" && $relatedProductTryOnImageKeys!=false){
			$show_related_product_box_specfit_platinum = true;
			$specFitProduct = wc_get_product( $postID ); 
			$name = $specFitProduct->get_title();
			$price = $specFitProduct->get_price();
			foreach($relatedProductTryOnImageKeys as $relatedtrykey){
				$colorDotsObject = new stdClass();
				$relatedProductObject = new stdClass();
				$relatedtry=get_post_meta($postID , $relatedtrykey ,true);
				$colorDotsObject->productid = $relatedtry->productid;
				$colorDotsObject->tryOnImage = $relatedtry->colorImage;
				$colorDotsObject->tryOnImageColorCode = $relatedtry->colorCode;
				array_push($colorDotsArray,$colorDotsObject);

				$tryOnImgUrl=$relatedtry->colorImage;
				if(($tryOnImgUrl !=null || $tryOnImgUrl !='') && $flag==true){
					$flag =false;
					$relatedProductObject->tryOnImage =$tryOnImgUrl;
					$relatedProductObject->name =$name;
					$relatedProductObject->price =$price;
					$relatedProductObject->postID =$postID;
					$relatedProductObject->permaLink =get_permalink( $postID );
					$relatedProductObject->description ="";
					array_push($relatedProductsWithTryOnArray,$relatedProductObject);
				}
			} 
		}
	}
	$productTryOnImageKeys = get_post_meta($post->ID , 'specfit_product_try_on_color_keys' ,true);
	$productTryOnImages=[];
	if($productTryOnImageKeys!="" && $productTryOnImageKeys!=false){
		foreach($productTryOnImageKeys as $key){
			 $colorDotsObject = new stdClass();
				$relatedtry=get_post_meta($post->ID , $key ,true);
				$colorDotsObject->productid = $relatedtry->productid;
				$colorDotsObject->tryOnImage = $relatedtry->colorImage;
				$colorDotsObject->tryOnImageColorCode = $relatedtry->colorCode;
				array_push($colorDotsArray,$colorDotsObject);
				array_push($productTryOnImages,$relatedtry);
		}
	} 
	
    if(count($productTryOnImages) > 0){
		$myObj = new stdClass();
		$myObj->tryOnImage = $productTryOnImages[0]->colorImage;
		$myObj->tryOnId = $productTryOnImages[0]->productid;
		$myObj->name = $product->get_title();
		$myObj->price = $product->get_price();
		$myObj->colorDotsArray = $colorDotsArray;
		$myObj->currencySign =get_woocommerce_currency_symbol();
		$myObj->relatedProductsArray = $relatedProductsWithTryOnArray;
		$myJSON = json_encode($myObj);
    	?>
		<textarea type="hidden" hidden id="specfit_tryOn_info"  value='<?php  echo $myJSON ?>'> </textarea>
    	
		<?php 
		include plugin_dir_path(__FILE__).'../languages/eyewear_virtual_try_on_wordpress_English.php';
		$specfit_plati_words_lng = $words_specfit_platinum[get_locale()];
		if($specfit_plati_words_lng == null){
			$specfit_plati_words_lng = $words_specfit_platinum["en_US"];
		}
		
		?>
		<img class="specfit_platinum_try_on_image" style="display: none;position: absolute;top: 20%;width: 62%;left: 19%;"src="<?php echo $productTryOnImages[0]->colorImage ?>">
    	<!-- <button type="button" class="specfit_tryon_btn button" onclick="set_properties_glasses('<?php echo $productTryOnImages[0]->productid;?>','<?php echo $productTryOnImages[0]->colorImage;?>');" data-toggle="specfit_modal" data-target="#TryOnModal"><?php echo __("Try On", "eyewear_virtual_try_on_wordpress") ?> </button> -->
    	<button type="button" class="specfit_tryon_btn button" onclick='setGlassProperties("<?php echo $product->get_title(); ?>","<?php echo $product->get_price(); ?>","<?php echo $productTryOnImages[0]->colorImage ?>","<?php echo $myObj->tryOnId?>",<?php echo json_encode($colorDotsArray)?>,<?php echo json_encode($relatedProductsWithTryOnArray)?>,"<?php echo $myObj->currencySign ?>")'  data-toggle="specfit_modal" data-target="#TryOnModal"><?php echo __("Try On", "eyewear_virtual_try_on_wordpress") ?> </button>
    	<?php
	load_script_and_styles_specfit_platinum();
    }
}

function show_specfit_model(){
	include_once plugin_dir_path(__FILE__).'partials/eyewear_virtual_try_on_wordpress-public-display-new.php';
}

function show_models_faces_specfit_platinum(){
	//include plugin_dir_path(__FILE__).'partials/eyewear_virtual_try_on_wordpress-public-display-model-faces.php';
    $div='
  <div class="specfit_img_row specfit_row" style="border-width: medium;border-style: groove;">
    <div class="specfit_img_div specfit_col-sm-3  specfit_col-xs-3">
        <img  style="cursor: pointer;" onclick="change_face(this,\'62\',\'19\',\'28\')" src="'.plugin_dir_url(__FILE__).'/partials/images/face-1.png"><img>
    </div>
    <div class="specfit_img_div specfit_col-sm-3  specfit_col-xs-3">
        <img  style="cursor: pointer;" onclick="change_face(this,\'62\',\'19\',\'34\')" src="'.plugin_dir_url(__FILE__).'/partials/images/face-2.png"><img>
    </div>
    <div class="specfit_img_div specfit_col-sm-3  specfit_col-xs-3">
        <img  style="cursor: pointer;" onclick="change_face(this,\'66\',\'17\',\'29\')" src="'.plugin_dir_url(__FILE__).'/partials/images/face-3.png"><img>
    </div>
	<div class="specfit_img_div specfit_col-sm-3  specfit_col-xs-3">
		<img style="cursor: pointer;" onclick="change_face(this,\'48\',\'25\',\'32\')" src="'.plugin_dir_url(__FILE__).'/partials/images/face-4.png"><img>
	</div>
	<div class="specfit_img_div specfit_col-sm-3  specfit_col-xs-3">
        <img id="customImage" style="cursor: pointer;" onclick="change_face(this)" src=""><img>
    </div>
	<div class="specfit_img_div specfit_col-sm-3  specfit_col-xs-3">
		<button class="specfit_button" onClick="openMedia()">Upload Your Image</button>
        <input type ="file" hidden id="chooseAvatar" multiple = false onChange="uploadImage(this)" accept="image/png, image/jpeg, image/jpg"> </input>
    </div>
  </div>';
  return $div;
}
function remove_defer_from_jquery($tag, $handle) {
	if ('jquery-core' === $handle) {
		$tag = str_replace(' defer', '', $tag);
	}
	return $tag;
}