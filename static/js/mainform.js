/********************************
**    表单通用功能模块         **
*********************************/
// 提示信息
var message = {
  edit_success: '数据提交成功！',
  edit_error: '数据提交失败，请重新填写',
  del_success: '数据删除成功！',
  del_error: '数据删除失败',
  recovery_success: '数据恢复成功',
  recovery_error: '数据恢复失败'
};

// 获取上传文件名
getFilename('.fileinput');

// 初始禁用指定表单
disabled('.form-static');
function edit (form) {
  $('.form-edit').on('click', function () {
    $(this).attr('disabled', true);
    $('.form-cancel').attr('disabled', false);
    disabled(form, false);
  });
  $('.form-cancel').on('click', function () {
    $(this).attr('disabled', true);
    $('.form-edit').attr('disabled', false);
    disabled(form, true);
  });
}
// 启动表单编辑修改控制
edit('.form-static');


// 重定向
var redirector = function (api) {
  $.ajax({
    url : api,
    type : 'GET',
    beforeSend:function(){
      $('.control-win').append(loading('页面跳转中...稍等'));
    },
    success : function(res) {
      $('.control-win').html(res);
    },
    error: function (res) {
      activeMessge(res.statusText, 'remove', '#e91e63');
    }
  });
};

// 重制加载
var Addloading = function () {
  this.load = loading('数据上传中，请稍等');
};
Addloading.prototype = {
  add: function () {
    var that = this;
    $('.form-reset').css('opacity', '0.5');
    $('.control-win').append(that.load);
  },
  remove: function () {
    var that = this;
    $('.form-reset').css('opacity', '1');
    that.load.remove();
  }
};

// 表单数据提交
// url 数据提交地址 
// re_url 提交成功后重定向地址
// form 需要提交的表单
var up_form_data = function (url, re_url, form) {
  // 加入loading动画
  var load = new Addloading();
  load.add();
  // 表单序列化测试查看
  // alert($(form).serialize());
  // 提交数据
  
  $.ajax({
    url : url,
    type : 'POST',
    data : $(form).serialize(),
    success : function(res) {
      load.remove();
      // console.log(res);
      if (parseInt(res)) {
        activeMessge(message.edit_success, 'ok', '#8bc34a');
        // 重定向表单 移除加载动画
        redirector(re_url);
      } else {
        activeMessge(message.edit_error, 'remove', '#e91e63');
        load.remove();
        disabled(form, false);
      }
    },
    error: function (res) {
      load.remove();
      activeMessge(res.statusText, 'remove', '#e91e63');
      disabled(form, false);
    }
  });
  
};

// 删除数据
/*******************************  
* url 数据提交地址 
* re_url 提交成功后重定向地址
* id 当前数据id
**********************************/
var del_data = function (url, re_url, id) {
  // 加入loading动画
  var load = new Addloading();
  load.add();
  // 提交数据
  $.ajax({
    url : url,
    type : 'POST',
    data : {'id': id},
    success : function(res) {
      load.remove();
      // console.log(res);
      if (parseInt(res)) {
        activeMessge(message.del_success, 'ok', '#8bc34a');
        // 重定向表单 移除加载动画
        redirector(re_url);
      } else {
        activeMessge(message.del_error, 'remove', '#e91e63');
        load.remove();
      }
    },
    error: function (res) {
      load.remove();
      activeMessge(res.statusText, 'remove', '#e91e63');
    }
  });
};

// 删除数据
/*******************************  
* url 数据提交地址 
* re_url 提交成功后重定向地址
* id 当前数据id
**********************************/
var recovery_data = function (url, re_url, id) {
  // 加入loading动画
  var load = new Addloading();
  load.add();
  // 提交数据
  $.ajax({
    url : url,
    type : 'POST',
    data : {'id': id},
    success : function(res) {
      load.remove();
      // console.log(res);
      if (parseInt(res)) {
        activeMessge(message.recovery_success, 'ok', '#8bc34a');
        // 重定向表单 移除加载动画
        redirector(re_url);
      } else {
        activeMessge(message.recovery_error, 'remove', '#e91e63');
        load.remove();
      }
    },
    error: function (res) {
      load.remove();
      activeMessge(res.statusText, 'remove', '#e91e63');
    }
  });
};

// 设置置顶
/*******************************  
* url 数据提交地址 
* re_url 提交成功后重定向地址
* id 当前数据id
**********************************/
var set_top = function(url, re_url, id){
  // 加入loading动画
  var load = new Addloading();
  load.add();
  // 提交数据
  $.ajax({
    url : url,
    type : 'POST',
    data : {'id': id},
    success : function(res) {
      load.remove();
      // console.log(res);
      if (parseInt(res)) {
        activeMessge("置顶成功", 'ok', '#8bc34a');
        // 重定向表单 移除加载动画
        redirector(re_url);
      } else {
        activeMessge("置顶失败", 'remove', '#e91e63');
        load.remove();
      }
    },
    error: function (res) {
      load.remove();
      activeMessge(res.statusText, 'remove', '#e91e63');
    }
  });
};

// 取消置顶
/*******************************  
* url 数据提交地址 
* re_url 提交成功后重定向地址
* id 当前数据id
**********************************/
var cancel_top = function(url, re_url, id){
  // 加入loading动画
  var load = new Addloading();
  load.add();
  // 提交数据
  $.ajax({
    url : url,
    type : 'POST',
    data : {'id': id},
    success : function(res) {
      load.remove();
      // console.log(res);
      if (parseInt(res)) {
        activeMessge("设置成功", 'ok', '#8bc34a');
        // 重定向表单 移除加载动画
        redirector(re_url);
      } else {
        activeMessge("设置失败", 'remove', '#e91e63');
        load.remove();
      }
    },
    error: function (res) {
      load.remove();
      activeMessge(res.statusText, 'remove', '#e91e63');
    }
  });
};


// 删除图片数据
/*******************************  
* url 数据提交地址 
* re_url 提交成功后重定向地址
* imginfo 图片对象信息
**********************************/
var del_img_file = function (url, re_url, imginfo) {
  // 加入loading动画
  var load = new Addloading();
  load.add();
  // 提交数据
  $.ajax({
    url : url,
    type : 'POST',
    data : imginfo,
    success : function(res) {
      load.remove();
      // console.log(res);
      if (parseInt(res)) {
        activeMessge(message.del_success, 'ok', '#8bc34a');
        // 重定向表单 移除加载动画
        redirector(re_url);
      } else {
        activeMessge(message.del_error, 'remove', '#e91e63');
        load.remove();
      }
    },
    error: function (res) {
      load.remove();
      activeMessge(res.statusText, 'remove', '#e91e63');
    }
  });
};
