<?php
  class tableModel {
    // 创建用户表单
    public function create_users () {
      $sql = "CREATE TABLE IF NOT EXISTS users (
        `id` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(20) NOT NULL UNIQUE KEY,
        `password` VARCHAR(32) NOT NULL,
        `power` VARCHAR(20) DEFAULT 'admin',
        `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      )";
      return $sql;
    }
    // 创建新闻表单
    public function create_news () {
      $sql = "CREATE TABLE IF NOT EXISTS news (
        `index` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `id` VARCHAR(32) NOT NULL UNIQUE KEY,
        `title` TINYTEXT NOT NULL,
        `poster` SMALLINT(5) NOT NULL,
        `images` TINYTEXT NOT NULL,
        `content` TEXT NOT NULL,
        `username` TINYTEXT NOT NULL,
        `createdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `status` TINYINT(4) NOT NULL DEFAULT 1,
        `topvalue` SMALLINT(4) UNSIGNED NOT NULL DEFAULT 0
      )";
      return $sql;
    }
    // 创建酒店表单
    public function create_hotel () {
      $sql = "CREATE TABLE IF NOT EXISTS hotel (
        `index` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `id` VARCHAR(32) NOT NULL UNIQUE KEY,
        `name` TINYTEXT NOT NULL,
        `poster` SMALLINT(5) NOT NULL,
        `images` TINYTEXT NOT NULL,
        `content` TEXT NOT NULL,
        `username` TINYTEXT NOT NULL,
        `createdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `status` TINYINT(4) NOT NULL DEFAULT 1
      )";
      return $sql;
    }
    // 创建酒店表单
    public function create_autumn_hotel () {
      $sql = "CREATE TABLE IF NOT EXISTS autumn_hotel (
        `index` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `id` VARCHAR(32) NOT NULL UNIQUE KEY,
        `name` TINYTEXT NOT NULL,
        `poster` SMALLINT(5) NOT NULL,
        `images` TINYTEXT NOT NULL,
        `content` TEXT NOT NULL,
        `username` TINYTEXT NOT NULL,
        `createdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `status` TINYINT(4) NOT NULL DEFAULT 1
      )";
      return $sql;
    }
    // 创建职位表单
    public function create_jobs () {
      $sql = "CREATE TABLE IF NOT EXISTS jobs (
        `id` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `name` TINYTEXT NOT NULL,
        `note` TINYTEXT NOT NULL,
        `req` TEXT NOT NULL,
        `des` TEXT NOT NULL,
        `loc` TINYTEXT NOT NULL,
        `user` TINYTEXT NOT NULL,
        `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `status` TINYINT(4) NOT NULL DEFAULT 1
      )";
      return $sql;
    }
    // 创建图片表单
    public function create_images () {
      $sql = "CREATE TABLE IF NOT EXISTS images (
        `id` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL UNIQUE KEY,
        `path` VARCHAR(200) NOT NULL,
        `url` VARCHAR(200) NOT NULL,
        `desc` VARCHAR(400) ,
        `status` TINYINT(1) NOT NULL DEFAULT 1,
        `used` TINYINT(1) NOT NULL DEFAULT 0,
        `dir` VARCHAR(50) NOT NULL,
        `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
      )";
      return $sql;
    }
  }
?>
