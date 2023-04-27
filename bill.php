<?php
error_reporting(E_ERROR | E_PARSE);
require 'includes/db_connect.php';
session_start();
if(!isset($_SESSION['sid'])){
  header("Location:index.php");
}
else if($_GET['logout']==1){

  session_destroy();
   header("Location:index.php");
 }
$sid=$_SESSION['sid'];
$username=$_SESSION['mobile'];
$password=$_SESSION['password'];

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Dashboard | User</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300&display=swap" rel="stylesheet">
    <style type="text/css" media="all">

.header-container{
      width: 100%;
      height:120px;
      display: flex;
      flex-direction: row;
      justify-content: center;
    }
    .header-element{
      width:100px;
      border-radius: 20px;
      height:100px;
      box-shadow: 0px 3px 1px -2px rgb(0 0 0 / 20%), 0px 2px 2px 0px rgb(0 0 0 / 14%), 0px 1px 5px 0px rgb(0 0 0 / 12%);
      margin-left: 5px;
      display: flex;
      flex-direction: column;
      margin: 10px;
      padding: 10px;
      justify-content: center;




    }
    .header-element:hover .header-items{
      color: white;
    }
    .header-element:hover{
      background-color: #0dbf3d

    }
    .header-items{

      width:100px;
      height: 100%;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-self: center;
      color: #0dbf3d

    }

    a{
      text-decoration: none;
    }
    .outer-box{
      width:500px;
      height:auto;
      margin: auto;
      border: none;
      padding-top: 50px;
      padding-bottom: 50px;

      box-shadow: 0px 3px 1px -2px rgb(0 0 0 / 20%), 0px 2px 2px 0px rgb(0 0 0 / 14%), 0px 1px 5px 0px rgb(0 0 0 / 12%);
      border-radius: 20px;
      background-color:#4CAF50;
    }
    .form-container{
      display: flex;
      background-color:#ffffff;
      border-radius:10px;
      margin:10px;
      box-shadow: 0px 3px 1px -2px rgb(0 0 0 / 20%), 0px 2px 2px 0px rgb(0 0 0 / 14%), 0px 1px 5px 0px rgb(0 0 0 / 12%);

    }
    .bill-form{
      width:300px;
      margin: auto;
      margin-top:10px;
      padding: 20px;


    }
    .bill-fetched-data{
     
      word-wrap: break-word;
      margin-top:20px;
      display: none;
      flex-direction: row;
      justify-content: center;
      background-color:#ffffff;
      margin:10px;
      border-radius:10px;


    }


    /* Modal Content */

    .selector{
      box-shadow: 0px 3px 1px -2px rgb(0 0 0 / 20%), 0px 2px 2px 0px rgb(0 0 0 / 14%), 0px 1px 5px 0px rgb(0 0 0 / 12%);
      width: 300px;
      height: 50px;
      font-size:18px;
      border-radius: 10px;

      border: none;
      outline: none;



    }
    .labels{
      font-size:18px;
      margin-top: 200px;
    }
    .bill-fetched-table{
      margin: 20px;
      text-indent: initial;
      table-layout: fixed;
      width: 100%;
    }

    input{
      box-shadow: 0px 3px 1px -2px rgb(0 0 0 / 20%), 0px 2px 2px 0px rgb(0 0 0 / 14%), 0px 1px 5px 0px rgb(0 0 0 / 12%);
      width: 300px;
      height: 50px;
      font-size:18px;
      border: none;
      outline:none;
      text-decoration: none;
      text-align: center;
      border-radius: 10px;
      margin: 5px 0px 20px 0px;

    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
}
    .button{

      background-color: #0dbf3d;
      border-radius: 10px;
      color: WHITE;
      width:300px;
      height:50px;
      font-size: 18px;
      border: none;
      box-shadow: 0px 3px 1px -2px rgb(0 0 0 / 20%), 0px 2px 2px 0px rgb(0 0 0 / 14%), 0px 1px 5px 0px rgb(0 0 0 / 12%);

    }
    .button:hover{
      background-color:GREEN ;
    }
    #modal-close{
      align-self:center;
      width:70px;
      display:'flex';
    }
    #btn-cancel{
      background-color: #666666;
      color: #ffffff;
    }
    .value{
      font-weight: bold;
      font-size: 18px;

    }
    .title{
      font-size: 18px;
    }
    .cancel{
    background-color: #0dbf3d;
    }
    #loading{
      display:flex;
      position: relative;
      left: 34%;      
    }
    .header{
      display:flex;
      flex-direction:column;
      justify-content:center;
      margin:10px;
      width:'90%';
      border-radius:10px;
      align-items:center;
      height:170px;
      background-color:#ffffff;
      box-shadow: 0px 3px 1px -2px rgb(0 0 0 / 20%), 0px 2px 2px 0px rgb(0 0 0 / 14%), 0px 1px 5px 0px rgb(0 0 0 / 12%);


    }
    #shop_name{
        font-size:20px;    
    }
    #balance{
      font-size:30px;
      margin-top:10px;
      font-weight:bold;
    }
    .header-bottom{
      display:flex;
      flex-direction:row;
      justify-content:space-between;
      margin-top:30px;
      width:400px
    }
    .header-item{
      display:flex;
      flex-direction:column;
      justify-content:space-between;
      align-items:center;
      
    }
    body {font-family: Arial, Helvetica, sans-serif; margin:0px;}

