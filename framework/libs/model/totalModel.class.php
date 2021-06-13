<?php
  // 数据统计
  class totalModel {
    //获取新闻总数
    private function total_news () {
      $newsOBJ = M('news_hotel');
      return $newsOBJ->total_news();
    }
    //获取酒店总数
    private function total_hotel () {
      $hotelOBJ = M('news_hotel');
      return $hotelOBJ->total_hotels();
    }
    //获取管理员总数
    private function total_users () {
      $userOBJ = M('admin');
      return $userOBJ->total_users();
    }
    //获取管理员总数
    private function total_jobs () {
      $jobOBJ = M('job');
      return $jobOBJ->total_jobs();
    }
    //获取图片总数
    private function total_images () {
      $imageOBJ = M('image');
      return $imageOBJ->total_images();
    }

    // 总数数据模型
    public function total() {
      return array(
        'news' => $this->total_news(),
        'hotel' => $this->total_hotel(),
        'admin' => $this->total_users(),
        'job' => $this->total_jobs(),
        'image' => $this->total_images(),
        );
    }

  }
?>
