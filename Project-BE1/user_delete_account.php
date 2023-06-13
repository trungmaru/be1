<?php
session_start();

/* Connection Declarationn - Start */
require_once './config/database.php';
spl_autoload_register(function ($className) {
  require_once "./app/models/$className.php";
});
/* Connection Declarationn - End */

$userModel = new UserModel();

if (isset($_POST['deleteId'])) {
  $id = $_POST['deleteId'];
  if ($userModel->deleteUser($id)) {
?>
    <script>
      alert('Tài khoản của bạn đã bị xóa !');
      window.location.href = "logout.php";
    </script>
  <?php
  } else {
  ?>
    <script>
      alert('Xóa không thành công !');
      // window.location.href = ".";
    </script>
<?php
  }
}
?>