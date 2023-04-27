<?php
require '../includes/db_connect.php';
date_default_timezone_set("Asia/Kolkata");
$time=date("ha");
if($time=="01am" || $time=="04:00am"){
  $sql="SELECT * FROM bill_details WHERE status='Unpaid'";
  $result=mysqli_query($conn,$sql);
  if (!$result) {
  	$response = array("success" => false, "message" => "Something went wrong!");
  	echo json_encode($response);
  	return;
  }

  else{
    $row=mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result)==0){
      $response = array("success" => false, "message" => "No pending bill!");
    	echo json_encode($response);
    	return;
    }
    else{
      $data=mysqli_fetch_all($result,MYSQLI_ASSOC);
      foreach ($data as $detail) {
        $account=$detail['Account'];
        $url="https://www.kwikapi.com/api/v2/bills/validation.php?api_key=12f4e4-164827-868329-2620eb-e4b21e&number=".$account."&amount=10&opid=88&order_id=478245232&mobile=7906025575";
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result=curl_exec($ch);
        curl_close($ch);
        $result=json_decode($result,true);
        $message=$result['message'];
        $status=$result['status'];
        if($status=="FAILED" && $message="Payment received for the billing period - no bill due"){
          $sql2="UPDATE `bill_details` SET status='Paid' WHERE Account=$account";
          $result=mysqli_query($conn,$sql2);
          if (!$result) {
            echo "Some error occurred";
          }
          else{
            echo "Updation successfull!\n";
          }
        }
        else{
          echo "Bill/s is/are pending.";
        }

      }

    }
  }
}


?>
