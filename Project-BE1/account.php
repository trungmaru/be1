<?php
session_start();

/* Connection Declarationn - Start */
require_once './config/database.php';
spl_autoload_register(function ($className) {
  require_once "./app/models/$className.php";
});
/* Connection Declaration - End */

/* Initialize Value From Query - Start */
$userModel = new UserModel();
/* Initialize Value From Query - End */

//move to login.php if not logged in
if (!isset($_SESSION['username'])) {
  header('location:login.php');
}

//move to admin.php if account is admin
if (isset($_SESSION['username'])) {
  if ($_SESSION['role'] > 0) {
    header('location:admin_manage_account.php');
  }
}
$id = $_SESSION['id'];
$user = $userModel->getUserByID($id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản lý tài khoản - P3 Pet Shop</title>

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
      <li class="admin-side-bar-item"><a class="admin-side-bar-link active" href="account.php"><i class="fa-solid fa-users-gear"></i> Thông tin tài khoản</a></li>
      <li class="admin-side-bar-item"><a class="admin-side-bar-link" href="user_edit_password.php?id=<?php echo $id; ?>"><i class="fa-solid fa-key"></i> Đổi mật khẩu</a></li>
      <li class="admin-side-bar-item"><a class="admin-side-bar-link" href="user_manage_order.php"><i class="fa-solid fa-box-open"></i> Quản lý đơn hàng</a></li>
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
        <table class="table table-hover table-dark">
          <thead>
            <tr>
              <th><i class="fa-solid fa-user"></i> Username</th>
              <th><i class="fa-solid fa-lock"></i> Password</th>
              <th><i class="fa-solid fa-phone"></i> Số điện thoại</th>
              <th><i class="fa-solid fa-location-dot"></i> Địa chỉ</th>
              <th><i class="fa-solid fa-screwdriver-wrench"></i> Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><span class="table-content"><?php echo $user['username']; ?></span></td>
              <td><span class="table-content"><?php echo $user['password']; ?></span></td>
              <td><span class="table-content"><?php echo $user['phone']; ?></span></td>
              <td><span class="table-content"><?php echo $user['address']; ?></span></td>
              <td>
                <a class="btn btn-warning mb-2 mt-2" href="user_edit_account.php?username=<?php echo $user['username']; ?>&id=<?php echo $user['id']; ?>"><i class="fa-solid fa-pencil"></i> Sửa thông tin</a>
                <form action="user_delete_account.php" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản của mình ?')">
                  <input type="hidden" name="deleteId" value="<?php echo $user['id'] ?>">
                  <button class="btn btn btn-danger mb-2 mt-2" type="submit"><i class="fa-solid fa-trash"></i> Xóa tài khoản</button>
                </form>
              </td>
            </tr>
          </tbody>
        </table>

      </div>
    </main>
    <!-- Main Section End -->
  </section>

  <script src="./public/js/script.js"></script>
</body>

</html>