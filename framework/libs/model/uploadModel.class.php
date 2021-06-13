<?php
  // 上传文件模型
  class uploadModel {

    private static $fileinfo;

    public function __construct () {
      self::$fileinfo = isset($_FILES['up_file'])? $_FILES['up_file'] : '';
    }

    private function check() {
      return empty(self::$fileinfo)? false : true;
    }

    // 图片上传
    public function up ($method) {
      if ($this->check()) {
        $fun = $method.'Up';
        return FILE::$fun(self::$fileinfo);
      } else {
        return false;
      }
    }

  }

?>
