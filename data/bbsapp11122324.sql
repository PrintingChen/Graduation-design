-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-11-12 23:24:28
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `parent_module`
--

INSERT INTO `parent_module` (`pid`, `pmoduleName`, `moderatorId`, `pmoduleDesc`) VALUES
(1, '前端开发', 8, 'Web前端开发是从网页制作演变而来的'),
(2, '后端开发', 4, '后端开发是数据库操作和管理'),
(3, '网站SEO', 0, 'SEO是指在了解搜索引擎自然排名机制的基础之上，对网站进行内部及外部的调整优化'),
(8, 'Python', 0, 'PythonPythonPython');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

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
(11, 'vuejs', 'uploads/2016/11/12/600588582706af399ea497578041.jpg', 1, 'vuejs是一个构建数据驱动的 web 界面的渐进式框架'),
(12, 'python爬虫', 'uploads/2016/11/12/2357705827065c3cdaf139044705.jpg', 8, 'python爬虫python爬虫'),
(16, 'python爬虫1', 'uploads/2016/11/12/94771258269967344e0289044137.JPG', 8, 'python爬虫1python爬虫1python爬虫1'),
(17, 'python爬虫2', 'uploads/2016/11/12/94771258269967344e0289044137.JPG', 8, '4566'),
(18, 'python爬虫6', 'uploads/2016/11/12/49803358270c801e0e2788425938.jpg', 8, '单方事故吧'),
(19, 'python爬虫8', 'uploads/2016/11/12/922658582707baebe9b805886937.jpg', 8, 'python爬虫89python爬虫89python爬虫89'),
(20, 'NodeJs', 'uploads/2016/11/12/55019858270ce54ca77578350405.jpg', 2, 'Node.js 是一个基于 Chrome V8 引擎的 JavaScript 运行环境');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `psw`, `sex`, `email`, `qq`, `photo`, `reallyName`, `birthday`, `homeplace`, `bloodType`, `fixedTel`, `phone`, `website`, `school`, `degree`, `company`, `profession`, `job`, `income`, `registerTime`, `lastLogin`) VALUES
(2, 'admin', '9cbf8a4dcb8e30682b927f352d6559a0', '男', '1076023927@qq.com', '5469812780', 'uploads/2016/11/10/2448085824251a7b86f760611800.jpg', '李四', '2004-3-16', '山东省、莱芜市、莱城区', 'B', '0778-3142659', '13678913698', 'https://www.baidu.com', '清华大学', '硕士', '腾讯', 'IT', '架构师', '600000', '2016-11-02 00:00:00', '2016-11-12 23:20:35'),
(3, 'admin1', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', '2663251638@qq.com', '未填写', '', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-02 00:00:00', '2016-11-03 19:52:21'),
(4, '李四', '28a48bc650699aa0fd11223b9ad62dd8', '未填写', 'lisi@qq.com', '未填写', '', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-02 00:00:00', '2016-11-02 00:00:00'),
(5, '张三', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '男', '123546@qq.com', '987619673', 'uploads/2016/11/06/503852581f1ee96a626571575782.jpg', '张三丰', '1987-4-16', '省份、城市、县/区/镇', 'AB', '0778-3142664', '13978793065', 'http://www.sousou.com', '同济大学', '硕士', '阿里巴巴', 'IT', '部门经理', '65000000', '2016-11-02 00:00:00', '2016-11-06 20:15:23'),
(6, 'admin2', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', '457983@qq.com', '未填写', '', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-02 21:49:35', '2016-11-02 21:49:35'),
(7, 'admin3', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '未填写', '124987@qq.com', '未填写', '', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-02 21:51:12', '2016-11-02 21:52:08'),
(8, 'MrStay', '49dec5fb8af4eeef7c95e7f5c66c8ae6', '男', 'chenytrl@163.com', '未填写', 'uploads/2016/11/05/136308581d929778a3b656082866.jpg', '张三', '1998-3-14', '省份、城市、县/区/镇', 'O', '未填写', '未填写', 'http://', '未填写', '未填写', '未填写', '未填写', '未填写', '未填写', '2016-11-05 15:50:23', '2016-11-05 15:57:16');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
