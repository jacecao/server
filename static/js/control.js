// 控制信息
var controleINFO = {
  del_success: '删除管理员成功!',
  del_fail: '删除管理员失败!',
  del_err: '对不起你没有操作权限',
  edit_success: '数据修改成功！',
  edit_error: '数据修改失败，请重新填写'
};

/********************************
**  管理员控制界面编写         **
*********************************/
// 删除管理员
$('.del-user').on('click', function () {
  $(this).attr('disabled','disabled');
  var name = $(this).data('user');
  $.post(URL.userDel, {user_name: name}, function (res) {
    switch (parseInt(res)) {
      case 0:
        activeMessge(controleINFO.del_fail, 'remove', '#f00');
        break;
      case 4:
        activeMessge(controleINFO.del_err, 'remove', '#f00');
        break;
      default:
        activeMessge(controleINFO.del_success, 'ok', '#8bc34a');
        break;
    }
    $.get(URL.userList, function (res) {
      $('.control-win').html(res);
    });
  });
});

/********************************
**   会展信息录入编写          **
********************************/
// 初始添加图片按钮
$('.addimg-header').on('click', function() {
  new Imgwin('header', URL.upHeader);
});
// 初始头部封面图片模块
var imgModel_header = new Imgmodel('.up-header-post', '.choose-header-post', URL.upHeader);
imgModel_header.upimg();
imgModel_header.chooseimg();

// 提交数据
$('.sub-header').on('click', function () {
  // 执行数据提交处理
  up_form_data(URL.sub_header, URL.headerSet, '.header-form');
});


/********************************
**   春季\秋季-会展中心图文录入          **
********************************/
var setHuizhanFun = function(name) {
  // 初始添加图片按钮
  $('.addimg-'+ name + '-huizhan').on('click', function() {
    new Imgwin(name + '_huizhan', URL['up_' + name + '_huizhan']);
  });
  // 初始头部封面图片模块
  var imgModel_huizan_post = new Imgmodel('.up-' + name + '-huizhan-post', '.choose-' + name + '-huizhan-post', URL['up_' + name + '_huizhan']);
  imgModel_huizan_post.upimg();
  imgModel_huizan_post.chooseimg();
  // 其他图片上传模块
  var imgModel_huizhan = new Imgmodel('.up-' + name + '-huizhan', '.choose-huizhan', URL['up_' + name + '_huizhan']);
  imgModel_huizhan.upimg();
  imgModel_huizhan.chooseimg();

  // 提交数据
  $('.sub-' + name + '-huizhan').on('click', function () {
    // 执行数据提交处理
    up_form_data(URL['sub_' + name + '_huizhan'], URL[name + '_huizhan_page'], '.huizhan-form');
  });
};

// 春季会展中心操作
setHuizhanFun('chun');
// 秋季会展中心操作
setHuizhanFun('qiu');

/********************************
**   导航条设置  编写          **
********************************/
// 提交数据
$('.sub-nav').on('click', function () {
  $(this).attr('disabled', true);
  // 执行数据提交处理
  up_form_data(URL.sub_nav, URL.navSet, '.nav-form');
});

/********************************
**       新闻录制编写          **
********************************/
// 初始添加图片按钮
$('.addimg-news').on('click', function() {
  new Imgwin('news', URL.upNews);
});
// 初始新闻封面上传和选择图片模块
var imgModel_news_post = new Imgmodel('.up-news-post', '.choose-news-post', URL.upNews);
imgModel_news_post.upimg();
imgModel_news_post.chooseimg();
// 初始新闻上传和选择图片模块
var imgModel_news = new Imgmodel('.up-news', '.choose-news', URL.upNews);
imgModel_news.upimg();
imgModel_news.chooseimg();
// 提交数据
$('.sub-news').on('click', function () {
  var id = $(this).data('id');
  $(this).attr('disabled', true);
  // h
  if (id) {
    // 执行修改数据处理
    up_form_data(URL.sub_edit_news, URL.newsList, '.news-form');
  } else {
    // 执行数据提交处理
    up_form_data(URL.sub_news, URL.newsList, '.news-form');
  }
});
// 编辑数据
$('.news-edit').on('click', function () {
  var _id = $(this).data('id');
  var _url = URL.edit_news + _id;
  redirector(_url);
});
// 置顶操作
$('.news-set-top').on('click', function () {
  var _id = $(this).data('id');
  $(this).attr('disabled', true);
  set_top(URL.set_top_news, URL.newsList, _id);
});
// 取消数据置顶
$('.news-cancel-top').on('click', function () {
  var _id = $(this).data('id');
  $(this).attr('disabled', true);
  cancel_top(URL.cancel_top_news, URL.newsList, _id);
});
// 删除数据
$('.news-del').on('click', function () {
  var id = $(this).data('id');
  $(this).attr('disabled', true);
  // 执行修改数据处理
  del_data(URL.del_news, URL.newsList, id);
});
// 恢复数据处理
$('.news-recovery').on('click', function () {
  var id = $(this).data('id');
  $(this).attr('disabled', true);
  // 执行修改数据处理
  recovery_data(URL.recovery_news, URL.newsUnlineList, id);
});

