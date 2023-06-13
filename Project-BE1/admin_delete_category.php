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

$categoryModel = new CategoryModel();

if (isset($_POST['deleteId'])) {
  $id = $_POST['deleteId'];
  if ($categoryModel->deleteCategory($id)) {
?>
    <script>
      alert('Xóa thành công !');
      window.location.href = "admin_manage_category.php";
    </script>
  <?php
  } else {
  ?>
    <script>
      alert('Xóa thất bại !');
      window.location.href = "admin_manage_category.php";
    </script>
<?php
  }
}
?>