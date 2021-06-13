<?php
  // mysql_class 工厂模式
  class DB {
    public static $db;

    public static function init ($dbtype, $config) {
      self::$db = DBclass($dbtype);
      self::$db->connect($config);
    }

    // 创建数据表
    public static function create_table ($table_name) {
      $db_model = DBclass('tableModel');
      $method_name = 'create_'.$table_name;
      $sql = $db_model->$method_name();
      return self::$db->query($sql);
    }

    public static function query ($sql) {
      return self::$db->query($sql);
    }

    public static function findAll ($sql) {
      $query = self::$db->query($sql);
      return self::$db->findAll($query);
    }

    public static function findOne ($sql) {
      $query = self::$db->query($sql);
      return self::$db->findOne($query);
    }

    public static function findResult ($sql, $row = 0, $field = 0) {
      $query = self::$db->query($sql);
      return self::$db->findResult($query, $row, $field);
    }

    public static function num_rows ($sql) {
      $query = self::$db->query($sql);
      return self::$db->num_rows($query);
    }

    public static function insert ($table_name, $arr) {
      return self::$db->insert($table_name, $arr);
    }

    public static function update($table_name, $arr, $where) {
      return self::$db->update($table_name, $arr, $where);
    }

    public static function del ($table_name, $where) {
      return self::$db->del($table_name, $where);
    }

    public static function pageList ($pageNo=0, $pageSize=10, $status=1, $tableName) {
      return self::$db->pageList($pageNo, $pageSize, $status, $tableName);
    }
  }
?>
