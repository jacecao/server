<?php
  // 视图操作类
  class VIEW {

    public static $view;
    // 配置模板引擎
    public static function init ($viewtype, $config) {
      self::$view = V($viewtype);
      // 加入配置
      foreach ($config as $key => $value) {
        # code...
        self::$view -> $key($value);
      }
    }

    //# 模板变量注册
    // $data = array('key'=>'value')
    public static function assign ($data) {
      foreach ($data as $key => $value) {
        # code...
        self::$view->assign($key, $value);
      }
    }

    //# 驱动模板
    public static function display ($tpl) {
      self::$view->display($tpl);
    }


  }

?>
