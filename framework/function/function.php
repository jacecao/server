<?php
  // 操作MVC的总函数类
  function getPath($c_name) {
    return dirname(dirname(__FILE__)).'/libs/'.$c_name.'/';
  }
  // 控制器执行函数
  function C ($name, $method) {
    require_once(getPath('controller').$name.'Controller.class.php');
    $_c = $name.'Controller';
    $obj = new $_c();
    $obj->$method();
  }

  // 模型执行函数
  function M ($name) {
    require_once(getPath('model').$name.'Model.class.php');
    $mod = $name.'Model';
    $obj = new $mod();
    return $obj;
  }

  // 加载数据库类
  function DBclass ($name) {
    require_once(getPath('db').$name.'.class.php');
    $db = new $name();
    return $db;
  }

  // 文件操作
  function F ($name) {
    require_once(getPath('file').$name.'.class.php');
    $obj = new $name();
    return $obj;
  }

  // 视图执行函数
  function V ($name) {
    require_once(getPath('view').$name.'.class.php');
    $obj = new $name();
    return $obj;
  }

  // 转移特殊字符
  function Daddslashes ($str) {
    if (is_array($str)) {
      foreach ($str as $key => $value) {
        $str[$key] = (!get_magic_quotes_gpc()) ? addslashes($value) : $value;
        return $str;
      }
    } else {
      return (!get_magic_quotes_gpc()) ? addslashes($str) : $str;
    }
  }

?>
