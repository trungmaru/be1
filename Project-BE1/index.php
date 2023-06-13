<?php
// Inclue Header Start
include './includes/header.php';;
// Inclue Header End
?>

<!-- Main Section Start -->
<main>
  <?php 
  $topViewPetList = $petModel->getPopularPets();
  $topLikePetList = $petModel->getTopLikePets();
  ?>
  <!-- Banner Start -->
  <div class="banner">
    <div class="banner-title"><span class="hight-light-text">Chào mừng</span> đến với P3 Pet Shop</div>
    <img class="wave-bottom" src="public/img/banner/bottom-wave.png" alt="">
  </div>
  <!-- Banner End -->
  <div class="container">

    <h1 style="margin-top: 100px; margin-bottom: 20px; font-weight: bold;"><i class="fa-regular fa-clock"></i> Các thú cưng đã xem gần đây <i class="fa-solid fa-circle-chevron-down"></i></h1>

    <div class="row">
      <?php
      if (isset($_COOKIE['viewedPets'])) {
        $arrViewedPetID = $petModel->getPetByIds(json_decode($_COOKIE['viewedPets'], true));
        foreach ($arrViewedPetID as $pet) {
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
              </div>
              <a href="pet.php?name=<?php echo $model->hrefFormat($pet['pet_name']) . "&id=" . $pet['id'] ?>" class="pet-buy-btn"><i class="fa-solid fa-cart-plus"></i> Mua ngay</a>
            </div>
          </div>
      <?php
        }
      }
      ?>
    </div>

    <h1 style="margin-top: 100px; margin-bottom: 20px; font-weight: bold;"><i class="fa-solid fa-eye"></i> Các thú cưng được xem nhiều nhất <i class="fa-solid fa-circle-chevron-down"></i></h1>

    <div class="row">
      <?php
      foreach ($topViewPetList as $pet) {
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
            </div>
            <a href="pet.php?name=<?php echo $model->hrefFormat($pet['pet_name']) . "&id=" . $pet['id'] ?>" class="pet-buy-btn"><i class="fa-solid fa-cart-plus"></i> Mua ngay</a>
          </div>
        </div>
      <?php
      }
      ?>
    </div>

    <h1 style="margin-top: 100px; margin-bottom: 20px; font-weight: bold;"><i class="fa-solid fa-heart"></i> Các thú cưng được yêu thích nhất <i class="fa-solid fa-circle-chevron-down"></i></h1>
    <div class="row">
      <?php
      foreach ($topLikePetList as $pet) {
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
            </div>
            <a href="pet.php?name=<?php echo $model->hrefFormat($pet['pet_name']) . "&id=" . $pet['id'] ?>" class="pet-buy-btn"><i class="fa-solid fa-cart-plus"></i> Mua ngay</a>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
</main>
<!-- Main Section End -->

<?php
// Include Footer Start
include './includes/footer.php';
// Include Footer End
?>