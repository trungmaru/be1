<?php
session_start();

/* Connection Declaration - Start */
require_once './config/database.php';
spl_autoload_register(function ($className) {
  require_once "./app/models/$className.php";
});
/* Connection Declaration - End */

/* Initialize Value From Query - Start */
$model = new Model();
$userModel = new UserModel();
$categoryModel = new CategoryModel();
$petModel = new PetModel();
$orderModel = new OrderModel();
/* Initialize Value From Query - End */

//get title from file name
$fileName = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
if ($fileName == 'Project-BE1' || $fileName == 'index.php') {
  $title = 'Trang chủ';
} elseif ($fileName == 'pets.php') {
  $title = 'Mua thú cưng';
} elseif ($fileName == 'pet_take_care.php') {
  $title = 'Chăm sóc thú cưng';
} elseif ($fileName == 'pet_beauty.php') {
  $title = 'Làm đẹp thú cưng';
} elseif ($fileName == 'pet_treatment.php') {
  $title = 'Chữa bệnh thú cưng';
} elseif ($fileName == 'pet_magazine.php') {
  $title = 'Tạp chí thú cưng';
} elseif ($fileName == 'login.php') {
  $title = 'Đăng nhập';
} elseif ($fileName == 'register.php') {
  $title = 'Đăng ký';
} elseif ($fileName == 'shop_info.php') {
  $title = 'Thông tin cửa hàng';
} elseif ($fileName == 'shop_info.php') {
  $title = 'Thông tin cửa hàng';
} elseif ($fileName == 'cart.php') {
  $title = 'Giỏ hàng';
} elseif ($fileName == 'order_detail.php') {
  $title = 'Chi thiết đơn hàng';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $title; ?> - P3 Pet Shop</title>

  <!-- Fav Icon Link - Start -->
  <link rel="shortcut icon" href="./public/img/logo/P3.png" type="image/x-icon">
  <!-- Fav Icon Link - End -->

  <!-- Google Font Link - Start -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,500;0,600;0,700;0,800;0,900;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <!-- Google Font Link - End -->

  <link rel="stylesheet" href="./public/vendor/bootstrap/css/bootstrap.min.css">

  <!-- Font Awesome Link - Start -->
  <link rel="stylesheet" href="./public/fonts/font-awesome/css/all.min.css">
  <!-- Font Awesome Link - End -->


  
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- Style Link - Start -->
  <link rel="stylesheet" href="./public/css/style.css">
  <!-- Style Link - End -->
</head>

<body>
  <!-- Header Section - Start -->
  <header class="header">
    <a class="logo" href="."><img class="logo-img" src="./public/img/logo/P3.png" alt="P3 Logo"><span class="logo-text">P3<p class="logo-mini-text">Pet Shop</p></span></a>
    <nav class="nav-bar">
      <ul class="nav-list">
        <li class="nav-item"><a class="nav-link" href=".">Trang chủ</a></li>
        <li class="nav-item">
          <a class="nav-link" href="./pets.php">Mua thú cưng <i class="fa-solid fa-chevron-down"></i></a>
          <ul class="subnav-list">
            <?php
            //get categories list
            $categoriesList = $categoryModel->getAllRootCategories();
            foreach ($categoriesList as $category) {
            ?>
              <li class="subnav-item">
                <a class="subnav-link" href="category_pet.php?name=<?php echo $model->hrefFormat($category['category_name']); ?>&id=<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></a>
                <ul class="subsubnav-list">
                  <?php
                  //get parent ID of cateogry from current parent category
                  $subCategoryParentID = $category['id'];

                  //get sub categories list from current category
                  $subCategoriesList = $categoryModel->getAllCategoriesByParentID($subCategoryParentID);

                  foreach ($subCategoriesList as $subCategory) {
                  ?>
                    <li class="subsubnav-item"><a class="subsubnav-link" href="category_pet_type.php?name=<?php echo $model->hrefFormat($subCategory['category_name']) . "&id=" . $subCategory['id'] ?>"><?php echo $subCategory['category_name'] ?></a></li>
                  <?php
                  }
                  ?>
                </ul>
              </li>
            <?php
            }
            ?>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="./pet_services.php">Dịch vụ thú cưng <i class="fa-solid fa-chevron-down"></i></a>
          <ul class="subnav-list">
            <li class="subnav-item"><a class="subnav-link" href="./pet_take_care.php">Chăm sóc thú cưng</a></li>
            <li class="subnav-item"><a class="subnav-link" href="./pet_beauty.php">Làm đẹp thú cưng</a></li>
            <li class="subnav-item"><a class="subnav-link" href="./pet_treatment.php">Chữa bệnh thú cưng</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="./pet_magazine.php">Tạp chí thú cưng</a></li>
        <li class="nav-item"><a class="nav-link" href="./shop_info.php">Thông tin cửa hàng</a></li>
      </ul>
    </nav>
    <div class="icon-bar">
      <ul class="icon-list">
        <li class="icon-item"><a class="icon-link" href="./account.php"><i class="fa-solid fa-user"></i></a>
          <ul class="account-functions-list">
            <?php
            if (isset($_SESSION['username'])) {
            ?>
              <li class="account-functions-item"><a class="account-functions-link" href="./account.php"><i class="fa-solid fa-user-pen"></i> <?php echo $_SESSION['username'] ?></a></li>
              <li class="account-functions-item"><a class="account-functions-link" href="./logout.php"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a></li>
            <?php
            } else {
            ?>
              <li class="account-functions-item"><a class="account-functions-link" href="./login.php"><i class="fa-solid fa-right-to-bracket"></i> Đăng nhập</a></li>
              <li class="account-functions-item"><a class="account-functions-link" href="./register.php"><i class="fa-solid fa-user-plus"></i> Đăng ký</a></li>
            <?php
            }
            ?>
          </ul>
        </li>
        <li class="icon-item"><a class="icon-link" href="./cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
        <li class="icon-item"><a class="icon-link menu-btn" href="#"><i class="fa-solid fa-bars"></i></a></li>
      </ul>
    </div>
  </header>
  <!-- Header Section - End -->