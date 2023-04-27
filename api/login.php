<?php
error_reporting(E_ERROR | E_PARSE);
require '../includes/db_connect.php';

//header('Content-Type: application/json');
//header('Access-Control-Allow-Origin:*');
//$data=json_decode(file_get_contents("php://input"),true);
$mobile=$_REQUEST['mobile'];
$password=$_REQUEST['password'];
if(strlen($mobile)<10 || strlen($password)<1){
	$response = array("success" => false, "message" => "Invalid parameters!");
	echo json_encode($response);
	return;
}

$password = md5($password);

$sql = "SELECT * FROM user_detail WHERE mobile='$mobile' AND passowrd='$password'";
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
	return;

}
else{
	$response = array("success" => true, "message" => "You are successfully logged in!");
	session_start();
	$sid=uniqid();
	$_SESSION['sid']=$sid;
	$_SESSION['mobile']=$row['mobile'];
	$_SESSION['password']=$row['passowrd'];
	$_SESSION['name']=$row['name'];
	$_SESSION['balance']=$row['balance'];
	$_SESSION['email']=$row['email'];
	$_SESSION['user_status']=$row['user_status'];

	echo json_encode($response);
return;
}
mysqli_close($conn);
?>
