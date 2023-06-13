<?php
class OrderModel extends Model
{
  public function getOrderById($id)
  {
    $sql = parent::$connection->prepare('SELECT * FROM `orders` WHERE `id` = ?');
    $sql->bind_param('i', $id);
    return parent::select($sql)[0];
  }

  public function getOrdersByUserID($id)
  {
    $sql = parent::$connection->prepare('SELECT * FROM `orders` WHERE `user_id` = ?');
    $sql->bind_param('i', $id);
    return parent::select($sql);
  }

  public function getLatestIDInOrders()
  {
    $sql = parent::$connection->prepare('SELECT `id` FROM `orders` ORDER BY `id` DESC LIMIT 1');
    return parent::select($sql)[0]['id'];
  }

  public function getTotalOrders()
  {
    $sql = parent::$connection->prepare('SELECT COUNT(id) AS `total_orders` FROM `orders`');
    return parent::select($sql)[0]['total_orders'];
  }

  public function getOrdersByPage($page, $perPage)
  {
    $start = ($page - 1) * $perPage;
    $sql = parent::$connection->prepare('SELECT * FROM `orders` LIMIT ?, ?');
    $sql->bind_param('ii', $start, $perPage);
    return parent::select($sql);
  }

  public function getDetailOrderByID($id)
  {
    $sql = parent::$connection->prepare('SELECT * FROM `order_item`, `pets` WHERE `order_id` = ? AND `order_item`.`pet_id` = `pets`.`id`');
    $sql->bind_param('i', $id);
    return parent::select($sql);
  }

  public function addOrder($userID, $name, $phone, $address)
  {
    $sql = parent::$connection->prepare('INSERT INTO `orders`(`user_id`, `name`, `phone`, `address`) VALUES (?, ?, ?, ?)');
    $sql->bind_param('isss', $userID, $name, $phone, $address);
    return $sql->execute();
  }

  public function addOrderItem($orderID, $petID, $color, $size, $quantity, $price)
  {
    $sql = parent::$connection->prepare('INSERT INTO `order_item`(`order_id`, `pet_id`, `color`, `size`, `quantity`, `price`) VALUES (?, ?, ?, ?, ?, ?)');
    $sql->bind_param('iissii', $orderID, $petID, $color, $size, $quantity, $price);
    return $sql->execute();
  }

  public function updateStatusOrder($status, $id)
  {
    $sql = parent::$connection->prepare('UPDATE `orders` SET `status`= ?,`time_create`= NOW() WHERE `id` = ?');
    $sql->bind_param('ii', $status, $id);
    return $sql->execute();
  }
}
