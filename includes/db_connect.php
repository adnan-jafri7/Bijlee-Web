<?php
$db_url="localhost";
$db_username="root";
$db_password="";
$db_name="test";
$conn=mysqli_connect($db_url,$db_username,$db_password,$db_name);
if(!$conn){
  echo "Database connection error". mysqli_connect_error();
} ?>
