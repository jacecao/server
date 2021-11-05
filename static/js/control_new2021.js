/*
**
以后所有的操作控制将写这这里
与之前的control.js中的操作不同的是
当下将所有操作事件都挂载在指定目录下，避免异步多次加载的问题
**
*/

// 挂载在菜单拦下的操作
var TJHZS_WIN_LEFT = $('#tjhzs-win-left');

// 挂载在右侧操作面板
var TJHZS_WIN_RIGHT = $('#tjhzs-win-right');

TJHZS_WIN_RIGHT.on('click', function(e){
	var ele_id = e.target.id;
	if (ele_id) {
		// 根据不同事件的id值执行不同的操作
		switch(ele_id) {
			case 'show_autumn_hotel':
				display_event_function(ele_id, URL.show_autumn_hotel);
				break;
			case 'show_spring_hotel':
				display_event_function(ele_id, URL.show_spring_hotel);
				break;	
		}	
	}
});
// 显示控制事件执行函数
var display_event_function = function (ele_id, url_ip) {
	var _display_value = $("#" + ele_id).prop('checked');
	$.ajax({
	    url : url_ip,
	    type : 'POST',
	    data : {"display": _display_value},
	    success : function(res) {
	      console.log(res);
	    },
	    error: function (res) {
	      console.error(res);
	    }
	});
};	