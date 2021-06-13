// 链接初始页面
function run () {

  $.ajax({
    url : URL.enter,
    type : 'GET',
    beforeSend:function(){
      $('#app-body').html(loading('正在加载...请稍等'));
    },
    success : function(res) {
      $('#app-body').html(res);
      add_user_info();
    },
    error: function (res) {
      activeMessge(res.statusText, 'remove', '#e91e63');
    }
  });
  // var load = loading();
  // $('#app-body').html(load);
  // var htmlobj = $.ajax({url: URL.enter, async: false});
  // console.log(htmlobj.responseText);
  // $('#app-body').html(htmlobj.responseText);
  // 写入用户信息
  // add_user_info();
}

// 消息弹框
function alertmessage(info, icon, color) {
  var message_body = $('<div class="main-message"></div>');
  var message_box = $('<div class="message-box"></div>');
  var _icon = $('<span class="glyphicon glyphicon-' + icon + ' message-icon"></span>');
  var _info = $('<span>' + info + '</span>');
  // console.log(info);
  _icon.css('color', color);
  _info.css('color', color);
  message_box.append(_icon);
  message_box.append(_info);
  message_body.append(message_box);
  return message_body;
}

// 添加用户信息
function add_user_info (fun) {
  $.ajax({
    url : URL.userINFO,
    type : 'GET',
    success : function(res) {
      if (res !== '') {
        var user = JSON.parse(res);
        // 顶部导航栏添加用户信息
        if (user) {
          var _user = $('<span>欢迎您 '+ user.username +'</span>');
          var _btn = $('<a href="javascript:;" id="exit">退出</button>');
          $('#user-info').html('');
          $('#user-info').append(_user);
          $('#user-info').append(_btn);
          _btn.on('click', function () {
            $(this).attr('disabled', true);
            exit();
          });
        }
        fun && fun();
      }
    },
    error: function (res) {
      activeMessge(res.statusText, 'remove', '#e91e63');
    }
  });
}

// 退出用户登录
function exit () {
  $.ajax({
    url : URL.exit,
    type : 'GET',
    beforeSend:function(){
      $('#app-body').html(loading('正在退出...请稍等'));
    },
    success : function(res) {
      if (parseInt(res)) {
        $('#user-info').html('请登录您的账号');
        run();
      }
    },
    error: function (res) {
      activeMessge(res.statusText, 'remove', '#e91e63');
    }
  });
}

// 显示提示信息
function activeMessge (info, icon, color) {
  var message = alertmessage(info, icon, color);
  $('#app-body').append(message);
  message.fadeIn();
  setTimeout(function () {
    message.fadeOut();
    message.remove();
  }, 3000);
}

// loading..画面加载
// targetele 需要加载动画的目标元素
function loading (info) {
  var _info = info ? info : '正在加载中，请稍后';
  var body = $('<div id="loading"></div>');
  var load = $('<div class="loading-body"></div>');
  var circle1 = $('<div class="circle-1"></div>');
  var circle2 = $('<div class="circle-2"></div>');
  var info = $('<div class="loading-info">'+_info+'</div>');
  load.append(circle1).append(circle2);
  body.append(load).append(info);
  body.hide();
  body.fadeIn('slow');
  return body;
}

// 禁用/启用表单所有元素
function disabled (form, bool) {
  var _bool = (bool == undefined) ? true : bool;
  $(form + ' :input').attr('disabled', _bool);
}

// 获取上传文件名
function getFilename (ele) {
  $(ele).on('change', function () {
    var id = $(this).data('id');
    // console.log(id);
    var file = $('.fileinput_'+id)[0].files[0];
    $('.filename_'+id).text(file.name);
  });
}

