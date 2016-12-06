<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>系统信息统计</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="js/echarts.common.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="js/systeminfo.js"></script>
</head>
<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //管理员是否登录
    if (!($mid = manage_login_state($link))) {
        promptBox('您还未登录！', 5, 'login.php');
        exit;
    }
?>
<body>
<?php include_once 'inc/header.inc.php'; ?>
<!--引入侧边栏-->
<?php include_once 'inc/leftnav.inc.php';?>
<!--引入位置信息-->
<?php include_once 'inc/position.inc.php';?>
    <div id="systeminfo" style="width: 600px;height:400px;margin: 50px auto ;"></div>
</body>
</html>