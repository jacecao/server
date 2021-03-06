<?php
  // 引入文件清单变
  include_once('include.list.php');
  foreach ($requireFiles as $requireFile) {
    # code...
    include_once($requireFile);
  }

  class PC {


    public static $controller;
    public static $method;
    private static $config;


    // 初始数据引擎
    private static function init_db () {
      DB::init('mysql', self::$config['dbConfig']);
    }

    // 初始视图引擎
    private static function init_view () {
      VIEW::init('Smarty', self::$config['viewConfig']);
    }

    // 初始文件操作
    private static function init_file () {
      FILE::init('fileModel', self::$config['fileConfig']);
    }

    // 初始加载控制器
    private static function init_controller () {
      // 初始载入admin主控制
      self::$controller = isset($_GET['controller']) ?  Daddslashes($_GET['controller']) : 'admin';
    }
    // 初始加载控制器方法
    private static function init_method () {
      // 初始载入登录模块
      self::$method = isset($_GET['method']) ? Daddslashes($_GET['method']) : 'login';
    }
    public static function run ($config) {
      self::$config = $config;
      self::init_db();
      self::init_view();
      self::init_file();
      self::init_controller();
      self::init_method();
      C(self::$controller, self::$method);
    }

  }
?>
