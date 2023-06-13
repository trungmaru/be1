<?php
// Inclue Header Start
include './includes/header.php';;
// Inclue Header End
?>
<!-- Main Section Start -->
<main>
  <?php
  $id = "";
  $name = "";
  $quantity = 0;
  $price = 0;
  $size = "";
  $color = "";

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $pet = $petModel->getPetById($id);
    $photo = explode(",", $pet['pet_photo'])[0];
    $name = $pet['pet_name'];
  }

  if (isset($_POST['quantity']) && isset($_POST['price']) && isset($_POST['color']) && isset($_POST['size'])) {
    $quantity = (int)$_POST['quantity'];
    $price = (int)$_POST['price'];
    $color = $_POST['color'];
    $size = $_POST['size'];
  }

  if ($id != "") {
    if (isset($_SESSION['cart'][$id])) {
      $_SESSION['cart'][$id]['quantity'] += $quantity;
    } else {
      $_SESSION['cart'][$id] = array(
        "id" => $id,
        "name" => $name,
        "photo" => $photo,
        "quantity" => $quantity,
        "price" => $price,
        "size" => $size,
        "color" => $color
      );
    }
  }


  if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if ($status == "add") {
  ?>
      <script>
        alert('Thêm giỏ hàng thành công !');
        window.location.href = "pet.php?id=<?php echo $id; ?>";
      </script>
  <?php
    }
  }

  if (isset($_SESSION['cart'])) {
    $petList = $_SESSION['cart'];
  }
  ?>
  <div class="container">
    <h1 style="margin-top: 100px; font-weight: bold;">Giỏ hàng</h1>

    <table class="table table-hover table-bordered">
      <thead class="thead-dark">
        <tr>
          <th><i class="fa-solid fa-image"></i> Ảnh</th>
          <th><i class="fa-solid fa-signature"></i> Tên</th>
          <th><i class="fa-brands fa-pagelines"></i> Tháng tuổi</th>
          <th><i class="fa-solid fa-droplet"></i> Màu sắc</th>
          <th><i class="fa-solid fa-plus-minus"></i> Số lượng</th>
          <th><i class="fa-solid fa-dollar-sign"></i> Đơn giá</th>
          <th><i class="fa-solid fa-dollar-sign"></i> Thành tiền</th>
          <th><i class="fa-solid fa-grip-lines"></i> Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($petList)) {
          foreach ($petList as $pet) {
        ?>
            <tr>
              <td><img class="table-content-pet img-fluid rounded-4" src="public/img/pets_photo/<?php echo $pet['photo']; ?>" alt="Hình ảnh của một con vật nào đó"></td>
              <td><span class="table-content-pet"><?php echo $pet['name']; ?></span></td>
              <td><span class="table-content-pet"><?php echo $pet['size']; ?></span></td>
              <td><span class="table-content-pet"><?php echo $pet['color']; ?></span></td>
              <td><span class="table-content-pet">
                <a href="minus_pet_in_cart.php?id=<?php echo $pet['id']; ?>" class="btn btn btn-danger mb-2 mt-2" type="submit">-</a>
                <?php echo $pet['quantity']; ?>
                <a href="plus_pet_in_cart.php?id=<?php echo $pet['id']; ?>" class="btn btn btn-danger mb-2 mt-2" type="submit">+</a></span></td>
              <td><span class="table-content-pet"><?php echo $model->currencyFormat($pet['price']); ?></span></td>
              <td><span class="table-content-pet"><?php echo $model->currencyFormat($pet['price'] * $pet['quantity']); ?></span></td>
              <td>
                <a href="delete_pet_in_cart.php?id=<?php echo $pet['id']; ?>" class="btn btn btn-danger mb-2 mt-2" type="submit"><i class="fa-solid fa-trash"></i> Xóa</a>
              </td>
            </tr>
        <?php
          }
        }
        ?>
      </tbody>
    </table>
    <div>
      <a href="delete_all_pet_in_cart.php" class="btn btn-danger mb-2 mt-4 me-4" type="submit"><i class="fa-solid fa-trash"></i> Xóa toàn bộ</a>
      <a href="." class="btn btn-warning mb-2 mt-4 me-4" type="submit"><i class="fa-brands fa-golang"></i> Mua tiếp</a>
      <a href="order.php" class="btn btn-success mb-2 mt-4 me-4" type="submit"><i class="fa-solid fa-credit-card"></i> Thanh toán</a>

    </div>
  </div>
</main>
<!-- Main Section End -->

<?php
// Include Footer Start
include './includes/footer.php';
// Include Footer End
?>