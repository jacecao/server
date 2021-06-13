<?php

  class userModel {

    private $user = ''; // 当前登录管理员信息

    public function __construct () {
      // session_start();
      if (isset($_SESSION['user']) && (!empty($_SESSION['user']))) {
        $this->user = $_SESSION['user'];
        // session_write_close();
      }
      // session_write_close();
    }

    // 获取私有变量user
    public function getuser () {
      return $this->user;
    }

    // 注册新的用户
    public function register () {
      if ( !$this->have_root() || $this->user['power'] === 'root') {
        $adminobj = M('admin');
        $user_id = $adminobj->insert_user();
        // 如果注册成功
        if (!empty($user_id) && $user_id != 0) {
          return $user_id;
        } else {
          return 0;
        }
      } else {
        return 4;
      }
    }

    public function loginsubmit () { // 登录验证
      if (empty($_POST['username']) || empty($_POST['password'])) {
        return false;
      }
      $username = addslashes($_POST['username']);
      $password = addslashes($_POST['password']);
      // echo $username.'>>>>>'.$password.'>>>>>>'.$_POST['password'];
      // session_start();
      if ($this->user = $this->checkuser($username, $password)) {
        $_SESSION['user'] = $this->user;
        session_write_close();
        return true;
      } else {
        return false;
      }
    }

    public function logout () { // 退出登录
      // session_start();
      unset($_SESSION['user']);
      // unset($_SESSION['controller']);
      // unset($_SESSION['method']);
      $this->user='';
      session_write_close();
    }

    private function checkuser ($username, $password) {
      $adminobj = M('admin');
      $user = $adminobj->findOne_by_username($username);
      // 这里需要对密码编码
      $_pass = $adminobj->get_Mark($password);
      if ((!empty($user)) && $user['password'] === $_pass) {
        return $user;
      } else {
        return false;
      }
    }

    // 检查注册用户名是否唯一
    public function checkusername () {
      $adminobj = M('admin');
      $username = addslashes($_POST['username']);
      $user = $adminobj->findOne_by_username($username);
      if (empty($user)) {
        return 1;
      } else {
        return 0;
      }
    }

    // 获取所有的管理员
    public function get_all_user () {
      $adminobj = M('admin');
      $users = $adminobj->get_all_user();
      return $users;
    }

    // 当前是否有超级用户的存在
    function have_root () {
      $adminobj = M('admin');
      $user = $adminobj->find_by_power();
      return !empty($user) ? true : false;
    }

    // 删除管理员
    function del_user () {
      if (!empty($this->user) && $this->user['power'] === 'root') {
        $username = $_POST['user_name'];
        $adminobj = M('admin');
        $result = $adminobj->del_user($username);
        if (!$result) {
          return 1;
        } else {
          return 0;
        }
      } else {
        return 4;
      }
    }

  }

?>
