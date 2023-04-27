<?php
session_start();
if(isset($_SESSION['sid'])){
  header("Location:bill.php");
} ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | Bijlee</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <style type="text/css" media="all">
    .m-outer-box{
      display:flex;
      flex-direction:row;
      justify-content: center;
    }

    .m-inner-box{

    width: 300px;
    display: flex;
    flex-direction: column;
    justify-content:center;

    }
    .m-img-container{
      display: flex;
      flex-direction: row;
      justify-content: center;
    }
    .btn{

      align-self: center;
      margin: 10px;
      background-color: #4CAF50;
      color: white;
      width: 100px;
    }
    .text{
      text-align: center;
      margin: 10px;
      font-size: 20px;
    }
    </style>
  </head>
  <body id="body" onload="myFunction()">

    <script type="text/javascript" src="js/login.js">

    </script>

    <div class="outer-box">
      <div class="inner-box">
        <img id="logo" src="img/icon_flash.png" alt="" height="120px" width="100px">
        <div class="form-login">
          <form class="login" id="login-form" action="./api/login.php" method="post">
            <label class="plabel" for="Mobile"><b>Mobile</b></label><br>
            <input type="text" name="mobile" id="mobile" value="" maxlength="10" required><br>
            <label class="plabel" for="password"><b>Password</b></label><br>
            <input type="password" name="password" id="password"  value="" maxlength="20" required><br>
            <button type="submit" name="submit" id="btn-submit" value="Login" class="button">Login</button>
            <img src="img/loading.gif" alt="" width="80px" height="80px" id="loading">

          </form>

        </div>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLongTitle"></h3>


              </div>
              <div class="modal-body">
               <div class="m-outer-box">
                <div class="m-inner-box">

                  <div class="m-img-container">
                     <img src="img/wrong.gif" width="100px" height="100px"</img>

                  </div>
                  <span class="text" id="alertText">Wrong Username or Password!</span>
                  <button type="button" class="btn" data-dismiss="modal">Close</button>


                </div>

              </div>
              </div>
              <div class="modal-footer">

              </div>
            </div>
          </div>
        </div>


      </div>

    </div>


  </body>
</html>
