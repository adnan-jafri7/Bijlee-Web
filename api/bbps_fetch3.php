<?php
//error_reporting(E_ERROR | E_PARSE);
require '../includes/db_connect.php';
session_start();
$username=$_SESSION['mobile'];
$password=$_SESSION['password'];
$opr_id=$_REQUEST['op_selector'];
$account=$_REQUEST['account'];
$mobile=$_REQUEST['mobile'];
$sid=$_POST['sid'];
$sid_session=$_SESSION['sid'];
if(strlen($sid_session)<1){
  $response=array("success" => false, "message" => "You are not logged in.");
  echo json_encode($response);
}
else if(strlen($username)<10 || strlen($password)<1 || strlen($opr_id<1) || strlen($account)<5 || $sid!=$sid_session)  {
	$response = array("success" => false, "message" => "Invalid parameters");
	echo json_encode($response);
  //header("Location:../index.php");
	return;
}
else{


//$password = md5($password);

$sql = "SELECT * FROM user_detail WHERE mobile='$username' AND passowrd='$password'";
$result = mysqli_query($conn, $sql);
if (!$result) {
	$response = array("success" => false, "message" => "Something went wrong!");
	echo json_encode($response);
	return;
}

$row=mysqli_fetch_assoc($result);
if(mysqli_num_rows($result)==0){
	$response = array("success" => false, "message" => "Wrong username or password!");
	echo json_encode($response);
  //header("Location:../index.php");
	return;

}
else{
    /*$data = array(
        'ca_number' => $account,
        'csrf_cscportal_token2' => '8ad097517f136f96b06326702bbc4be3',    for digital seva api
        'mobile' => $mobile,
    );*/   
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
    
    // Get the status code for the response
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Close the cURL session
    curl_close($ch);
    //print_r($headers);
    
    // Check if the request was successful
    if ($status_code == 200) {
        if($result['success']==false){
          $message=$result['message'];
          $response=array("success"=>true,"status"=>"Failed","message"=>$message['text']);
		      echo json_encode($response);
        }
        else if($result['success']==true){
          $data=$result['data'];
          $connectionProfile=$data['connectionProfile'];
          $items=$connectionProfile['lineItemList'];
          $customer_name=$items[1]['value'];
          //echo $customer_name;
          
          $dueDate=$data['paymentItemDetails'][0]['lineItemList'][0]['value'];
          $date=date_create($dueDate);
          $due_date=date_format($date,"Y-m-d");
          //echo $due_date;
          $due_amount=$data['paymentItemDetails'][0]['lineItemList'][2]['value'];
          $amount= substr($due_amount, 0, strpos($due_amount, "."));
          //echo $amount;
          $provider='Paschimanchal Vidyut Vitran Nigam Ltd.(PVVNL)';
          $bill_number=$account;
          date_sub($date,date_interval_create_from_date_string("7 days"));
          
          $bill_date=date_format($date,"Y-m-d");
          $response = array("success" => true, "provider"=>"$provider", "amount"=>"$amount", "due_date"=>"$due_date", "customer_name"=>"$customer_name", "bill_number"=>"$bill_number", "bill_date"=>"$bill_date");
          echo json_encode($response);
          return;

        }
       
        // Do something with the response
        //echo $response;
    } else {
        // Handle the error
        echo "Request failed with status code: $status_code";
    }
  //echo $result;
}
}