<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.dugudlabs.com
 * @since      1.0.0
 *
 * @package    Eyewear_virtual_try_on_wordpress
 * @subpackage Eyewear_virtual_try_on_wordpress/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Eyewear_virtual_try_on_wordpress
 * @subpackage Eyewear_virtual_try_on_wordpress/admin
 * @author     DugudLabs <ravindrashekhawat5876@gmail.com>
 */
class Eyewear_virtual_try_on_wordpress_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action( 'wp_ajax_addProductColorTryOn', 'addProductColorTryOn' );
		add_action( 'wp_ajax_nopriv_addProductColorTryOn', 'addProductColorTryOn' );
		add_action( 'wp_ajax_updateProductColorTryOn', 'updateProductColorTryOn' );
		add_action( 'wp_ajax_nopriv_updateProductColorTryOn', 'updateProductColorTryOn' );
		add_action( 'wp_ajax_deleteProductColorTryOn', 'deleteProductColorTryOn' );
		add_action( 'wp_ajax_nopriv_deleteProductColorTryOn', 'deleteProductColorTryOn' );
	}

	/**
	 * Register the stylesheets for the admin area.
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

		
		wp_enqueue_style('thickbox');
		//wp_enqueue_style('bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css');
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/eyewear_virtual_try_on_wordpress-admin.css', array(), $this->version, 'all' );
    


	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_enqueue_script('jquery');
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/eyewear_virtual_try_on_wordpress-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( "load_core_function_specfit", plugin_dir_url( __FILE__ ) . 'js/load_core_function.js', $this->version, false );
		wp_enqueue_script( "submitNewtryOnImages", plugin_dir_url( __FILE__ ) . 'js/submitNewtryOnImages.js', $this->version, false );
		wp_localize_script( 'submitNewtryOnImages', 'submitNewType_specfit_Ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php') ));
		
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		//wp_enqueue_script('bootstrap-js', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', ['jquery']);

	}
public function add_menu_specfit_platinum() {
	add_menu_page("SpecFit","SpecFit", "manage_options", "tryonmenu",  'show_admin_menu_specfit_platinum', $icon_url = plugin_dir_url( __FILE__ ) . 'css/specfit.svg', $position = null );
	$accessKey=get_option('specfit_platinum_access_key');
	if($accessKey!= null && $accessKey!=false && $accessKey!="INVALID_ACCESS_KEY"){
		$accessEmail=get_option('specfit_platinum_access_email');
		$json = '';
		$url="https://dugudlabs.com/wp-json/specfitcore/v1/activate/specfit?apikey=".$accessKey."&email=".$accessEmail."&host=".get_site_url();
		if (!function_exists('curl_init')){ 
			$json = file_get_contents($url);
		}
		else{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			curl_close($ch);
			$json = $output;
		}
		
		
		if($json!="true"){
			update_option("specfit_platinum_access_key","INVALID_ACCESS_KEY");
			update_option("specfit_platinum_access_email","INVALID_EMAIL");  
		}
		else{
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes_transparent_image_specfit_platinum' ) );
			add_action( 'save_post', array( $this, 'save_transparent_image_specfit_platinum' )); 
		}
		
		
	}
 }
 public function save_transparent_image_specfit_platinum($post_id){
     $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'case_study_bg_nonce' ] ) && wp_verify_nonce( $_POST[ 'case_study_bg_nonce' ], 'case_study_bg_submit' ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce  ) {
        return;
    }

    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'specfit_platinum_try_on_image_URL' ] ) ) {
        update_post_meta( $post_id, 'try_on_image_specfit_platinum', $_POST[ 'specfit_platinum_try_on_image_URL' ] );
          //update_post_meta( $post_id, 'try_on_image_specfit_platinum', plugin_dir_url( __FILE__ ) . 'images/glasses.png' );
    }    
    }
                
 public function add_meta_boxes_transparent_image_specfit_platinum($post_types  ) {
	 
    $post_types = array('product');     //limit meta box to certain post types
    global $post;
    if ( 
  	in_array( 
    'woocommerce/woocommerce.php', 
    apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) 
  	) 
	) {
		$post_variable = (isset($_GET['post']))?'post':'post_type';
    	$product = wc_get_product( $_GET[$post_variable] );
   		if ($post->post_type=='product'){
        	add_meta_box(
	            'Try On Image SpecFit-Platinum'
	            ,__( 'Try On Image SpecFit-Platinum', 'woocommerce' )
	            ,array( $this, 'render_meta_box_content_specfit_platinum' )
	            ,$post_types
	            ,'advanced'
	            ,'high'
	        );
    	}
	}
    
}
    public function render_meta_box_content_specfit_platinum(){
		global $post;
		global $product; 
		$defaultImage=plugin_dir_url( __FILE__ ) . 'css/upload.png';
		$post_variable = (isset($_GET['post']))?'post':'post_type';
		$productTryOnImageKeys = get_post_meta($_GET[$post_variable] , 'specfit_product_try_on_color_keys' ,true);
		$productTryOnImages=[];
		if($productTryOnImageKeys!="" && $productTryOnImageKeys!=false){
			foreach($productTryOnImageKeys as $key){
					array_push($productTryOnImages,get_post_meta($_GET[$post_variable] , $key ,true));
			}
		}
		
		?>
		<div class="specfit_row" style="display: inline-block;">
			<div class="specfit_column" id="specfit_product_color_column">
				<div class="specfit_card">
					<img onclick="upload_product_try_on_image('specfit_color_img_upload_icon');" class="specfit_color_img_upload_icon" id="specfit_color_img_upload_icon" src="<?php echo plugin_dir_url( __FILE__ ) . 'css/upload.png'?>">
					<div class="container">
						<b>Color: <input  type="color" name="specfit_product_color" id="specfit_product_color"></b></br>
						<b class="specfit_add_errors" id="specfit_add_error"></b>
						<b class="specfit_add_info" id="specfit_add_info"></b>
						<p><a onclick="addNewProductTryOn('<?php echo $_GET[$post_variable]; ?>','<?php echo $defaultImage; ?>')" class="specfit_button">Add New Try On Image</a></p>
					</div>
				</div>
			</div>
			<?php foreach($productTryOnImages as $tryOnImage){
			$combined_id=$tryOnImage->productTryOnImageId;
			?>
			<div class="specfit_column" id="specfit_product_color_column_<?php echo $combined_id;?>">
				<div class="card specfit_card">
					<img style="display: none;" class="specfit_color_img_upload_icon" onclick="upload_product_try_on_image('specfit_color_img_upload_icon_<?php echo $combined_id;?>');" id="specfit_color_img_upload_icon_<?php echo $combined_id;?>" src="<?php echo $tryOnImage->colorImage ; ?>">
					<img class="specfit_color_img_upload_icon" id="specfit_color_img_upload_icon_uneditable_<?php echo $combined_id;?>" src="<?php echo $tryOnImage->colorImage ; ?>">
					<div class="container">
						<b>Color:<input disabled value="<?php echo $tryOnImage->colorCode ; ?>" type="color" name="specfit_product_color_<?php echo $combined_id;?>" id="specfit_product_color_<?php echo $combined_id;?>"></b></br>
						<b class="specfit_add_errors" id="specfit_add_error_<?php echo $combined_id;?>"></b>
						<b class="specfit_add_info" id="specfit_add_info_<?php echo $combined_id;?>"></b>
						<p><a onclick="edit_specfit_color('<?php echo $combined_id;?>')" id="specfit_color_edit_btn_<?php echo $combined_id;?>" class="specfit_button">Edit</a></p>
						<p><a onclick="deleteProductColorTryOn('<?php echo $combined_id;?>','<?php echo $post->ID;?>')" id="specfit_color_delete_btn_<?php echo $combined_id;?>" class="specfit_button specfit_color_delete_btn">Delete</a></p>
						<p><a onclick="updateProductColorTryOn('<?php echo $combined_id;?>','<?php echo $post->ID;?>')" style="display:none;" id="specfit_color_save_btn_<?php echo $combined_id;?>" class="specfit_button specfit_color_save_btn">Save</a></p>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php
	}
}
    
   function show_admin_menu_specfit_platinum() { 
    include_once plugin_dir_path(__FILE__).'partials/eyewear_virtual_try_on_wordpress-admin-display.php';
     //include plugin_dir_url(__FILE__)."partials/eyewear_virtual_try_on_wordpress-admin-display.php";
 }
 function addProductColorTryOn(){
	$color = (object) $_POST["data"];
	$result = add_post_meta( $color->productid,'specfit_product_try_on_color_'.$color->productTryOnImageId,$color,true);
	if($result!=false){
		$specfit_color_keys=get_post_meta($color->productid,'specfit_product_try_on_color_keys',true);
		if($specfit_color_keys!=""){
			$specfit_color_keys['specfit_product_try_on_color_'.$color->productTryOnImageId]='specfit_product_try_on_color_'.$color->productTryOnImageId;
			$result = update_post_meta( $color->productid,'specfit_product_try_on_color_keys',$specfit_color_keys);
		}
		else{
			$specfit_color_keys=[];
			$specfit_color_keys['specfit_product_try_on_color_'.$color->productTryOnImageId]='specfit_product_try_on_color_'.$color->productTryOnImageId;
			$result = add_post_meta( $color->productid,'specfit_product_try_on_color_keys',$specfit_color_keys,true);
		}
	}
	echo $result;
	die();
}

function updateProductColorTryOn(){
	$color = (object) $_POST["data"];
	$oldProductColorId = $color->productTryOnImageId;
	$color->productTryOnImageId = $color->productid."_".str_replace("#","",$color->colorCode);
	$result = update_post_meta( $color->productid,'specfit_product_try_on_color_'.$color->productTryOnImageId,$color);
	if($oldProductColorId!=$color->productTryOnImageId){
		$specfit_color_keys=get_post_meta($color->productid,'specfit_product_try_on_color_keys',true);
		unset($specfit_color_keys['specfit_product_try_on_color_'.$oldProductColorId]);
		$specfit_color_keys['specfit_product_try_on_color_'.$color->productTryOnImageId]='specfit_product_try_on_color_'.$color->productTryOnImageId;
		update_post_meta( $color->productid,'specfit_product_try_on_color_keys',$specfit_color_keys);
		delete_post_meta( $color->productid,'specfit_product_try_on_color_'.$oldProductColorId);
	}
	echo $result;
    die();
}

function deleteProductColorTryOn(){
	$color = (object) $_POST["data"];
	$specfit_color_keys = get_post_meta($color->productid,'specfit_product_try_on_color_keys' ,true);
	$result=false;
	unset($specfit_color_keys['specfit_product_try_on_color_'.$color->productTryOnImageId]);
	update_post_meta( $color->productid,'specfit_product_try_on_color_keys',$specfit_color_keys);
	$result = delete_post_meta( $color->productid,'specfit_product_try_on_color_'.$color->productTryOnImageId);
	echo $result;
    die();
}