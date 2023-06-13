<?php
session_start();

//move to index.php if account is not admin 
if ($_SESSION['role'] < 1) {
  header('location:.');
}

/* Connection Declaration - Start */
require_once './config/database.php';
spl_autoload_register(function ($className) {
  require_once "./app/models/$className.php";
});
/* Connection Declaration End */

/* Initialize Value From Query - Start */
$orderModel = new OrderModel();
/* Initialize Value From Query - End */

/* Pagination - Start */
$page = 1;
if (isset($_GET['page'])) {
  $page = $_GET['page'];
}

if (isset($_POST['perPage'])) {
  $_SESSION['perPage'] = $_POST['perPage'];
}

if (isset($_SESSION['perPage'])) {
  $perPage = $_SESSION['perPage'];
} else {
  $perPage = 3;
}
$totalPage = ceil($orderModel->getTotalOrders() / $perPage);
/* Pagination - End */

$orderList = $orderModel->getOrdersByPage($page, $perPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản lý đơn hàng - P3 Pet Shop</title>

  <!-- Fav Icon Link Start -->
  <link rel="shortcut icon" href="./public/img/logo/P3.png" type="image/x-icon">
  <!-- Fav Icon Link End -->

  <!-- Google Font Link Start -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,500;0,600;0,700;0,800;0,900;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <!-- Google Font Link End -->

  <!-- Font Awesome Link Start -->
  <link rel="stylesheet" href="./public/fonts/font-awesome/css/all.min.css">
  <!-- Font Awesome Link End -->

  <!-- Bootstrap Link Start -->
  <link rel="stylesheet" href="./public/vendor/bootstrap/css/bootstrap.min.css">
  <!-- Bootstrap Link Start -->

  <!-- Style Link Start -->
  <link rel="stylesheet" href="./public/css/style.css">
  <link rel="stylesheet" href="./public/css/style-admin.css">
  <!-- Style Link End -->
</head>

<body>
  <!-- Sidebar Section Start -->
  <section class="admin-sidebar">
    <a class="logo" href="."><img class="logo-img" src="./public/img/logo/P3.png" alt="P3 Logo"><span class="logo-text">P3<p class="logo-mini-text">Pet Shop</p></span></a>
    <ul class="admin-side-bar-list">
      <?php if ($_SESSION['role'] == 2) {
      ?>
        <li class="admin-side-bar-item"><a class="admin-side-bar-link" href="admin_manage_interface.php"><i class="fa-solid fa-wand-magic-sparkles"></i> Quản lý giao diện</a></li>
      <?php
      } ?>
      <li class="admin-side-bar-item"><a class="admin-side-bar-link" href="admin_manage_account.php"><i class="fa-solid fa-users-gear"></i> Quản lý tài khoản</a></li>
      <li class="admin-side-bar-item"><a class="admin-side-bar-link" href="admin_manage_category.php"><i class="fa-regular fa-folder-open"></i> Quản lý danh mục</a></li>
      <li class="admin-side-bar-item"><a class="admin-side-bar-link" href="admin_manage_pet.php"><i class="fa-solid fa-shield-cat"></i> Quản lý thú cưng</a></li>
      <li class="admin-side-bar-item"><a class="admin-side-bar-link active" href="admin_manage_order.php"><i class="fa-solid fa-box-open"></i> Quản lý đơn hàng</a></li>
    </ul>
  </section>
  <!-- Sidebar Section End -->

  <!-- Header Section Start -->
  <section class="admin-content">
    <header class="header">
      <nav class="nav-bar">
        <ul class="nav-list">
          <li class="nav-item">
            <form class="serch-box" action="admin_serch_account.php?key=<?php if (isset($key)) {
                                                                          echo $key;
                                                                        } ?>">
              <input class="serch-box-input" type="text" name="key" placeholder="Tìm kiếm" value="<?php if (isset($key)) {
                                                                                                    echo $key;
                                                                                                  } ?>">
              <button class="serh-box-button button-serch" type="submit"><i class="fa fa-search"></i></button>
              <button class="serh-box-button button-reset" type="reset"><i class="fa-solid fa-xmark"></i></button>
            </form>
          </li>
        </ul>
      </nav>
      <div class="icon-bar">
        <ul class="icon-list">
          <li class="icon-item"><a class="icon-link" href="account.php"><i class="fa-solid fa-user"></i></a>
            <ul class="account-functions-list">
              <?php
              if (isset($_SESSION['username'])) {
              ?>
                <li class="account-functions-item"><a class="account-functions-link" href="account.php"><i class="fa-solid fa-user-tie"></i> <?php echo $_SESSION['username'] ?></a></li>
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
        </ul>
      </div>
    </header>
    <!-- Header Section End -->

    <!-- Main Section Start -->
    <main>
      <div class="table-wrap">
        <div class="table-bar mb-4">
          <section class="d-flex align-items-center">
            <span class="d-inline">Số hàng: </span>
            <form method="post" action="admin_manage_order.php" class="form-per-page d-inline-block ms-2">
              <select class="form-select" id="select-per-page" name="perPage">
                <option value="3" <?php if ($perPage == 3) {
                                    echo 'selected';
                                  } ?>>3</option>
                <option value="4" <?php if ($perPage == 4) {
                                    echo 'selected';
                                  } ?>>4</option>
                <option value="5" <?php if ($perPage == 5) {
                                    echo 'selected';
                                  } ?>>5</option>
              </select>
            </form>
          </section>
        </div>

        <table class="table table-hover table-dark">
          <thead>
            <tr>
              <th><i class="fa-solid fa-user"></i> Tên người đặt</th>
              <th><i class="fa-solid fa-mobile-retro"></i> Số điện thoại</th>
              <th><i class="fa-solid fa-location-crosshairs"></i> Địa chỉ</th>
              <th><i class="fa-solid fa-signal"></i> Trạng thái đơn</th>
              <th><i class="fa-solid fa-calendar-days"></i> Tạo lúc</th>
              <th><i class="fa-solid fa-screwdriver-wrench"></i> Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($orderList as $order) {
            ?>
              <tr>
                <td><span class="table-content"><?php echo $order['name']; ?></span></td>
                <td><span class="table-content"><?php echo $order['phone']; ?></span></td>
                <td><span class="table-content"><?php echo $order['address']; ?></span></td>
                <td><span class="table-content"><?php if ($order['status'] == 0) {
                                                  echo "Chờ xác nhận";
                                                } else if ($order['status'] == 1) {
                                                  echo "Đã xác nhận";
                                                } else if ($order['status'] == 2) {
                                                  echo "Đã huỷ";
                                                } ?></span></td>
                <td><span class="table-content"><?php echo $order['time_create']; ?></span></td>
                <td>
                  <a class="btn btn-warning mb-2 mt-2" href="order_detail.php?id=<?php echo $order['id']; ?>"><i class="fa-solid fa-eye"></i> Xem chi tiết</a>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
        <nav aria-label="Page navigation" class="mt-4">
          <ul class="pagination justify-content-center">
            <!-- first page -->
            <?php if ($page == 1) {
            ?>
              <li class="page-item disabled">
                <a class="page-link"><i class="fa-solid fa-circle-left"></i></a>
              </li>
              <li class="page-item disabled">
                <a class="page-link"><i class="fa-regular fa-circle-left"></i></a>
              </li>
            <?php
            } else {
            ?>
              <li class="page-item">
                <a class="page-link" href="admin_manage_order.php"><i class="fa-solid fa-circle-left"></i></a>
              </li>
              <li class="page-item">
                <a class="page-link" href="admin_manage_order.php?page=<?php echo $page - 1; ?>"><i class="fa-regular fa-circle-left"></i></a>
              </li>
            <?php
            }
            ?>

            <!-- page item -->
            <?php
            if ($page == 1) {
              $getAdd = $page + 2;
              $getMinus = $page;
            } elseif ($page == $totalPage) {
              $getAdd = $page;
              $getMinus = $page - 2;
            } else {
              $getAdd = $page + 1;
              $getMinus = $page - 1;
            }
            for ($pageItem = 1; $pageItem <= $totalPage; $pageItem++) {
              if ($pageItem == $page) {
            ?>
                <li class="page-item active"><a class="page-link" href="admin_manage_order.php?page=<?php echo $pageItem; ?>"><?php echo $pageItem; ?></a></li>
              <?php
              } else {
              ?>
                <li class="page-item" <?php if ($pageItem > $getAdd || $pageItem < $getMinus) {
                                        echo "style='display:none;position:absolute'";
                                      } ?>><a class="page-link" href="admin_manage_order.php?page=<?php echo $pageItem; ?>"><?php echo $pageItem; ?></a></li>
            <?php
              }
            }
            ?>

            <!-- last page -->
            <?php if ($page == $totalPage) {
            ?>
              <li class="page-item disabled">
                <a class="page-link"><i class="fa-regular fa-circle-right"></i></a>
              </li>
              <li class="page-item disabled">
                <a class="page-link"><i class="fa-solid fa-circle-right"></i></a>
              </li>
            <?php
            } else {
            ?>
              <li class="page-item">
                <a class="page-link" href="admin_manage_order.php?page=<?php echo $page + 1; ?>"><i class="fa-regular fa-circle-right"></i></a>
              </li>
              <li class="page-item">
                <a class="page-link" href="admin_manage_order.php?page=<?php echo $totalPage; ?>"><i class="fa-solid fa-circle-right"></i></a>
              </li>
            <?php
            }
            ?>
          </ul>
        </nav>
      </div>
    </main>
    <!-- Main Section End -->
  </section>

  <script src="./public/js/script.js"></script>
</body>

</html>