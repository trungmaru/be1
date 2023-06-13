<?php
class PetModel extends Model
{
    public function getAllPets()
    {
        $sql = parent::$connection->prepare('SELECT *, COUNT(pets_users_like.user_id) AS pet_like FROM `pets` LEFT JOIN pets_users_like ON pets.id = pets_users_like.pet_id GROUP BY pets.id');
        return parent::select($sql);
    }

    public function getPetById($id)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `pets` WHERE `id` = ?');
        $sql->bind_param('i', $id);
        return parent::select($sql)[0];
    }

    public function getPetByIds($arrID)
    {
        $questionMark = "";
        for ($i = 0; $i < count($arrID) - 1; $i++) {
            $questionMark .= '?, ';
        }
        $questionMark .= '?';
        $i = str_repeat('i', count($arrID));
        $sql = parent::$connection->prepare("SELECT * FROM `pets` WHERE id IN ($questionMark) ORDER BY FIELD(id, $questionMark)");
        $sql->bind_param($i . $i, ...$arrID, ...$arrID);
        return parent::select($sql);
    }
    public function getPopularPets()
    {
        $sql = parent::$connection->prepare('SELECT * FROM `pets` ORDER BY `pet_view` DESC LIMIT 0,4');
        return parent::select($sql);
    }
    public function getTopLikePets()
    {
        $sql = parent::$connection->prepare('SELECT *, COUNT(pets_users_like.user_id) AS pet_like FROM `pets` LEFT JOIN pets_users_like ON pets.id = pets_users_like.pet_id GROUP BY pets.id ORDER BY pet_like DESC');
        return parent::select($sql);
    }
    public function getPetsByCategoryID($categoryID)
    {
        $sql = parent::$connection->prepare('SELECT *, COUNT(pets_users_like.user_id) AS pet_like FROM `pets` LEFT JOIN pets_users_like ON pets.id = pets_users_like.pet_id WHERE `category_id` = ? GROUP BY pets.id');
        $sql->bind_param('i', $categoryID);
        return parent::select($sql);
    }

    public function getPetByRelatedName($relatedName)
    {
        $relatedName = parent::getKeyByName($relatedName);
        $sql = parent::$connection->prepare('SELECT *, COUNT(pets_users_like.user_id) AS pet_like FROM `pets` LEFT JOIN pets_users_like ON pets.id = pets_users_like.pet_id WHERE `pet_name` LIKE ? GROUP BY pets.id LIMIT 4');
        $relatedName = "%{$relatedName}%";
        $sql->bind_param('s', $relatedName);
        return parent::select($sql);
    }

    public function getPetsByPage($page, $perPage)
    {
        $start = ($page - 1) * $perPage;
        $sql = parent::$connection->prepare('SELECT *, COUNT(pets_users_like.user_id) AS pet_like FROM `pets` LEFT JOIN pets_users_like ON pets.id = pets_users_like.pet_id GROUP BY pets.id LIMIT ?, ?');
        $sql->bind_param('ii', $start, $perPage);
        return parent::select($sql);
    }

    public function getTotalPets()
    {
        $sql = parent::$connection->prepare('SELECT COUNT(id) AS `total_pets` FROM `pets`');
        return parent::select($sql)[0]['total_pets'];
    }

    public function checkUserLike($petID, $userID)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `pets_users_like` WHERE `pet_id` = ? AND `user_id` = ?');
        $sql->bind_param('ii', $petID, $userID);
        $check = parent::select($sql);
        if (!empty($check[0])) {
            return true;
        }
        return false;
    }

    public function addPet($petName, $petPrice, $petPhoto, $petDescription, $categoryID)
    {
        if ($petPhoto == "") {
            $petPhoto = "default.jpg";
        }
        if ($petDescription == "") {
            $petDescription = "Không có mô tả";
        }
        $sql = parent::$connection->prepare('INSERT INTO `pets`(`pet_name`, `pet_price`, `pet_photo`, `pet_description`, `category_id`) VALUES (?, ?, ?, ?, ?)');
        $sql->bind_param('sissi', $petName, $petPrice, $petPhoto, $petDescription, $categoryID);
        return $sql->execute();
    }

    public function deletePet($id)
    {
        $sql = parent::$connection->prepare('DELETE FROM `pets` WHERE `id`= ?');
        $sql->bind_param('i', $id);
        return $sql->execute();
    }

    public function updatePet($petName, $petPrice, $petPhoto, $petDescription, $categoryID, $id)
    {
        $sql = parent::$connection->prepare('UPDATE `pets` SET `pet_name`= ?, `pet_price`= ?, `pet_photo`= ?,`pet_description`= ?, `category_id`= ?,`time_create` = NOW() WHERE `id` = ?');
        $sql->bind_param('sissii', $petName, $petPrice, $petPhoto, $petDescription, $categoryID, $id);
        return $sql->execute();
    }

    public function updatePetView($id)
    {
        $sql = parent::$connection->prepare('UPDATE `pets` SET `pet_view` = `pet_view` + 1 WHERE `id`=?');
        $sql->bind_param('i', $id);
        return $sql->execute();
    }

    public function updatePetLikeUser($petID, $userID)
    {
        $sql = parent::$connection->prepare('INSERT INTO `pets_users_like`(`pet_id`, `user_id`) VALUES (?, ?)');
        $sql->bind_param('ii', $petID, $userID);
        return $sql->execute();
    }

    public function updatePetUnLikeUser($petID, $userID)
    {
        $sql = parent::$connection->prepare('DELETE FROM `pets_users_like` WHERE `pet_id` = ? AND `user_id` = ?');
        $sql->bind_param('ii', $petID, $userID);
        return $sql->execute();
    }
}
