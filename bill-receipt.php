<?php
error_reporting (E_ALL ^ E_NOTICE);
include 'phpqrcode/qrlib.php';
require("./includes/db_connect.php");
$tid=$_GET['tid'];
if($tid==""){
  echo "Transaction Id can't be empty";
}
else{
  $sql = "SELECT * FROM bill_details WHERE Tid='$tid'";
  $result = mysqli_query($conn, $sql);
  $row_count = mysqli_num_rows($result);
  if (!$result) {
      echo "Something went wrong!";
  }
  else if($row_count != 0){
    $data=mysqli_fetch_all($result,MYSQLI_ASSOC);

    ?>


<!DOCTYPE html>
<html>
  <head>
    <title>Hello World!</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css" />
    <style type="text/css" media="all">
    body{
      font-family:'Roboto', sans-serif;
    }
    .outer-box{

      height: 700px;
      width: 400px;
      }
      .img-container{
        display: flex;
        flex-direction: row;
        justify-content: center;

      }
      .title-container{
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
        margin: 8px;
      }

      .title{
        font-size:18px;
        color: #4A4A51;
        font-weight: 400;


      }


        .bill-detail{
          display: flex;
        flex-direction: column;
        margin-right:10px;
        justify-content: space-between;
        margin: 0px 10px 0px 10px;
        }

        .value{
          word-wrap: break-word;
          color: BLACK;
          font-weight: 500;
        }
        .below-bill-detail{
          display: flex;
          flex-direction: column;
          text-align: center;
        }
        .row-1{
          display: flex;
          flex-direction: row;
          justify-content: space-between;


        }
        .bill-data{
          display: flex;
          flex-direction: column;
          text-align: left;
          width:33.33%;


        }
        h1{
          margin: 10px 0px 0px 0px;
        }
        #bill-amount {
    font-size: 30px;
    font-weight: 500;}



    </style>
  </head>
  <body>
      <div class="outer-box">
        <div class="title-container">
          <?php foreach ($data as $detail) {
            if($detail['amount']<1000){
              $charge=10;
              $total=$detail['amount']+$charge;
            }
            else{
              $charge=(int)((1*$detail['amount'])/100);
              $total=(int)($detail{'amount'}+$charge);
            }
          ?>
         <span style="text-align:center; color:#0dbf3d">Bill Payment of <?php echo $detail['operatorName']; ?> has been successfully processed.</span>

        </div>
        <div class="img-container">
          <img src="check.png" alt="" width="50px" height="50px" />
       </div>
       <div class="title-container">
         <h1 id="bill-amount">&#8377;<?php echo $detail['amount']; ?>.00</h1>
         <br/>
         <span id="charge">Convenience Charges: &#8377;<?php echo $charge; ?>.00 </span>
         <span id="charge">Total Amount: &#8377;<?php echo $total; ?>.00 </span>


       </div><br />

       <div class="bill-detail">

      <div class="row-1">
        <div class="bill-data">
          <span class="title">Name</span>
          <span class="value"><?php echo $detail['customerName']; ?></span>

        </div>
         <div class="bill-data">
          <span class="title">Account No.</span>
          <span class="value"><?php echo $detail['Account']; ?></span>
       </div>
      </div><br />
      <div class="row-1">
        <div class="bill-data">
          <span class="title">Due Date</span>
          <span class="value"><?php echo $detail['dueDate']; ?></span>

        </div>

         <div class="bill-data">
          <span class="title">Bill Date</span>
          <span class="value"><?php echo $detail['billDate']; ?></span>
       </div>
      </div><br />
       <div class="row-1">
        <div class="bill-data">
          <span class="title">Payment Date</span>
          <span class="value"><?php echo $detail['paymentDate']; ?></span>

        </div>

         <div class="bill-data">
          <span class="title">Transaction ID</span>
          <span class="value"><?php echo $detail['Tid']; ?></span>
       </div>
      </div><br />
       <div class="row-1">
        <div class="bill-data">
          <span class="title">Shop Name</span>
          <span class="value"><?php echo $detail['shopName']; ?></span>

        </div>

         <div class="bill-data">
          <span class="title">Shop Mobile</span>
          <span class="value"><?php echo $detail['shopMobile']; ?></span>
       </div>
      </div>


      </div><br />

      <div class="below-bill-detail">
        <span style="font-size:10px; margin:0px 10px 0px 10px">The Payment will reflect at biller's end after 2-3 working days. This receipt does not guarantee that your bill has been successfully paid.</span>
        <div img-container>

          <?php
        $tid=$detail['Tid'];
        $text = "http://bijlee.tk/bijlee/bill-receipt.php?tid=$tid";
        $path = 'img/';
        $file = $path.uniqid().".png";

        // $ecc stores error correction capability('L')
        $ecc = 'L';
        $pixel_Size = 10;
        $frame_Size = 10;

        // Generates QR Code and Stores it in directory given
        QRcode::png($text, $file, $ecc, $pixel_Size);?>
        <center><img src='<?php  echo $file;?>' width="50px" height="50px"></center>

      </div>
      <span style="font-size:10px; margin:0px 10px 0px 10px">This receipt can be verified by visiting http://bijlee.tk/bijlee/receipt.html or by scanning QR code.</span>
      <br />
      <div img-container>
        <img src="bbps_logo.png" alt="BBPS LOGO" width="20px" height="30px" />


      </div>
      </div>


      </div>
  </body>
</html>
<?php
}}
else{
  echo "No record found.";
}
}
?>