// 添加图片控件
/*
** url  上传图片的地址
** dir  指获取图片的文件夹
** 目前我们分为 news hotel product logo header
*/
function Imgwin (dir, url) {
  // 需要生成元素的唯一id
  this.id = parseInt(Math.random()*10 + 10);
  // 获取图片API
  this.url = url;
  // 需要获取图片的路径
  // this.dir = ele.substring(ele.lastIndexOf('-') + 1);
  this.dir = dir;
  // 图片上次选选择模型
  this.model = null;
  // 添加图片表单
  this.body = null;
  // 当前图片信息表单
  this.imginfo = null;
  this.add();
}
Imgwin.prototype = {
  add: function () {
    var that = this;
    var body = $('<div class="add-img add-img-'+that.id+'"></div>');
    var label = $('<label class="desc-label">添加图片描述</label>');
    var desc = $('<input type="text" class="form-control desc-'+that.id+'" name="img_desc_new[]" placeholder="img-desc">');
    var row = $('<div class="row"></div>');
    var up = $('<button type="button" class="btn btn-info col-md-1 up-img up-'+that.id+'" data-id="'+that.id+'">上传</button>');
    var choose = $('<button type="button" class="btn btn-primary col-md-2 col-md-offset-1 choose-'+that.id+'" data-id="'+that.id+'" data-toggle="modal" data-dir="'+that.dir+'" data-target="#choosefile">选择图片</button>');
    var col = $(' <div class="col-md-6"> </div>');
    var btn = $('<button type="button" class="btn btn-default btn-check">选择图片文件</button>');
    var file = $('<input class="fileinput fileinput_'+that.id+'" type="file" name="bgimg" data-id="'+that.id+'">');
    var span = $('<span class="imgname filename_'+that.id+'"></span>');

    var del = $('<button type="button" class="btn btn-danger col-md-1 remove-img remove-img-'+that.id+'" data-id="'+that.id+'"></button>');
    var del_icon = $('<span class="glyphicon glyphicon-trash"></span>');

    btn.append(file);
    col.append(btn).append(span);
    del.append(del_icon);
    row.append(col).append(up).append(choose).append(del);
    body.append(row).append(label).append(desc);

    body.hide();

    $('.add-box').append(body);

    body.fadeIn('slow');

    getFilename('.fileinput_'+that.id);
    that.model = new Imgmodel('.up-'+that.id, '.choose-'+that.id,  that.url);
    that.model.upimg();
    that.model.chooseimg();

    that.body = body;
    // 为删除元素绑定移除功能
    del.on('click', function () {
      // 获取当前图片信息组件
      that.imginfo = that.model.imginfo();
      // 执行清除功能
      that.remove();
    });
  },
  remove: function () {
    // 移除添加图片功能
    var that = this;
    this.body.fadeOut('slow', function () {
      // 注意这里的this的指向发生了改变
      // console.log(that.body);
      this.remove();
      if (that.imginfo) {
        // 注意这里需要查看Imginfo()模型的制定规则
        that.imginfo.ele.remove();
      }
    });
  }
};

// 图片上传后重制图片表单
function Imginfo (target, obj, post) {
  // obj {name, path, url, dir}
  // target 重置表单插入对象
  // console.log(target);
  this.target = target;
  this.obj = obj;
  this.imgid = null;
  this.imgurl = null;
  this.imgname = null;
  // post是否为封面或logo图片,布尔值
  // 默认为不是
  this.post = post ? post : false;
  this.fun = function () {
    var id = Math.floor(Math.random()*10 + 100);
    var _box = $('<div class="info'+id+'"></div>');
    var imgid,imgurl,imgname;
    if (this.post) {
      imgid = $('<input type="hidden" name="post_id_new" value="'+this.obj['id']+'">');
      imgurl = $('<input type="hidden" name="post_url_new" value="'+this.obj['url']+'">');
      imgname = $('<input type="hidden" name="post_name_new" value="'+this.obj['name']+'">');
    } else {
      imgid = $('<input type="hidden" name="img_id_new[]" value="'+this.obj['id']+'">');
      imgurl = $('<input type="hidden" name="img_url_new[]" value="'+this.obj['url']+'">');
      imgname = $('<input type="hidden" name="img_name_new[]" value="'+this.obj['name']+'">');
    }
    _box.append(imgid).append(imgurl).append(imgname);
    // 判断是否需要在这里自动加入图片描述
    // 只有在图片为logo或post情况下才会添加imgdesc
    this.imgid = imgid;
    this.imgurl = imgurl;
    this.imgname = imgname;
    var tar = this.target;
    $(tar).append(_box);
    return _box;
  };
  this.ele = this.fun();
}

