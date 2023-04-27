<?php
//error_reporting(E_ERROR | E_PARSE);
require '../includes/db_connect.php';
session_start();
$username=$_SESSION['mobile'];
$password=$_SESSION['password'];
$opr_id=$_POST['op_selector'];
$account=$_POST['account'];
$mobile=$_POST['mobile'];
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
          'mobileNumber'=>'8979319339',
          'billerName'=>"Paschimanchal Vidyut Vitran Nigam Limited (PVVNL)(Postpaid and Smart Prepaid Meter Recharge)",
          'billerId'=>'PASC00000NATUL',
          'dynamicFields'=>array(
          		array(
              'billerId'=>'PASC00000NATUL',
              'dataType'=>'NUMERIC',
              'optional'=>'N',
              'paramName'=>'Consumer Number',
              'minLength'=>'10',
              'maxLength'=>'10',
              'prefix'=>null,
              'postfix'=>null,
              'regex'=>"^[0-9]{10}$",
              'regexJs'=>"^[0-9]{10}$",
              'visibility'=>'true',
              'helpText'=>null,
              'paramValue'=>$account
          )
          ),
          'billCaptureFlag'=>''
        
        );
  
    $post_data=json_encode($arr);
  
  
    $url="https://bbps.spicemoney.com/billfetch";
    //$url="https://digitalseva.csc.gov.in/services/electricity/billenquiry";
  //$url="https://www.kwikapi.com/api/v2/bills/validation.php?api_key=12f4e4-164827-868329-2620eb-e4b21e&number=".$account."&amount=10&opid=$opr_id&order_id=478245232&mobile=7906025575";
  $ch=curl_init();
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  //curl_setopt($ch,CURLINFO_HEADER_OUT, true);
  //curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  
  curl_setopt($ch,CURLOPT_HTTPHEADER,array("Cookie: _ga=GA1.2.1010293249.1676461276; _gid=GA1.2.292157822.1676461276; JSESSIONID=6E98E6CB5E6163D66EF7865668FEDE39.BAB4F6DC; cookiesession1=051F515D4EJ1QLXFSZOOT2GM8NSRFB90; _gat_UA-117676079-1=1","Content-Type:application/json"));
  //echo $post_data;
  $result=curl_exec($ch);
  //echo $result;
  curl_close($ch);
  $result=json_decode($result,true);
  $status=$result['respCode'];
  $message=$result['respDesc'];
  //echo $result;

	if($status=="311"){
		$response=array("success"=>true,"status"=>"Failed","message"=>"$message");
		echo json_encode($response);
	}
	else{
        
        $provider=$result['provider'];
        $amount=$result['due_amount'];
        $due_date=$result['due_date'];
        $customer_name=$result['customer_name'];
        $bill_number=$result['bill_number'];
        $bill_date=$result['bill_date'];
  $response = array("success" => true, "message" => "$message", "provider"=>"$provider", "amount"=>"$amount", "due_date"=>"$due_date", "customer_name"=>"$customer_name", "bill_number"=>"$bill_number", "bill_date"=>"$bill_date");
	echo json_encode($response);
	return;
}
}
}