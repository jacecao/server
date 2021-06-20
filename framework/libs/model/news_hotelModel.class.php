<?php
  // 新闻和酒店信息数据处理模块
  class news_hotelModel {

    private $news_table = 'news'; // 数据表单
    private $hotel_table = 'hotel'; // 数据表单
    private $autumn_hotel_table = 'autumn_hotel'; // 数据表单
    private $_splite = '#'; // 设定字符串分隔符
    private $_user = ''; // 当前登录管理员信息
    private $_imgdata = null; // 图片数据更新后返回的图片信息

    public function __construct () {
      // 获取当前登录用户名
      $user = M('user');
      $this->_user = $user->getuser();
      // 创建数据表
      DB::create_table($this->news_table);
      DB::create_table($this->hotel_table);
      DB::create_table($this->autumn_hotel_table);
      // 更新当前传入图片数据
      $img_model = M('product');
      $this->_imgdata = $img_model->image_update_model();
    }
    // 图片信息重组
    // $time 如果为空就是为旧的图片信息 'new'新的图片信息
    private function reset_img ($time='') {
      $_images_id = null;
      // 将图片的id值构建为特定的字符串模型
      $date = empty($time) ? '' : '_'.$time;
      if (isset($_POST['img_id'.$date]) && is_array($_POST['img_id'.$date])) {
        foreach ($_POST['img_id'.$date] as $key => $value) {
          $_images_id .= Daddslashes($value).$this->_splite;
        }
      }
      return $_images_id;
    }
    // 重组传入新闻数据
    private function reset_data () {
      // 新旧图片信息重组
      $_images = $this->reset_img().$this->reset_img('new');
      // 构建数据模型
      $_data = array(
        'poster' => $this->_imgdata['postimg']['img_id'],
        'images' => $_images,
        'content' => Daddslashes($_POST['content']),
        'username' => $this->_user['username']
        );
      // 新闻和酒店数据唯一的区别在与新闻有title\酒店是name
      isset($_POST['title']) ? $_data['title'] = Daddslashes($_POST['title']) : $_data['name'] = Daddslashes($_POST['name']);
      return $_data;
    }

    /********************************
    **       写入数据库         **
    ********************************/
    // 写入新闻数据
    public function insert_news () {
      // 对于写入数据库的操作都要求验证是否管理员登录
      if (!empty($this->_user)) {
        $data = $this-> reset_data();
        // 构建ID值
        $_id = 'hb_'.time();
        // 写入id
        $data['id'] = $_id;
        // 写入数据库
        return DB::insert($this->news_table, $data);
      }
    }
    // 写入酒店数据
    public function insert_hotel () {
      // 对于写入数据库的操作都要求验证是否管理员登录
      if (!empty($this->_user)) {
        $data = $this-> reset_data();
        // 构建ID值
        $_id = 'hb_'.time();
        // 写入id
        $data['id'] = $_id;
        // 写入数据库
        return DB::insert($this->hotel_table, $data);
      }
    }
    // 写入秋季酒店数据
    public function insert_autumn_hotel () {
      // 对于写入数据库的操作都要求验证是否管理员登录
      if (!empty($this->_user)) {
        $data = $this-> reset_data();
        // 构建ID值
        $_id = 'hb_'.time();
        // 写入id
        $data['id'] = $_id;
        // 写入数据库
        return DB::insert($this->autumn_hotel_table, $data);
      }
    }

    /********************************
    **       修改新闻数据         **
    ********************************/
    // 新闻数据修改
    public function update_news () {
      if (!empty($this->_user)) {
        $data = $this-> reset_data();
        $id = Daddslashes($_POST['id']);
        // 注意由于新闻数据中ID是字符串，所以这里需要使用双引号加单单引号的方式将变量作为字符串变量输入
        return DB::update($this->news_table, $data, '`id`="'.$id.'"');
      }

    }
    
    /********************************
    **       修改酒店数据         **
    ********************************/
    // 酒店数据修改
    public function update_hotel () {
      if (!empty($this->_user)) {
        $data = $this-> reset_data();
        $id = Daddslashes($_POST['id']);
        return DB::update($this->hotel_table, $data, '`id`="'.$id.'"');
      }
    }
    // 秋季酒店数据修改
    public function update_autumn_hotel () {
      if (!empty($this->_user)) {
        $data = $this-> reset_data();
        $id = Daddslashes($_POST['id']);
        return DB::update($this->autumn_hotel_table, $data, '`id`= "'.$id.'"');
      }
    }

    /********************************
    **       数据的上下线处理       **
    ********************************/
    // 数据下线处理
    // $table 数据表名字
    public function del_news_hotel ($table) {
      $_update_data = array('status'=> 0, 'topvalue' => 0);
      if (!empty($this->_user)) {
        $id = Daddslashes($_POST['id']);
        if ($table == 'news') {
          return DB::update($this->news_table, $_update_data, '`id`="'.$id.'"');
        }
        if ($table == 'hotel') {
          return DB::update($this->hotel_table, $_update_data, '`id`="'.$id.'"');
        }
        if ($table == 'autumn_hotel') {
          return DB::update($this->autumn_hotel_table, $_update_data, '`id`="'.$id.'"');
        }
      }
    }
    // 数据上线处理
    // $table 数据表名字
    public function recovery_news_hotel ($table) {
      $_update_data = array('status'=> 1);
      if (!empty($this->_user)) {
        $id = Daddslashes($_POST['id']);
        if ($table == 'news') {
          return DB::update($this->news_table, $_update_data, '`id`="'.$id.'"');
        }
        if ($table == 'hotel') {
          return DB::update($this->hotel_table, $_update_data, '`id`="'.$id.'"');
        }
        if ($table == 'autumn_hotel') {
          return DB::update($this->autumn_hotel_table, $_update_data, '`id`="'.$id.'"');
        }
      }
    }

    /********************************
    ** 数据置顶操作
    ********************************/
    // 通用方法
    // 设置置顶
    private function set_top ($table_name) {
      if (!empty($this->_user)) {
        $id = Daddslashes($_POST['id']);
        // 获取当前置顶值最大数
        $sql_max_topvalue = 'SELECT MAX(`topvalue`) FROM '.$this->$table_name." WHERE `status` = 1";
        // 将返回的数组(键值对的关联数组)转换位值得索引数组
        $_max_value_arr = array_values(DB::findOne($sql_max_topvalue));
        // 取第一个索引对应值(也就是最大值)
        $_max_top_value = (int)($_max_value_arr[0]);

        // 查询当前top值设定为最大值的数据有几条
        $sql = 'SELECT `topvalue` FROM '.$this->$table_name.' WHERE `topvalue` = '.$_max_top_value;
        $data_count = count(DB::findAll($sql));
        // 修改当前数据的topvalue值
        $sql = 'SELECT `topvalue` FROM '.$this->$table_name.' WHERE `id` = "'.$id.'"';
        // 获取topvalue字段值
        try {
          $_top_value = (int)(DB::findOne($sql)['topvalue']);
          if ($data_count == 1 && $_max_top_value == $_top_value) { // 如果当前置顶的值已经是最大的值，那么不做任何操作直接返回
            return 1;
          } else {
            $_top_value ++;
            return DB::update($this->$table_name, array('topvalue' => $_top_value), '`id`="'.$id.'"');
          }
        } catch (Exception $e) {
          return 0;
        }
        
      }
    }
    // 取消置顶
    private function cancel_top ($table_name) {
      if (!empty($this->_user)) {
        try {
          // 取消当前数据的置顶
          $id = Daddslashes($_POST['id']);
          DB::update($this->$table_name, array('topvalue' => 0), '`id`="'.$id.'"');
          // 当目前置顶的数据为1条时，需要将该条的topvalue值强行设定为1
          // 查询当前设定top值的数据有几条
          $sql = 'SELECT `id`, `topvalue` FROM '.$this->$table_name.' WHERE `topvalue` <> 0';
          $_result = DB::findAll($sql);
          $data_count = count($_result);
          if ($data_count == 1 && isset($_result[0])) {
            // 获取唯一置顶数据的ID值
            $id = $_result[0]['id'];
            DB::update($this->$table_name, array('topvalue' => 1), '`id`="'.$id.'"');
          }
          return 1;
        } catch (Exception $e) {
          return 0;
        }
        
      }
    }
    /******
    ** 新闻置顶操作
    *******/
    // 新闻置顶
    public function set_top_news () {
      return $this->set_top('news_table');
    }
    // 新闻取消置顶
    public function cancel_top_news () {
      return $this->cancel_top('news_table');
    }


    /********************************
    **       获取新闻_酒店数据         **
    ********************************/
    // 通用方法获取所有数据
    private function get_all_data ($table_name) {
      $sql = 'SELECT * FROM '.$this->$table_name.' ORDER BY `createdate` DESC';
      $data = DB::findAll($sql);
      return empty($data) ? '' : $data;
    }
    // 通用获取所有在线的数据
    private function get_all_online_data ($table_name) {
      $sql = 'SELECT * FROM '.$this->$table_name.' WHERE `status` = 1 ORDER BY `topvalue` DESC,`createdate` DESC';
      $data = DB::findAll($sql);
      return empty($data) ? '' : $data;
    }
    // 通用获取所有下线的数据
    private function get_all_unline_data ($table_name) {
      $sql = 'SELECT * FROM '.$this->$table_name.' WHERE `status` = 0 ORDER BY `createdate` DESC';
      $data = DB::findAll($sql);
      return empty($data) ? '' : $data;
    }
    /********************
    **  新闻数据集处理 ***
    *********************/
    // 获取所有的新闻数据
    public function get_all_news () {
      return $this->get_all_data('news_table');
    }
    // 获取所有的在线新闻数据
    public function get_online_news () {
      return $this->get_all_online_data('news_table');
    }
    // 获取所有的下线的新闻数据
    public function get_unline_news () {
      return $this->get_all_unline_data('news_table');
    }

    /********************************
    **       获取春季酒店数据         **
    ********************************/
    // 获取所有的酒店数据
    public function get_all_hotel () {
      return $this->get_all_data('hotel_table');
    }
    // 获取所有在线的酒店数据
    public function get_online_hotel (){
      return $this->get_all_online_data('hotel_table');
    }
    // 获取所有下线的酒店数据
    public function get_unline_hotel (){
      return $this->get_all_unline_data('hotel_table');
    }

    /********************************
    **       获取春季酒店数据         **
    ********************************/
    // 获取所有的秋季酒店数据
    public function get_all_autumn_hotel () {
      return $this->get_all_data('autumn_hotel_table');
    }
    // 获取所有在线秋季酒店数据
    public function get_online_autumn_hotel (){
      return $this->get_all_online_data('autumn_hotel_table');
    }
    // 获取所有下线的酒店数据
    public function get_unline_autumn_hotel (){
      return $this->get_all_unline_data('autumn_hotel_table');
    }

    /********************************
    **       重组图片获取数据         **
    ********************************/
    // 重组输出图片id数据
    // $arr  新闻数据数组
    private function reset_imgs_id ($arr) {
      // 将字符串转为数组
      $_imgs_id = explode($this->_splite, $arr['images']);
      // 截取数组(抛弃最后一个值)
      // 因为根据reset_data()方法会在‘des’中多加一个分隔符
      $_imgs_id = array_slice($_imgs_id, 0, count($_imgs_id)-1);
      $arr['images'] = $_imgs_id;
      return $arr;
    }
    // 获取图片信息
    // 根据上面获得的图片id依次取出图片数据
    // $img_id 可能是单个也可能是多个
    // 主要针对新闻封面图片是id值，而新闻图片是一个id数组
    private function get_img_data ($img_id) {
      $imgs_data = null;
      $imgModel = M('image');
      if (is_array($img_id)) {
        for ($i = 0; $i < count($img_id); $i++) {
          // 查找数据
          $_data = $imgModel->find_by_id($img_id[$i]);
          // 判断是否是一个可用的数据
          if (is_array($_data)) {
            // 如果是那么存入$imgs_data内
            $imgs_data[] = $_data;
          }
        }
      } else {
        $_data = $imgModel->find_by_id($img_id);
        // 判断是否是一个可用的数据
        if (is_array($_data)) {
          // 如果是那么存入$imgs_data内
          $imgs_data = $_data;
        }
      }
      return $imgs_data;
    }

    // 重组图片信息
    private function put_images ($dataArr) {
      if($dataArr && count($dataArr) > 0) {
        // 将新闻中储存images的id的字符串转换为id数组
        for ($i = 0; $i < count($dataArr); $i++) {
          $dataArr[$i] = $this -> reset_imgs_id($dataArr[$i]);
          // 根据poster的id值获取图片
          $dataArr[$i]['poster'] = $this -> get_img_data($dataArr[$i]['poster']);
          // 根据imges的id值获取图片
          $dataArr[$i]['images'] = $this -> get_img_data($dataArr[$i]['images']);
        }
        return $dataArr;
      } else {
        return array(
          'status' => FALSE,
          'data' => NULL,
        );
      }
      
    }

    // 将图片id值替换为图片数据信息加入新闻数据模块中
    // 转换指定的新闻模块信息 为json储存做好准备
    public function get_image_news ($max=6) {
      // 获取所有的新闻数据
      $allNews = $this->get_online_news();
      // 如果数据超过指定个数
      // 那么需要截取掉
      if (count($allNews) > $max) {
        $allNews = array_slice($allNews, 0, $max);
      }
      // 数据中加入图片
      return $allNews = $this->put_images($allNews);
    }

    public function get_image_hotel ($max=8) {
      // 获取所有的新闻数据
      $allHotel = $this->get_all_hotel();
      // 如果数据超过指定个数
      // 那么需要截取掉
      if (count($allHotel) > $max) {
        $allNews = array_slice($allHotel, 0, $max);
      }
      // 数据中加入图片
      return $allHotel = $this->put_images($allHotel);
    }
    
    public function get_image_autumn_hotel ($max=8) {
      // 获取所有的新闻数据
      $allHotel = $this->get_all_autumn_hotel();
      // 如果数据超过指定个数
      // 那么需要截取掉
      if (count($allHotel) > $max) {
        $allHotel = array_slice($allHotel, 0, $max);
      }
      // 数据中加入图片
      return $allHotel = $this->put_images($allHotel);
    }

    // 根据id值获取新闻完整数据
    // $table 数据表名字
    public function get_by_id ($table, $id) {
      if ($table == 'news') {
        $sql = 'SELECT * FROM '.$this->news_table.' WHERE `id`="'.$id.'"';
      }
      if ($table == 'hotel') {
        $sql = 'SELECT * FROM '.$this->hotel_table.' WHERE `id`="'.$id.'"';
      }
      if ($table == 'autumn_hotel') {
        $sql = 'SELECT * FROM '.$this->autumn_hotel_table.' WHERE `id`="'.$id.'"';
      }
      $data = DB::findOne($sql);
      if (!empty($data)) {
        // 转换图片id
        $data = $this->reset_imgs_id($data);
        // 获取图片完整数据
        $data['poster'] = $this->get_img_data($data['poster']);
        $data['images'] = $this->get_img_data($data['images']);
        return $data;
      } else {
        return false;
      }
    }


    /**************************************
    **  获取数据总数目
    **************************************/
    // 获取酒店信息总数
    public function total_hotels () {
      $sql_a = 'SELECT * FROM '.$this->hotel_table;
      $sql_b = 'SELECT * FROM '.$this->autumn_hotel_table;
      return DB::num_rows($sql_a) + DB::num_rows($sql_b);
    }

    // 获取新闻信息总数
    public function total_news () {
      $sql = 'SELECT * FROM '.$this->news_table;
      return DB::num_rows($sql);
    }

    /************************************
    ** 获取数据分页信息
    ************************************/
    // 新闻
    public function pageList_news ($pageNo=0, $pageSize=10, $status = 1) {
      $res = DB::pageList($pageNo, $pageSize, $status, $this->news_table);

      if (!$res) {
        return false;
      } else {
        // 在新闻数据中读取图片信息，加入到数据中
        return $this->put_images($res);
      }
    }

  }
?>
