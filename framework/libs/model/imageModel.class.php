
<?php
  // 所有图片存储读取处理
  class imageModel {

    private $_table = 'images'; // 定义表名

    public function __construct () {
      // 检查表单是否创建
      DB::create_table($this->_table);
      // session_start();
      if (isset($_SESSION['user']) && (!empty($_SESSION['user']))) {

      }
      session_write_close();
    }

    // 添加图片数据
    public function insert_img ($upinfo) {
      // $upinfo来自filemode中定义好的$upinfo
      // 上传后的文件信息
      // $upinfo = array(
      //   'url'=> $url.$dir.'/'.$newname, // 文件引用地址需要存入数据库
      //   'path'=> $targetdir.'/'.$newname, // 文件真实地址方便后期删除
      //   'name'=> $newname, // 新的文件名
      //   'mes'=> $mes, // 返回上传结果信息
      //   'dir'=> $dir
      // );
      $arr = array(
        'name' => $upinfo['name'],
        'path' => $upinfo['path'],
        'url' => $upinfo['url'],
        'dir' => $upinfo['dir']
      );
      return DB::insert($this->_table, $arr);
    }

    // 获取指定图片
    public function find_by_dir ($dir) {
      $sql = 'SELECT * FROM '.$this->_table.' WHERE `dir`="'.$dir.'" ORDER BY `date` DESC';
      return DB::findAll($sql);
    }

    // 根据id获取图片
    public function find_by_id ($id) {
      $sql = 'SELECT * FROM '.$this->_table.' WHERE `id`="'.$id.'"';
      $data = DB::findOne($sql);
      return empty($data) ? '' : $data;
    }

    // 修改图片数据
    public function update_img ($arr) {
      $id = $arr['id'];
      $_arr = array(
        'desc' => $arr['desc'] ? $arr['desc'] : 'no message',
        'used' => 1
        );
      return DB::update($this->_table, $_arr, 'id='.$id);
    }

    // 获取图片总数
    public function total_images () {
      $sql = 'SELECT * FROM '.$this->_table;
      return DB::num_rows($sql);
    }

    // 自定义数组排序函数
    private function compare_key ($a, $b) {
      if (strlen($a) > strlen($b)) {
        return 1;
      } else if (strlen($a) < strlen($b)) {
        return -1;
      } else {
        return 0;
      }
    }
    // 获取当前图片类别
    public function get_images_category() {
      // 查询当前图片的所有类
      $sql = 'SELECT `dir` FROM '.$this->_table.' GROUP BY `dir`';
      $res = DB::findAll($sql);
      // 将得到的数据重组为只包含类名称的数组
      $res_arr = array();
      if ($res && is_array($res) && count($res) > 0) {
        foreach ($res as $key => $value) { // 遍历索引数组
          foreach ($value as $_key => $_value) { // 这一层得到键值对数组"dir"=>"value"
            switch ($_value) {
              case 'header':
                $res_arr[$_value] = '网页顶部图片';
                break;
              case 'hotel':
                $res_arr[$_value] = '酒店图片';
                break;
              case 'news':
                $res_arr[$_value] = '新闻图片';
                break;
              case 'chun_huizhan':
                $res_arr[$_value] = '春季会展中心图片';
                break;
              case 'qiu_huizhan':
                $res_arr[$_value] = '秋季会展中心图片';
                break;
            }
          }
        }
      }
      // 对分类数组进行自定义排序，按类的字符串长度排序
      // 这里需要将类中函数作为参数变量传入时，需用通过数组传参的方式来
      // 否则就会出现错误 uksort($res_arr, 'compare_key'),这样就会出现问题
      uksort($res_arr, array($this, 'compare_key'));
      return $res_arr;
    }

    // 按类获取图片列表
    public function getImgsByDir() {
      if ( isset($_GET['dir']) ) {
        $_dir = Daddslashes($_GET['dir']);
        $_img_arr = $this->find_by_dir($_dir);
        if ($_img_arr) {
          return $_img_arr;
        } else {
          echo 0;
        }
      } else {
        echo 0;
      }
    }


  }
?>