/********************************
**       春季酒店录制编写          **
********************************/
// 初始添加图片按钮
$('.addimg-hotel').on('click', function() {
  new Imgwin('hotel', URL.upHotel);
});
// 初始酒店封面上传和选择图片模块
var imgModel_hotel_post = new Imgmodel('.up-hotel-post', '.choose-hotel-post', URL.upHotel);
imgModel_hotel_post.upimg();
imgModel_hotel_post.chooseimg();
// 初始酒店上传和选择图片模块
var imgModel_hotel = new Imgmodel('.up-hotel', '.choose-hotel', URL.upHotel);
imgModel_hotel.upimg();
imgModel_hotel.chooseimg();
// 提交数据
$('.sub-hotel').on('click', function () {
  var id = $(this).data('id');
  // $(this).attr('disabled', true);
  if (id) {
    // 执行修改数据处理
    up_form_data(URL.sub_edit_hotel, URL.hotelList, '.hotel-form');
  } else {
    // 执行数据提交处理
    up_form_data(URL.sub_hotel, URL.hotelList, '.hotel-form');
  }
});
// 编辑数据
$('.hotel-edit').on('click', function () {
  var _id = $(this).data('id');
  var _url = URL.edit_hotel + _id;
  // $.get(_url, function (res) {console.log(res);});
  // 启动重定向
  redirector(_url);
});

// 删除数据
$('.hotel-del').on('click', function () {
  var id = $(this).data('id');
  $(this).attr('disabled', true);
  // 执行修改数据处理
  console.log(id);
  console.log(URL.del_hotel);
  del_data(URL.del_hotel, URL.hotelList, id);
});

/********************************
**       秋季酒店录制编写          **
********************************/
// 初始添加图片按钮
$('.addimg-autumn-hotel').on('click', function() {
  new Imgwin('hotel', URL.upHotel);
});
// 初始酒店封面上传和选择图片模块
var imgModel_autumn_hotel_post = new Imgmodel('.up-autumn-hotel-post', '.choose-autumn-hotel-post', URL.upHotel);
imgModel_autumn_hotel_post.upimg();
imgModel_autumn_hotel_post.chooseimg();
// 初始酒店上传和选择图片模块
var imgModel_autumn_hotel = new Imgmodel('.up-autumn-hotel', '.choose-autumn-hotel', URL.upHotel);
imgModel_autumn_hotel.upimg();
imgModel_autumn_hotel.chooseimg();
// 提交数据
$('.sub-autumn-hotel').on('click', function () {
  var id = $(this).data('id');
  // $(this).attr('disabled', true);
  if (id) {
    // 执行修改数据处理
    up_form_data(URL.sub_edit_autumn_hotel, URL.autumnHotelList, '.hotel-form');
  } else {
    // 执行数据提交处理
    up_form_data(URL.sub_autumn_hotel, URL.autumnHotelList, '.hotel-form');
  }
});
// 编辑数据
$('.autumn-hotel-edit').on('click', function () {
  var _id = $(this).data('id');
  var _url = URL.edit_autumn_hotel + _id;
  // $.get(_url, function (res) {console.log(res);});
  // 启动重定向
  redirector(_url);
});

// 删除数据
$('.autumn-hotel-del').on('click', function () {
  var id = $(this).data('id');
  $(this).attr('disabled', true);
  // 执行修改数据处理
  del_data(URL.del_autumn_hotel, URL.autumnHotelList, id);
});

/********************************
**       关于我们编写          **
********************************/
// 提交数据
$('.sub-about').on('click', function () {
  // $(this).attr('disabled', true);
  // 执行数据提交处理
  up_form_data(URL.sub_about, URL.aboutSet, '.about-form');
  // $.post(URL.sub_about, $('.about-form').serialize(), function (res) {
  //   document.write(res);
  //   console.log(res);
  // });
});

/********************************
**       footer数据编写        **
********************************/
// 启动复选框模块
var check = new Check_link();
// 复选框操作
$('.is-link').on('click', function () {
  check.run($(this));
});