/* The Modal (background) */
.modal {
  display: flex; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */}

/* Modal Content */
.modal-content {
  display: flex;
  background-color: #fefefe;
  margin: auto;
  padding: 0px;
  width: 40%;
  border-radius:20px;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  align-content: center;
}

    

    </style>

  </head>
  <body onload="fetch()">
    <script type="text/javascript" src="js/fetch.js">

    </script>
    <div id="myModal" class="modal">

<!-- Modal content -->
<div class="modal-content">
  <div style="display:flex; flex-direction:column; justify-content:center; height:250px"> 
      <img style="display:flex; align-self:center;" src="img/loading.gif" alt="" width="80px" height="80px" id="loading-pay">
  <p id="title-process" style="text-align:center" >Your transaction is processing, please wait...</p>
  <p id="note-process" style="text-align:center">Do not refresh or close the page!</p>
  <button type="submit" class="button" name="modal-close" id="modal-close">Done</button>
  
  </div>
</div>



</div>
    
      <div class="outer-box">
        
        <div class="header">
        <span id="shop_name">Hi, <?php echo $_SESSION['name'];?></span>
          <span id="balance" >&#x20B9;&nbsp;<?php echo $_SESSION['balance'];?>.00</span>
          <div class="header-bottom">
              <div class="header-item">
                <a href="/bijlee/dashboard.php" target=_blank>
              <img src="img/wallet.png" alt="" width="30px" height="30px">
              </a>
              <span>Reports</span>
              
              </div>
              <div class="header-item">
              <img src="img/password.png" alt="" width="30px" height="30px">
              <span>Change Password</span>
              </div>
              <div class="header-item">
              <a href="?logout=1">
              <img src="img/logout.png" alt="" width="30px" height="30px">
              </a>
              <span>Logout</span>
              
              </div>
              
          </div>
        </div>
        
        <div class="form-container" id="form-container">
          <form action="" id="fetch-form" method="POST" class="bill-form">
            <select id="op_selector" name="op_selector" class="selector" required>
              <option value="0">Select Operator</option>
                <option value="88">UPPCL Urban</option>
                <option value="114">UPPCL Rural</option>
          </select><br/> <br/>

          <label for="account" class="labels">Account No.</label>
          <input type="number" name="account" id="account" maxlength="12" required/>
          <label for="mobile" class="labels">Mobile No.</label>
          <input type="phone" name="mobile" id="mobile" maxlength="10" />
          <button type="submit" class="button" name="fetch" id="btn-fetch">Fetch</button>
          <img src="img/loading.gif" alt="" width="80px" height="80px" id="loading" style="display:none;">
          <input type="hidden" name="sid" value="<?php echo $sid; ?>" id="sid"/>

          </form>



          </div>
          <div class="bill-fetched-data" id="bill-fetched-data">
            <table class="bill-fetched-table">
              <tr>
                <td class="title">Customer Name:</td>
                <td class="value" id="customerName">Customer Name</td>
              </tr>
              <tr>
                  <td>&nbsp;</td>
              </tr>

              <tr>
                <td class="title">Bill Date:</td>
                <td class="value" id="billDate">2022-01-01</td>
              </tr>
              <tr>
                  <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="title">Due Date</td>
                <td class="value" id="dueDate">2022-01-01</td>
              </tr>
              <tr>
                  <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="title">Amount</td>
                <td class="value">&#x20B9;&nbsp;<input type="text" style="width:100px" id="amount"></td>
                
              </tr>
              <tr>
                  <td align="center" colspan="2" id="note" style="color:RED;">Minimum Amount : </td>
              </tr>
              <tr align="center">
                <td colspan="2" class="title"><input type="submit" class="button" name="pay-bill" id="btn-pay-bill" value="Pay Now"  /></td>

              </tr>
              <tr align="center">
                <td colspan="2" class="title"><input type="submit" class="button" name="cancel" id="btn-cancel" value="Cancel" /></td>

              </tr>

            </table>


        </div>





      </div>
      

  </body>
</html>
