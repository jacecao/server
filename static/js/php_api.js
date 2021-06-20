// 所有后端的接口
var PATH = '.';
var URL = {
  // 入口
  enter: PATH + "/enter/main.php",
  // 退出接口
  exit: PATH + '/enter/main.php?controller=admin&method=logout',
  // 识别码检查
  captchar: PATH + '/enter/checkCaptchar.php',
  // 链接识别码
  captcharIMG: PATH + '/enter/captchar.php?r=' + Math.random(),
  // 注册入口
  userREG: PATH + '/enter/main.php?controller=admin&method=register',
  // 提交登录入口
  userLOG: PATH + '/enter/main.php?controller=admin&method=submit',

  // 管理员注册页面
  userREGwin: PATH + '/enter/main.php?controller=admin&method=reg_user',
  // 管理员列表
  userList: PATH + '/enter/main.php?controller=admin&method=user_list',
  // 删除管理员
  userDel: PATH + '/enter/main.php?controller=admin&method=del_user',
  // 检查用户名是否唯一
  usernameCheck: PATH + '/enter/main.php?controller=admin&method=checkusername',
  // 用户信息获取
  userINFO: PATH + '/enter/main.php?controller=admin&method=userinfo',
  // 管理界面首页
  win: PATH + '/enter/main.php?controller=admin&method=win',

  // 获取头部信息设置
  headerSet: PATH + '/enter/main.php?controller=admin&method=view&view=header',
  // 顶部广告图片上传
  upHeader: PATH + '/enter/main.php?controller=data&method=headerup',
  // 顶部数据提交
  sub_header: PATH + '/enter/main.php?controller=data&method=header_sub',

  // 导航条设置
  navSet: PATH + '/enter/main.php?controller=admin&method=view&view=nav',
  // 导航条数据设置
  sub_nav: PATH + '/enter/main.php?controller=data&method=nav_sub',

   // 获取春季会展编辑页面
  chun_huizhan_page: PATH + '/enter/main.php?controller=admin&method=view&view=chun_huizhan',
  // 春季会展图片上传
  up_chun_huizhan: PATH + '/enter/main.php?controller=data&method=chun_huizhan_up',
  // 春季数据保存
  sub_chun_huizhan: PATH + '/enter/main.php?controller=data&method=chun_huizhan_sub',

   // 获取秋季会展编辑页面
  qiu_huizhan_page: PATH + '/enter/main.php?controller=admin&method=view&view=qiu_huizhan',
  // 秋季会展图片上传
  up_qiu_huizhan: PATH + '/enter/main.php?controller=data&method=qiu_huizhan_up',
  // 秋季会展数据保存
  sub_qiu_huizhan: PATH + '/enter/main.php?controller=data&method=qiu_huizhan_sub',

  // 获取新闻录制界面
  newsAdd: PATH + '/enter/main.php?controller=admin&method=view&view=news',
  // 新闻列表界面
  newsList: PATH + '/enter/main.php?controller=admin&method=list_win&list=news',
  // 下线新闻列表界面
  newsUnlineList: PATH + '/enter/main.php?controller=admin&method=list_win&list=news_unline',
  // 新闻图片上传
  upNews: PATH + '/enter/main.php?controller=data&method=newsup',
  // 新闻数据上传
  sub_news: PATH + '/enter/main.php?controller=data&method=news_sub',
  // 置顶新闻
  set_top_news: PATH + '/enter/main.php?controller=data&method=news_set_top',
  // 置顶新闻
  cancel_top_news: PATH + '/enter/main.php?controller=data&method=news_cancel_top',
  // 删除数据
  del_news: PATH + '/enter/main.php?controller=data&method=news_del',
  // 新闻数据恢复
  recovery_news: PATH + '/enter/main.php?controller=data&method=news_recovery',
  // 新闻数据修改
  edit_news: PATH + '/enter/main.php?controller=admin&method=view&view=news&id=',
  // 修改后的新闻数据上传
  sub_edit_news: PATH + '/enter/main.php?controller=data&method=news_update',

  // 获取春季酒店录制界面
  hotelAdd: PATH + '/enter/main.php?controller=admin&method=view&view=hotel',
  // 酒店列表界面
  hotelList: PATH + '/enter/main.php?controller=admin&method=list_win&list=hotel',
  // 酒店数据上传
  sub_hotel: PATH + '/enter/main.php?controller=data&method=hotel_sub',
  // 删除数据
  del_hotel: PATH + '/enter/main.php?controller=data&method=hotel_del',
  // 数据修改
  edit_hotel: PATH + '/enter/main.php?controller=admin&method=view&view=hotel&id=',
  // 修改后的数据上传
  sub_edit_hotel: PATH + '/enter/main.php?controller=data&method=hotel_update',

  // 获取秋季酒店录制界面
  autumnHotelAdd: PATH + '/enter/main.php?controller=admin&method=view&view=autumn_hotel',
  // 秋季酒店列表界面
  autumnHotelList: PATH + '/enter/main.php?controller=admin&method=list_win&list=autumn_hotel',
  // 酒店数据上传
  sub_autumn_hotel: PATH + '/enter/main.php?controller=data&method=autumn_hotel_sub',
  // 删除数据
  del_autumn_hotel: PATH + '/enter/main.php?controller=data&method=autumn_hotel_del',
  // 数据修改
  edit_autumn_hotel: PATH + '/enter/main.php?controller=admin&method=view&view=autumn_hotel&id=',
  // 修改后的数据上传
  sub_edit_autumn_hotel: PATH + '/enter/main.php?controller=data&method=autumn_hotel_update',

  // 酒店图片上传
  upHotel: PATH + '/enter/main.php?controller=data&method=hotelup',


  // 设置关于我们
  aboutSet: PATH + '/enter/main.php?controller=admin&method=view&view=about',
  // 关于我们数据上传
  sub_about: PATH + '/enter/main.php?controller=data&method=about_sub',

  // 招聘发布
  jobAdd: PATH + '/enter/main.php?controller=admin&method=view&view=job',
  // 招聘列表
  jobList: PATH + '/enter/main.php?controller=admin&method=list_win&list=job',
  // 招聘数据上传
  sub_job: PATH + '/enter/main.php?controller=data&method=job_sub',
  // 修改后的招聘数据上传
  sub_edit_job: PATH + '/enter/main.php?controller=data&method=job_update',
  // 删除数据
  del_job: PATH + '/enter/main.php?controller=data&method=job_del',
  // 招聘数据修改
  edit_job: PATH + '/enter/main.php?controller=admin&method=view&view=job&id=',
  // 招聘联系人页面获取
  jobContact: PATH + '/enter/main.php?controller=admin&method=view&view=job_contact',
  // 招聘联系人数据修改提交
  sub_job_contact: PATH + '/enter/main.php?controller=data&method=sub_job_contact',

  // 底部信息设置
  footerSet: PATH + '/enter/main.php?controller=admin&method=view&view=footer',
  // 底部数据上传
  sub_footer: PATH + '/enter/main.php?controller=data&method=footer_sub',

  // 获取产品录制界面
  productShow: PATH + '/enter/main.php?controller=admin&method=view&view=product&other=show',
  productAd: PATH + '/enter/main.php?controller=admin&method=view&view=product&other=ad',
  productAc: PATH + '/enter/main.php?controller=admin&method=view&view=product&other=ac',

  // 产品图片上传
  upProduct: PATH + '/enter/main.php?controller=data&method=productup',
  // logo图片上传
  upLogo: PATH + '/enter/main.php?controller=data&method=logoup',

  // 数据提交
  // 产品数据提交
  sub_pro_show: PATH + '/enter/main.php?controller=data&method=product_show',
  sub_pro_ad: PATH + '/enter/main.php?controller=data&method=product_ad',
  sub_pro_ac: PATH + '/enter/main.php?controller=data&method=product_ac',

  // 获取图片
  getImg: PATH + '/enter/main.php?controller=admin&method=imglist',
};
