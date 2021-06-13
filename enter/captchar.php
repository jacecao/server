<?php
  session_start();
  $capth_code = '';
  // GD创建图片(画布)
  $image = imagecreatetruecolor(100, 30);
  // 设置背景颜色
  $white = imagecolorallocate($image, 220, 220, 220);
  // 填充颜色
  imagefill($image, 0, 0, $white);
  // 产生4个随机数
  /*
  for ($i = 0; $i < 4; $i++) {
    // 字体大小
    $fontsize = 6;
    // 字体颜色，随机生产不同的颜色
    $fontcolor = imagecolorallocate($image, rand(0, 120), rand(0, 120), rand(0, 120));
    // 产生的0-9的随机数
    $fontcontent = rand(0,9);
    // 随机坐标值, 避免生成的数字位置重合
    $x = ($i * 100 / 4) + rand(5, 10);
    $y = rand(5, 10);
    imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);
  }
  */
  // 字母加数字
  for ($i = 0; $i < 4; $i++) {
    $fontsize = 6;
    $fontcolor = imagecolorallocate($image, rand(0, 120), rand(0, 120), rand(0, 120));
    // 生成内容的字典
    // 同时将l 1 o 0 2 z去掉防止识别错误
    $data = 'abcdefghijkmnpqrstuvwxy3456789';
    $fontcontent = substr($data, rand(0, strlen($data) - 1), 1);
    $capth_code .= $fontcontent;
    $x = ($i * 100 / 4) + rand(5, 10);
    $y = rand(5, 10);
    imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);
  }
  // 保存到SESSION中
  $_SESSION['usercode'] = $capth_code;
  // 增加干扰元素
  // 增加干扰点
  for ($j = 0; $j < 300; $j ++) {
    $pointcolor = imagecolorallocate($image, rand(50, 200), rand(50, 200), rand(50, 200));
    imagesetpixel($image, rand(1, 99), rand(1, 99), $pointcolor);
  }
  // 增加干扰线
  for($k = 0; $k < 3; $k ++) {
    $linecolor = imagecolorallocate($image, rand(80, 220), rand(80, 220), rand(80, 220));
    imageline($image, rand(1, 99), rand(1, 29), rand(1, 99), rand(1, 29), $linecolor);
  }
  session_write_close();

  // 输出图片头信息
  header('Content-type: image/png');
  imagepng($image);
  // 销毁图片信息
  imagedestroy($image)
?>
