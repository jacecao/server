<?php
  // 后台页面加载
  class adminController {
    // 保存当前登录用户名
    public $user = '';
    // 初始执行方法
    public function __construct () {
      // 判断当前是否已经登录->auth模型来处理
      // 如果没有登录就需要跳转到登录页
      $userObj = M('user');
      $this->user = $userObj->getuser();
    }
    /********************************
    **       用户管理接口          **
    ********************************/
    // 注册处理
    public function register () {
      // 注册存在2种情况
      // 1.是超级用户注册,2.是超级用户注册管理员
      // 需要根据$user是否有值来判断
      // 如果超级用户注册，那注册成功后需要返回管理页面
      // 如果注册管理员，那么返回管理员列表
      $userObj = M('user');
      $res = $userObj->register();

      if (empty($this->user)) {
        // 在没有用户登录的情况下注册那么就是超级用户注册
        if ($res) {
          // 当超级用户注册成功后，直接启动登录
          $this->submit();
        } else {
          echo 0;
        }
      } else {
        // 返回所有管理员列表
        switch ($res) {
          case 0:
            echo 0;
            break;
          case 4:
            echo 4;
            break;
          default:
            echo 1;
            break;
        }
      }
    }

    // 删除管理员
    public function del_user () {
      $userObj = M('user');
      $res = $userObj->del_user();
      echo $res;
      switch ($res) {
        case 0:
          echo 0;
          break;
        case 4:
          echo 4;
          break;
        default:
          echo $res;
          break;
      }
    }

    // 显示所有管理员列表界面
    public function user_list () {
      if (!empty($this->user)) {
        $userObj = M('user');
        $users = $userObj->get_all_user();
        VIEW::assign(array('power'=>$this->user['power']));
        VIEW::assign(array('users'=>$users));
        VIEW::display('user_list.html');
      }
    }

    /********************************
    **  登录\注册\用户管理        **
    ********************************/
    // 显示登录界面
    public function login () {
      // 判断是否以及登录
      if (!empty($this->user)) {
        $this->win();
      } else {
        // 检查是否有超级用户
        $userObj = M('user');
        $result = $userObj->have_root();
        VIEW::assign(array('have_root'=>$result));
        VIEW::display('login.html');
      }
    }

    // 注册管理员界面
    public function reg_user () {
      if (!empty($this->user)) {
        VIEW::assign(array('user'=>$this->user));
        VIEW::display('reg_user.html');
      } else {
        $this->login();
      }
    }

    // 检查注册用户名是否唯一
    public function checkusername () {
      $userObj = M('user');
      $res = $userObj->checkusername();
      if ($res) {
        echo 1;
      } else {
        echo 0;
      }
    }

    // 退出登录
    public function logout() {
      $authobj = M('user');
      $authobj->logout();
      echo 1;
    }

    // 提交登录信息
    public function submit () {
      $userObj = M('user');
      $result = $userObj->loginsubmit();
      $this->user = $userObj->getuser();
      if ($result) {
        echo 1;
        return true;
      } else {
        echo 0;
        return false;
      }
    }


    // 获取用户信息
    public function userinfo () {
      if (!empty($this->user)) {
        $_user = array(
          'username'=>$this->user['username'],
          'power'=>$this->user['power']
          );
        echo json_encode($_user);
      } else {
        echo '';
      }
    }

    // 获取管理界面
    public function win() {
      // 只有当用户登录时才显示主界面
      if (!empty($this->user)) {
        $totalObj = M('total');
        $total = $totalObj->total();
        VIEW::assign(array('user'=>$this->user));
        VIEW::assign($total);
        VIEW::display('win.html');
      } else {
        $this->login();
      }
    }

    // 获取所有信息录入界面
    private function get_json_data ($name) {
      // 启动数据工程模型
      $data = M('product');
      $dataArr = $data->read_json($name);
      // print_r($dataArr);
      if ($dataArr) {
        VIEW::assign($dataArr);
      }
    }
    // 获取指定信息数据
    // $name json文件名
    // $id  需要查找数据的id值
    private function get_json_by_id ($name, $id) {
      if (!empty($id)) {
        // 启动数据工程模型
        $data = M('product');
        $dataArr = $data->read_json($name);
        foreach ($dataArr as $key => $values) {
          foreach ($values as $value) {
            $_data_arr[] = $value;
          }
        }
        foreach ($_data_arr as $_value) {
          if ($_value['id'] === $id) {
            VIEW::assign($_value);
          }
        }
      }
    }
    /********************************
    **       界面接口处理          **
    ********************************/
    public function view () {
      if (!empty($this->user)) {
        // 获取view名称
        $viewname = $_GET['view'];
        $data = false;
        $other = isset($_GET['other']) ? $_GET['other'] : '';
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        // 为不同的窗口获取不同的数据资源
        switch ($viewname) {
          case 'header': // 头部会展信息
            $this->get_json_data('headerinfo');
            break;
          case 'chun_huizhan': // 获取春季会展模板
            $viewname = 'huizhan';
            // 春秋会展信息使用同一模板，这里需要传入style来用于区别控制
            $data = array("style" => "chun", "title"=>"春季");
            // 注入录入的数据
            $this->get_json_data('huizhan_chun');
            break;
          case 'qiu_huizhan': // 获取秋季会展模板
            $viewname = 'huizhan';
            // 春秋会展信息使用同一模板，这里需要传入style来用于区别控制
            $data = array("style" => "qiu", "title"=>"秋季");
            // 注入录入的数据
            $this->get_json_data('huizhan_qiu');
            break; 
          case 'news': // 指定id-新闻修改页面
            if (!empty($id)) {
              $newsModel = M('news_hotel');
              $data = $newsModel->get_by_id('news', $id);
            }
            break;

          case 'hotel': // 指定id-酒店修改页面
            if (!empty($id)) {
              $newsModel = M('news_hotel');
              $data = $newsModel->get_by_id('hotel', $id);
            }
            break;

          case 'autumn_hotel': // 指定id-酒店修改页面
            if (!empty($id)) {
              $newsModel = M('news_hotel');
              $data = $newsModel->get_by_id('autumn_hotel', $id);
            }
            break;
          case 'about':
            $this->get_json_data('about');
            break;
          case 'footer':
            $this->get_json_data('footer');
            break;
          case 'job': // 指定id-以方便查询数据返回指定的工作修改页面
            $this->get_json_by_id('jobs', $id);
            break;
          case 'job_contact':
            $this->get_json_data('email');
            break;  
        }
        if (!empty($other)) {
          /************************
          ** 这里需要添加API变量是为了识别前端提交数据时指明需要修改的具体对象
          ** 因为产品有3个系列，但页面使用了相同的模板，加上API方便前端调用具体的操作API
          *************************/
          switch ($other) {
            case 'show':
              $this->get_json_data('productShow');
              $data = array('api'=>'show');
              break;
            case 'ad':
              $this->get_json_data('productMake');
              $data = array('api'=>'ad');
              break;
            case 'ac':
              $this->get_json_data('productActivity');
              $data = array('api'=>'ac');
              break;
          }
        }
        if ($data) {VIEW::assign($data);}
        VIEW::display($viewname.'_form.html');
      } else {
        $this->login();
      }
    }

    // 获取所有数据列表界面
    public function list_win () {
      if (!empty($this->user)) {
        // 获取list名称
        $listname = $_GET['list'];
        // 初始数据值
        $_data = array();
        // 计入当前管理员信息
        $_data['userinfo'] = $this->user['power'];
        // 为不同的窗口获取不同的数据资源

        switch ($listname) {
          case 'job':
            $this->get_json_data('jobs');
            break;
          case 'news':
            $newsModel = M('news_hotel');
            $_news_value = $newsModel->get_online_news();
            empty($_news_value) ? '' : ($_data['news'] = $_news_value);
            break;
          case 'news_unline':
            $newsModel = M('news_hotel');
            $_news_value = $newsModel->get_unline_news();
            $listname = 'news';
            empty($_news_value) ? '' : ($_data['news'] = $_news_value);
            break;
          case 'hotel':
            $newsModel = M('news_hotel');
            $_hotel_data = $newsModel->get_all_hotel();
            empty($_hotel_data) ? '' : ($_data['hotel'] = $_hotel_data);
            break;
          case 'autumn_hotel':
            $newsModel = M('news_hotel');
            $_autumn_hotel_data = $newsModel->get_all_autumn_hotel();
            empty($_autumn_hotel_data ) ? '' : ($_data['hotel'] = $_autumn_hotel_data );
            break;
        }
        VIEW::assign($_data);
        VIEW::display($listname.'_list.html');
      } else {
        $this->login();
      }
    }

    // 获取图片列表界面
    public function imglist () {
      if (!empty($this->user)) {
        $imgObj = M('image');
        /* **************图片列表类型 *********
        ** 前端选择图片列表和图片编辑列表使用统一模板
        ** 这里根据类型来设定，列表输出样式和对应的功能按钮
        ** 0 || false -> 选择图片列表
        ** 1 || true -> 图片编辑列表
        ***************************************/
        $_img_list_type = isset($_GET['type']) && (int)$_GET['type'];
        $_category_text = isset($_GET['text']) ? $_GET['text'] : false;
        $res = $imgObj->getImgsByDir();
        $_data = array(
          'images'=>$res, 
          'type'=>$_img_list_type,
          'categoryText'=>$_category_text
        );
        VIEW::assign($_data);
        VIEW::display('img_list.html');      
      } else {
        $this->login();
      }
    }

  }

?>
