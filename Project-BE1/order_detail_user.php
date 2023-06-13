<?php
// Inclue Header Start
include './includes/header.php';;
// Inclue Header End
?>
<!-- Main Section Start -->
<main>
  <?php
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_POST['status'])) {
      $status = $_POST['status'];
      $orderModel->updateStatusOrder($status, $id);
    }
    $orderList = $orderModel->getDetailOrderByID($id);
    $orderInfo = $orderModel->getOrderById($id);
  }
  ?>
  <div class="container">
    <h1 style="margin-top: 100px; font-weight: bold;">Chi tiết đơn hàng</h1>
    <h2 style="margin-top: 2rem; font-weight: bold;">+ Thông tin người đặt</h2>
    <table class="table table-hover table-bordered">
      <thead class="thead-dark">
        <th><i class="fa-solid fa-signature"></i> Tên người đặt</th>
        <th><i class="fa-solid fa-mobile-retro"></i> Số điện thoại</th>
        <th><i class="fa-solid fa-location-crosshairs"></i> Địa chỉ</th>
      </thead>
      <tbody>
        <tr>
          <td><span class="table-content-pet"><?php echo $orderInfo['name']; ?></span></td>
          <td><span class="table-content-pet"><?php echo $orderInfo['phone']; ?></span></td>
          <td><span class="table-content-pet"><?php echo $orderInfo['address']; ?></span></td>
        </tr>
      </tbody>
    </table>
    <h2 style="margin-top: 2rem; font-weight: bold;">+ Chi tiết đơn hàng</h2>
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
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($orderList)) {
          foreach ($orderList as $order) {
        ?>
            <tr>
              <td><img class="table-content-pet img-fluid rounded-4" src="public/img/pets_photo/<?php echo explode(",", $order['pet_photo'])[0]; ?>" alt="Hình ảnh của một con vật nào đó"></td>
              <td><span class="table-content-pet"><?php echo $order['pet_name']; ?></span></td>
              <td><span class="table-content-pet"><?php echo $order['size']; ?></span></td>
              <td><span class="table-content-pet"><?php echo $order['color']; ?></span></td>
              <td><span class="table-content-pet"><?php echo $order['quantity']; ?></span></td>
              <td><span class="table-content-pet"><?php echo $model->currencyFormat($order['price']); ?></span></td>
              <td><span class="table-content-pet"><?php echo $model->currencyFormat($order['price'] * $order['quantity']); ?></span></td>
            </tr>
        <?php
          }
        }
        ?>
      </tbody>
    </table>
    <h2 style="margin-top: 2rem; font-weight: bold;">+ Trạng thái đơn hàng</h2>
    <?php
    if ($orderInfo['status'] == 0) {
    ?>
      <form action="order_detail_user.php?id=<?php echo $id; ?>" method="POST">
        <input type="hidden" name="status" value="2">
        <button class="btn btn-danger" type="submit">Hủy đơn hàng</button>
      </form>
    <?php
    } else {
      if ($orderInfo['status'] == 2) {
        echo "<h2>Đã hủy</h2>";
      } else if ($orderInfo['status'] == 1) {
        echo "<h2>Đã xác nhận</h2>";
      }
    }
    ?>

  </div>
</main>
<!-- Main Section End -->

<?php
// Include Footer Start
include './includes/footer.php';
// Include Footer End
?>