<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once 'inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //判断当前是否为登录状态
    $member_id = login_state($link);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人资料</title>
    <link rel="stylesheet" href="font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
<!--引入头部-->
<?php include_once "inc/header.inc.php"?>
<!--引入导航-->
<?php include_once "inc/nav.inc.php"?>
<div id="position">
    <div class="container">
        <i class="fa fa-map-marker"></i>
        <a href="#">李四</a>
        >>
        <a href="register.php">个人资料</a>
    </div>
</div>
<div id="profile">
    <div class="container">
        <div class="profile-h">
            <a href="profile.php"><img src="img/noavatar_small.gif" alt=""></a>
            <div class="info">
                <?php echo $res_info['name']?>个人资料<br>
                UID：<?php echo $res_info['id']?>
            </div>
        </div>
        <div class="person-info">
            sdf
        </div>
    </div>
</div>
</body>
</html>