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
$categoryModel = new CategoryModel();
/* Initialize Value From Query - End */

$_SESSION['editCategoryAlert'] = '';

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  if (isset($_POST['category-name']) && isset($_POST['parent-id'])) {
    $categoryName = $_POST['category-name'];
    $parentID = $_POST['parent-id'];
    if ($categoryModel->editCategory($categoryName, $parentID, $id)) {
      $_SESSION['editCategoryAlert'] = '<div class="form-alert-success">Sửa thành công ! <span class="close-btn" onclick="this.parentElement.style.display=' . "'none'" . ';">&times;</span></div>';
    }
  }

  $category = $categoryModel->getCategoryByID($id);
}

$categoryList = $categoryModel->getAllCategories();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sửa thông tin - P3 Pet Shop</title>
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
  <a class="button-black" href="admin_manage_category.php"><i class="fa-solid fa-circle-chevron-left"></i> Trở về</a>

  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <form action="admin_edit_category.php?id=<?php echo $category['id']; ?>" method="POST" class="login100-form validate-form">
          <a class="logo" href="."><img class="logo-img" src="./public/img/logo/P3.png" alt="P3 Logo"></a>

          <span class="login100-form-title p-b-26">Sửa thông tin</span>

          <div class="wrap-input100 validate-input" data-validate="Chưa nhập tên danh mục">
            <input class="input100" type="text" id="category-name" name="category-name" value="<?php echo $category['category_name']; ?>">
            <span class="focus-input100" data-placeholder="Tên danh mục"></span>
          </div>

          <div class="wrap-input100">
            <label for="parent-id" class="role-title">Danh mục cha</label>
            <select id="parent-id" name="parent-id" class="form-select">
              <optgroup class="form-role">
                <?php
                if ($category['parent_id'] === NULL) {
                ?>
                  <option value="0" selected>Gốc</option>
                  <?php
                } else {
                  ?>
                  <option value="0">Gốc</option>
                  <?php
                }
                foreach ($categoryList as $categoryItem) {
                  if ($categoryItem['id'] == $category['parent_id']) {
                  ?>
                    <option value="<?php echo $categoryItem['id']; ?>" selected><?php echo $categoryItem['category_name']; ?></option>
                  <?php
                  } else {
                  ?>
                    <option value="<?php echo $categoryItem['id']; ?>"><?php echo $categoryItem['category_name']; ?></option>
                <?php
                  }
                }
                ?>
              </optgroup>
            </select>
          </div>

          <?php
          if (isset($_SESSION['editAccountAlert'])) {
            echo $_SESSION['editAccountAlert'];
          }
          ?>

          <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
              <div class="login100-form-bgbtn"></div>
              <button type="submit" class="login100-form-btn"><i class="fa-solid fa-user-pen"></i> Sửa</button>
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