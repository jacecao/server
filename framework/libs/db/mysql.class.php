<?php
  // 数据库操作
  class mysql {

    private $con = null;

    // 返回错误函数
    function err ($err) {
      die("操作出现错误，错误信息为:".$err);
      // die有两种作用-输出-终止，相当于echo和exit的组合
    }

    // 连接数据库
    // $config为配置数组
    // array(dbhost=>'', dbuser=>'', dbpsw=>'', dbname=>'', dbcharset=>'')
    function connect ($config) {
      extract($config);
      // extract() 该函数使用数组键名作为变量名，
      //  使用数组键值作为变量值。针对数组中的每个元素，将在当前符号表中创建对应的一个变量。
      /*
      if (!($this->con = mysqli_connect($dbhost, $dbuser, $dbpsw, $dbname))) {
        // 如果连接失败，打印出错误信息
        $this->err('数据库连接失败, 出错信息: '.mysqli_connect_error($this->con));
      }
      // 设置编码格式
      mysqli_query($this->con, 'set names'.$dbcharset);
      */


      if (!($this->con = @mysql_connect($dbhost, $dbuser, $dbpsw))) {
        $this->err(mysql_error());
      }
      if (!mysql_select_db($dbname, $this->con)) {
        $this->err(mysql_error());
      }
      mysql_query('set names '.$dbcharset);

    }

    // 执行sql语句
    function query ($sql) {
      // echo $sql;

      if (!($query = @mysql_query($sql))) {
        $this->err($sql.'<br>'.mysql_error($this->con));
      } else {
        return $query;
      }
      /*
      if (!($query = mysqli_query($this->con, $sql))) {
        $this->err($sql.'<br>'.mysqli_error($this->con));
      } else {
        return $query;
      }
      */
    }
    /*************************************
    ** $query 指mysqli_query返回的句柄  **
    *************************************/
    // 查询所有
    function findAll ($query) {
      // while ($rs = mysqli_fetch_array($query, MYSQL_ASSOC)) {
      //   $list[] = $rs;
      // }
      while ($rs = mysql_fetch_array($query, MYSQL_ASSOC)) {
        $list[] = $rs;
      }
      return isset($list) ? $list : '';
    }

    // 查询单条数据
    function findOne ($query) {
      // $rs = mysqli_fetch_array($query, MYSQL_ASSOC);
      $rs = mysql_fetch_array($query, MYSQL_ASSOC);
      return $rs;
    }

    // 返回指定行的指定字段的值
    function findResult ($query, $row = 0, $field = 0) {
      // 使用mysqli 需要通过下面的方式返回结果
      // $query->data_seek($row);
      // $datarow = $query->fetch_array();
      // return $datarow[$field];
      // 返回数据个数
      /*
      $res = $query->num_rows;
      return $res;
      */
      return mysql_result($query, $row, $field);
      // return mysql_num_rows($query);
    }

    // 返回当前数据条数
    function num_rows ($query) {
      return mysql_num_rows($query);
    }

    // 添加数据
    function insert ($table_name, $arr) {
      // $arr 根据数据表字段来编写
      // array('字段名1' => '值1', '字段名2' => '值2')
      // $sql = 'insert into 表名(多个字段) values(多个值)';
      foreach ($arr as $key => $value) {
        // mysql_real_escape_string() 函数转义 SQL 语句中使用的字符串中的特殊字符。
        $value = @mysql_real_escape_string($value);
        // $value = mysqli_escape_string($this->con, $value);
        // 将字段名单独保存到一个数组中
        $keyArr[] = '`'.$key.'`';
        // 将值单独保存到一个数组中
        $valueArr[] = "'".$value."'";
      }
      // 将数组转换为字符串
      $keys = implode(',', $keyArr);
      $values = implode(',', $valueArr);
      $sql = "INSERT INTO ".$table_name."(".$keys.") VALUES(".$values.")";
      // 执行mysql语句
      $this->query($sql);
      // mysql_insert_id()返回插入数据的_id
      // return mysqli_insert_id($this->con);
      return mysql_insert_id($this->con);
    }

    // 修改数据
    function update ($table_name, $arr, $where) {
      // updata db_name set key = value where ....;
      // 与添加数据类似，通过一维数组来实现
      foreach ($arr as $key => $value) {
        // mysql_real_escape_string() 函数转义 SQL 语句中使用的字符串中的特殊字符。
        $value = mysql_real_escape_string($value);
        // $value = mysqli_real_escape_string($this->con, $value);
        $keyANDvalueArr[] = "`".$key."`="."'$value'";
      }
      $keyANDvalues = implode(',', $keyANDvalueArr);
      $sql = "UPDATE ".$table_name." SET ".$keyANDvalues.' WHERE '.$where;
      return $this->query($sql);
    }

    // 删除数据
    function del ($table_name, $where) {
      // 删除语句
      $sql = 'DELETE FROM '.$table_name.' WHERE '.$where;
      return $this->query($sql);
    }

    // 获取数据列表
    // $pageNo : 当前页号
    // $pagesize: 当前每页显示数量
    // $status: 状态显示为已经上线的数据
    public function pageList ($pageNo=0, $pageSize=10, $status=1, $tableName) {
      // 起始值
      $start = $pageNo * ($pageSize-1) + ($pageNo==0?0:1);
      // sql语句
      $sql = "select * from `".$tableName."` where `status`=".$status." order by `date` desc limit ".$start.", ".$pageSize;
      $query = $this->query($sql);
      return $this->findAll($query);
    }

  }
?>
