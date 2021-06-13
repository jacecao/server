<?php
// 从数据库取用户数据
  class adminModel {

    private $_table = 'users'; // 指定数据表名

    public function __construct () {
      DB::create_table($this->_table);
      // session_start();
      // session_commit();
      // if (isset($_SESSION['user']) && (!empty($_SESSION['user']))) {}
      // session_write_close();
    }

    private function Mark ($str) {
      return crypt($str, '$1$tjhzs$');
    }

    public function get_Mark ($str) {
      return $this->Mark($str);
    }

    // 取用户信息
    public function findOne_by_username ($usename) {
      $sql = 'SELECT * FROM '.$this->_table.' WHERE `username`="'.$usename.'"';
      return DB::findOne($sql);
    }

    // 通过id值获取用户名
    public function fndOne_by_id ($id) {
      $sql = 'SELECT * FROM '.$this->_table.' WHERE `id`="'.$id.'"';
      return DB::findOne($sql);
    }

    // 查看是否超级用户
    public function find_by_power () {
      $sql = 'SELECT * FROM '.$this->_table.' WHERE `power`="root"';
      return DB::findOne($sql);
    }

    // 添加用户
    public function insert_user () {
      if (isset($_POST['power']) && $_POST['power'] === 'root') {
        $power = 'root';
      } else {
        $power = 'admin';
      }
      $arr = array(
        'username' => addslashes($_POST['username']),
        'password'=>$this->Mark(addslashes($_POST['password'])),
        'power' => $power
        );
      return DB::insert($this->_table, $arr);
    }

    // 获取所有管理员用户
    public function get_all_user () {
      $sql = 'SELECT * FROM '.$this->_table.' WHERE `power`="admin"'.' ORDER BY `date` DESC';
      return DB::findAll($sql);
    }

    // 删除管理员
    public function del_user ($username) {
      return DB::del($this->_table, 'username='."'$username'");
    }

    // 总计管理员人数
    public function total_users () {
      $sql = 'SELECT * FROM '.$this->_table;
      return DB::num_rows($sql);
    }

  }
?>
