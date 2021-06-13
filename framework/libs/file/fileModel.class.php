<?php
  // 文件的处理
  class fileModel {

    // 允许上传的文件后缀名
    private static $allowSuffix = array('gif', 'jpeg', 'jpg', 'png', 'txt', 'json');
    // 允许上传文件的大小
    private static $maxsize = 628800;
    // 初始目标出存储文件夹
    private static $path;
    // web引用地址
    private static $url;
    // 图片资源路径
    private static $_img = 'images/';
    // json资源路径
    private static $_json = 'static/data/';

    // 获取文件后缀
    private function getSuffix ($filename) {
      return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    }
    // 随机文件名
    private function getUniqidName ($length = 10) {
      return substr(md5(uniqid(microtime(true), true)), 0, $length);
    }

    public function init ($config) {
      self::$path = $config['path'];
      self::$url = $config['url'];
    }

    // 上传文件
    public function upload ($fileinfo, $dir) {
      // 变量$up初始位false
      // echo 'upload_test_fileModel'.$dir;
      // 只有当文件上传成功后才位true
      $up = false;
      // 重定向路径
      $path = self::$path.self::$_img;
      $url = self::$url.self::$_img;
      // 开始读取上传文件信息
      if ($fileinfo['error'] === UPLOAD_ERR_OK) {
        // 检查目标文件夹是否存在
        $targetdir = $path.$dir;
        if (!file_exists($targetdir)) {
          mkdir($targetdir, 0777, true);
        }
        // 文件是否是通过HTTP POST方式上传来的 以及上传的是否为一张图片
        if (is_uploaded_file($fileinfo['tmp_name']) && getimagesize($fileinfo['tmp_name'])) {
          // 限制上传文件的类型
          $suffix = $this->getSuffix($fileinfo['name']);
          $_id = $this->getUniqidName();
          // 上传文件储存路径
          // $_name = pathinfo($fileinfo['name'], PATHINFO_FILENAME);
          $newname = 'tjhzs_'.$_id.'.'.$suffix;
          $newpath = $targetdir.'/'.$newname;
          if (in_array($suffix, self::$allowSuffix)) {
            // 限制上传文件的大小
            if ($fileinfo['size'] <= self::$maxsize) {
              // 获取上传文件
              if (move_uploaded_file($fileinfo['tmp_name'], $newpath)) {
                $mes = '文件上传成功';
                $up = true;
              } else {
                $mes = '内存文件移动失败';
              }
            } else {
              $mes = '文件过大';
            }
          } else {
            $mes = '非法文件类型';
          }
        } else {
          $mes = $fileinfo['name'].'上传途径非法';
        }
      } else {
        switch ($fileinfo['error']) {
          // 0——没有错误发生，文件上传成功。。
          case 1:
            $mes = '上传的文件超过系统要求大小';
            break;
          case 2:
            $mes = '上传文件的太大啦';
            break;
          case 3:
            $mes = '文件只有部分被上传';
            break;
          case 4:
            $mes = '上传文件失败';
            break;
        }
      }
      // 上传后的文件信息
      $upinfo = array(
        'url'=> $url.$dir.'/'.$newname, // 文件引用地址需要存入数据库
        'path'=> $targetdir.'/'.$newname, // 文件真实地址方便后期删除
        'name'=> $newname, // 新的文件名
        'mes'=> $mes, // 返回上传结果信息
        'dir'=> $dir
      );
      return $up ? array('status'=>true, 'upinfo'=>$upinfo) : array('status'=>false, 'mes'=>$mes);
    }

    // 删除文件
    public function delfile ($filename) {
      $name = basename($filename);
      $status = false;
      // 如果是文件就直接删除
      if (is_file($filename)) {
        if (unlink($filename)) {
          $mes = $name . "删除成功";
          $status = true;
        } else {
          $mes = $name . "删除失败";
          $status = false;
        }
      }
      if (is_dir($filename)) {
        // 打开目录
        $handle = opendir($filename);
        // 读取目录内的内容
        while (($item = readdir($handle)) !== false) {
          // 排除'.'与'..'特殊路径
          if ($item != '.' && $item != '..') {
            $mes = delFile($filename.'/'.$item);
          }
        }
        closedir($handle);
        $mes = rmdir($filename) ? $name.'删除成功' : $name.'删除失败';
        $status = rmdir($filename) ? true : false;
      }
      return $status;
    }

    // 获取JSON文件内容
    public function getjson ($filename) {
      $path = self::$path.self::$_json;
      $filepath = $path.$filename.'.json';
      $data = null;
      if (file_exists($filepath)) {
        // 从json文件中读取数据
        $json_string = file_get_contents($filepath);
        // 把json字符转换为PHP数组
        $data = json_decode($json_string, true);
      }
      return $data;
    }

    // 将数据写入json文件
    public function writejson ($filename, $arr) {
      $path = self::$path.self::$_json;
      $filepath = $path.$filename.'.json';
      // 把PHP数组转成JSON字符串
      $json_string = json_encode($arr);
      return file_put_contents($filepath, $json_string);
    }

  }
?>
