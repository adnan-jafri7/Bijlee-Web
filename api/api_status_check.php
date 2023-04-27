<?php
error_reporting(E_ERROR | E_PARSE);
require '../includes/db_connect.php';
session_start();
$tid=$_GET['tid'];
$username=$_GET['username'];
if(strlen($tid)!=0 && strlen($username)==10){
  $url="https://www.kwikapi.com/api/v2/status.php?api_key=12f4e4-164827-868329-2620eb-e4b21e&order_id=$tid";
  $ch=curl_init();
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  $result=curl_exec($ch);
  curl_close($ch);
  $result=json_decode($result,true);
  //print_r($result);
  $apiresponse=$result['response'];
  $message=$apiresponse['message'];
  if($message=="Invalid Transaction Id"){
    $response = array("success" => true, "status" => "FAILED", "message" => "$message");
    echo json_encode($response);
    return;
  }
  else{
    $status=$apiresponse['status'];
    $opr_id=$apiresponse['operator_ref'];
    $response=array("success"=>true, "status"=>"$status", "opr_id"=>"$opr_id");
    echo json_encode($response);
    return;
  }


}
else{
  $response = array("success" => false, "message" => "Invalid Parameters!");
  echo json_encode($response);
  return;
return;
} ?>
