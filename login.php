<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <link rel="stylesheet" href="font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/register.css">
    <script src="js/jquery-1.12.2.min.js"></script>
    <script src="css/bootstrap/js/bootstrap.min.js"></script>
    <script src="layui/layui.js"></script>
    <script src="js/formValidator.js"></script>
    <script src="js/common.js"></script>
    <script src="js/login.js"></script>
</head>
<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once 'inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //查询公告内容
    $sql_n = "select * from notice where nid=1";
    $data_n = fetch_array(execute($link, $sql_n));
    $nc = $data_n["noticeContent"];
    //判断当前是否为登录状态
    if ($member_id = login_state($link)){
        promptBox('处于登录状态', 5, 'index.php');
        exit;
    }
    //引入处理登录信息
    include_once "inc/handlerLogin.php";
?>

<body>
<!--引入头部-->
<?php include_once "inc/header.inc.php"?>
<!--引入导航-->
<?php include_once "inc/nav.inc.php"?>
<div class="container" id="container" style="width: 990px;">
    <div class="position">
        <div class="z">
            <a href="index.php" class="nvhm"><i class="fa fa-home"></i></a>
            <em><i class="fa fa-angle-right"></i></em>
            <a>用户登录</a>
        </div>
    </div>
    <div class="bm" id="main-message">
        <div class="bm-h">
            <span class="y">
                <a href="register.php">没有帐号？现在注册</a>
            </span>
            <h3 class="login-info">
                用户登录
            </h3>
        </div>
        <form id="form-login">
            <div class="form-group">
                <div class="col-md-3 tac"><label for="">用户名：</label></div>
                <div class="col-md-9">
                    <input type="text" name="userName" id="userName" class="form-control w40"
                           data-notempty="true"
                           data-notempty-message="用户名不能为空"
                    >
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-3 tac"><label for="">密码：</label></div>
                <div class="col-md-9">
                    <input type="password" name="psw" id="password" class="form-control w40"
                           data-notempty="true"
                           data-notempty-message="密码不能为空"
                    >
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-3 tac"><label for="">验证码：</label></div>
                <div class="col-md-9">
                    <input type="text" name="yzm" id="yzm" class="form-control w40"
                           data-notempty="true"
                           data-notempty-message="验证码未填写"
                    >
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-3 tac"><label for=""></label></div>
                <div class="col-md-9"><img style="cursor: pointer;" src="inc/vcode.php" class="yzmpic"><span>点击图片换一张</span></div>
            </div>

            <div class="form-group">
                <div class="col-md-3 tac"><label for=""></label></div>
                <div class="col-md-9 w40"><button type="button" id="loginBtn" class="btn btn-primary"><i class="fa fa-check-square-o custom"></i>提交</button></div>
            </div>
        </form>
    </div>
</div>
<!--引入底部-->
<?php include_once "inc/footer.inc.php"?>
</body>
</html>