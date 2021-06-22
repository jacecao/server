<?php
// echo phpinfo();
echo $_SERVER['DOCUMENT_ROOT'];
echo '<br>';
echo dirname($_SERVER['DOCUMENT_ROOT']);
// echo '<br>';
// echo __FILE__;
// echo '<br>';
// echo realpath(__FILE__);
// echo '<br>';
// echo realpath(dirname(dirname(__FILE__))) ;

/*
$dbConfig = array(
  'dbhost' => '127.0.0.1:3306',
  'dbuser' => 'root',
  'dbpsw' => '',
  'dbname' => 'tjhzs',
  // 每次连接设置数据编码，保证前后端数据传输一致，防止乱码
  'dbcharset' => 'utf8'
);

$dsn = 'mysql:host='.$dbConfig['dbhost'].';dbname='.$dbConfig['dbname'].'; charset=utf8';
$option = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
);

try {
	$db = new PDO($dsn, $dbConfig['dbuser'], $dbConfig['dbpsw'], $option);
	echo '连接成功';
} catch (PDOException $e){
	echo '连接失败'.$e->getMessage();
}
*/
$_arr = array();

$_arr['key'] = 1;

var_dump($_arr);

$_arr['key_2'] = 3;

var_dump($_arr);

$_int_1 = 1;
echo "$_int_1";


class Getdefine {
  private $site = 1;
  public function get ($v) {
    echo $this->$v;
  }
}

$GG =  new Getdefine();
$GG-> get('site');
echo'<hr/>';
// 自定义数组排序，键名排序
$_test_arr = array(
  "chun_huizhan" => '1',
  "header" => '3',
  "hotel" => '4',
  "news" => '5',
  "qiu_huizhan" => '2',
);
var_dump($_test_arr);
echo'<hr/>';
function compare_key($a, $b) {
  if (strlen($a) > strlen($b)) {
    return 1;
  } else if (strlen($a) < strlen($b)) {
    return -1;
  } else {
    return 0;
  }
}
uksort($_test_arr, $this-);

var_dump($_test_arr);