// 提交数据
$('.sub-footer').on('click', function () {
  $(this).attr('disabled', true);
  // 执行数据提交处理
  up_form_data(URL.sub_footer, URL.footerSet, '.web-form');
});

/********************************
**   产品页面界面编写          **
********************************/
// 产品页面
// 初始添加图片按钮
// argument 文件上传接口
$('.addimg-product').on('click', function() {
  new Imgwin('product', URL.upProduct);
});

// 初始产品图片模块
var imgModel_product = new Imgmodel('.up-0', '.choose-product', URL.upProduct);
imgModel_product.upimg();
imgModel_product.chooseimg();
// 初始logo图片模块
var imgModel_logo = new Imgmodel('.up-logo', '.choose-logo', URL.upLogo);
imgModel_logo.upimg();
imgModel_logo.chooseimg();

// 图片删除
$('.del-scan').on('click', function () {
  var id = $(this).data('id');
  $('.scan-box-' + id).fadeOut().remove();

});

// 产品信息提交
// 提交数据到json文件
$('.sub-data').on('click', function () {
  $(this).attr('disabled', true);
  // 数据提交地址
  var url = '';
  // 重定向地址
  var re_url = '';
  switch ($(this).data('up')) {
    case 'show':
      url = URL.sub_pro_show;
      re_url = URL.productShow;
    break;
    case 'ad':
      url = URL.sub_pro_ad;
      re_url = URL.productAd;
    break;
    case 'ac':
      url = URL.sub_pro_ac;
      re_url = URL.productAc;
    break;
  }
  // 执行数据提交处理
  up_form_data(url, re_url, '.products-form');
});

/********************************
**   招聘页面界面编写          **
********************************/
// 提交数据
$('.sub-job').on('click', function () {
  var id = $(this).data('id');
  $(this).attr('disabled', true);
  if (id) {
    // 执行修改数据处理
    up_form_data(URL.sub_edit_job, URL.jobList, '.job-form');
  } else {
    // 执行数据提交处理
    up_form_data(URL.sub_job, URL.jobList, '.job-form');
  }
});

// 编辑数据
$('.job-edit').on('click', function () {
  var _id = $(this).data('id');
  var _url = URL.edit_job + _id;
  // $.get(_url, function (res) {console.log(res);});
  // 启动重定向
  redirector(_url);
});

// 删除数据
$('.job-del').on('click', function () {
  var id = $(this).data('id');
  $(this).attr('disabled', true);
  // 执行修改数据处理
  del_data(URL.del_job, URL.jobList, id);
});


// 编辑数据
$('.job-edit').on('click', function () {
  var _id = $(this).data('id');
  var _url = URL.edit_job + _id;
  // $.get(_url, function (res) {console.log(res);});
  // 启动重定向
  redirector(_url);
});

/********************************
**   招聘页面联系人控制          **
********************************/
// 编辑招聘人联系页面
$('.sub-job-contact').on('click', function () {
  $(this).attr('disabled', true);
  // 提交修改的数据
  up_form_data(URL.sub_job_contact, URL.jobContact, '.job-contact-form');
});

/********************************
**   图片操作控制          **
********************************/
// 图片删除操作
var del_img_info = new Object();

$('.img-scan-box').on('click', function (e) {
  // 当删除按钮点击时
  if ( $(e.target).hasClass('delete') || $(e.target).hasClass('del-scan') ) {
    // 获取当前被删除图片的主要信息
    var _img_node = $(e.currentTarget).find('.scan-img')[0];
    var _img_src = _img_node.src;
    var _img_title = _img_node.title;
    var _img_id = _img_node.dataset.id;
    var _img_url = _img_node.dataset.url;
    // 初始化模态框
    $('#img-edit-ctl').on('show.bs.modal', function(e) {
      var _html_str = '<img class="modal-img" style="width: 200px; margin:auto;" src="' + _img_src + '" title="' + _img_title + '">';
      $('.modal-body').html(_html_str);
    });
    // 模态框显示后，将当前图片信息输出
    $('#img-edit-ctl').on('shown.bs.modal', function(e) {
      del_img_info['url'] = _img_url;
      del_img_info['id'] = _img_id;
    });
    $('#img-edit-ctl').modal('show');
    // 添加模态框隐藏后触发事件
    $('#img-edit-ctl').on('hidden.bs.modal', function(e) {
      // 执行图片删除任务
      del_img_file(URL.deleteImg, window.redirectorImgUri, del_img_info);
    });
  }
});
// 执行删除操作
$('.delete-img').on('click', function(e) {
  // 隐藏模态框
  $('#img-edit-ctl').modal('hide');
});