-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-11-22 16:12:05
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bbsapp`
--

-- --------------------------------------------------------

--
-- 表的结构 `manager`
--

CREATE TABLE IF NOT EXISTS `manager` (
  `mid` int(20) NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `managerName` varchar(200) NOT NULL COMMENT '管理员名字',
  `managerPsw` varchar(200) NOT NULL COMMENT '管理员密码',
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `manager`
--

INSERT INTO `manager` (`mid`, `managerName`, `managerPsw`) VALUES
(1, 'admin', '49dec5fb8af4eeef7c95e7f5c66c8ae6');

-- --------------------------------------------------------

--
-- 表的结构 `parent_module`
--

CREATE TABLE IF NOT EXISTS `parent_module` (
  `pid` int(20) NOT NULL AUTO_INCREMENT COMMENT '父版块编号',
  `pmoduleName` varchar(200) NOT NULL COMMENT '父版块名称',
  `moderatorId` int(20) NOT NULL COMMENT '版主编号',
  `pmoduleDesc` varchar(200) NOT NULL COMMENT '版块描述',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `parent_module`
--

INSERT INTO `parent_module` (`pid`, `pmoduleName`, `moderatorId`, `pmoduleDesc`) VALUES
(1, '前端开发', 8, 'Web前端开发是从网页制作演变而来的'),
(2, '后端开发', 5, '后端开发是数据库操作和管理'),
(3, '网站SEO', 5, 'SEO是指在了解搜索引擎自然排名机制的基础之上，对网站进行内部及外部的调整优化'),
(8, 'Python', 7, 'PythonPythonPython'),
(9, 'JavaWeb', 0, 'Java Web，是用Java技术来解决相关web互联网领域的技术总和。');

-- --------------------------------------------------------

--
-- 表的结构 `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `postId` int(11) NOT NULL AUTO_INCREMENT COMMENT '帖子id',
  `postTitle` varchar(200) NOT NULL COMMENT '帖子标题',
  `postContent` varchar(2000) NOT NULL COMMENT '帖子内容',
  `postTime` datetime NOT NULL COMMENT '发帖时间',
  `tsmoduleId` int(11) NOT NULL COMMENT '所属子版块的id',
  `times` int(11) NOT NULL COMMENT '浏览次数',
  `postuid` int(11) NOT NULL COMMENT '发帖人id',
  `isTop` int(11) NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `isBoutique` int(11) NOT NULL DEFAULT '0' COMMENT '是否加精',
  `updateTime` datetime NOT NULL COMMENT '当前条帖子有回复就更新',
  PRIMARY KEY (`postId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- 转存表中的数据 `post`
--

INSERT INTO `post` (`postId`, `postTitle`, `postContent`, `postTime`, `tsmoduleId`, `times`, `postuid`, `isTop`, `isBoutique`, `updateTime`) VALUES
(1, 'h5的border-radius如何使用0', '                                                                                                                                            border-radius属性如何使用？                                                                                                                        ', '2016-11-15 21:04:10', 1, 18, 2, 0, 0, '2016-11-20 15:59:15'),
(3, 'CSS的margin用法', '                            <h3>\n	<span style="color:#9933E5;font-family:arial;font-size:13px;background-color:#FFFFFF;">margin是值外边距</span>\n</h3>                        ', '2016-11-16 21:16:03', 5, 31, 11, 0, 0, '2016-11-21 15:46:30'),
(11, 'php网站开发', 'php网站开发php网站开发php网站开发php网站开发', '2016-11-16 21:27:11', 2, 27, 11, 0, 0, '2016-11-21 21:59:35'),
(12, 'java随机数', '                            java随机数java随机数java随机数                        ', '2016-11-16 21:31:03', 7, 32, 11, 0, 0, '2016-11-21 20:49:47'),
(13, 'Node服务端', 'Node服务端Node服务端Node服务端', '2016-11-16 21:32:53', 20, 26, 11, 0, 0, '2016-11-21 20:55:14'),
(14, 'ajax()的用法详解', 'ajax()的用法详解ajax()的用法详解ajax()的用法详解ajax()的用法详解', '2016-11-16 21:34:12', 9, 73, 11, 0, 0, '0000-00-00 00:00:00'),
(15, 'SEO优化的步骤', 'SEO优化的步骤SEO优化的步骤SEO优化的步骤', '2016-11-16 21:37:16', 4, 67, 11, 0, 0, '2016-11-21 20:46:23'),
(16, 'vue社区', 'vue社区vue社区vue社区。', '2016-11-16 21:45:04', 11, 9, 15, 0, 0, '2016-11-21 15:36:38'),
(18, '栅格布局', '栅格布局栅格布局栅格布局栅格布局', '2016-10-18 12:25:10', 10, 24, 8, 0, 0, '2016-11-20 20:37:39'),
(20, 'vue是国人开发的吗', '                            vue是国人开发的vue是国人开发的vue是国人开发的                        ', '2016-11-17 19:10:08', 11, 11, 10, 0, 0, '2016-11-20 16:00:34'),
(23, 'iframe关于滚动条的去除和保留', '<span style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:16px;background-color:#FEFEF2;">iframe嵌入页面后，我们有时需要调整滚动条，例如，去掉全部的滚动条，去掉右边的滚动条且保留底下的滚动条，去掉底下的滚动条且保留右边的滚动条。那么我们应该怎么做呢？</span>', '2016-11-18 11:59:08', 1, 44, 14, 0, 0, '0000-00-00 00:00:00'),
(24, ' 【CSS3动画】transform对文字及图片的旋转、缩放、倾斜和移动', '<span style="font-family:Verdana, Geneva, Arial, Helvetica, sans-serif;font-size:13px;">之前我有写过CSS3的</span><strong><span style="color:;">transform</span></strong><span style="font-family:Verdana, Geneva, Arial, Helvetica, sans-serif;font-size:13px;">这一这特性，对于它的用法，还不是很透彻，今天补充补充，呵呵 你懂的，小司机准备开车了。</span>', '2016-11-18 12:20:58', 5, 34, 14, 0, 0, '2016-11-22 09:29:39'),
(25, 'bootstrap是什么', '                            <span style="color:#333333;font-family:"font-size:18px;background-color:#FFFFFF;"> bootstrap引用了部分html元素，所以头部需写成下面所示的样列。</span>                        ', '2016-11-18 12:27:24', 10, 217, 14, 0, 0, '0000-00-00 00:00:00'),
(26, ' JSON字符串和js对象转换', '$.parseJSON()和JSON.parse()函数用于将格式完好的JSON字符串转为与之对应的JavaScript对象', '2016-11-18 12:34:45', 6, 33, 8, 0, 0, '2016-11-22 09:24:08'),
(27, '五种方式获取文件扩展名-转载未验证', '<span style="font-family:Verdana, Arial, Helvetica, sans-serif;background-color:#FFFFFF;">在PHP面试中，经常碰到此题 ：要求写出5种以上的方法，获取一个文件的扩展名，其实也是在考察面试者基础知识的掌握程度</span>', '2016-11-18 13:15:59', 2, 64, 8, 0, 0, '2016-11-21 20:57:35'),
(29, 'java泛型', '<strong>泛型</strong><span style="color:#4B4B4B;font-family:Verdana, Geneva, Arial, Helvetica, sans-serif;font-size:13px;background-color:#FFFFFF;">（Generic type 或者 generics）是对&nbsp;</span><strong>Java</strong><span style="color:#4B4B4B;font-family:Verdana, Geneva, Arial, Helvetica, sans-serif;font-size:13px;background-color:#FFFFFF;">&nbsp;语言的类型系统的一种扩展，以支持创建可以按类型进行参数化的类。可以把类型参数看作是使用参数化类型时指定的类型的一个占位符，就像方法的形式参数是运行时传递的值的占位符一样。</span>', '2016-11-18 13:59:27', 21, 19, 8, 0, 0, '2016-11-21 22:00:56'),
(30, 'Bootstrap Table使用分享', 'bootStrap table 是一个轻量级的table插件，使用AJAX获取JSON格式的数据，其分页和数据填充很方便，支持国际化', '2016-11-18 20:34:14', 10, 27, 4, 0, 0, '2016-11-21 20:52:43'),
(32, 'bootstrap-treeview', '<span style="font-family:&quot;color:#0000FF;line-height:1.5 !important;">public</span><span style="font-family:&quot;background-color:#F5F5F5;">&nbsp;ActionResult&nbsp;MessageBox(</span><span style="font-family:&quot;color:#0000FF;line-height:1.5 !important;">int</span><span style="font-family:&quot;background-color:#F5F5F5;">?id){</span><br />\n<span style="font-family:&quot;background-color:#F5F5F5;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="font-family:&quot;color:#0000FF;line-height:1.5 !important;">int</span><span style="font-family:&quot;background-color:#F5F5F5;">&nbsp;pageID=</span><span style="font-family:&quot;color:#800080;line-height:1.5 !important;">1</span><span style="font-family:&quot;background-color:#F5F5F5;">;</span><br />\n<span style="font-family:&quot;background-color:#F5F5F5;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="font-family:&quot;color:#0000FF;line-height:1.5 !important;">if</span><span style="font-family:&quot;background-color:#F5F5F5;">&nbsp;(id.HasValue)&nbsp;{</span><br />\n<span style="font-family:&quot;background-color:#F5F5F5;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;pageID=id.Value;</span><br />\n<span style="font-family:&quot;background-color:#F5F5F5;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}</span><br />\n<span style="font-family:&quot;background-color:#F5F5F5;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br />\n<span style="font-family:&quot;background-color:#F5F5F5;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="font-family:&quot;color:#0000FF;line-height:1.5 !important;">var</span><span style="font-family:&quot;background-color:#F5F5F5;">&nbsp;list=DBFactory.GetEntities&lt;Message&gt;(MessageTable.MessageToUserID.Equal(SystemGlobalData.CURRENT_USERID).And(Me', '2016-11-18 20:56:16', 10, 47, 4, 0, 0, '0000-00-00 00:00:00'),
(33, 'CSS的选择器', '最近在研究jQuery的选择器，大家知道jQuery的选择器和css的选择器非常相似，所以整理一下css选择器；\n\ncss1-css3提供非常丰富的选择器，但是由于某些选择器被各个浏览器支持的情况不一样，所以很多选择器在实际css开发中很少用到。', '2016-11-20 09:44:07', 5, 79, 7, 0, 0, '2016-11-20 16:20:54');

-- --------------------------------------------------------

--
-- 表的结构 `reply`
--

CREATE TABLE IF NOT EXISTS `reply` (
  `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回复id',
  `tpostId` int(11) NOT NULL COMMENT '被回复帖子的id',
  `quoteId` int(11) NOT NULL COMMENT '引用回复id',
  `ruid` int(11) NOT NULL COMMENT '回复者id',
  `rcontent` varchar(1000) NOT NULL COMMENT '回复内容',
  `rtime` datetime NOT NULL COMMENT '回复时间',
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

--
-- 转存表中的数据 `reply`
--

INSERT INTO `reply` (`rid`, `tpostId`, `quoteId`, `ruid`, `rcontent`, `rtime`) VALUES
(1, 25, 0, 4, 'Bootstrap1119111', '2016-11-19 15:49:33'),
(2, 23, 0, 4, 'iframe是很难控制高度，不建议使用。', '2016-11-19 15:52:21'),
(3, 26, 0, 4, 'Json格式的数据', '2016-11-19 16:06:28'),
(4, 25, 0, 4, 'Bootstrap201611190412', '2016-11-19 16:13:01'),
(5, 30, 0, 4, 'Bootstrap0445', '2016-11-19 16:45:54'),
(6, 24, 0, 10, 'transform变换', '2016-11-19 16:47:10'),
(7, 25, 0, 2, '法规和规范换个环境换个', '2016-11-19 16:50:05'),
(8, 25, 0, 2, 'Bootstrap前端的UI框架', '2016-11-19 18:50:32'),
(11, 23, 0, 2, 'gdfsgfdgfdgfdg', '2016-11-19 19:05:31'),
(12, 15, 0, 10, '<span style="background-color:#FFFFFF;">近些日子一直在看一些SEO方面的书。</span><span style="background-color:#FFFFFF;">为人有些浮躁，读SEO实在读不出太大营养，除了第一本书外，之后的书就是在不停地向后翻页。没有过太具体的实践，现在就来写一下我眼中的SEO。还希望各位多多指教。</span>', '2016-11-19 19:18:26'),
(13, 15, 0, 10, '呵呵呵呵呵呵呵呵呵', '2016-11-19 19:26:13'),
(15, 27, 0, 10, 'sdfsdfsdafsadf', '2016-11-19 22:51:02'),
(17, 27, 15, 10, '201911191145stay', '2016-11-19 23:46:07'),
(18, 33, 0, 7, '<span style="font-family:verdana, &quot;background-color:#FFFFFF;">通用元素选择器，匹配任何元素</span>', '2016-11-20 09:48:38'),
(19, 11, 0, 7, '<span style="color:#009900;font-family:verdana, Arial, Helvetica, sans-serif;font-size:16px;background-color:#FFFFFF;">socket</span><span style="line-height:1.8;color:#009900;font-size:16px;background-color:#FFFFFF;font-family:宋体;">是怎么建立连接的呢？上面已经提到过了，它建立连接的过程是与</span><span style="color:#009900;font-size:16px;background-color:#FFFFFF;font-family:Verdana;">mysql</span><span style="line-height:1.8;color:#009900;font-size:16px;background-color:#FFFFFF;font-family:宋体;">的客户端和服务端的连接本质是一</span>', '2016-11-20 10:11:04'),
(21, 30, 0, 2, '<span style="font-size:16px;color:#CC33E5;">Bootstrap201611201029</span>', '2016-11-20 10:29:16'),
(25, 13, 0, 2, '<span style="font-size:24px;color:#006600;">Node npm</span>', '2016-11-20 10:36:25'),
(26, 13, 25, 2, '<span style="font-size:24px;color:#EE33EE;">Node npm 的环境很使用</span>', '2016-11-20 10:37:23'),
(27, 13, 26, 2, '<span style="font-size:24px;color:#FF9900;">Node npm 的环境很使用，但是很难搭建。。。。</span>', '2016-11-20 10:38:47'),
(29, 14, 0, 8, '<span style="font-size:24px;color:#99BB00;">Jquery ajax的异步请求方式</span>', '2016-11-20 10:57:07'),
(34, 29, 0, 16, '撒旦法三大发撒地方', '2016-11-20 15:44:50'),
(35, 29, 0, 16, '水电费水电费撒的发撒地方', '2016-11-20 15:47:20'),
(43, 1, 0, 15, '圣诞节快乐；福克斯打飞机是；拉倒', '2016-11-20 15:59:15'),
(44, 20, 0, 15, 'gfdsgsdfgdfgdfg', '2016-11-20 16:00:34'),
(45, 13, 25, 15, 'fdsgfdhdf对手犯规对手犯规的风格的风格丹甫股份', '2016-11-20 16:00:55'),
(46, 27, 0, 15, '说的粉色啊股份的风格撒旦法公司大', '2016-11-20 16:01:13'),
(47, 12, 0, 15, '合肥市共和国发几个', '2016-11-20 16:01:28'),
(48, 18, 0, 15, 'fhgjh天热也啊神灯夫妇的方法', '2016-11-20 16:02:01'),
(49, 24, 6, 15, 'sdagdfagdfg还发个截图豆腐干儿好地方好吧', '2016-11-20 16:02:22'),
(52, 33, 0, 15, 'sadfsdafsdf是打发打发都舒服舒服', '2016-11-20 16:14:26'),
(53, 33, 52, 15, '三大发撒地方水电费水电费', '2016-11-20 16:14:51'),
(54, 3, 0, 15, 'fsadf的发生过的非官方的股份', '2016-11-20 16:20:15'),
(55, 33, 0, 15, 'sdg对方回复回复更好', '2016-11-20 16:20:54'),
(56, 18, 48, 15, 'sadfsadfsdf第三方郭德纲的风格的风格的风格', '2016-11-20 20:37:39'),
(57, 26, 0, 15, '<span style="color:#B8D100;font-size:32px;">反对股份股东非官方的三个回家感觉</span>', '2016-11-20 20:41:59'),
(58, 15, 13, 15, '<span style="color:#EE33EE;font-size:24px;">afs大丰收的放松的方式的范德萨分的萨芬说的</span>', '2016-11-20 21:07:13'),
(60, 16, 0, 29, '官方好风光好风光好风光好', '2016-11-21 15:36:38'),
(61, 3, 0, 29, 'my name is weide', '2016-11-21 15:46:30');

-- --------------------------------------------------------

--
-- 表的结构 `sub_module`
--

CREATE TABLE IF NOT EXISTS `sub_module` (
  `sid` int(20) NOT NULL AUTO_INCREMENT COMMENT '子版块id',
  `smoduleName` varchar(200) NOT NULL COMMENT '子版块名称',
  `smodulePic` varchar(200) NOT NULL COMMENT '子版块图片',
  `tParenModuleId` int(20) NOT NULL COMMENT '所属父版块id',
  `smoduleDesc` varchar(200) NOT NULL COMMENT '子版块描述',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `sub_module`
--

INSERT INTO `sub_module` (`sid`, `smoduleName`, `smodulePic`, `tParenModuleId`, `smoduleDesc`) VALUES
(1, 'HTML5', 'uploads/2016/11/12/237324582704c4f0fe7706890099.jpg', 1, '万维网的核心语言、标准通用标记语言下的一个应用超文本标记语言HTML的第五次重大修改'),
(2, 'php交流', 'uploads/2016/11/12/609431582705a79759c110303384.jpg', 2, 'PHP是一种通用开源脚本语言。'),
(4, 'SEO优化', 'uploads/2016/11/12/2094715827064f1e278891558848.png', 3, 'SEO优化SEO优化SEO优化SEO优化'),
(5, 'CSS讨论', 'uploads/2016/11/12/713378582705b3ef69f169857390.jpg', 1, '层叠样式表'),
(6, 'JavaScript交流', 'uploads/2016/11/12/593870582706d518b37795432271.jpg', 1, 'JavaScript是前端的核心语言'),
(7, 'Java交流', 'uploads/2016/11/12/419546582705d986f54362984080.jpg', 2, 'Java是一门面向对象编程语言'),
(9, 'Jquery框架', 'uploads/2016/11/12/718940582705e20eb72740404406.jpg', 1, 'jQuery是一个快速、简洁的JavaScript框架'),
(10, 'Bootstrap交流', 'uploads/2016/11/12/673066582706469acab757714923.jpg', 1, 'Bootstrap是Twitter推出的一个用于前端开发的开源工具包'),
(11, 'vuejs', 'uploads/2016/11/12/600588582706af399ea497578041.jpg', 1, 'vuejs是一个构建数据驱动的 web 界面的渐进式框架。'),
(20, 'NodeJs', 'uploads/2016/11/12/55019858270ce54ca77578350405.jpg', 2, 'Node.js 是一个基于 Chrome V8 引擎的 JavaScript 运行环境。'),
(21, 'java技术交流区', 'uploads/2016/11/20/2159395831a220e428b440002329.jpg', 9, 'java技术交流区java技术交流区java技术交流区'),
(22, 'python爬虫', 'uploads/2016/11/20/7035885831a20eab438318162094.jpg', 8, 'python爬虫python爬虫python爬虫');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '唯一标识符',
  `name` varchar(200) NOT NULL COMMENT '用户名称',
  `psw` varchar(200) NOT NULL COMMENT '用户密码',
  `sex` varchar(200) NOT NULL DEFAULT '未填写' COMMENT '用户性别',
  `email` varchar(200) NOT NULL COMMENT '邮箱地址',
  `qq` varchar(200) NOT NULL DEFAULT '未填写' COMMENT '用户qq',
  `photo` varchar(200) NOT NULL COMMENT '用户头像',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '用户权限',
  `reallyName` varchar(200) NOT NULL DEFAULT '未填写' COMMENT '用户真实姓名',
  `birthday` varchar(200) NOT NULL DEFAULT '未填写' COMMENT '用户生日',
  `homeplace` varchar(200) NOT NULL DEFAULT '未填写' COMMENT '用户出生地',
  `bloodType` varchar(200) NOT NULL DEFAULT '未填写' COMMENT '用户血型',
  `fixedTel` varchar(200) NOT NULL DEFAULT '未填写' COMMENT '用户固定电话',
  `phone` varchar(200) NOT NULL DEFAULT '未填写' COMMENT '用户电话',
  `website` varchar(200) NOT NULL DEFAULT 'http://' COMMENT '用户主页',
  `school` varchar(200) NOT NULL DEFAULT '未填写' COMMENT '用户毕业学校',
  `degree` varchar(200) NOT NULL DEFAULT '未填写' COMMENT '用户学历',
  `company` varchar(200) NOT NULL DEFAULT '未填写' COMMENT '用户公司',
  `profession` varchar(200) NOT NULL DEFAULT '未填写' COMMENT '用户职业',
  `job` varchar(200) NOT NULL DEFAULT '未填写' COMMENT '用户职位',
  `income` varchar(200) NOT NULL DEFAULT '未填写' COMMENT '用户年收入',
  `registerTime` datetime NOT NULL COMMENT '注册时间',
  `lastLogin` datetime NOT NULL COMMENT '最后一次登录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `psw`, `sex`, `email`, `qq`, `photo`, `level`, `reallyName`, `birthday`, `homeplace`, `bloodType`, `fixedTel`, `phone`, `website`, `school`, `degree`, `company`, `profession`, `job`, `income`, `registerTime`, `lastLogin`) VALUES
(2, 'admin', '9cbf8a4dcb8e30682b927f352d6559a0', '2', '2663251638@qq.com', '2663251638', 'uploads/2016/11/10/2448085824251a7b86f760611800.jpg', 0, '李四', '1997-11-20', '山东省、莱芜市、莱城区', 'B', '0778-3124265', '13264467325', 'http://www.1233.com', '北京大学', '', '阿里巴巴', 'IT', '经理', '3000000', '2016-11-02 00:00:00', '2016-11-22 16:11:18'),
(3, 'admin1', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '2', '2663251638@qq.com', '2663251638', '', 0, 'admin01', '1997-11-20', '未填写', '未填写', '0778-3124265', '13264467325', 'http://www.1233.com', '科技大学', '', '阿里巴巴', 'IT', '经理', '3000000', '2016-11-02 00:00:00', '2016-11-03 19:52:21'),
(4, '李四', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '', '2663251638@qq.com', '2663251638', '', 0, 'admin111', '1997-11-20', '未填写', '未填写', '0778-3124265', '13264467325', 'http://www.1233.com', '科技大学', '', '阿里巴巴', 'IT', '经理', '3000000', '2016-11-02 00:00:00', '2016-11-19 10:42:05'),
(5, '张三', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '', '2663251638@qq.com', '2663251638', 'uploads/2016/11/06/503852581f1ee96a626571575782.jpg', 0, 'admin111', '1997-11-20', '省份、城市、县/区/镇', 'AB', '0778-3124265', '13264467325', 'http://www.1233.com', '科技大学', '', '阿里巴巴', 'IT', '经理', '3000000', '2016-11-02 00:00:00', '2016-11-06 20:15:23'),
(6, 'admin2', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '', '2663251638@qq.com', '2663251638', '', 0, 'admin111', '1997-11-20', '未填写', '未填写', '0778-3124265', '13264467325', 'http://www.1233.com', '科技大学', '', '阿里巴巴', 'IT', '经理', '3000000', '2016-11-02 21:49:35', '2016-11-02 21:49:35'),
(7, 'admin3', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '男', '2663251638@qq.com', '2663251638', 'uploads/2016/11/20/46535658310186e81ae448582964.jpg', 0, 'admin111', '1983-3-3', '河北省、唐山市、古冶区', 'O', '0778-3124265', '13264467325', 'http://www.1233.com', '科技大学', '', '阿里巴巴', 'IT', '经理', '3000000', '2016-11-02 21:51:12', '2016-11-20 10:10:15'),
(8, 'MrStay', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '男', '2663251638@qq.com', '2663251638', 'uploads/2016/11/05/136308581d929778a3b656082866.jpg', 0, 'admin111', '1981-3-30', '河南省、驻马店市、古吕镇', 'AB', '0778-3124265', '13264467325', 'http://www.1233.com', '科技大学', '', '阿里巴巴', 'IT', '经理', '3000000', '2016-11-05 15:50:23', '2016-11-20 10:55:55'),
(10, '胡歌', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '保密', '2663251638@qq.com', '2663251638', '', 0, 'admin111', '--', '省份、城市、县/区/镇', '未填写', '0778-3124265', '13264467325', 'http://www.1233.com', '科技大学', '', '阿里巴巴', 'IT', '经理', '3000000', '0000-00-00 00:00:00', '2016-11-22 16:08:53'),
(11, '王宝强', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '', '2663251638@qq.com', '2663251638', 'uploads/2016/11/17/118356582d876838cfb903985235.jpg', 0, 'admin111', '1997-11-20', '未填写', '未填写', '0778-3124265', '13264467325', 'http://www.1233.com', '科技大学', '', '阿里巴巴', 'IT', '经理', '3000000', '0000-00-00 00:00:00', '2016-11-17 19:49:45'),
(14, '阿伦-克拉布', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '', '2663251638@qq.com', '2663251638', '', 0, 'admin111', '1997-11-20', '未填写', '未填写', '0778-3124265', '13264467325', 'http://www.1233.com', '科技大学', '', '阿里巴巴', 'IT', '经理', '3000000', '0000-00-00 00:00:00', '2016-11-18 11:56:52'),
(15, 'angle', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', '1076023927@qq.com', '未填写', 'uploads/2016/11/16/321942582c628c32631394923074.jpg', 0, 'baby', '--', '省份、城市、县/区/镇', '未填写', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '0000-00-00 00:00:00', '2016-11-20 15:55:39'),
(16, 'baby', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', '1239085@qq.com', '未填写', '', 0, '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-16 21:52:15', '2016-11-22 15:31:37'),
(29, '韦德', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', '2584480035@qq.com', '未填写', '', 0, '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-17 08:51:20', '2016-11-21 15:33:14'),
(30, 'James', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', '3584480035@qq.com', '未填写', '', 0, '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-17 09:01:34', '2016-11-21 20:07:26');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
