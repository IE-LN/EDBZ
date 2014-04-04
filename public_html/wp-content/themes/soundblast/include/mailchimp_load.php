<?php
global $cs_theme_option,$counter;
require_once '../../../../wp-load.php';
$mailchimp_key = '';
if(isset($cs_theme_option['mailchimp_key'])){ $mailchimp_key= $cs_theme_option['mailchimp_key'];}
if(isset($_POST) and !empty($_POST['cs_list_id']) and $mailchimp_key !=''){
    if($mailchimp_key <> ''){
		  $MailChimp = new MailChimp($mailchimp_key);
	  }
  $email = $_POST['mc_email'];
  $list_id = $_POST['cs_list_id'];
  $result = $MailChimp->call('lists/subscribe', array(
	  'id'                => $list_id,
	  'email'             => array('email'=>$email),
	  'merge_vars'        => array(),
	  'double_optin'      => false,
	  'update_existing'   => false,
	  'replace_interests' => false,
	  'send_welcome'      => true,
  ));
  if($result <> ''){
	  if(isset($result['status']) and $result['status'] == 'error'){
		  echo $result['error'];
	  }else{
		  echo 'subscribe successfully';
	  }
  }
}else{
  echo 'please set API key';	 
}
?>