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
else if($_GET['all_unpaid']==1){
  $mobile=$_SESSION['mobile'];
  $sql="SELECT * FROM bill_details WHERE status='Unpaid' ORDER BY paymentDate DESC";
  $sql2="SELECT COUNT(Account) AS count FROM bill_details WHERE status='Unpaid' ORDER BY paymentDate DESC";
  $sql3="SELECT SUM(amount) AS sum FROM bill_details WHERE status='Unpaid' ORDER BY paymentDate DESC";
  $result=mysqli_query($conn,$sql);
  $result2=mysqli_query($conn,$sql2);
  $result3=mysqli_query($conn,$sql3);
  $data2=mysqli_fetch_assoc($result2);
  $data3=mysqli_fetch_assoc($result3);
  $sum=$data3['sum'];
  $count=$data2['count'];
  if(!$result || !$result2){
    echo "Something went wrong";
  }
  else{
    $data=mysqli_fetch_all($result,MYSQLI_ASSOC);
  }
}
else if($_GET['all_unpaid_999']==1){
  $mobile=$_SESSION['mobile'];
  $sql="SELECT * FROM bill_details WHERE status='Unpaid' AND amount<1000 ORDER BY paymentDate DESC";
  $sql2="SELECT COUNT(Account) AS count FROM bill_details WHERE status='Unpaid' AND amount<1000 ORDER BY paymentDate DESC";
  $sql3="SELECT SUM(amount) AS sum FROM bill_details WHERE status='Unpaid' AND amount<1000 ORDER BY paymentDate DESC";
  $result=mysqli_query($conn,$sql);
  $result2=mysqli_query($conn,$sql2);
  $result3=mysqli_query($conn,$sql3);
  $data2=mysqli_fetch_assoc($result2);
  $data3=mysqli_fetch_assoc($result3);
  $sum999=$data3['sum'];
  $count999=$data2['count'];
  $result=mysqli_query($conn,$sql);
  if(!$result){
    echo "Something went wrong";
  }
  else{
    $data=mysqli_fetch_all($result,MYSQLI_ASSOC);
  }
}
else if($_GET['all_unpaid_3999']==1){
  $mobile=$_SESSION['mobile'];
  $sql="SELECT * FROM bill_details WHERE status='Unpaid' AND amount>1000 AND amount<4000 ORDER BY paymentDate DESC";
  $sql2="SELECT COUNT(Account) AS count FROM bill_details WHERE status='Unpaid' AND amount>1000 AND amount<4000 ORDER BY paymentDate DESC";
  $sql3="SELECT SUM(amount) AS sum FROM bill_details WHERE status='Unpaid' AND amount>1000 AND amount<4000 ORDER BY paymentDate DESC";
  $result=mysqli_query($conn,$sql);
  $result2=mysqli_query($conn,$sql2);
  $result3=mysqli_query($conn,$sql3);
  $data2=mysqli_fetch_assoc($result2);
  $data3=mysqli_fetch_assoc($result3);
  $sum3999=$data3['sum'];
  $count3999=$data2['count'];
  $result=mysqli_query($conn,$sql);
  if(!$result){
    echo "Something went wrong";
  }
  else{
    $data=mysqli_fetch_all($result,MYSQLI_ASSOC);
  }
}
else if($_GET['all_unpaid_4000']==1){
  $mobile=$_SESSION['mobile'];
  $sql="SELECT * FROM bill_details WHERE status='Unpaid' AND amount>4000 ORDER BY paymentDate DESC";
  $sql2="SELECT COUNT(Account) AS count FROM bill_details WHERE status='Unpaid' AND amount>4000 ORDER BY paymentDate DESC";
  $sql3="SELECT SUM(amount) AS sum FROM bill_details WHERE status='Unpaid' AND amount>4000 ORDER BY paymentDate DESC";
  $result=mysqli_query($conn,$sql);
  $result2=mysqli_query($conn,$sql2);
  $result3=mysqli_query($conn,$sql3);
  $data2=mysqli_fetch_assoc($result2);
  $data3=mysqli_fetch_assoc($result3);
  $sum4000=$data3['sum'];
  $count4000=$data2['count'];
  $result=mysqli_query($conn,$sql);
  if(!$result){
    echo "Something went wrong";
  }
  else{
    $data=mysqli_fetch_all($result,MYSQLI_ASSOC);
  }
} else if($_GET['all_paid']==1){
  $mobile=$_SESSION['mobile'];
  $sql="SELECT * FROM bill_details WHERE status='Paid' ORDER BY paymentDate DESC";
  $result=mysqli_query($conn,$sql);
  if(!$result){
    echo "Something went wrong";
  }
  else{
    $data=mysqli_fetch_all($result,MYSQLI_ASSOC);
  }
}
else if($_GET['all']==1){
  $mobile=$_SESSION['mobile'];
  $sql="SELECT * FROM bill_details ORDER BY paymentDate DESC";
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
      <a href="?all=1">All</a>
      <a href="?all_paid=1">All Paid</a>
      <a href="?all_unpaid=1">All Unpaid <br><br><?php echo $sum;?> / <?php echo $count;?></a>
      <a href="?all_unpaid_999=1">0-999 <br><br><?php echo $sum999;?> / <?php echo $count999;?> </a>
      <a href="?all_unpaid_3999=1">1000-4000 <br><br><?php echo $sum3999;?> / <?php echo $count3999;?></a>
      <a href="?all_unpaid_4000=1">Above 4000 <br><br><?php echo $sum4000;?> / <?php echo $count4000;?></a>
      
    <a href="?logout=1">Logout</a>
    <br><br>

    <table  class="zigzag">
      <tbody>

        <thead>
          <th>Account No</th>
          <th>Operator</th>
          <th>Amount</th>
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
          $n=0;
          foreach ($data as $billdata) {
           ?>
           <tr style="text-align:center;" id="<?php echo $n++; ?>">
          <td><?php echo $billdata['Account'];?></td>
          <td><?php echo $billdata['operatorName']; ?></td>
          <td>&#8377;<?php echo $billdata['amount'];?></td>
          <td><?php echo $billdata['customerName']; ?></td>
          <td><?php echo $billdata['dueDate']; ?></td>
          <td><?php echo $billdata['billDate']; ?></td>
          <td><?php echo $billdata['paymentDate']; ?></td>
          <td><?php echo $billdata['Tid']; ?></td>
          <td>&#8377;<?php echo $billdata['balance']; ?></td>
          <td><a href="http://bijlee.tk/bijlee/bill-receipt.php?tid=<?php echo $billdata['Tid'];?>">Reciept</a></td>
          <td id="status"><?php if(strcmp($billdata['status'],"Unpaid")==0){ ?>
            <a id="chk<?php echo $n;?>" href="javascript:myFunction('<?php echo $billdata['Account'];?>','<?php echo $billdata['Tid'];?>','<?php echo $n?>','<?php echo $_SESSION['sid']; ?>');">Check</a><?php }
            else{ ?>
            <span id="chk_img<?php echo $n;?>"><img src="check.svg" alt="" width="50px" height="50px"></span> <?php } ?>
          <img src="load2.gif" id="loading<?php echo $n; ?>" style="display:none;" height="80px" width="90px" alt="">
<span style="display:none;" id="chk_img<?php echo $n;?>"><img src="check.svg" alt="" width="50px" height="50px"></span>

 </td>
        </tr>
      <?php } ?>
      </tbody>
    </table>

  </body>
</html>