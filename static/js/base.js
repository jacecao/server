// 所有数据管理界面获取都再这里发出
var GetWin = function (ele, url) {
  $(ele).on('click', function () {
    $.ajax({
      url : url, 
      type : 'GET',
      beforeSend:function(){
        $('.control-win').html(loading());
      },
      success : function(res) {
        $('.control-win').html(res);
      }
    });
  });
};
// 左侧列表操作
// 管理员控制
// 会展信息设置
GetWin('.header-set', URL.headerSet);
//
// 春季会展信息设置
GetWin('.chun-huizhan-set', URL.chun_huizhan_page);
// 秋季会展信息设置
GetWin('.qiu-huizhan-set', URL.qiu_huizhan_page);

// 注册管理员
GetWin('.admin-reg', URL.userREGwin);
// 获取管理列表
GetWin('.admin-list', URL.userList);

// 导航条设置
GetWin('.nav-set', URL.navSet);

// 获取新闻录入
GetWin('.add-news', URL.newsAdd);
// 获取新闻列表
GetWin('.list-news', URL.newsList);
// 获取下线新闻列表
GetWin('.list-del-news', URL.newsUnlineList);

// 获取春季酒店录入
GetWin('.add-hotel', URL.hotelAdd);
// 获取秋季酒店录入
GetWin('.add-autumn-hotel', URL.autumnHotelAdd);
// 获取酒店列表
GetWin('.list-hotel', URL.hotelList);
// 获取秋季酒店列表
GetWin('.list-autumn-hotel', URL.autumnHotelList);

// 获取产品录入
// 展示设计
GetWin('.product-show', URL.productShow);
// 广告制作
GetWin('.product-ad', URL.productAd);
// 活动那个推广
GetWin('.product-ac', URL.productAc);

// 关于我们
GetWin('.about-set', URL.aboutSet);

// 获取职位发布
GetWin('.add-job', URL.jobAdd);
// 获取职位列表
GetWin('.list-job', URL.jobList);
// 获取联系编辑表
GetWin('.job-contact', URL.jobContact);

// 底部信息设置
GetWin('.bottom-set', URL.footerSet);

/********************************
**   图片操作控制          **
********************************/
$('#images_ctl').on('click', function (e) {
  // GetWin('.img_test', URL.getImgCat);
  // 提交修改的数据
});

// 创建富文本对象
/******************************************** 
$ueNodeID UE挂载元素，直接输入ID名称，不需要加“#”
********************************************/
var createUE = function (ueNodeID) {
  // 编辑器实例挂载ID
  var _key = ueNodeID + '_tjh';
  // 销毁已创建的UE编辑器
  /* 
  ** 由于页面中可能因为异步请求同一内容，导致该内容内的副文本对象不会再触发
  ** （在异步请求前就已经生成），为了防止该情况的发生，则需要强制让UE生成实例
  **  UE.ui.Editor方法越过相同ID无法多次生成实例的情况
  **  所以也就需要手工清除掉已经存在的编辑器实例
  */
  if (window[_key] instanceof Object) {
    window[_key] = null;
  }
  window[_key] = new UE.ui.Editor({
    wordCount:false, //关闭字数统计
    elementPathEnabled:false, //关闭elementPath
    enableAutoSave: false, //关闭自动保存
    toolbars:[
                ['source', 'undo', 'redo','bold'], 
                ['italic', 'underline','fontborder','paragraph', '|', 'forecolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
        'rowspacingtop', 'rowspacingbottom', 'lineheight', '|','fontfamily', 'fontsize'],
                ['justifyleft', 'justifycenter', 'justifyright', 'justifyjustify','superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain']
            ] 
  });
  window[_key].render(ueNodeID);
};


