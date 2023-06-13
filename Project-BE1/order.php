<?php
session_start();

require_once './config/database.php';
spl_autoload_register(function ($className) {
  require_once "./app/models/$className.php";
});

//move to index.php if already logged in
if (!isset($_SESSION['username'])) {
  header('location:login.php');
}

if (!isset($_SESSION['cart'])) {
  header("location:cart.php?status=buy");
}

$petModel = new OrderModel;

if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['address'])) {
  $userID = $_SESSION['id'];
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];

  $petModel->addOrder($userID, $name, $phone, $address);

  $latestIDInOrder = $petModel->getLatestIDInOrders();

  $petList = $_SESSION['cart'];

  foreach ($petList as $pet) {
    $petModel->addOrderItem($latestIDInOrder, $pet['id'], $pet['color'], $pet['size'], $pet['quantity'], $pet['price']);
  }

  unset($_SESSION['cart']);

  header('location:thankyou.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Thông tin nhận hàng - P3 Pet Shop</title>
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
  <a class="button-black" href="cart.php"><i class="fa-solid fa-circle-chevron-left"></i> Trở về</a>

  <div class="icon"></div>
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <form action="order.php" method="POST" class="login100-form validate-form">
          <a class="logo" href="."><img class="logo-img" src="./public/img/logo/P3.png" alt="P3 Logo"></a>

          <span class="login100-form-title p-b-26">
            THÔNG TIN NHẬN HÀNG
          </span>

          <div class="wrap-input100 validate-input" data-validate="Chưa nhập số điện thoại">
            <input class="input100" type="text" id="name" name="name">
            <span class="focus-input100" data-placeholder="Tên"></span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Chưa nhập số điện thoại">
            <input class="input100" type="text" id="phone" name="phone">
            <span class="focus-input100" data-placeholder="Số điện thoại"></span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Chưa nhập địa chỉ">
            <input class="input100" type="text" id="address" name="address">
            <span class="focus-input100" data-placeholder="Địa chỉ"></span>
          </div>

          <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
              <div class="login100-form-bgbtn"></div>
              <button type="submit" class="login100-form-btn"><i class="fa-solid fa-credit-card"></i> Đặt hàng</button>
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
  <!--===============================================================================================-->
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <!--===============================================================================================-->
  <script src="./public/vendor/select2/select2.min.js"></script>
  <!--===============================================================================================-->
  <script src="./public/vendor/daterangepicker/moment.min.js"></script>
  <!--===============================================================================================-->
  <script src="./public/vendor/daterangepicker/daterangepicker.js"></script>
  <!--===============================================================================================-->
  <script src="./public/vendor/countdowntime/countdowntime.js"></script>
  <!--===============================================================================================-->
  <script src="./public/js/script-form.js"></script>

</body>

</html>