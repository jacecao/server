<?php
  // 模块显示控制
class displayController {
 // 保存当前登录用户名
  public $user = '';
  // 初始执行方法
  public function __construct () {
    // 判断当前是否已经登录->auth模型来处理
    // 如果没有登录就需要跳转到登录页
    $userObj = M('user');
    $this->user = $userObj->getuser();
  }

  public function display_autumn_hotel() {
  	$bool = $_POST['display'] == 'false' ? 0 : 1;
  	echo FILE::writePartJson('display_config', array("display_autumn_hotel", $bool));
  }

  public function display_spring_hotel() {
  	$bool = $_POST['display'] == 'false' ? 0 : 1;
  	echo FILE::writePartJson('display_config', array("display_spring_hotel", $bool));
  }
}
?>	