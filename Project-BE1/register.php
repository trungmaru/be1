<?php
session_start();

/* Connection Declarationn - Start */
require_once './config/database.php';
spl_autoload_register(function ($className) {
  require_once "./app/models/$className.php";
});
/* Connection Declarationn - End */

/* Initialize Value From Query - Start */
$userModel = new UserModel();
/* Initialize Value From Query - End */

//declare session
$_SESSION['registerAlert'] = '';

//move to index.php if already logged in
if (isset($_SESSION['username'])) {
  header('location:login.php');
}

//get all values from form
if (isset($_POST['register-username']) && isset($_POST['register-password']) && isset($_POST['register-re-password']) && isset($_POST['register-phone']) && isset($_POST['register-address'])) {
  $registerUsername = $_POST['register-username'];
  $registerPassword = $_POST['register-password'];
  $registerRePassword = $_POST['register-re-password'];
  $registerPhone = $_POST['register-phone'];
  $registerAddress = $_POST['register-address'];

  //check register success or failure
  if ($userModel->checkRegister($registerUsername, $registerPassword, $registerRePassword, $registerPhone, $registerAddress)) {
    //add values to database
    if ($userModel->addUser($registerUsername, $registerPassword, $registerPhone, $registerAddress)) {
      $_SESSION['username'] = $registerUsername;
      $_SESSION['id'] = $userModel->getUserByUsername($registerUsername)[0]['id'];
      $_SESSION['role'] = $userModel->getUserByUsername($registerUsername)[0]['role'];
      header('location:.');
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Đăng ký - P3 Pet Shop</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--===============================================================================================-->
  <link rel="icon" type="image/png" href="./public/img/logo/P3.png">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="./public/vendor/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" href="./public/fonts/font-awesome/css/all.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="./public/fonts/iconic/css/material-design-iconic-font.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="./public/vendor/animate/animate.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="./public/vendor/css-hamburgers/hamburgers.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="./public/vendor/animsition/css/animsition.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="./public/vendor/select2/select2.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="./public/vendor/daterangepicker/daterangepicker.css">
  <!--===============================================================================================-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,500;0,600;0,700;0,800;0,900;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="./public/css/style-form.css">
  <link rel="stylesheet" type="text/css" href="./public/css/util.css">
  <!--===============================================================================================-->
</head>

<body>
  <a class="button-black" href="."><i class="fa-solid fa-circle-chevron-left"></i> Trở về</a>

  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <form action="register.php" method="POST" class="login100-form validate-form">
          <a class="logo" href="."><img class="logo-img" src="./public/img/logo/P3.png" alt="P3 Logo"></a>

          <span class="login100-form-title p-b-26">
            ĐĂNG KÝ
          </span>

          <div class="wrap-input100 validate-input" data-validate="Chưa nhập Username">
            <input class="input100" type="text" id="register-username" name="register-username" value="<?php if (isset($registerUsername) && $userModel->checkRegister($registerUsername, $registerPassword, $registerRePassword, $registerPhone, $registerAddress) !== true) {
                                                                                                          echo $registerUsername;
                                                                                                        } ?>">
            <span class="focus-input100" data-placeholder="Username"></span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Chưa nhập số điện thoại">
            <input class="input100" type="text" id="register-phone" name="register-phone" value="<?php if (isset($registerPhone) && $userModel->checkRegister($registerUsername, $registerPassword, $registerRePassword, $registerPhone, $registerAddress) !== true) {
                                                                                                    echo $registerPhone;
                                                                                                  } ?>">
            <span class="focus-input100" data-placeholder="Số điện thoại"></span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Chưa nhập Password">
            <span class="btn-show-pass">
              <i class="zmdi zmdi-eye"></i>
            </span>
            <input class="input100" type="password" id="register-password" name="register-password" value="<?php if (isset($registerPassword) && $userModel->checkRegister($registerUsername, $registerPassword, $registerRePassword, $registerPhone, $registerAddress) !== true) {
                                                                                                              echo $registerPassword;
                                                                                                            } ?>">
            <span class="focus-input100" data-placeholder="Password"></span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Chưa nhập Password">
            <span class="btn-show-pass">
              <i class="zmdi zmdi-eye"></i>
            </span>
            <input class="input100" type="password" id="register-re-password" name="register-re-password" value="<?php if (isset($registerRePassword) && $userModel->checkRegister($registerUsername, $registerPassword, $registerRePassword, $registerPhone, $registerAddress) !== true) {
                                                                                                                    echo $registerRePassword;
                                                                                                                  } ?>">
            <span class="focus-input100" data-placeholder="Lặp lại Password"></span>
          </div>

          <div class="wrap-input100" data-validate="Chưa nhập địa chỉ">
            <input class="input100" type="text" id="register-address" name="register-address" value="<?php if (isset($registerAddress) && $userModel->checkRegister($registerUsername, $registerPassword, $registerRePassword, $registerPhone, $registerAddress) !== true) {
                                                                                                        echo $registerAddress;
                                                                                                      } ?>">
            <span class="focus-input100" data-placeholder="Địa chỉ"></span>
          </div>

          <?php
          if (isset($_SESSION['registerAlert'])) {
            echo $_SESSION['registerAlert'];
          }
          ?>

          <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
              <div class="login100-form-bgbtn"></div>
              <button type="submit" class="login100-form-btn"><i class="fa-solid fa-clipboard-check"></i> Đăng ký</button>
            </div>
          </div>

          <div class="text-center p-t-30">
            <span class="txt1">
              Bạn đã có tài khoản ?
            </span>

            <a class="txt2" href="login.php">
              Đăng nhập
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!--===============================================================================================-->
  <script src="./public/vendor/jquery/jquery-3.2.1.min.js"></script>
  <!--===============================================================================================-->
  <script src="./public/vendor/animsition/js/animsition.min.js"></script>
  <!--===============================================================================================-->
  <script src="./public/vendor/bootstrap/js/popper.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <!--===============================================================================================-->
  <script src="./public/vendor/select2/select2.min.js"></script>
  <!--===============================================================================================-->
  <script src="./public/vendor/daterangepicker/moment.min.js"></script>
  <script src="./public/vendor/daterangepicker/daterangepicker.js"></script>
  <!--===============================================================================================-->
  <script src="./public/vendor/countdowntime/countdowntime.js"></script>
  <!--===============================================================================================-->
  <script src="./public/js/script-form.js"></script>

</body>

</html>