// 图片操作模型
// upbtn  上传按钮
// choosebtn 选择图片按钮
// url 图片上传api
function Imgmodel (upbtn, choosebtn, url) {
  this.upbtn = upbtn; // 上传按钮
  this.choosebtn = choosebtn; // 选择图片按钮
  this.url = url;
  // this.target = null;
  this.fun = null;
  this.infobox = null;
  this.id = $(upbtn).data('id');
  this.dir = $(choosebtn).data('dir');
  this.class = 'choose-ok-'+this.id;
}
Imgmodel.prototype = {
  gettarget: function (that, obj) {
    var reset = function () {
      // 清除原始记录
      // 并重制图片信息
      if ($('.'+that.id+'-info-old').length) {
        $('.'+that.id+'-info-old').remove();
      }
      that.infobox = new Imginfo('.'+that.id+'-box', obj, true);
    };
    var imgdesc = null;
    switch (that.id) {
      case 'logo':
      case 'post':
        reset();
        imgdesc = $('<input type="hidden" name="post_desc" value="logo or post">');
        that.infobox.ele.append(imgdesc);
        break;
      case 'news-post':
      case 'hotel-post':
      case 'huizhan-post':
        reset();
        break;
      default:
        that.infobox = new Imginfo('.'+'add-box', obj);
    }
  },
  upimg: function () {
    // ele 上传按钮
    // url api地址
    // fun 上传成功后将要执行的操作
    // console.log(target);
    this.clear();
    var that = this;
    $(that.upbtn).on('click', function() {
      // 检查是否选择了文件
      var up_that = this;
      if ($('.fileinput_'+that.id).val()) {
        $(this).attr('disabled','disabled');
        var file = $('.fileinput_'+that.id)[0].files[0];
        var data = new FormData();
        data.append('up_file', file);
        $.ajax({
          // url : 'http://ajaxtest.com/php/tjhzs/test.php',
          url : that.url,
          type : 'POST',
          data : data,
          // 告诉jQuery不要去处理发送的数据
          processData : false,
          // 告诉jQuery不要去设置Content-Type请求头
          contentType : false,
          beforeSend:function(){
            $('.filename_'+that.id).text("正在上传中.....");
          },
          success : function(responseStr) {
            if (responseStr) {
              var obj = JSON.parse(responseStr);
              // 如果返回的状态是假，则显示错误信息
              if(!obj.status){
                $('.filename_'+that.id).text(obj.mes);
              }else{
                that.gettarget(that, obj['upinfo']);
                var mes = decodeURI(obj['upinfo']['mes']);
                $('.filename_'+that.id).text(mes);
                // 更新浏览图片
                $('.scan-img-'+that.id) && $('.scan-img-'+that.id).attr('src', obj['upinfo']['url']);
              }
            } else {
              $('.filename_'+that.id).text("上传失败啦");
              $(up_that).attr('disabled', false);
            }
          },
          error: function (res) {
            activeMessge(res.statusText, 'remove', '#e91e63');
          }
        });
      } else {
        $('.filename_'+that.id).text('请挑选一张图片');
      }
    });
  },
  clear: function () {
    var that = this;
    $('.fileinput_'+that.id).on('change', function () {
      // console.log('change');
      $(that.upbtn).attr('disabled', false);
      // 当用户重新选择上传图片后
      // 将原来的图片信息删除
      if (that.infobox) {
        that.infobox.ele.remove();
        that.infobox = null;
      }
    });
  },
  chooseimg: function (ele) {
    // 如果已经选择了图片再次选择
    this.clear();
    var that = this;
    $(that.choosebtn).on('click', function () {
      // 模态框确定按钮添加动态class
      $('.choose-ok').addClass(that.class);
      // 那么需要将原始的信息数据清除
      $('.choose-body').html('');
      var load;
      $.ajax({
        url : URL.getImg,
        type : 'GET',
        data : {dir: that.dir},
        beforeSend:function(){
          load = loading();
          // 加入加载组件
          // 禁止模态框的确定按钮
          $('.choose-body').html(load);
          $('.choose-ok').attr('disabled', true);
        },
        success : function(res) {
          // 移除加载组件
          // 加入服务器传过来的视图，启用模态框确定按钮
          load.remove();
          $('.choose-body').html(res);
          $('.choose-ok').attr('disabled', false);
        },
        error: function (res) {
          activeMessge(res.statusText, 'remove', '#e91e63');
        }
      });
      // 为模态框确定按钮添加事件
      $('.'+that.class).on('click', function () {
        // 获取当前选项
        var choose = $('input[name="chooseimg"]:checked');
        // 判断是否有内容被选择
        if (choose.length) {
          $(that.upbtn).attr('disabled', true);
          // 弹出框关闭
          $('#choosefile').modal('hide');
          var obj = {
            id: choose.data('id'),
            url: choose.val(),
            name: choose.data('name'),
            desc: choose.data('desc')
          };
          // 更新当前图片文件名
          $('.filename_'+that.id).text(choose.data('name'));
          // 更新当前图片描述
          $('.desc-'+that.id).val(choose.data('desc'));
          // 更新当前浏览图片
          $('.scan-img-'+that.id) && $('.scan-img-'+that.id).attr('src', choose.val());
          // 更新当前信息
          if (that.infobox) {
            // 如果已经有信息生成，那么修改信息模块
            // console.log('remove');
            that.infobox.imgid.val( choose.data('id') );
            that.infobox.imgurl.val( choose.val() );
            that.infobox.imgname.val( choose.data('name') );
            // that.infobox.ele.remove();
            // that.infobox = null;
          } else {
            // 如果没有图片信息生成那么就加入生成模块
            that.gettarget(that, obj);
          }

        } else {
          // console.log('sss');
          var info = '注意您没有选择图片,请点击关闭按钮关闭';
          activeMessge (info, 'remove', '#e91e63');
        }
      });

    });
    // 模态框隐藏后
    $('#choosefile').on('hidden.bs.modal', function (e) {
      // 移除绑定的事件
      $('.'+that.class).off('click');
      // 移除指定的类名
      $('.choose-ok').removeClass(that.class);
    });
  },
  imginfo: function () {
    return this.infobox;
  },
};


