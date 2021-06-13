<?php
  class productModel {

    // 图片信息重组方法
    // $name 用于区别普通图片还是封面或logo
    // $time 用于区别为新的图片信息还是旧的图片信息
    // 默认为旧的图片信息
    private function build_data ($name, $time='') {
      $arr = null;
      $date = empty($time) ? '' : '_'.$time;
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && $name == 'img' && isset($_POST['img_id'.$date])) {
        foreach ($_POST as $key => $value) {
          if ($key == 'img_desc'.$date || $key == 'img_id'.$date || $key == 'img_url'.$date ||$key == 'img_name'.$date) {
            if (is_array($arr)) {
              for ($i = 0; $i < count($arr); $i++) {
                if (is_array($value)) {
                  $arr[$i][$key] = Daddslashes($value[$i]);
                } else {
                  $arr[$i][$key] = Daddslashes($value);
                }
              }
            } else {
              foreach ($value as $_val) {
                $arr[] = array($key=>$_val);
              }
            }
          }
        }
      }
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && $name == 'post' && isset($_POST['post_id'.$date])) {
        $arr = array( array(
          'post_desc'.$date => $_POST['post_desc'],
          'post_id'.$date => $_POST['post_id'.$date],
          'post_url'.$date => $_POST['post_url'.$date],
          'post_name'.$date => $_POST['post_name'.$date],
          )
        );
      }
      return $arr;
    }

    // 重组图片数据格式
    // $type 给出当前数据的特征是img 还是 post
    // $time 是新的数据还是原始数据
    private function retype ($imgsarr, $type, $time="") {
      $arr = null;
      $date = empty($time) ? '' : '_'.$time;
      if (is_array($imgsarr)) {
        foreach ($imgsarr as $key => $value) {
          $arr[$key]['img_id'] = $value[$type.'_id'.$date];
          $arr[$key]['img_url'] = $value[$type.'_url'.$date];
          $arr[$key]['img_name'] = $value[$type.'_name'.$date];
          $arr[$key]['img_desc'] = $value[$type.'_desc'.$date] ? $value[$type.'_desc'.$date] : "";
        }
      }
      return $arr;
    }

    // 图片数据信息重组
    private function reset () {
      // 重组图片数据信息
      $newimg = $this->build_data('img', 'new');
      $img = $this->build_data('img');
      // 重组海报或logo图片信息
      $newpost = $this->build_data('post', 'new');
      $post = $this->build_data('post');

      return array(
        'newimg'=>$this->retype($newimg, 'img', 'new'),
        'img'=>$img,
        'newpost'=>$this->retype($newpost, 'post', 'new'),
        'post'=>$this->retype($post, 'post')
      );
    }

    // 升级图片库数据
    private function update ($arr) {
      $imgarr = array();
      foreach ($arr as $key => $value) {
        $imgarr['id'] = $value['img_id'];
        $imgarr['desc'] = $value['img_desc'];
        $imgObj = M('image');
        $imgObj->update_img($imgarr);
      }
    }

    // 数据总控制器
    private function dataCONTROL () {
      $imgArr = $this->reset();
      // 海报图片或logo一个页面只存在一个
      // 所以这里只有一种情况要么新的海报信息要么就是旧的海报信息
      $postimg = $imgArr['post'] ? $imgArr['post'] : $imgArr['newpost'];
      $img = $imgArr['img'] ? $imgArr['img'] : array();
      // 将新的图片信息写入数据库
      if ($imgArr['newimg']) {
        $this->update($imgArr['newimg']);
        $img = array_merge($imgArr['newimg'], $img);
      }
      if ($imgArr['newpost']) {
        $this->update($imgArr['newpost']);
      }
      // 最后返回所有的海报和图片
      return array(
        'postimg' => $postimg[0],
        'images'=> $img
      );
    }

    // 外部获取图片数组更新模块
    public function image_update_model () {
      return $this->dataCONTROL();
    }

    // 读取json数据
    public function read_json ($name) {
      // 返回php数组
      return FILE::getJson($name);
    }

    /********************************
    **  header信息数据结构模型     **
    ********************************/
    private function header_model () {
      $imagedata = $this->dataCONTROL();
      // 检查页面是否勾选了需要显示时间框
      $_show_time = isset($_POST['showtime']) ? true: false;
      /* 这里需要将封面图片和内容图片进行重组，原始这里的数据只是一张图片的数据
      // 现在改成多张图片，就将封面图片和内容图片进行数据重做
      */
      $images_reset = $imagedata['postimg'] ? array_merge(array($imagedata['postimg']), $imagedata['images']) : $imagedata['images'];
      // 重组数据结构
      $res = array(
        'city' => Daddslashes($_POST['city']),
        'addr' => Daddslashes($_POST['addr']),
        'season' => Daddslashes($_POST['season']),
        'zhuban' => Daddslashes($_POST['zhuban']),
        'chenban' => Daddslashes($_POST['chenban']),
        'xieban' => Daddslashes($_POST['xieban']),
        'readytime' => Daddslashes($_POST['readytime']),
        'starttime' => Daddslashes($_POST['starttime']),
        'showtime' => $_show_time,  
        'bgimg' => $images_reset
      );
      return FILE::writeJson('headerinfo', $res);
    }
    // 写入头部信息数据
    public function  write_header () {
      return $this->header_model();
    }


    /********************************
    **     会展图文结构模型     **
    ********************************/
    private function huizhan_model ($style) {
      // 获取图片数据
      $imagedata = $this->dataCONTROL();
      // 记录当前内容是否需要显示
      $_display = isset($_POST['isshow']) ? true: false;
      // 重组数据结构
      $res = array(
        'display' => $_display,
        'name' => Daddslashes($_POST['name']),
        'content' => Daddslashes($_POST['content']),
        'poster' => $imagedata['postimg'],
        'images' => $imagedata['images']
      );
      return FILE::writeJson('huizhan_'.$style, $res);
    }
    // 写入头部信息数据
    public function  write_huizhan ($style) {
      return $this->huizhan_model($style);
    }


    /********************************
    **     产品数据结构模型        **
    ********************************/
    // $title 标题
    // $name  需要写入数据的json文件 首字母大写
    private function product_model ($title, $name) {
      $imagedata = $this->dataCONTROL();
      // 重组数据结构
      $res = array(
        'title'=> $title,
        'logo'=> $imagedata['postimg'],
        'note'=> Daddslashes($_POST['header_note']),
        'show'=> array(
          'title'=> $title.'案例展示',
          'note'=> Daddslashes($_POST['show_note']),
          'ad'=> Daddslashes($_POST['bottom_note']),
          'images'=> $imagedata['images']
        )
      );
      return FILE::writeJson('product'.$name, $res);
    }
    // 写入广告展示数据
    public function write_show () {
      return $this->product_model('展示设计', 'Show');
    }

    // 写入广告制作数据
    public function write_ad () {
      return $this->product_model('广告制作', 'Make');
    }

    // 写入活动推广数据
    public function write_ac () {
      return $this->product_model('活动推广', 'Activity');
    }


    /********************************
    **   导航条信息数据结构模型    **
    ********************************/
    private function nav_model () {
      // $imagedata = $this->dataCONTROL();
      // 重组数据结构
      $res = array(
        'backgroundColor' => Daddslashes($_POST['color']),
        'title' => Daddslashes($_POST['title']),
        'fixed' => Daddslashes($_POST['position']) == 'true' ? true : false,
        'backgroundImage' => '',
      );
      return FILE::writeJson('navbar', $res);
    }

    // 写入导航条信息数据
    public function  write_nav () {
      return $this->nav_model();
    }

    /********************************
    **     关于我们数据结构模型    **
    ********************************/
    private function about_model () {
      // $imagedata = $this->dataCONTROL();
      // 重组数据结构
      $res = array(
        'tjhzs' => array(
          array(
            'title'=> '我们的愿景',
            'content'=> Daddslashes($_POST['future_note'])
          ),
          array(
            'title'=> '关于我们',
            'content'=> Daddslashes($_POST['about_note'])
          ),
        )
      );
      return FILE::writeJson('about', $res);
    }
    // 写入关于我们数据
    public function write_about () {
      return $this->about_model();
    }


    /********************************
    **     footer数据结构模型     **
    ********************************/
    // 注意这里id是根据元素组件实现拟定好的
    // 可参考common.js里各模块的规范
    private function blockdata ($id) {
      if (isset($_POST['is_link_'.$id])) {
        $block = array(
          'title' => Daddslashes($_POST['title_'.$id]),
          'smalltitle' => Daddslashes($_POST['small_title_'.$id]),
          'link' => true,
          'url' => Daddslashes($_POST['link_url_'.$id]),
          );
      } else {
        $block = array(
          'title' => Daddslashes($_POST['title_'.$id]),
          'smalltitle' => Daddslashes($_POST['small_title_'.$id]),
          'link' => false,
          );
      }
      return $block;
    }

    private function footer_model () {
      $blockdata = array(
        $this->blockdata(1),
        $this->blockdata(2)
        );
      // 重组数据结构
      $res = array(
        'webinfo' => array(
          'name'=> Daddslashes($_POST['name']),
          'address'=> Daddslashes($_POST['address']),
          'number'=> Daddslashes($_POST['number']),
          'version'=> "2017-0.0.1"
          ),
        'blockinfo' => $blockdata
      );
      return FILE::writeJson('footer', $res);
    }
    // 写入关于我们数据
    public function write_footer () {
      return $this->footer_model();
    }

    /********************************
    **       招聘数据结构模型     **
    ********************************/
    public function write_job () {
      $job = M('job');
      $data = $job->find_all();
      return FILE::writeJson('jobs', $data);
    }

    /********************************
    **       写入招聘联系人JSON文件     **
    ********************************/
    public function write_job_contact() {
      $job = M('job');
      $data = $job->get_job_contact_data();
      if ($data) {
        return FILE::writeJson('email', $data);
      } else {
        return 0;
      }
    }

    /********************************
    **       新闻数据结构模型     **
    ********************************/
    public function write_news () {
      $news = M('news_hotel');
      $data = $news->get_image_news();
      return FILE::writeJson('news', $data);
    }

    /********************************
    **       酒店数据结构模型     **
    ********************************/
    public function write_hotel () {
      $hotel = M('news_hotel');
      $data = $hotel->get_image_hotel();
      return FILE::writeJson('hotel', $data);
    }
    // 写入秋季酒店数据
    public function write_autumn_hotel () {
      $hotel = M('news_hotel');
      $data = $hotel->get_image_autumn_hotel();
      return FILE::writeJson('hotel_autumn', $data);
    }


  }
?>
