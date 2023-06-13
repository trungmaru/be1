<?php
session_start();

/* Connection Declaration - Start */
require_once 'config/database.php';
spl_autoload_register(function ($className) {
  require_once "app/models/$className.php";
});
/* Connection Declaration - End */

/* Initialize Value From Query - Start */
$model = new Model();
$userModel = new UserModel();
$categoryModel = new CategoryModel();
$petModel = new PetModel();
/* Initialize Value From Query - End */

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $petModel = new petModel();
  $pet = $petModel->getPetById($id);

  //cộng vào product-view
  $petModel->updatePetView($id);

  if (!isset($_COOKIE['viewedPets'])) {
    $viewedProductID = [$id]; //tạo mảng ban đầu        
    setcookie('viewedPets', json_encode($viewedProductID), time() + 3600 * 24); //setcookie với mảng được biến đỗi thành chuỗi
  } else {
    $arrViewedPetID = json_decode($_COOKIE['viewedPets'], true); //lấy mảng ra từ cookie

    if (!in_array($id, $arrViewedPetID)) { //kiểm tra nếu phần tử chưa có trong mảng       
      if (count($arrViewedPetID) == 4) { //kiểm tra nếu mảng đã có đủ 5 phần tử                
        array_pop($arrViewedPetID); //xóa phần tử cuối
      }

      array_unshift($arrViewedPetID, $id); //thêm phần tử mới vào đầu mảng
    } else { //kiểm tra nếu phần tử đã có trong mảng
      unset($arrViewedPetID[$id]); //xóa phần tử khỏi mảng

      array_unshift($arrViewedPetID, $id); //thêm lại phần tử đó vào đầu mảng
    }

    setcookie('viewedPets', json_encode($arrViewedPetID), time() + 3600 * 24); //tạo lại cookie
  }

  if (isset($_POST['likedID'])) {
    $likedID = $_POST['likedID'];

    //product like user
    if (isset($_SESSION['id'])) {
      $userID = $_SESSION['id'];

      if ($petModel->checkUserLike($likedID, $userID)) {
        //unlike
        $petModel->updatePetUnLikeUser($likedID, $userID);
      } else {
        //like
        $petModel->updatePetLikeUser($likedID, $userID);
      }
    }
  }
}

