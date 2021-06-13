<?php
/***************************************
** 前端数据访问接口
***************************************/ 
class webController {
	// 新闻数据总条数
	private $newsNum = 0;
	private $news_hotel_model = null;
	// 设置每页显示的数量
	private $pageSize = 6;
	// 初始执行方法
	public function __construct () {
		// 获取新闻与酒店数据处理模型
		$this->news_hotel_model = M('news_hotel');
		// 设置每页显示数据的数量
		if ( isset($_GET['pageSize']) ) {
			$this->pageSize = intval($_GET['pageSize']);
		}
		// 获取新闻数据总数量
		$this->newsNum = $this->news_hotel_model->total_news();
	}

/**********************************************
** 新闻操作
**********************************************/
	// 新闻总条数
	public function getNewsTotal() {
		// 获取新闻数据总数量
		echo $this->newsNum;
	}
	// 获取新闻总页数
	public function getNewsPages() {
		// 获取新闻数据总数量
		$this->newsNum = $this->news_hotel_model->total_news();
		echo ceil($this->newsNum / $this->pageSize);
	}
    // 分页操作 
	public function newsPageList() {
		// 设置当前需要获取的页码
		$pageNum = 0;
		if ( isset($_GET['pageNum']) ) {
			$pageNum =  $_GET['pageNum'];
		}
		// 连接新闻数据模型，进行数组提取操作
		$res = $this->news_hotel_model->pageList_news($pageNum, $this->pageSize);
		// 返回数据到前端
		if ($res) {
			echo json_encode(array(
				"errno" => 0,
				"data" => $res
			));
		} else {
			echo json_encode( array (
				"errno" => 1,
				"errmsg" => "获取当前页出现错误"
			));
		}
		
	}
	// 获取单个新闻数据 
	public function getOneNews() {
		// 获取新闻ID
		if ( isset($_GET['id']) ) {
			$newsID = $_GET['id'];
			// 连接新闻数据模型，进行数组提取操作
			$res = $this->news_hotel_model->get_by_id ("news", $newsID);
			// 返回数据到前端
			if ($res) {
				echo json_encode(array(
					"errno" => 0,
					"data" => $res
				));
			} else {
				echo json_encode( array (
					"errno" => 1,
					"errmsg" => "新闻编号不正确，无法获取数据"
				));
			}
			
		} else {
			echo json_encode( array (
				"errno" => 1,
				"errmsg" => "必须提交新闻编号，不能为空"
			));
		}
	}

}




