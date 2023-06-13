<div class="side-bar">
  <div class="side-bar-title">DANH MỤC SẢN PHẨM</div>
  <ul class="side-list">
    <?php
    //get categories list
    $categoriesList = $categoryModel->GetAllRootCategories();
    foreach ($categoriesList as $category) {
    ?>
      <li class="side-item">
        <button type="button" class="side-link" href="#"><a href="category_pet.php?name=<?php echo $userModel->hrefFormat($category['category_name']); ?>&id=<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></a> <i class="fa-solid fa-circle-chevron-right"></i></button>

        <ul class="subside-list">
          <?php
          //get parent ID of cateogry from current parent category
          $subCategoryParentID = $category['id'];

          //get sub categories list from current category
          $subCategoriesList = $categoryModel->GetAllCategoriesByParentID($subCategoryParentID);

          foreach ($subCategoriesList as $subCategory) {
          ?>
            <li class="subside-item"><a class="subside-link" href="category_pet_type.php?name=<?php echo $model->hrefFormat($subCategory['category_name']) . "&id=" . $subCategory['id'] ?>"><i class="fa-solid fa-location-arrow"></i> <?php echo $subCategory['category_name'] ?></a></li>
          <?php
          }
          ?>
        </ul>
      </li>
    <?php
    }
    ?>
  </ul>
</div>