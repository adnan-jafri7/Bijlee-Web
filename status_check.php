<?php
require 'includes/db_connect.php';
session_start();
$account=$_POST['account'];
$tid=$_POST['tid'];
$opr_id=$_POST['op_selector'];
$mobile=$_POST['mobile'];
$sid=$_POST['sid'];
if($account=="" || $tid==""){
  $message="Invalid Account No or Tid";
  $response = array("success" => true, "status" => "FAILED", "message" => "$message");
  echo json_encode($response);
  return;
}
else{
  $arr=
       array(
        'adParams'=>new \stdClass(),
        'op'=>779,
        'cn'=>$account
       );
  
    $post_data=json_encode($arr);
    //echo $post_data;

    $url = "https://rapi.mobikwik.com/recharge/v1/viewpayment";
    

    // Initialize a new cURL session
    $ch = curl_init();
    //echo $cookie_file;
    // Set the URL for the request
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);

    
    // Set the method for the request (GET is the default, but you could use POST, PUT, DELETE, etc.)
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

    
    // Set the headers for the request
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-MClient:0","Content-Type:application/json","Cookie:__cf_bm=fZrPvjpV89IhjlG7jQL3j1_rMb8if0dMi0x0ac6ez.Y-1676638961-0-AUPeMQEJCOeBDdq1pJjmJcs+bOX/Vy7ZowFxvdfeII+BzGFxqJ8AZ5zGe8YzhLlftSy33GVEnFR/ax9bML3Bgrn2F2qe2SjfJd6y8rbImRaC"));
    
    //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    //curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
   
    
    // Follow redirects
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    // Return the response as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Execute the request and get the response
    $response = curl_exec($ch);
    $result=json_decode($response,true);
    //print_r($result);
    
    // Get the status code for the response
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Close the cURL session
    curl_close($ch);
    //print_r($headers);
    
    // Check if the request was successful
    if ($status_code == 200) {
        if($result['success']==false){
          $message=$result['message'];
          if($message['code']==500 && $message['text']=="Payment received for the billing period - no bill due"){
            $sql = "UPDATE `bill_details` SET `status`='Paid' WHERE tid='$tid'";
            $result=mysqli_query($conn,$sql);
            if(!$result){
              $response = array("success" => true, "status" => "Failed", "message" => "Some error occurred");
              echo json_encode($response);
            }
            else{
              $response = array("success" => true, "status" => "Success", "message" => "Bill Updated at Biller");
              echo json_encode($response);
            }
          }
         
        }
        else{
          $response = array("success" => true, "status" => "Failed", "message" => "Paid");
          echo json_encode($response);
        }
      }    
  
}
?>
