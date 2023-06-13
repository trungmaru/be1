<?php
class UserModel extends Model
{
  public function getAllUsers()
  {
    $sql = parent::$connection->prepare('SELECT * FROM `users`');
    return parent::select($sql);
  }

  public function getUserByID($id)
  {
    $sql = parent::$connection->prepare('SELECT * FROM `users` WHERE id=?');
    $sql->bind_param('i', $id);
    return parent::select($sql)[0];
  }

  public function getUserByUsername($username)
  {
    $sql = parent::$connection->prepare('SELECT * FROM `users` WHERE `username`=?');
    $sql->bind_param('s', $username);
    return parent::select($sql);
  }

  public function getUsersByKeywordAndPage($key, $page, $perPage)
  {
    $start = ($page - 1) * $perPage;
    $sql = parent::$connection->prepare('SELECT * FROM `users` WHERE `username` LIKE ? OR `phone` LIKE ? OR `address` LIKE ? LIMIT ?, ?');
    $key = "%{$key}%";
    $sql->bind_param('sssii', $key, $key, $key, $start, $perPage);
    return parent::select($sql);
  }

  public function getUsersByPage($page, $perPage)
  {
    $start = ($page - 1) * $perPage;
    $sql = parent::$connection->prepare('SELECT * FROM `users` WHERE `role` != 2 LIMIT ?, ?');
    $sql->bind_param('ii', $start, $perPage);
    return parent::select($sql);
  }

  public function getTotalUsers()
  {
    $sql = parent::$connection->prepare('SELECT COUNT(id) AS `total_users` FROM `users`');
    return parent::select($sql)[0]['total_users'] - 1;
  }

  public function getTotalUsersWithKey($key)
  {
    $sql = parent::$connection->prepare('SELECT COUNT(id) AS `total_users` FROM `users` WHERE `username` LIKE ? OR `phone` LIKE ? OR `address` LIKE ? ');
    $key = "%{$key}%";
    $sql->bind_param('sss', $key, $key, $key);
    return parent::select($sql)[0]['total_users'];
  }

  public function checkLogin($username, $password)
  {
    $user = self::getUserByUsername($username);
    if (empty($user)) {
      $_SESSION['loginAlert']  = '<div class="form-alert-fail">Username không tồn tại ! <span class="close-btn" onclick="this.parentElement.style.display=' . "'none'" . ';">&times;</span></div>';
      return false;
    } elseif (!password_verify($password, $user[0]['password'])) {
      $_SESSION['loginAlert'] = '<div class="form-alert-fail">Sai mật khẩu ! <span class="close-btn" onclick="this.parentElement.style.display=' . "'none'" . ';">&times;</span></div>';
      return false;
    }
    unset($_SESSION['loginAlert']);
    return true;
  }

  public function checkRegister($registerUsername, $registerPassword, $registerRePassword, $registerPhone, $registerAddress)
  {
    $registerUsername = trim($registerUsername);
    $registerPhone = trim($registerPhone);
    $registerAddress = trim($registerAddress);
    $user = self::getUserByUsername($registerUsername);
    if (strlen($registerUsername) < 4 || strlen($registerUsername) > 25 || strpos($registerUsername, ' ') !== false) {
      $_SESSION['registerAlert'] = '<div class="form-alert-fail">Username không chứa khoảng trắng, dài 4 - 25 kí tự ! <span class="close-btn" onclick="this.parentElement.style.display=' . "'none'" . ';">&times;</span></div>';
      return false;
    } elseif (!empty($user[0]['username'])) {
      $_SESSION['registerAlert'] = '<div class="form-alert-fail">Username đã tồn tại ! <span class="close-btn" onclick="this.parentElement.style.display=' . "'none'" . ';">&times;</span></div>';
      return false;
    } elseif (strlen($registerPassword) < 4) {
      $_SESSION['registerAlert'] = '<div class="form-alert-fail">Password phải từ 4 kí tự trở lên ! <span class="close-btn" onclick="this.parentElement.style.display=' . "'none'" . ';">&times;</span></div>';
      return false;
    } elseif ($registerRePassword != $registerPassword) {
      $_SESSION['registerAlert'] = '<div class="form-alert-fail">Password không trùng nhau ! <span class="close-btn" onclick="this.parentElement.style.display=' . "'none'" . ';">&times;</span></div>';
      return false;
    } elseif (strlen($registerPhone) < 10 || strlen($registerPhone) > 11 || (int)$registerPhone == 0) {
      $_SESSION['registerAlert'] = '<div class="form-alert-fail">Số điện thoại trong phạm vi 0-9, dài 10 - 11 kí tự ! <span class="close-btn" onclick="this.parentElement.style.display=' . "'none'" . ';">&times;</span></div>';
      return false;
    } elseif (strlen($registerAddress) > 500) {
      $_SESSION['registerAlert'] = '<div class="form-alert-fail">Địa chỉ tối đa 500 kí tự ! <span class="close-btn" onclick="this.parentElement.style.display=' . "'none'" . ';">&times;</span></div>';
      return false;
    }
    return true;
  }

  //INSERT
  public function addUser($registerUsername, $registerPassword, $registerPhone, $registerAddress)
  {
    if ($registerAddress == '') {
      $registerAddress = 'Không';
    }
    $sql = parent::$connection->prepare('INSERT INTO `users`(`username`, `password`, `phone`, `address`) VALUES (?, ?, ?, ?)');
    $registerHashPassword = password_hash($registerPassword, PASSWORD_DEFAULT);
    $sql->bind_param('ssss', $registerUsername, $registerHashPassword, $registerPhone, $registerAddress);
    return $sql->execute();
  }

  public function addUserHasRole($username, $password, $phone, $address, $role)
  {
    if ($address == '') {
      $address = 'Không';
    }
    $sql = parent::$connection->prepare('INSERT INTO `users`(`username`, `password`, `phone`, `address`, `role`) VALUES (?, ?, ?, ?, ?)');
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql->bind_param('ssssi', $username, $hashPassword, $phone, $address, $role);
    return $sql->execute();
  }

  //UPDATE
  public function editUser($phone, $address, $role, $id)
  {
    $sql = parent::$connection->prepare('UPDATE `users` SET `phone`=?,`address`=?,`role`=? WHERE `id`=?');
    $sql->bind_param('ssii', $phone, $address, $role, $id);
    return $sql->execute();
  }

  public function editUserPassword($newPassword, $id)
  {
    $sql = parent::$connection->prepare('UPDATE `users` SET `password`=? WHERE `id`=?');
    $sql->bind_param('si', $newPassword, $id);
    return $sql->execute();
  }

  //DELETE
  public function deleteUser($id)
  {
    $sql = parent::$connection->prepare('DELETE FROM `users` WHERE `id`=?');
    $sql->bind_param('i', $id);
    return $sql->execute();
  }
}
