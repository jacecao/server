<?php
  // 图文相关的数据处理
class dataController {
  // 保存当前登录用户名
  public $user = '';
  // 初始执行方法
  public function __construct () {
    // 判断当前是否已经登录->auth模型来处理
    // 如果没有登录就需要跳转到登录页
    $userObj = M('user');
    $this->user = $userObj->getuser();
  }
  // 上传图片并保存到数据库
  private function up ($method) {
    $upObj = M('upload');
    $res = $upObj->up($method);
    // 除开用户接口外，其他接口都将采用状态返回机制
    if ($res['status']) {
      $imgObj = M('image');
      $id = $imgObj->insert_img($res['upinfo']);
      $res['upinfo']['id'] = $id;
    }
    echo json_encode($res);
  }

  /********************************
  **       会展信息-头部header          **
  ********************************/
  // 图片上传位置
  public function headerup () {
    $this->up('header');
  }
  // 会展信息头部数据上传
  public function header_sub () {
    $pro = M('product');
    $res = $pro->write_header();
    if ($res) {
      echo 1;
    } else {
      echo 0;
    }
  }


  /********************************
  **       春季会展图文          **
  ********************************/
  // 图片上传位置
  public function chun_huizhan_up () {
    $this->up('chunHuiZhan');
  }
  // 春季会展数据上传
  public function chun_huizhan_sub () {
    $pro = M('product');
    $res = $pro->write_huizhan('chun');
    if ($res) {
      echo 1;
    } else {
      echo 0;
    }
  }

  /********************************
  **       秋季会展图文          **
  ********************************/
  // 图片上传位置
  public function qiu_huizhan_up () {
    $this->up('qiuHuiZhan');
  }
  // 春季会展数据上传
  public function qiu_huizhan_sub () {
    $pro = M('product');
    $res = $pro->write_huizhan('qiu');
    if ($res) {
      echo 1;
    } else {
      echo 0;
    }
  }

  /********************************
  **       导航条数据处理        **
  ********************************/
  // 导航条数据上传
  public function nav_sub () {
    $pro = M('product');
    $res = $pro->write_nav();
    if ($res) {
      echo 1;
    } else {
      echo 0;
    }
  }

  /********************************
  **       新闻数据处理        **
  ********************************/
  // 新闻图片上传
  public function newsup () {
    $this->up('news');
  }
  // 新闻数据上传
  public function news_sub () {
    $newsobj = M('news_hotel');
    // 启动数据库录入
    // 返回录入的id值
    $res = $newsobj->insert_news();
    if ($res) {
      // 启动json数据储存
      $pro = M('product');
      echo $pro->write_news();
    } else {
      echo 0;
    }
  }
  // 新闻数据修改
  public function news_update () {
    $newsModel = M('news_hotel');
    $res = $newsModel->update_news();
    if ($res) {
      // 启动json数据储存
      $pro = M('product');
      echo $pro->write_news();
    } else {
      echo 0;
    }
  }
  // 新闻置顶设置
  public function news_set_top () {
    $newsModel = M('news_hotel');
    $res = $newsModel->set_top_news();
    if ($res) {
      echo 1;
    } else {
      echo 0;
    }
  }
   // 取消新闻置顶
  public function news_cancel_top () {
    $newsModel = M('news_hotel');
    $res = $newsModel->cancel_top_news();
    if ($res) {
      echo 1;
    } else {
      echo 0;
    }
  }

  // 删除新闻数据
  // 注意这里不是真实的删除，只是将该条新闻下线，不再显示
  // 超级管理人员可以恢复上线
  public function news_del () {
    $newsModel = M('news_hotel');
    $res = $newsModel->del_news_hotel('news');
    if ($res) {
      // 启动json数据储存
      $pro = M('product');
      echo $pro->write_news();
    } else {
      echo 0;
    }
  }
  // 删除新闻数据
  // 注意这里不是真实的删除，只是将该条新闻下线，不再显示
  // 超级管理人员可以恢复上线
  public function news_recovery () {
    $newsModel = M('news_hotel');
    $res = $newsModel->recovery_news_hotel('news');
    if ($res) {
      // 启动json数据储存
      $pro = M('product');
      echo $pro->write_news();
    } else {
      echo 0;
    }
  }

  /********************************
  **       酒店数据处理        **
  ********************************/
  // 酒店图片上传
  public function hotelup () {
    $this->up('hotel');
  }

