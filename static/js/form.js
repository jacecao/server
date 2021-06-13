// 注册用户校验
var HTML = '';
var check_length = false;
var pas_check = true;
var captchar_check = false;
var info = {
  user: '用户名不少于6位',
  pas: '密码长度不少于8位',
  checkPAS: '对不起密码不一致',
  captchar: '验证码错误',
  error: '登录出现错误，请重新登录',
  success: '登录成功',
  regsuccess: '注册管理员成功',
  rootsuccess: '注册超级用户成功',
  regfail: '注册管理员失败!',
  rootfail: '注册超级用户失败',
  repeat: '对不起该用户名已经存在',
  err: '对不起你没有操作权限'
};

// 检查是否所有的条件都符合提交表单的要求
function is_sub () {
  if (check_length && pas_check && captchar_check) {
    // console.log('ok');
    $('.btn-sub').removeAttr('disabled');
  } else {
    // console.log('ss');
    $('.btn-sub').attr('disabled', 'disabled');
  }
}

// 长度是否达标
function Check (selector, length, info) {

  this.id = 'helpBlock' + parseInt(Math.random() * 100);
  this.has_info = false;
  this.info = info;

  this.fun = function () {

    var id = this.id;
    var ele = $(selector);
    var user = '';
    var info = this.info;

    ele.on('focus', function () {
      user = ele.val();
      if (user === '' && user.length < length) {
        if (!this.has_info) {
          HTML = '<p class="text-danger '+ id +'">'+ info + '</p>';
          $(this).parent().append(HTML);
          this.has_info = true;
        } else {
          $('.' + id).text(info);
          $('.' + id).fadeIn();
        }
      } else if(user.length >= length){
        $('.' + id).hide();
        check_length = true;
        is_sub();
      }
    });

    ele.keyup( function () {
      user = ele.val();
      if (user.length < length) {
        check_length = false;
         $('.' + id).text(info);
        $('.' + id).fadeIn();
      } else {
        check_length = true;
        $('.' + id).hide();
      }
      is_sub();
    });

    ele.on('blur', function () {
      user = ele.val();
      if (user === '' || user.length >= length) {
        $('.' + id).hide();
        check_length = true;
        is_sub();
      }
    });

  };
  // 检查用户名唯一性
  this.name = function () {
    var id = this.id;
    var ele = $(selector);
    var user = '';
    ele.on('blur', function () {
      user = ele.val();
      if (user.length >= length) {
        $.post(URL.usernameCheck, {username: user}, function(res) {
          if (parseInt(res)) {
            check_length = true;
          } else {
            check_length = false;
            $('.' + id).text('对不起该用户名已经存在');
            $('.' + id).fadeIn();
          }
          is_sub();
        });
      }
    });
  };

  this.fun();

}

// 密码是否相同
function checkPass(psw_r, psw, info) {

  var _id = 'helpBlock' + parseInt(Math.random() * 100);

  $(psw_r).on('blur', function () {
    // 当验证密码框的字符串长度等于密码框长度时开始验证
    if ($(this).val().length >= $(psw).val().length) {
      if ($(this).val() !== $(psw).val()) {
        HTML = '<p class="text-danger '+ _id +'">'+ info + '</p>';
        $(this).parent().append(HTML);
        pas_check = false;
      } else {
        pas_check = true;
      }
    }
    is_sub();
  });

  $(psw_r).on('focus', function () {
    $('.' + _id).remove();
  });
}

// 识别码检查
function checkCaptcher (selector, info, fun) {

  var _id = 'helpBlock' + parseInt(Math.random() * 100);

  $(selector).keyup( function () {
    $('.' + _id).remove();
    captchar_check = false;
    is_sub();
    // 当输入框不为空时才会进入后台验证
    if ($(this).val() && $(this).val().length === 4) {
      $.get(URL.captchar, {usercode: $(this).val()}, function (data) {
        if (parseInt(data) != 1) {
          HTML = '<p class="text-danger '+ _id +'">'+ info + '</p>';
          $('.captchar-input').append(HTML);
          captchar_check = false;
        } else {
          captchar_check = true;
          $('.' + _id).remove();
        }
        // 注意由于此处时异步执行
        // 所以不能把is_sub()放在异步外执行
        is_sub();
      });
    } else if($(this).val() == ''){
      $('.' + _id).remove();
      HTML = '<p class="text-danger '+_id+'">请输入验证码</p>';
      $('.captchar-input').append(HTML);
      captchar_check = false;
      is_sub();
    }
  });

  $(selector).on('blur', function () {
    is_sub();
    if($(this).val() == '') {
      $('.' + _id).remove();
    }
  });
}



