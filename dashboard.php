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
else{
  $mobile=$_SESSION['mobile'];
  $sql="SELECT * FROM bill_details WHERE shopMobile='$mobile' ORDER BY paymentDate DESC LIMIT 10 ";
  $result=mysqli_query($conn,$sql);
  if(!$result){
    echo "Something went wrong";
  }
  else{
    $data=mysqli_fetch_all($result,MYSQLI_ASSOC);
  }
}?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
    th{
      background-color: #0dbf3d;
      color: #ffffff;
      font-size: 18px;
      padding: 10px;
    }
    td{
      background-color: #ccedcf;
      padding: 10px;
      font-size: 16px;
    }
    a:link, a:visited {
  background-color: #0dbf3d;
  color: white;
  padding: 14px 25px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}

a:hover, a:active {
  background-color: #33ab1b;
}

    </style>
  </head>
  <body>
    <script type="text/javascript" src="js/status_check.js">

    </script>
    <?php if($mobile=='8979319339'){ ?>
      <a href="filter.php" target="_blank">Filter</a>
    <?php } ?>
    <a href="?logout=1">Logout</a>
    <br><br>

    <table  class="zigzag">
      <tbody>

        <thead>
          <th>Account No</th>
          <th>Operator</th>
          <th>Amount</th>
          <th>Customer Mobile</th>
          <th>Customer Name</th>
          <th>Due Date</th>
          <th>Bill Date</th>
          <th>Payment Date</th>
          <th>Transaction Id</th>
          <th>Balance</th>
          <th>Receipt</th>
          <th>Status</th>
        </thead>

          <?php
          foreach ($data as $billdata) {
           ?>
           <tr style="text-align:center;">
             <?php $acc=$billdata['Account'];
             ?>
          <td id="account"><?php echo $billdata['Account'];?> </td>
          <td><?php echo $billdata['operatorName']; ?></td>
          <td>&#8377;<?php echo $billdata['amount'];?></td>
          <td><?php echo $billdata['customerMobile']; ?></td>
          <td><?php echo $billdata['customerName']; ?></td>
          <td><?php echo $billdata['dueDate']; ?></td>
          <td><?php echo $billdata['billDate']; ?></td>
          <td><?php echo $billdata['paymentDate']; ?></td>
          <td><?php echo $billdata['Tid']; ?></td>
          <td>&#8377;<?php echo $billdata['balance']; ?></td>
          <td><a href="http://bijlee.tk/bijlee/bill-receipt.php?tid=<?php echo $billdata['Tid'];?>">Reciept</a></td>
          <td><?php if(strcmp($billdata['status'],"Unpaid")==0){ ?>
            <a href="javascript:myFunction('<?php echo $acc;?>');">Check</a><?php }
            else{ ?>
            <span> <img src="check.svg" alt="" width="50px" height="50px"> </span> <?php } ?>
          <img src="img/loading.gif" id="loading" style="display:none;" height="30px" width="30px" alt=""> </td>
        </tr>
      <?php } ?>
      </tbody>
    </table>

  </body>
</html>