// 复选框模块
function Check_link () {
  this.ele = new Array();
  this.id = new Array();
}
Check_link.prototype = {
  // 注意这里传入的是jquery对象
  run: function (ele) {
    var id = ele.data('id');
    var is_exist = false;
    // 判断是否已经存在这样的id值
    // 如果没有那么加入
    for (var j = 0; j < this.id.length; j++) {
      if (this.id[j] == id) {
        is_exist = true;
      }
    }
    // 判断当前复选框状态
    var is_checked = ele.prop('checked');
    if (is_checked) {
      // 当复选框选中时
      // 那么如果该模块中没有该ID注册那么加入该模块id
      // 接下来生成新的模块信息
      !is_exist && this.id.push(id);
      this.addlink(id);
    } else {
      this.clear(id);
    }

  },
  addlink: function (id) {
    var body = $('<div class="link-body-'+id+'"></div');
    var label = $('<label>链接地址</label>');
    var input = $('<input type="text" class="form-control" name="link_url_'+id+'" placeholder="url">');
    body.append(label).append(input);
    $('.link-box-'+id).append(body);
    body.hide().fadeIn();
    this.ele.push({
      id: id,
      body: body
    });
  },
  clear: function (id) {
    var _exist = false;
    var _index= null;
    for (var i = 0; i < this.ele.length; i++) {
      if (this.ele[i].id == id) {
        _exist = true;
        _index = i;
      }
    }
    if (_exist) {
      this.ele[_index].body.fadeOut();
      this.ele[_index].body.remove();
      this.ele.splice(_index, 1);
      // 当存在这样的模块信息后，才执行移除模块ID信息
      for (var j = 0; j < this.id.length; j++) {
        if (this.id[j] == id) {
          this.id.splice(j, 1);
        }
      }
    } else {
      // 这里是指当一开始复选框就是被选中的状态
      // 当再次点击(即未选中复选框时)，我们需要清除掉旧的信息模块
      // 由于这些模块时后台直接产生，并没在该模块中注册
      // 所以直接通过选择器选择移除，
      // (注意，信息模块都为统一约定模式, 即addlink中那样的结构)
      $('.link-body-'+id).length > 0 && $('.link-body-'+id).remove();
    }

  },
  getele: function (id) {
    for (var i = 0; i < this.ele.length; i++) {
      if (this.ele[i].id == id) {
        return this.ele[i];
      }
    }
  }
};








