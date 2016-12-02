-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-12-02 19:28:35
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
  `power` int(11) NOT NULL DEFAULT '0' COMMENT '管理员类型',
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `manager`
--

INSERT INTO `manager` (`mid`, `managerName`, `managerPsw`, `power`) VALUES
(1, 'admin', '49dec5fb8af4eeef7c95e7f5c66c8ae6', 1),
(2, 'admin1', '49dec5fb8af4eeef7c95e7f5c66c8ae6', 0),
(8, 'a', '670b14728ad9902aecba32e22fa4f6bd', 0);

-- --------------------------------------------------------

--
-- 表的结构 `notice`
--

CREATE TABLE IF NOT EXISTS `notice` (
  `nid` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `noticeContent` varchar(200) NOT NULL COMMENT '公告内容',
  PRIMARY KEY (`nid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `notice`
--

INSERT INTO `notice` (`nid`, `noticeContent`) VALUES
(1, '欢迎来到猿学社区， 这是一个程序猿的交流天地。');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `parent_module`
--

INSERT INTO `parent_module` (`pid`, `pmoduleName`, `moderatorId`, `pmoduleDesc`) VALUES
(1, '前端开发', 14, 'Web前端开发是从网页制作演变而来的'),
(2, '后端开发', 15, '后端开发是数据库操作和管理'),
(3, '网站SEO', 29, 'SEO是指在了解搜索引擎自然排名机制的基础之上，对网站进行内部及外部的调整优化'),
(8, 'Python', 0, 'PythonPythonPython'),
(18, 'test1', 0, 'test1'),
(19, 'test2', 0, 'test2'),
(23, 'test4', 42, 'sadf');

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
  `postStatus` int(11) NOT NULL DEFAULT '0' COMMENT '帖子是否需要验证状态，默认0无需验证',
  `updateTime` datetime NOT NULL COMMENT '当前条帖子有回复就更新',
  `isShield` int(11) NOT NULL DEFAULT '0' COMMENT '是否屏蔽',
  PRIMARY KEY (`postId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- 转存表中的数据 `post`
--

INSERT INTO `post` (`postId`, `postTitle`, `postContent`, `postTime`, `tsmoduleId`, `times`, `postuid`, `isTop`, `isBoutique`, `postStatus`, `updateTime`, `isShield`) VALUES
(1, 'h5的border-radius如何使用', '                            border-radius属性如何使用？                        ', '2016-11-15 21:04:10', 1, 93, 2, 0, 1, 0, '2016-11-23 16:58:49', 0),
(3, 'CSS的margin用法', '                            <h3>\n	<span style="color:#9933E5;font-family:arial;font-size:13px;background-color:#FFFFFF;">margin是值外边距</span>\n</h3>                        ', '2016-11-16 21:16:03', 5, 48, 11, 0, 0, 0, '2016-11-29 12:08:10', 0),
(13, 'Node服务端', 'Node服务端Node服务端Node服务端', '2016-11-16 21:32:53', 20, 50, 11, 0, 1, 0, '2016-11-24 23:27:51', 0),
(14, 'ajax()的用法详解', 'ajax()的用法详解ajax()的用法详解ajax()的用法详解ajax()的用法详解', '2016-11-16 21:34:12', 9, 83, 11, 0, 1, 0, '2016-11-23 18:42:30', 1),
(15, 'SEO优化的步骤', 'SEO优化的步骤SEO优化的步骤SEO优化的步骤', '2016-11-16 21:37:16', 4, 88, 11, 0, 0, 0, '2016-11-23 15:52:24', 0),
(16, 'vue社区', 'vue社区vue社区vue社区。', '2016-11-16 21:45:04', 11, 10, 15, 0, 0, 0, '2016-11-21 15:36:38', 0),
(18, '栅格布局', '栅格布局栅格布局栅格布局栅格布局', '2016-10-18 12:25:10', 10, 24, 8, 0, 0, 0, '2016-11-20 20:37:39', 0),
(20, 'vue是国人开发的吗', '                            vue是国人开发的vue是国人开发的vue是国人开发的                        ', '2016-11-17 19:10:08', 11, 27, 10, 0, 0, 0, '2016-11-20 16:00:34', 1),
(23, 'iframe关于滚动条的去除和保留', '<span style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:16px;background-color:#FEFEF2;">iframe嵌入页面后，我们有时需要调整滚动条，例如，去掉全部的滚动条，去掉右边的滚动条且保留底下的滚动条，去掉底下的滚动条且保留右边的滚动条。那么我们应该怎么做呢？</span>', '2016-11-18 11:59:08', 1, 103, 14, 0, 1, 1, '0000-00-00 00:00:00', 0),
(24, ' 【CSS3动画】transform对文字及图片的旋转、缩放、倾斜和移动', '<span style="font-family:Verdana, Geneva, Arial, Helvetica, sans-serif;font-size:13px;">之前我有写过CSS3的</span><strong><span style="color:;">transform</span></strong><span style="font-family:Verdana, Geneva, Arial, Helvetica, sans-serif;font-size:13px;">这一这特性，对于它的用法，还不是很透彻，今天补充补充，呵呵 你懂的，小司机准备开车了。</span>', '2016-11-18 12:20:58', 5, 66, 14, 0, 0, 0, '2016-11-29 12:08:29', 0),
(25, 'bootstrap是什么', '                            <span style="color:#333333;font-family:"font-size:18px;background-color:#FFFFFF;"> bootstrap引用了部分html元素，所以头部需写成下面所示的样列。</span>                        ', '2016-11-18 12:27:24', 10, 253, 14, 0, 0, 0, '2016-11-30 19:22:00', 0),
(26, ' JSON字符串和js对象转换', '$.parseJSON()和JSON.parse()函数用于将格式完好的JSON字符串转为与之对应的JavaScript对象', '2016-11-18 12:34:45', 6, 96, 8, 0, 0, 0, '2016-11-24 23:19:28', 0),
(27, '五种方式获取文件扩展名-转载未验证', '<span style="font-family:Verdana, Arial, Helvetica, sans-serif;background-color:#FFFFFF;">在PHP面试中，经常碰到此题 ：要求写出5种以上的方法，获取一个文件的扩展名，其实也是在考察面试者基础知识的掌握程度</span>', '2016-11-18 13:15:59', 2, 112, 8, 0, 1, 0, '2016-11-24 11:42:23', 1),
(35, '关于面向对象----继承', '<span style="color:#337FE5;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:16px;background-color:#FFFFFF;">先说说继承是什么吧？也许我们最早接触有关继承的应该是“遗产”？？也许电视剧看多了，总有家族为了这玩意儿整的你死我活，确实听看不下去的哈，但是对于咱大JS而言，可就变得十分和蔼，可亲。毕竟没有人来争夺，也不会有任何事故，最多来些许bug等等。废话不多说，进入正题！！</span>', '2016-11-23 15:40:05', 6, 90, 11, 0, 1, 0, '2016-11-24 14:32:57', 0),
(36, 'HTML5标签', '                                                                                    <p style="font-family:verdana, Arial, helvetica, sans-seriff;background-color:#FFFFFF;">\n	<span style="color:#0000FF;font-size:16px;">不允许写结束标记的标签</span><span style="font-size:16px;">：area(定义图像映射中的区域)、base(为页面上的所有链接规定默认地址或默认目标)、br、col(为表格中一个或多个列定义属性值)、embed(定义嵌入的内容，比如插件--5)、hr、img、input、keygen、link、meta、param、source、track、wbr<span id="__kindeditor_bookmark_start_2__"></span></span>\n</p>\n<p style="font-family:verdana, Arial, helvetica, sans-seriff;background-color:#FFFFFF;">\n	<span style="font-size:16px;"><span><span style="font-family:verdana, Arial, helvetica, sans-seriff;color:#0000FF;font-size:16px;">不允许写结束标记的标签</span><span style="font-family:verdana, Arial, helvetica, sans-seriff;font-size:16px;">：area(定义图像映射中的区域)、base(为页面上的所有链接规定默认地址或默认目标)、br、col(为表格中一个或多个列定义属性值)、embed(定义嵌入的内容，比如插件--5)、hr、img、input、keygen、link、meta、param、source、track、wbr</span></span></span> \n</p>                                                                        ', '2016-11-23 17:21:41', 1, 245, 2, 0, 1, 0, '2016-11-29 15:48:19', 0),
(37, 'Kendo Grid editing 自定义验证报错提示', '<span style="font-size:16px;color:#CC33E5;">Kendo UI是一个强大的框架用于快速HTML5 UI开发。基于最新的HTML5、CSS3和JavaScript标准。</span><br />\n<span style="font-size:16px;color:#CC33E5;">Kendo UI包含了开发现代JavaScript开发所需要的所有一切，包括：强大的数据源，通用的拖拉（Drag-and-Drop）功能，模板，和UI控件。</span><br />', '2016-11-23 18:31:03', 9, 260, 2, 0, 1, 0, '2016-11-24 21:27:07', 0),
(44, '浅入tomcat', '                                                                                                                <p class="MsoNormal" style="font-size:13px;color:#4B4B4B;font-family:verdana, Arial, helvetica, sans-seriff;background-color:#FFFFFF;">\n	<span style="line-height:1.5;font-family:宋体;">所谓的服务器其实就是一段别人写好的程序，服务器有两个能力。</span>\n</p>\n<p class="MsoNormal" style="font-size:13px;color:#4B4B4B;font-family:verdana, Arial, helvetica, sans-seriff;background-color:#FFFFFF;">\n	<span style="line-height:1.5;">  a.</span><span style="line-height:1.5;font-family:宋体;">可以帮助我们来管理资源。</span>\n</p>\n<p class="MsoNormal" style="font-size:13px;color:#4B4B4B;font-family:verdana, Arial, helvetica, sans-seriff;background-color:#FFFFFF;">\n	<span style="line-height:1.5;">  b.</span><span style="line-height:1.5;font-family:宋体;">可以将资源向外界发布以便于外界来访问这个资源。</span>\n</p>                                                                                                ', '2016-11-24 19:36:53', 21, 46, 30, 0, 0, 0, '0000-00-00 00:00:00', 0),
(47, '为什么需要socket.io？', '<span style="font-family:Verdana, Geneva, Arial, Helvetica, sans-serif;font-size:16px;color:#4C33E5;">node.js提供了高效的服务端运行环境，但是由于浏览器端对</span><span style="font-family:Verdana, Geneva, Arial, Helvetica, sans-serif;font-size:16px;text-decoration:underline;color:#4C33E5;">HTML5</span><span style="font-family:Verdana, Geneva, Arial, Helvetica, sans-serif;font-size:16px;color:#4C33E5;">的支持不一，为了兼容所有浏览器，提供卓越的实时的用户体验，并且为程序员提供客户端与服务端一致的编程体验，于是socket.io诞生。</span>', '2016-11-29 16:06:21', 20, 24, 34, 0, 1, 0, '2016-11-30 19:28:50', 0),
(48, 'fsdfdsf', 'sdfsdafads', '2016-11-30 20:37:28', 7, 5, 15, 0, 0, 1, '0000-00-00 00:00:00', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

--
-- 转存表中的数据 `reply`
--

INSERT INTO `reply` (`rid`, `tpostId`, `quoteId`, `ruid`, `rcontent`, `rtime`) VALUES
(6, 24, 0, 10, 'transform变换', '2016-11-19 16:47:10'),
(7, 25, 0, 2, '法规和规范换个环境换个', '2016-11-19 16:50:05'),
(8, 25, 0, 2, 'Bootstrap前端的UI框架', '2016-11-19 18:50:32'),
(11, 23, 0, 2, 'gdfsgfdgfdgfdg', '2016-11-19 19:05:31'),
(12, 15, 0, 10, '<span style="background-color:#FFFFFF;">近些日子一直在看一些SEO方面的书。</span><span style="background-color:#FFFFFF;">为人有些浮躁，读SEO实在读不出太大营养，除了第一本书外，之后的书就是在不停地向后翻页。没有过太具体的实践，现在就来写一下我眼中的SEO。还希望各位多多指教。</span>', '2016-11-19 19:18:26'),
(13, 15, 0, 10, '呵呵呵呵呵呵呵呵呵', '2016-11-19 19:26:13'),
(15, 27, 0, 10, 'sdfsdfsdafsadf', '2016-11-19 22:51:02'),
(17, 27, 15, 10, '201911191145stay', '2016-11-19 23:46:07'),
(21, 30, 0, 2, '<span style="font-size:16px;color:#CC33E5;">Bootstrap201611201029</span>', '2016-11-20 10:29:16'),
(25, 13, 0, 2, '<span style="font-size:24px;color:#006600;">Node npm</span>', '2016-11-20 10:36:25'),
(27, 13, 26, 2, '<span style="font-size:24px;color:#FF9900;">Node npm 的环境很使用，但是很难搭建。。。。</span>', '2016-11-20 10:38:47'),
(29, 14, 0, 8, '<span style="font-size:24px;color:#99BB00;">Jquery ajax的异步请求方式</span>', '2016-11-20 10:57:07'),
(34, 29, 0, 16, '撒旦法三大发撒地方', '2016-11-20 15:44:50'),
(35, 29, 0, 16, '水电费水电费撒的发撒地方', '2016-11-20 15:47:20'),
(43, 1, 0, 15, '圣诞节快乐；福克斯打飞机是；拉倒', '2016-11-20 15:59:15'),
(44, 20, 0, 15, 'gfdsgsdfgdfgdfg', '2016-11-20 16:00:34'),
(45, 13, 25, 15, 'fdsgfdhdf对手犯规对手犯规的风格的风格丹甫股份', '2016-11-20 16:00:55'),
(46, 27, 0, 15, '说的粉色啊股份的风格撒旦法公司大', '2016-11-20 16:01:13'),
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
(61, 3, 0, 29, 'my name is weide', '2016-11-21 15:46:30'),
(62, 30, 0, 29, '发生地方撒分是对方的身份', '2016-11-23 11:54:25'),
(63, 15, 13, 11, '<span style="font-size:18px;color:#006600;">哈哈哈哈哈哈</span>', '2016-11-23 15:52:24'),
(64, 35, 0, 11, '撒旦法水电费水电费水电费说', '2016-11-23 15:53:39'),
(65, 13, 0, 11, '时间快到了富哦扼腕&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '2016-11-23 15:58:54'),
(66, 35, 64, 10, '都是粉色的放松的方式', '2016-11-23 16:33:49'),
(67, 33, 55, 10, '说的分手大放送答复', '2016-11-23 16:42:13'),
(68, 1, 0, 2, 'sdafasdfsadf74987', '2016-11-24 14:03:22'),
(69, 1, 68, 2, 'dsfsadfsdafsdfsdfsdf', '2016-11-23 16:58:49'),
(70, 14, 0, 2, 'php ajax异步加载', '2016-11-23 18:42:30'),
(72, 26, 3, 2, '<p>\n	格式如下：｛name: "张三",age: 10｝\n</p>', '2016-11-23 19:39:13'),
(81, 29, 34, 2, 'ghjdsfds规范和风格0', '2016-11-26 14:07:06'),
(86, 30, 5, 2, '1324656565656565656565656565656565', '2016-11-24 14:57:06'),
(88, 26, 72, 2, '645465465456456645465465', '2016-11-24 15:07:00'),
(90, 37, 0, 30, 'asdfasdfasdfsad', '2016-11-24 21:27:07'),
(91, 25, 0, 29, 'asdfasdfsadfsdafsad', '2016-11-24 23:09:28'),
(92, 26, 0, 29, 'asdfasdfhgfhfghfg', '2016-11-24 23:19:28'),
(93, 13, 25, 2, 'asdfsadfsdfds', '2016-11-24 23:27:51'),
(94, 36, 0, 2, '的方式大丰收的', '2016-11-26 11:03:18'),
(95, 3, 61, 4, '水电费水电费的说法', '2016-11-29 12:08:10'),
(96, 24, 0, 4, '地方规定发给对方该v', '2016-11-29 12:08:29'),
(97, 36, 0, 34, '<strong><em><u><span style="color:#4C33E5;font-size:24px;">15687kojk</span></u></em></strong>', '2016-11-29 15:51:45'),
(99, 47, 0, 2, '                            654510                        ', '2016-11-30 19:28:07'),
(100, 47, 99, 15, '撒旦法十大方法说的分手大锅饭十多个是的', '2016-11-30 19:28:50');

-- --------------------------------------------------------

--
-- 表的结构 `sensitivewords`
--

CREATE TABLE IF NOT EXISTS `sensitivewords` (
  `swid` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `words` varchar(200) NOT NULL COMMENT '敏感词',
  PRIMARY KEY (`swid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sensitivewords`
--

INSERT INTO `sensitivewords` (`swid`, `words`) VALUES
(1, '反共');

-- --------------------------------------------------------

--
-- 表的结构 `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `isverifyuser` int(11) NOT NULL DEFAULT '0' COMMENT '默认0，无需审核用户',
  `isverifypost` int(11) NOT NULL DEFAULT '0' COMMENT '默认0，无需审核帖子',
  `handlename` varchar(100) NOT NULL COMMENT '操作名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `settings`
--

INSERT INTO `settings` (`id`, `isverifyuser`, `isverifypost`, `handlename`) VALUES
(1, 0, 1, 'handle');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

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
(22, 'python爬虫', 'uploads/2016/11/20/7035885831a20eab438318162094.jpg', 8, 'python爬虫python爬虫python爬虫'),
(23, 'test1', 'uploads/2016/11/27/236308583ae332ce58c626288326.jpg', 11, 'test1');

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
  `userType` int(11) NOT NULL DEFAULT '0' COMMENT '用户类型',
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
  `userStatus` int(11) NOT NULL DEFAULT '0' COMMENT '用户是否需要验证状态',
  `isForbid` int(11) NOT NULL DEFAULT '0' COMMENT '是否禁止',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `psw`, `sex`, `email`, `qq`, `photo`, `userType`, `reallyName`, `birthday`, `homeplace`, `bloodType`, `fixedTel`, `phone`, `website`, `school`, `degree`, `company`, `profession`, `job`, `income`, `registerTime`, `lastLogin`, `userStatus`, `isForbid`) VALUES
(2, 'admin', '9cbf8a4dcb8e30682b927f352d6559a0', '', '2663251638@qq.com', '2663251638', 'uploads/2016/11/10/2448085824251a7b86f760611800.jpg', 0, '李四', '1997-11-20', '山东省、莱芜市、莱城区', 'B', '0778-3124265', '13264467325', 'http://www.1233.com', '北京大学', '博士', '阿里巴巴', 'IT', '经理', '3000000', '2016-11-02 00:00:00', '2016-12-01 14:21:26', 0, 0),
(3, 'admin1', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '1', '2663251638@qq.com', '78956416', 'uploads/2016/11/22/760279583445b2e3d89724471208.jpg', 0, 'admin01', '1997-11-20', '未填写', '未填写', '0778-3124265', '13264467325', 'http://www.1233.com', '河池学院', '', '阿里巴巴', 'IT', '程序猿', '100000', '2016-11-02 00:00:00', '2016-11-22 20:04:08', 0, 0),
(4, '李四', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '', '2663251638@qq.com', '2663251638', '', 0, 'admin11', '1997-11-20', '未填写', '未填写', '0778-3124265', '13264467325', 'http://www.1233.com', '科技大学', '本科', '阿里巴巴', 'IT', '经理', '3000000', '2016-11-02 00:00:00', '2016-11-29 15:31:53', 0, 0),
(7, 'admin3', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '', '2663251638@qq.com', '2663251638', 'uploads/2016/11/20/46535658310186e81ae448582964.jpg', 0, 'admin1', '1983-3-3', '河北省、唐山市、古冶区', 'O', '0778-3124265', '13264467325', 'http://www.1233.com', '科技大学', '硕士', '阿里巴巴', 'IT', '经理', '3000000', '2016-11-02 21:51:12', '2016-11-20 10:10:15', 0, 0),
(8, 'MrStay', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '1', '2663251638@qq.com', '2663251638', 'uploads/2016/11/05/136308581d929778a3b656082866.jpg', 0, 'admin111', '1981-3-30', '河南省、驻马店市、古吕镇', 'AB', '0778-3124265', '13264467325', 'http://www.1233.com', '科技大学', '硕士', '阿里巴巴', 'IT', '经理', '3000000', '2016-11-05 15:50:23', '2016-11-20 10:55:55', 0, 0),
(10, '胡歌', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '保密', '2663251638@qq.com', '11671356', '', 0, 'admin111', '--', '省份、城市、县/区/镇', '未填写', '0778-3124265', '13264467325', 'http://www.6794cd.com', '北京电影学院', '本科', '阿里巴巴', 'IT', '经理', '3000000', '0000-00-00 00:00:00', '2016-11-30 13:01:23', 0, 0),
(11, '王宝强', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '', '2663251638@qq.com', '2663251638', 'uploads/2016/11/17/118356582d876838cfb903985235.jpg', 0, 'admin111', '1997-11-20', '未填写', '未填写', '0778-3124265', '13264467325', 'http://www.1233.com', '科技大学', '', '阿里巴巴', 'IT', '经理', '3000000', '0000-00-00 00:00:00', '2016-11-29 13:00:43', 0, 0),
(14, '阿伦-克拉布', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '1', '2663251638@qq.com', '2663251638', '', 1, 'admin111', '1997-11-20', '未填写', '未填写', '0778-3124265', '13264467325', 'http://www.1233.com', '科技大学', '硕士', '阿里巴巴', 'IT', '经理', '3000000', '0000-00-00 00:00:00', '2016-11-18 11:56:52', 0, 0),
(15, 'angle', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', '1076023927@qq.com', '未填写', 'uploads/2016/11/16/321942582c628c32631394923074.jpg', 1, 'baby', '--', '省份、城市、县/区/镇', '未填写', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '0000-00-00 00:00:00', '2016-11-30 19:27:27', 0, 0),
(16, 'baby', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '', '1239085@qq.com', '未填写', '', 0, '未填写', '1985-11-13', '未填写', '未填写', '未填写', '未填写', 'http://', '未填写', '本科', '未填写', '未填写', '未填写', '未填写', '2016-11-16 21:52:15', '2016-11-24 10:46:55', 0, 0),
(29, '韦德', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '1', '2584480035@qq.com', '1216763458', '', 1, '韦德', '1982-4-15', '河南省、驻马店市、古吕镇', 'O', '0778-3142625', '13297733516', 'http://www.13456.com', '未填写', '博士', '百度', 'IT', 'php工程师', '300000', '2016-11-17 08:51:20', '2016-11-27 12:07:28', 0, 2),
(30, 'James', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', '3584480035@qq.com', '未填写', '', 0, '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-17 09:01:34', '2016-11-24 19:35:56', 0, 0),
(32, '小马哥', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '男', 'xiaomage@qq.com', '46576631', '', 0, '马健', '1991-2-15', '湖北省、随州市、曾都区', 'O', '0771-3166522', '15878913651', 'http://www.xmg.com', '广州大学', '硕士', '网易', '互联网', '产品经理', '50000000', '0000-00-00 00:00:00', '2016-11-24 18:58:13', 0, 0),
(33, '无名', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '男', '119384257@qq.com', '未填写', '', 0, '未填写', '1991-3-13', '江西省、九江市、都昌县', 'B', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-29 15:43:27', '2016-11-29 16:29:54', 0, 0),
(34, '无邪', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '1', '13546362@qq.com', '未填写', '', 0, '天真无邪', '未填写', '未填写', '未填写', '未填写', '未填写', 'http://', '未填写', '', '未填写', '未填写', '未填写', '未填写', '2016-11-29 15:47:25', '2016-11-29 15:47:25', 0, 0),
(35, 'aaa', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', '123465423@qq.com', '未填写', '', 0, '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-29 17:06:18', '2016-11-29 17:06:17', 0, 0),
(36, 'bbb', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', 'kdfsjkl@qq.com', '未填写', '', 0, '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-29 17:07:07', '2016-11-29 17:07:07', 0, 0),
(37, 'ccc', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', 'sadfjk@qq.com', '未填写', '', 0, '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-29 17:07:27', '2016-11-29 17:07:27', 0, 0),
(38, 'ddd', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', '12345s6dfd@qq.com', '未填写', '', 0, '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-29 17:07:56', '2016-11-29 17:43:43', 0, 0),
(39, 'eee', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', '12sd65f@qq.com', '未填写', '', 0, '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-29 17:08:14', '2016-11-29 17:08:14', 0, 0),
(40, 'fff', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', '2s3df1f@qq.com', '未填写', '', 0, '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-29 17:08:33', '2016-11-29 17:43:30', 0, 0),
(41, 'ggg', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', '231sdf3@qq.com', '未填写', '', 0, '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-29 19:20:17', '2016-11-29 19:20:17', 0, 1),
(42, 'hhh', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', '11132df@qq.com', '未填写', '', 1, '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-29 20:31:42', '2016-11-29 20:31:42', 0, 0),
(43, 'iii', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '男', '2346sdf@qq.com', '未填写', '', 0, '未填写', '1972-2-15', '山东省、泰安市、岱岳区', 'A', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-30 20:45:02', '2016-11-30 20:45:01', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
