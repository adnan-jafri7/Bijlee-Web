<?php
error_reporting(E_ERROR | E_PARSE);
require '../includes/db_connect.php';
session_start();
$username=$_SESSION['mobile'];
$password=$_SESSION['password'];
$opr_id=$_POST['op_selector'];
$account=$_POST['account'];
//$mobile=$_POST['mobile'];
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
  $url="https://www.kwikapi.com/api/v2/bills/validation.php?api_key=12f4e4-164827-868329-2620eb-e4b21e&number=".$account."&amount=10&opid=$opr_id&order_id=478245232&mobile=7906025575";
  $ch=curl_init();
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  $result=curl_exec($ch);
  curl_close($ch);
  $result=json_decode($result,true);
  $status=$result['status'];
  $provider=$result['provider'];
  $message=$result['message'];
  $amount=$result['due_amount'];
  $due_date=$result['due_date'];
  $customer_name=$result['customer_name'];
  $bill_number=$result['bill_number'];
  $bill_date=$result['bill_date'];
	if($status=="FAILED"){
		$response=array("success"=>true,"status"=>"Failed","message"=>"$message");
		echo json_encode($response);
	}
	else{
  $response = array("success" => true, "message" => "$message", "provider"=>"$provider", "amount"=>"$amount", "due_date"=>"$due_date", "customer_name"=>"$customer_name", "bill_number"=>"$bill_number", "bill_date"=>"$bill_date");
	echo json_encode($response);
	return;
}
}
}