<?php
// namespace Config;
// 获取服务文件的真实路径
$sys_real_path = realpath(dirname(dirname(__FILE__)));
// 总配置文件
$config = array(

  'viewConfig' => array(
    'setTemplateDir' => $sys_real_path.'/smart_dir/tpl',
    'setCompileDir' => $sys_real_path.'/smart_dir/template_c',
    'setCacheDir' => $sys_real_path.'/smart_dir/cache'
  ),

  'dbConfig' => array(
    'dbhost' => '127.0.0.1:3306',
    'dbuser' => 'root',
    'dbpsw' => '',
    'dbname' => 'tjhzs',
    // 每次连接设置数据编码，保证前后端数据传输一致，防止乱码
    'dbcharset' => 'utf8'
  ),

  'fileConfig' => array(
    // 网页主目录物理路径
    'path' => $_SERVER['DOCUMENT_ROOT']."/",
    // 相对地址
    'url' => '/'
  )

);

?>
