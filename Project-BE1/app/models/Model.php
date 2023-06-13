<?php
class Model
{
  public static $connection = NULL;

  public function __construct()
  {
    if (!self::$connection) {
      !self::$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      !self::$connection->set_charset('utf8mb4');
    }
    return self::$connection;
  }

  public function select($sql)
  {
    $items = [];
    $sql->execute();
    $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    return $items;
  }

  //format href
  public function hrefFormat($str)
  {
    $unicode = array(
      'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
      'd' => 'đ',
      'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
      'i' => 'í|ì|ỉ|ĩ|ị',
      'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
      'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
      'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
      'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
      'D' => 'Đ',
      'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
      'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
      'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
      'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
      'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );

    foreach ($unicode as $nonUnicode => $uni) {
      $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    $str = trim($str);
    $str = preg_replace('/\s+/', ' ', $str);
    $str = str_replace(' ', '-', $str);
    $str = str_replace('~-{2,}~', '-', $str);
    $str = strtolower($str);
    return $str;
  }

  //định dạng tiền VND
  function currencyFormat($number, $suffix = 'đ')
  {
    if (!empty($number)) {
      return number_format($number, 0, ',', '.') . "{$suffix}";
    }
  }
  
  //tách từ khóa trong tên
  function getKeyByName($name)
  {
    $explodeFullName = explode(' ', $name);
    return $explodeFullName[0];
  }
}