// 开始禁用提交
is_sub();
// 检查用户名
var _user = new Check('#user', 6, info.user);
var _user_log = new Check('#user-log', 6, info.user);
_user.name();
// 检查密码长度和一致性检查
var _psw = new Check('#psw', 8, info.pas);
var _psw_log = new Check('#psw-log', 8, info.pas);
checkPass('#psw_r', '#psw', info.checkPAS);
// 检查识别码
checkCaptcher('#captchar',info.captchar);


// 超级用户注册提交
$('.btn-root').on('click', function () {

  $('.btn-root').attr('disabled', 'disabled');

  $.ajax({
    url : URL.userREG,
    type : 'POST',
    data : $('.userform').serialize(),
    beforeSend:function(){
      $('#app-body').html(loading('正在提交注册信息！'));
    },
    success : function(res) {
      switch (parseInt(res)) {
        case 1:
          activeMessge(info.rootsuccess, 'ok', '#8bc34a');
          setTimeout(function(){
            run();
          }, 3000);
          break;
        case 0:
          $('#app-body').html(loading('注册出错，正在返回'));
          activeMessge(info.rootfail, 'remove', '#e91e63');
          $.get(URL.enter, function (res) {
            if (res) {
              $('#app-body').html(res);
            }
          });
          break;
      }
    },
    error: function (res) {
      activeMessge(res.statusText, 'remove', '#e91e63');
    }
  });
});


// 管理员注册提交
$('.btn-reg').on('click', function () {

  $('.btn-reg').attr('disabled', 'disabled');

  $.ajax({
    url : URL.userREG,
    type : 'POST',
    data : $('.userform').serialize(),
    beforeSend:function(){
      $('.control-win').html(loading('正在提交注册信息！'));
    },
    success : function(res) {
      switch (parseInt(res)) {
        case 0:
          activeMessge(info.regfail, 'remove', '#e91e63');
          break;
        case 4:
          activeMessge(info.err, 'remove', '#e91e63');
          break;
        default:
          activeMessge(info.regsuccess, 'ok', '#8bc34a');
          $('.control-win').html(loading('正前往管理员列表！'));
          $.get(URL.userList, function (res) {
            if (res) {
              $('.control-win').html(res);
            }
          });
          break;
      }
    },
    error: function (res) {
      activeMessge(res.statusText, 'remove', '#e91e63');
    }
  });
});


// 用户登录提交
$('.btn-log').on('click', function () {

  $('.btn-log').attr('disabled', 'disabled');

  $.ajax({
    url : URL.userLOG,
    type : 'POST',
    data : $('.userform').serialize(),
    beforeSend:function(){
      $('#app-body').html(loading('提交您的登录信息'));
    },
    success : function(res) {
      if (parseInt(res)) {
        // 激活账号成功登录信息
        activeMessge(info.success, 'ok', '#8bc34a');
        $('#app-body').html(loading('正在获取主页面'));
        // 获取用户信息
        add_user_info ( function () {
          // 获取操作界面
          $.get(URL.win, function (res) {
            $('#app-body').html(res);
          });
        });
      } else {
        activeMessge(info.error, 'remove', '#f00');
        $('#app-body').html(loading('登录出错，返回登录页'));
        $.get(URL.enter, function (res) {
          $('#app-body').html(res);
        });
      }
    },
    error: function (res) {
      activeMessge(res.statusText, 'remove', '#e91e63');
    }
  });

});

// 刷新识别码
$('.change-captchar').on('click', function () {
  $('.captchar-img').attr('src', URL.captcharIMG);
});
