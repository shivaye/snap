<?php 


//sms send function
function run_sms_api($a,$b){ 
$mobile = $a;
$message      = urlencode($b);
 $from = "DOSDLI"; 
$api_key = "35D529A163D14B";  
 
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, "http://txtsms.contourdigitalmedia.com/app/smsapi/index.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=0&routeid=13&type=text&contacts=".$mobile."&senderid=".$from."&msg=".$message);
$response = curl_exec($ch);
curl_close($ch); 
 

}


 //send otp 
if(isset($_POST['phone_number']) and !empty($_POST['phone_number'])){
	
	$response = array();
	
	$mobile_number  = $_POST['phone_number']; 
	
	$otp 			= substr(rand(),0,4);
	
   
           $response['error'] =  1;
    	   $response['otp'] =  $otp; 
    	   
    	   
           $message 		= "OTP ".$otp." for verify Mobile Number on mixmobile";
    	   
    	   run_sms_api($mobile_number,$message);
     
    
    echo json_encode($response);
  
} 

//Resend otp
if(isset($_POST['re_phone_number']) and !empty($_POST['re_phone_number'])){ 
    $otp 			= substr(rand(),0,4);
    $mobile_number  = $_POST['re_phone_number'];
    $message 		= "OTP ".$otp." for verify Mobile Number on Dealonsnap.com";
    run_sms_api($mobile_number,$message);
    echo $otp;
}

?>