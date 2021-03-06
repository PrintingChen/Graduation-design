<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册</title>
    <link rel="stylesheet" href="font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/register.css">
    <script src="js/jquery-1.12.2.min.js"></script>
    <script src="layui/layui.js"></script>
    <script src="js/formValidator.js"></script>
    <script src="js/common.js"></script>
    <script src="js/register.js"></script>
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
    if (login_state($link)){
        promptBox('您已经登录，无法进行此操作', 5, 'index.php');
        exit();
    }
?>
<body>
<!--引入头部-->
<?php include_once "inc/header.inc.php"?>
<!--引入导航-->
<?php include_once "inc/nav.inc.php"?>
<div id="position">
    <div class="container">
        <i class="fa fa-home"></i>
        <a href="index.php">首页</a>
        >
        <a href="register.php">立即注册</a>
    </div>
</div>
<div class="container" id="container">
    <div class="bm" id="main-message">
        <div class="bm-h">
            <span class="y">
                <a href="login.php">已有帐号？现在登录</a>
            </span>
            <h3 class="login-info">
                立即注册
            </h3>
        </div>
        <form id="form-login">
            <div class="form-group">
                <div class="col-md-3 tac"><label for="">用户名：</label></div>
                <div class="col-md-9">
                    <input type="text" name="userName" id="userName" class="form-control w40"
                           data-notempty="true"
                           data-notempty-message="用户名不能为空"
                           data-regex="^[\u4e00-\u9fa5\w]{2,10}$"
                           data-regex-message="用户名在2-10字符之间，不能包含明感字符（如@、！等）"
                    >
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-3 tac"><label for="">密码：</label></div>
                <div class="col-md-9">
                    <input type="password" name="psw" id="password" class="form-control w40"
                           data-notempty="true"
                           data-notempty-message="密码不能为空"
                           data-regex="^\w{6,15}$"
                           data-regex-message="密码长度为6-15位，由数字、字母或下划线所组成"
                    >
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-3 tac"><label for="">确认密码：</label></div>
                <div class="col-md-9">
                    <input type="password" name="repsw" id="repsw" class="form-control w40"
                           data-notempty="true"
                           data-notempty-message="确认密码不能为空"
                           data-equalto="#password"
                           data-equalto-message="两次密码不一致"
                    >
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-3 tac"><label for="">Email：</label></div>
                <div class="col-md-9">
                    <input type="text" name="email" id="email" class="form-control w40"
                           data-notempty="true"
                           data-notempty-message="邮箱地址不能为空"
                           data-regex="^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$"
                           data-regex-message="格式不匹配，由数字、字母、下划线或-所组成"
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
<?php include_once "inc/footer.inc.php"?>
</body>
</html>