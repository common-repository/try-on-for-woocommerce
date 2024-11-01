<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.dugudlabs.com
 * @since      1.0.0
 *
 * @package    Eyewear_virtual_try_on_wordpress
 * @subpackage Eyewear_virtual_try_on_wordpress/admin/partials
 */
$validAccessKey=false;
$accessKey="";
$accessEmail="";
$arrContextOptions=array(
      "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );
function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
      return file_get_contents($Url);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
if(isset($_POST['specfit_access_key']) && !empty($_POST['specfit_access_key']) && isset($_POST['specfit_access_email']) && !empty($_POST['specfit_access_email'])){
  $lk=specfit_validate_input_admin($_POST['specfit_access_key']);
  $email=specfit_validate_input_admin($_POST['specfit_access_email']);
  $url="https://dugudlabs.com/wp-json/specfitcore/v1/activate/specfit?apikey=".$lk."&email=".$email."&host=".get_site_url();
  $json = url_get_contents($url);
  if($json=="true"){
    $validAccessKey=true;
    update_option("specfit_platinum_access_key",specfit_validate_input_admin($_POST['specfit_access_key']));
    update_option("specfit_platinum_access_email",specfit_validate_input_admin($_POST['specfit_access_email'])); 
    $accessKey=get_option('specfit_platinum_access_key');
    $accessEmail=get_option('specfit_platinum_access_email'); 
  }
  else{
    update_option("specfit_platinum_access_key","INVALID_ACCESS_KEY");
    update_option("specfit_platinum_access_email","INVALID_EMAIL");  
    $accessKey=get_option('specfit_platinum_access_key');
    $accessEmail=get_option('specfit_platinum_access_email');
  }
}
else{
  $accessKey=get_option('specfit_platinum_access_key');
  $accessEmail=get_option('specfit_platinum_access_email'); 
  $url="https://dugudlabs.com/wp-json/specfitcore/v1/activate/specfit?apikey=".$accessKey."&email=".$accessEmail."&host=".get_site_url();
  $json = url_get_contents($url);
  if($json=="true"){
    $validAccessKey=true;
  }
  else{
    update_option("specfit_platinum_access_key","INVALID_ACCESS_KEY");
    update_option("specfit_platinum_access_email","INVALID_EMAIL");  
    $accessKey=get_option('specfit_platinum_access_key');
    $accessEmail=get_option('specfit_platinum_access_email');
  }
}
function specfit_validate_input_admin($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<!DOCTYPE html>
<html>
<style>
input[type=text] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
input[type=email] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

#specFit_Form_div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>
<body>

<h3>SpecFit Platinum</h3>
<h2>How to get Access key?</h2>
<p>You can avail 7 days trial license key by purchasing  <a href="https://dugudlabs.com/product/specfit-platinum/">https://dugudlabs.com/product/specfit-platinum/</a> for 3.00$. Once you feel specfit is good fit for your website, you can directly buy the Lifetime License from the same link. After each purchase, you will recieve your access keys via email, as well as you can check them at <a href="https://dugudlabs.com/my-account/">My Account</a> section on our website. For any kind of queries, please reach out us at Email: support@dugudlabs.com</p>
<h2>How to Activate Access key?</h2>
<p>To activate your licence key visit My Account page on our site <a href="https://dugudlabs.com/my-account/">https://dugudlabs.com/my-account/</a>. Once you activate the licence key then come back here and submit your registered email and licence key.</p>

<h4>Active Access Key: <?php echo get_option('specfit_platinum_access_key');?></h4>
<h4>Active Access Email: <?php echo $accessEmail;?></h4>
<h4>Status: <?php echo ($validAccessKey)?"<b style='color: green;'>Active</b>":"<b style='color: red;'>Not Active. Please contact support@dugudlabs.com</b>";?>
<div id="specFit_Form_div" style="width: 50%">
  <form  method="post">
    <label for="fnaspecfit_access_keyme">Enter Your Access Key.</label>
    <input class="specfitInput" type="text" id="specfit_access_key" name="specfit_access_key" placeholder="Your Access Key..">
    <span>*Access Key was sent in your order confirmation email or you can visit <a href="https://dugudlabs.com/my-account/view-license-keys/">Link</a> to check your keys.</span></br></br></br>
    <label for="specfit_access_email">Enter Your Registerd Email ID.</label>
    <input class="specfitInput" type="email" id="specfit_access_email" name="specfit_access_email" placeholder="Your Registered Email ID">
    <span>*Please enter the email address which you have used to register/order from www.dugudlabs.com</span>
    <input class="specfitInput" type="submit" value="Submit">
  </form>
</div>

 </body>
</html>