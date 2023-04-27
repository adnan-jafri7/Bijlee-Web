<?php
//error_reporting(E_ERROR | E_PARSE);
require '../includes/db_connect.php';
session_start();
$provider=$_POST['provider'];
$customer_mobile=$_POST['cus_mobile'];
$amount=$_POST['due_amount'];
$account=$_POST['account'];
$due_date=$_POST['due_date'];
$customer_name=$_POST['customer_name'];
$bill_number=$_POST['bill_number'];
$bill_date=$_POST['bill_date'];
$username=$_SESSION['mobile'];
$password=$_SESSION['password'];
$sid=$_POST['sid'];
$sid_session=$_SESSION['sid'];
if(strlen($sid_session)<1){
    $response=array("success" => false, "message" => "You are not logged in.");
    echo json_encode($response);
  }
  else if(strlen($username)<10 || strlen($password)<1 || $sid!=$sid_session)  {
      $response = array("success" => false, "message" => "Invalid parameters");
      echo json_encode($response);
    //header("Location:../index.php");
      return;
  }

  else{
    $sql = "SELECT * FROM user_detail WHERE mobile='$username' AND passowrd='$password'";
$result = mysqli_query($conn, $sql);
if (!$result) {
	$response = array("success" => false, "message" => "Something went wrong!");
	echo json_encode($response);
	return;
}


if(mysqli_num_rows($result)==0){
	$response = array("success" => false, "message" => "Some Error Occurred!");
	echo json_encode($response);
  //header("Location:../index.php");
	return;
}
else{
    $row=mysqli_fetch_assoc($result);
    $balance=$row['balance'];
    $name=$row['name'];
    $shopMobile=$row['username'];
    if($amount>$balance){
        $response=array("success"=>false,"message"=>"Insufficient Funds!");
        echo json_encode($response);
    }
    else{
        $balance=$balance-$amount;
        date_default_timezone_set("Asia/Kolkata");
        $paymentDate=date("Y-m-d H:i:s");
        $date=date("YmdHis");
        $Tid="JCC"."$date";
        $sql="UPDATE `user_detail` SET `balance`=$balance WHERE username='$username'";
        $query="INSERT INTO `bill_details`(`Account`, `operatorName`, `amount`, `customerMobile`, `customerName`, `dueDate`, `billDate`, `paymentDate`, `Tid`, `shopName`, `shopMobile`, `status`, `balance`, `updateDate`) VALUES ('$account','$provider','$amount','$customer_mobile','$customer_name','$due_date','$bill_date','$paymentDate','$Tid','$name','$shopMobile','Unpaid','$balance','$paymentDate')";
        $result = mysqli_query($conn, $sql);
        $result2=mysqli_query($conn,$query);
        if (!$result || !$result2) {
              $response = array("success" => false, "message" => "Something went wrong!");
              echo json_encode($response);
              return false;
          }
        else{
          $_SESSION['balance']=$balance;
          $response = array("success" => true, "message" => "Bill Payment Successful.","Tid" => "$Tid");
          echo json_encode($response); 
        }
        
    }

}
  }
?>