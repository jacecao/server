<?php
  // # 后台入口文件
  header('Content-type: text/html; charset=utf-8');
  ini_set('display_errors', 'On');
  date_default_timezone_set("PRC"); // 设置当前服务器时间时区
  session_start();
  require_once(realpath(dirname(dirname(__FILE__))).'/framework/config.php');
  require_once(realpath(dirname(dirname(__FILE__))).'/framework/pc.php');
  PC::run($config);
?>
