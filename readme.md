## 测试账号
super
测试账户：test123
密码：test123test

normal
测试账户：test1234
密码：test12345678
***
## 数据库修改信息

* 加入数据状态值

status => 标识是否删除

* 加入是否上线机制

offline

* 加入置顶属性

movetop => 修改时间权重来实现

>/ ALTER TABLE `news` ADD `status` INT(1) NULL DEFAULT '1' AFTER `status`;

***

## 主文件修改记录

* 修改入口配置文件
* 添加前端读取数据入口
* 修正所有库的引入路径
* 添加招聘联系人修改入口

* 添加富文本编辑插件

***

## 需要解决的问题

* 需要对about数据进行合理的重构
* 招聘邮件信息修改
* 上线下线功能的制作
* 修复前端图片上传BUG



## bug 2021-5-10

* 修复核心文件FILE中方法名不规范的问题
* 修改控制器admin中的view方法，减少不必要代码
* -- huizhan页面获取模块还需要添加json数据
* mainform up_form_data 关闭数据传送 进行测试
* common.js 中Imgmodel有问题，主要需要解决的故障就是封面图片的传输，这里有故障，导致封面图片无法完成