<?php
session_start();

//move to index.php if account is not admin 
if ($_SESSION['role'] < 1) {
  header('location:.');
}

/* Connection Declarationn - Start */
require_once './config/database.php';
spl_autoload_register(function ($className) {
  require_once "./app/models/$className.php";
});
/* Connection Declarationn - End */

/* Initialize Value From Query - Start */
$userModel = new UserModel();
/* Initialize Value From Query - End */

$_SESSION['addAccountAlert'] = '';

//get all values from form
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['role'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $role = $_POST['role'];

  //check register success or failure
  if ($userModel->addUserHasRole($username, $password, $phone, $address, $role)) {
    $_SESSION['addAccountAlert'] = '<div class="form-alert-success">Thêm thành công ! <span class="close-btn" onclick="this.parentElement.style.display=' . "'none'" . ';">&times;</span></div>';
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
  <a class="button-black" href="admin_manage_account.php"><i class="fa-solid fa-circle-chevron-left"></i> Trở về</a>

  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <form action="admin_add_account.php" method="POST" class="login100-form validate-form">
          <a class="logo" href="."><img class="logo-img" src="./public/img/logo/P3.png" alt="P3 Logo"></a>

          <span class="login100-form-title p-b-26">Thêm tài khoản</span>

          <div class="wrap-input100 validate-input" data-validate="Chưa nhập Username">
            <input class="input100" type="text" id="username" name="username">
            <span class="focus-input100" data-placeholder="Username"></span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Chưa nhập Password">
            <span class="btn-show-pass">
              <i class="zmdi zmdi-eye"></i>
            </span>
            <input class="input100" type="password" id="password" name="password">
            <span class="focus-input100" data-placeholder="Password"></span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Chưa nhập số điện thoại">
            <input class="input100" type="text" id="phone" name="phone">
            <span class="focus-input100" data-placeholder="Số điện thoại"></span>
          </div>

          <div class="wrap-input100" data-validate="Chưa nhập địa chỉ">
            <input class="input100" type="text" id="address" name="address">
            <span class="focus-input100" data-placeholder="Địa chỉ"></span>
          </div>

          <?php
          if ($_SESSION['role'] == 2) {
          ?>
            <div class="wrap-input100">
              <label for="role" class="role-title">Vai trò</label>
              <select id="role" name="role" class="form-select">
                <optgroup class="form-role">
                    <option value="1">Admin</option>
                    <option value="0" selected>User</option>
                </optgroup>
              </select>
            </div>
          <?php
          }
          ?>

          <?php
          if (isset($_SESSION['addAccountAlert'])) {
            echo $_SESSION['addAccountAlert'];
          }
          ?>

          <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
              <div class="login100-form-bgbtn"></div>
              <button type="submit" class="login100-form-btn"><i class="fa-solid fa-plus"></i> Thêm</button>
            </div>
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