  // 春季数据上传
  public function hotel_sub () {
    $newsobj = M('news_hotel');
    // 启动数据库录入
    // 返回录入的id值
    $res = $newsobj->insert_hotel();
    if ($res) {
      // 启动json数据储存
      $pro = M('product');
      echo $pro->write_hotel();
    } else {
      echo 0;
    }
  }
  // 秋季数据上传
  public function autumn_hotel_sub () {
    $newsobj = M('news_hotel');
    // 启动数据库录入
    // 返回录入的id值
    $res = $newsobj->insert_autumn_hotel();
    if ($res) {
      // 启动json数据储存
      $pro = M('product');
      echo $pro->write_autumn_hotel();
    } else {
      echo 0;
    }
  }
  // 春季数据修改
  public function hotel_update () {
    $newsModel = M('news_hotel');
    $res = $newsModel->update_hotel();
    if ($res) {
      // 启动json数据储存
      $pro = M('product');
      echo $pro->write_hotel();
    } else {
      echo 0;
    }
  }
  // 秋季数据修改
  public function autumn_hotel_update () {
    $newsModel = M('news_hotel');
    $res = $newsModel->update_autumn_hotel();
    if ($res) {
      // 启动json数据储存
      $pro = M('product');
      echo $pro->write_autumn_hotel();
    } else {
      echo 0;
    }
  }
  // 春季删除数据
  public function hotel_del () {
    $newsModel = M('news_hotel');
    $res = $newsModel->del_news_hotel('hotel');
    if ($res) {
      // 启动json数据储存
      $pro = M('product');
      echo $pro->write_hotel();
    } else {
      echo 0;
    }
  }
  // 秋季删除数据
  public function autumn_hotel_del () {
    $newsModel = M('news_hotel');
    $res = $newsModel->del_news_hotel('autumn_hotel');
    if ($res) {
      // 启动json数据储存
      $pro = M('product');
      echo $pro->write_autumn_hotel();
    } else {
      echo 0;
    }
  }

  /********************************
  **       产品数据处理        **
  ********************************/
  // 产品图片上传
  public function productup () {
    $this->up('product');
  }
  // logo图片上传
  public function logoup () {
    $this->up('logo');
  }

  // 产品数据提交
  public function product_show () {
    $pro = M('product');
    $res = $pro->write_show();
    if ($res) {
      echo 1;
    } else {
      echo 0;
    }
  }
  public function product_ad () {
    $pro = M('product');
    $res = $pro->write_ad();
    if ($res) {
      echo 1;
    } else {
      echo 0;
    }
  }
  public function product_ac () {
    $pro = M('product');
    $res = $pro->write_ac();
    if ($res) {
      echo 1;
    } else {
      echo 0;
    }
  }

  /********************************
  **     关于我们数据处理        **
  ********************************/
  // 关于我们数据提交
  public function about_sub () {
    $pro = M('product');
    $res = $pro->write_about();
    if ($res) {
      echo 1;
    } else {
      echo 0;
    }
  }

  /********************************
  **     footer数据处理        **
  ********************************/
  // footer数据提交
  public function footer_sub () {
    $pro = M('product');
    $res = $pro->write_footer();
    if ($res) {
      echo 1;
    } else {
      echo 0;
    }
  }

  /********************************
  **     招聘数据处理        **
  ********************************/
  // 招聘数据提交
  public function job_sub () {
    $job = M('job');
    // print_r($job->test());
    $res = $job->insert_job();
    // echo 'delog'.$res;
    if ($res) {
      $pro = M('product');
      echo $pro->write_job();
    } else {
      echo 0;
    }
  }
  // 招聘数据修改
  public function job_update () {
    $job = M('job');
    $res = $job->update_job();
    if ($res) {
      $pro = M('product');
      echo $pro->write_job();
    } else {
      echo 0;
    }
  }
  // 删除招聘数据
  public function job_del () {
    $job = M('job');
    $res = $job->del_job();
    //echo $res;
    if ($res) {
      $pro = M('product');
      echo $pro->write_job();
    } else {
      echo 0;
    }
  }
  // 招聘联系人修改
  public function sub_job_contact () {
    $pro = M('product');
    $res = $pro->write_job_contact();
    if ($res) {
      echo 1;
    } else {
      echo 0;
    }
  }

}
?>
