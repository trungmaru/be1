<?php
class CategoryModel extends Model
{
  public function getAllCategories()
  {
    $sql = parent::$connection->prepare('SELECT * FROM `categories`');
    return parent::select($sql);
  }

  public function getCategoryByID($id)
  {
    $sql = parent::$connection->prepare('SELECT * FROM `categories` WHERE `id`=?');
    $sql->bind_param('i', $id);
    return parent::select($sql)[0];
  }

  public function getAllRootCategories()
  {
    $sql = parent::$connection->prepare('SELECT * FROM `categories` WHERE `parent_id` IS NULL');
    return parent::select($sql);
  }

  public function getAllCategoriesByParentID($parentID)
  {
    $sql = parent::$connection->prepare('SELECT * FROM `categories` WHERE `parent_id`=?');
    $sql->bind_param('i', $parentID);
    return parent::select($sql);
  }

  public function getCategoriesByKeywordAndPage($key, $page, $perPage)
  {
    $start = ($page - 1) * $perPage;
    $sql = parent::$connection->prepare('SELECT * FROM `categories` WHERE `category_name` LIKE ? LIMIT ?, ?');
    $key = "%{$key}%";
    $sql->bind_param('sii', $key, $start, $perPage);
    return parent::select($sql);
  }

  public function getCategoriesByPage($page, $perPage)
  {
    $start = ($page - 1) * $perPage;
    $sql = parent::$connection->prepare('SELECT * FROM `categories` LIMIT ?, ?');
    $sql->bind_param('ii', $start, $perPage);
    return parent::select($sql);
  }

  public function getTotalCategories()
  {
    $sql = parent::$connection->prepare('SELECT COUNT(id) AS `total_categories` FROM `categories`');
    return parent::select($sql)[0]['total_categories'];
  }

  public function getTotalCategoriesWithKey($key)
  {
    $sql = parent::$connection->prepare('SELECT COUNT(id) AS `total_categories` FROM `categories` WHERE `category_name` LIKE ?');
    $key = "%{$key}%";
    $sql->bind_param('s', $key);
    return parent::select($sql)[0]['total_categories'];
  }

  public function getCategoryParrent($parentID)
  {
    $sql = parent::$connection->prepare('SELECT `category_name` FROM categories WHERE `id` = ?');
    $sql->bind_param('i', $parentID);
    return parent::select($sql);
  }

  public function getAllSubCategories($parentID)
  {
    $sql = parent::$connection->prepare('SELECT `category_name` FROM categories WHERE `id` = ?');
    $sql->bind_param('i', $parentID);
    return parent::select($sql);
  }

  public function addCategory($categoryName, $parentID)
  {
    if ($parentID == 0) {
      $parentID = NULL;
    }
    $sql = parent::$connection->prepare('INSERT INTO `categories`(`category_name`, `parent_id`) VALUES (?, ?)');
    $sql->bind_param('ss', $categoryName, $parentID);
    return $sql->execute();
  }

  public function editCategory($categoryName, $parentID, $id)
  {
    if ($parentID == 0) {
      $parentID = NULL;
    }
    $sql = parent::$connection->prepare('UPDATE `categories` SET `category_name` = ?,`parent_id` = ? WHERE `id` = ?');
    $sql->bind_param('ssi', $categoryName, $parentID, $id);
    return $sql->execute();
  }

  public function deleteCategory($id)
  {
      $sql = parent::$connection->prepare('DELETE FROM `categories` WHERE `id` = ?');
      $sql->bind_param('i', $id);
      return $sql->execute();
  }
}