$petList = $petModel->getPetByRelatedName($pet['pet_name']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $pet['pet_name']; ?> - P3 Pet Shop</title>

  <!-- Fav Icon Link - Start -->
  <link rel="shortcut icon" href="public/img/logo/P3.png" type="image/x-icon">
  <!-- Fav Icon Link - End -->

  <!-- Google Font Link - Start -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,500;0,600;0,700;0,800;0,900;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <!-- Google Font Link - End -->

  <link rel="stylesheet" href="public/vendor/bootstrap/css/bootstrap.min.css">

  <!-- Font Awesome Link - Start -->
  <link rel="stylesheet" href="public/fonts/font-awesome/css/all.min.css">
  <!-- Font Awesome Link - End -->

  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- Style Link - Start -->
  <link rel="stylesheet" href="public/css/style.css">
  <link rel="stylesheet" href="public/css/style-pet.css">
  <!-- Style Link - End -->
</head>

<body>
  <!-- Header Section - Start -->
  <header class="header">
    <a class="logo" href="."><img class="logo-img" src="public/img/logo/P3.png" alt="P3 Logo"><span class="logo-text">P3<p class="logo-mini-text">Pet Shop</p></span></a>
    <nav class="nav-bar">
      <ul class="nav-list">
        <li class="nav-item"><a class="nav-link" href=".">Trang chủ</a></li>
        <li class="nav-item">
          <a class="nav-link" href="pets.php">Mua thú cưng <i class="fa-solid fa-chevron-down"></i></a>
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
                    <li class="subsubnav-item"><a class="subsubnav-link" href="category_pet_type.php?name=<?php echo $model->hrefFormat($subCategory['category_name']); ?>&id=<?php echo $subCategory['id']; ?>"><?php echo $subCategory['category_name'] ?></a></li>
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
        <li class="nav-item"><a class="nav-link" href="pet_services.php">Dịch vụ thú cưng <i class="fa-solid fa-chevron-down"></i></a>
          <ul class="subnav-list">
            <li class="subnav-item"><a class="subnav-link" href="pet_take_care.php">Chăm sóc thú cưng</a></li>
            <li class="subnav-item"><a class="subnav-link" href="pet_beauty.php">Làm đẹp thú cưng</a></li>
            <li class="subnav-item"><a class="subnav-link" href="pet_treatment.php">Chữa bệnh thú cưng</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="pet_magazine.php">Tạp chí thú cưng</a></li>
        <li class="nav-item"><a class="nav-link" href="shop_info.php">Thông tin cửa hàng</a></li>
      </ul>
    </nav>
    <div class="icon-bar">
      <ul class="icon-list">
        <li class="icon-item"><a class="icon-link" href="account.php"><i class="fa-solid fa-user"></i></a>
          <ul class="account-functions-list">
            <?php
            if (isset($_SESSION['username'])) {
            ?>
              <li class="account-functions-item"><a class="account-functions-link" href="account.php"><i class="fa-solid fa-user-pen"></i> <?php echo $_SESSION['username'] ?></a></li>
              <li class="account-functions-item"><a class="account-functions-link" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a></li>
            <?php
            } else {
            ?>
              <li class="account-functions-item"><a class="account-functions-link" href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Đăng nhập</a></li>
              <li class="account-functions-item"><a class="account-functions-link" href="register.php"><i class="fa-solid fa-user-plus"></i> Đăng ký</a></li>
            <?php
            }
            ?>
          </ul>
        </li>
        <li class="icon-item"><a class="icon-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
        <li class="icon-item"><a class="icon-link menu-btn" href="#"><i class="fa-solid fa-bars"></i></a></li>
      </ul>
    </div>
  </header>
  <!-- Header Section - End -->

  <!-- Main Section - Start -->
  <main>
    <!------ Include the above in your HEAD tag ---------->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <div class="pd-wrap">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div id="slider" class="owl-carousel product-slider">
              <?php
              $petPhotos = explode(",", $pet['pet_photo']);
              foreach ($petPhotos as $petPhoto) {
              ?>
                <div class="item">
                  <img src="public/img/pets_photo/<?php echo $petPhoto; ?>" alt="Một hình ảnh của thú cưng" class="img-fluid rounded-4" />
                </div>
              <?php
              }
              ?>
            </div>
            <div id="thumb" class="owl-carousel product-thumb mt-3">
              <?php
              foreach ($petPhotos as $petPhoto) {
              ?>
                <div class="item">
                  <img src="public/img/pets_photo/<?php echo $petPhoto; ?>" alt="Một hình ảnh của thú cưng" class="img-fluid" />
                </div>
              <?php
              }
              ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="product-dtl">
              <form method="POST">
                <div class="product-info">
                  <div class="product-name"><?php echo $pet['pet_name']; ?></div>
                  <div class="reviews-counter">
                    <div class="rate">
                      <input type="radio" id="star5" name="rate" value="5" checked>
                      <label for="star5" title="5 sao">5 stars</label>
                      <input type="radio" id="star4" name="rate" value="4" checked>
                      <label for="star4" title="4 sao">4 stars</label>
                      <input type="radio" id="star3" name="rate" value="3" checked>
                      <label for="star3" title="3 sao">3 stars</label>
                      <input type="radio" id="star2" name="rate" value="2" />
                      <label for="star2" title="2 sao">2 stars</label>
                      <input type="radio" id="star1" name="rate" value="1" />
                      <label for="star1" title="1 sao">1 star</label>
                    </div>
                    <span><?php echo $pet['pet_view']; ?> lượt xem</span>
                  </div>
                  <div class="fs-2 mt-3"><span>Giá: </span><span class="pet-price"><?php echo $model->currencyFormat($pet['pet_price']); ?></span></div>
                  <input type="hidden" name="price" value="<?php echo $pet['pet_price']; ?>">
                </div>
                <p class="mb-4"><?php echo $pet['pet_description']; ?></p>
                <div class="row">
                  <div class="col-md-6">
                    <label for="size">Tháng tuổi</label>
                    <select id="size" name="size" class="form-control">
                      <option>1 tháng</option>
                      <option>2 tháng</option>
                      <option>3 tháng</option>
                      <option>4 tháng</option>
                      <option>5 tháng</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="color">Màu sắc</label>
                    <select id="color" name="color" class="form-control">
                      <option>Nhạt</option>
                      <option>Bình thường</option>
                      <option>Đậm</option>
                    </select>
                  </div>
                </div>
                <div class="product-count">
                  <label for="quantity">Số lượng</label>
                  <div class="d-flex">
                    <div class="qtyminus">-</div>
                    <input type="number" name="quantity" value="1" min="1" max="100" class="qty form-control text-center">
                    <div class="qtyplus">+</div>
                  </div>

                  <button type="submit" formaction="cart.php?id=<?php echo $id; ?>&status=add" class="round-black-btn me-2"><i class="fa-solid fa-cart-plus"></i> Thêm vào giỏ</button>
                  <button type="submit" formaction="cart.php?id=<?php echo $id; ?>&status=buy" class="round-black-btn"><i class="fa-solid fa-money-bill-1-wave"></i> Mua ngay</button=>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="product-info-tabs">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Các thú cưng liên quan</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
              <div class="row">
                <?php
                foreach ($petList as $pet) {
                ?>
                  <div class="col-md-3">
                    <div class="pet-card">
                      <div class="pet-card-head">
                        <a href="pet.php?name=<?php echo $model->hrefFormat($pet['pet_name']) . "&id=" . $pet['id'] ?>" class="pet_link">
                          <?php
                          $petPhotos = explode(",", $pet['pet_photo']);
                          $petPhoto = $petPhotos[0];
                          ?>
                          <img src="public/img/pets_photo/<?php echo $petPhoto; ?>" alt="<?php echo $pet['pet_photo']; ?>" class="pet-photo">

                        </a>
                      </div>
                      <div class="pet-card-body">
                        <a href="pet.php?name=<?php echo $model->hrefFormat($pet['pet_name']) . "&id=" . $pet['id'] ?>" class="pet_link">
                          <div class="pet-name"><?php echo $pet['pet_name']; ?></div>
                        </a>
                        <div class="pet-price"><?php echo $model->currencyFormat($pet['pet_price']); ?></div>
                        <div class="pet-interactive">
                          <button type="button" class="pet-icon pet-view d-inline-block"><i class="fa-regular fa-eye"></i><span class="pet-view-content"><?php echo $pet['pet_view']; ?> views</span></button>

                          <form action="pet.php?name=<?php echo $model->hrefFormat($pet['pet_name']) . "&id=" . $pet['id'] ?>" method="POST" class="d-inline">
                            <?php
                            if (isset($_SESSION['id'])) {
                              if ($petModel->checkUserLike($pet['id'], $_SESSION['id'])) {
                            ?>
                                <button value="<?php echo $pet['id']; ?>" name="likedID" type="submit" class="pet-icon pet-like"><i class="fa-solid fa-heart"></i><span class="pet-like-content"><?php echo $pet['pet_like']; ?> likes</span></button>

                              <?php
                              } else {
                              ?>
                                <button value="<?php echo $pet['id']; ?>" name="likedID" type="submit" class="pet-icon pet-like"><i class="fa-regular fa-heart"></i><span class="pet-like-content"><?php echo $pet['pet_like']; ?> likes</span></button>
                              <?php
                              }
                            } else {
                              ?>
                              <button value="<?php echo $pet['id']; ?>" name="likedID" type="button" class="pet-icon pet-like"><i class="fa-regular fa-heart"></i><span class="pet-like-content"><?php echo $pet['pet_like']; ?> likes</span></button>
                            <?php
                            }
                            ?>
                          </form>
                        </div>
                      </div>
                      <a href="pet.php?name=<?php echo $model->hrefFormat($pet['pet_name']) . "&id=" . $pet['id'] ?>" class="pet-buy-btn"><i class="fa-solid fa-cart-plus"></i> Mua ngay</a>
                    </div>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="product-info-tabs">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Mô tả</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">Đánh giá (0)</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
              <p><?php echo $pet['pet_description']; ?></p>
            </div>
            <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
              <div class="review-heading">Đánh giá</div>
              <p class="mb-20">Hiện tại chưa có đánh giá nào.</p>
              <form class="review-form">
                <div class="form-group">
                  <label>Đánh giá của bạn: </label>
                  <div class="reviews-counter">
                    <div class="rate">
                      <input type="radio" id="star5" name="rate" value="5" />
                      <label for="star5" title="text">5 stars</label>
                      <input type="radio" id="star4" name="rate" value="4" />
                      <label for="star4" title="text">4 stars</label>
                      <input type="radio" id="star3" name="rate" value="3" />
                      <label for="star3" title="text">3 stars</label>
                      <input type="radio" id="star2" name="rate" value="2" />
                      <label for="star2" title="text">2 stars</label>
                      <input type="radio" id="star1" name="rate" value="1" />
                      <label for="star1" title="text">1 star</label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Lời nhắn của bạn: </label>
                  <textarea class="form-control" rows="10"></textarea>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" name="" class="form-control" placeholder="Tên của bạn">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" name="" class="form-control" placeholder="Số điện thoại của bạn">
                    </div>
                  </div>
                </div>
                <button class="round-black-btn">Gửi đánh giá</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="	sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="public/js/script-pet.js"></script>
  </main>
  <!-- Main Section - End -->

  <?php
  // Include Footer Start
  include 'includes/footer.php';
  // Include Footer End
  ?>