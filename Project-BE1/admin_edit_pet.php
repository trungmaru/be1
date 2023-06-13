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
$model = new Model();
$petModel = new PetModel();
$categoryModel = new CategoryModel();
/* Initialize Value From Query - End */

$_SESSION['addPetAlert'] = '';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
}

if (isset($_POST['pet-name']) && isset($_POST['pet-price']) && isset($_POST['pet-description']) && isset($_POST['category-id'])) {
  $petName = $_POST['pet-name'];
  $petPrice = $_POST['pet-price'];
  $petDescription = $_POST['pet-description'];
  $categoryID = $_POST['category-id'];
  $petPhoto = "";

  for ($i = 0; $i < count($_FILES['pet-photo']['tmp_name']); $i++) {
    $tempPath = 'public/img/pets_photo/' . $_FILES['pet-photo']['name'][$i];

    if (is_uploaded_file($_FILES['pet-photo']['tmp_name'][$i]) && move_uploaded_file($_FILES['pet-photo']['tmp_name'][$i], $tempPath)) {
      $petPhoto .= $_FILES['pet-photo']['name'][$i] . ',';
    }
  }

  $petPhoto = rtrim($petPhoto, ",");

  if ($petModel->updatePet($petName, $petPrice, $petPhoto, $petDescription, $categoryID, $id)) {
    $_SESSION['addPetAlert'] = '<div class="form-alert-success">Sửa thành công ! <span class="close-btn" onclick="this.parentElement.style.display=' . "'none'" . ';">&times;</span></div>';
  }
}

if (isset($id)) {
  $pet = $petModel->getPetById($id);
}
$categoryList = $categoryModel->getAllCategories();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sửa thú cưng - P3 Pet Shop</title>
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
  <a class="button-black" href="admin_manage_pet.php"><i class="fa-solid fa-circle-chevron-left"></i> Trở về</a>

  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <form action="admin_edit_pet.php?id=<?php echo $pet['id']; ?>" method="POST" enctype="multipart/form-data" class="login100-form validate-form">
          <a class="logo" href="."><img class="logo-img" src="./public/img/logo/P3.png" alt="P3 Logo"></a>

          <span class="login100-form-title p-b-26">Sửa thú cưng</span>

          <div class="wrap-input100" data-validate="Chưa nhập ảnh">
            <label for="parent-id" class="role-title">Ảnh</label>
            <input class="input100 form-control" type="file" id="pet-photo" name="pet-photo[]" multiple>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Chưa nhập tên thú cưng">
            <input class="input100" type="text" id="pet-name" name="pet-name" value="<?php if (isset($pet)) {
                                                                                        echo $pet['pet_name'];
                                                                                      } ?>">
            <span class="focus-input100" data-placeholder="Tên thú cưng"></span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Chưa nhập giá thú cưng">
            <input class="input100" type="text" id="pet-price" name="pet-price" value="<?php if (isset($pet)) {
                                                                                          echo $pet['pet_price'];
                                                                                        } ?>">
            <span class="focus-input100" data-placeholder="Giá thú cưng"></span>
          </div>

          <div class="wrap-input100" data-validate="Chưa nhập mô tả">
            <input class="input100" type="text" id="pet-description" name="pet-description" value="<?php if (isset($pet)) {
                                                                                                      echo $pet['pet_description'];
                                                                                                    } ?>">
            <span class="focus-input100" data-placeholder="Mô tả"></span>
          </div>

          <div class="wrap-input100 validate-input">
            <label for="category-id" class="role-title">Danh mục</label>
            <select id="category-id" name="category-id" class="form-select">
              <optgroup class="form-role">
                <?php
                foreach ($categoryList as $categoryItem) {
                  if ($categoryItem['id'] == $pet['category_id']) {
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
          if (isset($_SESSION['addPetAlert'])) {
            echo $_SESSION['addPetAlert'];
          }
          ?>

          <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
              <div class="login100-form-bgbtn"></div>
              <button type="submit" class="login100-form-btn"><i class="fa-solid fa-pen-to-square"></i> Sửa</button>
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