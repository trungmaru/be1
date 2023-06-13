<?php
// Inclue Header Start
include './includes/header.php';
// Inclue Header End

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

$petList = $petModel->getAllPets();
?>
<!-- Main Section Start -->
<main style="margin-top: 10rem">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <h2 class="title-page">Mua thú cưng</h2>
      </div>
      <div class="col-md-9"></div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <?php include('includes/sidebar.php'); ?>
      </div>
      <div class="col-md-9">
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

                    <form action="pets.php" method="POST" class="d-inline">
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

</main>
<!-- Main Section End -->

<?php
// Include Footer Start
include './includes/footer.php';
// Include Footer End
?>