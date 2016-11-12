<!DOCTYPE html>
<html>
<head>
    <title>后台登陆</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/login.css" />
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="js/login.js"></script>
    <script>
        $(function () {
            $("#btn").on("click", function () {
                $.ajax({
                    type :　"post",
                    url : "loginHandle.php",
                    data : $("#loginform").serialize(),
                    success : function (response, status, xhr) {
                        layui.use("layer", function () {
                            var layer = layui.layer;
                            if (response == 0){
                                layer.msg("验证码错误", {icon: 5, time: 800});
                            }else if(response == 2){
                                layer.msg("登录名或者密码错误", {icon: 5, time: 800});
                            }else if (response == 1){
                                layer.msg("登录成功", {icon: 5, time: 1000});
                                window.location.href = "index.php";
                            }
                        });
                    }
                });
                //特别注意：如果button默认type=submit的提交按钮不使用return false来阻止默认的提交事件的话不能实现跳转
                //        如果type=button的提交按钮则不用return false
                //return false;
            });
        });
    </script>
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
    if (manage_login_state($link)) {
        promptBox('您已经登录！', 6, 'index.php');
        exit();
    }
?>
<body id="loginpage">
<div id="login" class="clearfix">
    <div class="main clearfix">
        <div class="logbox">
            <div class="header">
                BBS论坛系统后台登录
            </div>
            <div class="web_login" id="web_login">
                <form id="loginform" name="loginform" method="post">
                    <div class="inputOuter">
                        <i class="fa fa-user fa-2x abs"></i>
                        <input type="text" class="form-control rel" id="userName" name="userName" placeholder="登录账号">
                    </div>
                    <div class="inputOuter">
                        <i class="fa fa-unlock-alt fa-2x abs"></i>
                        <input type="password" class="form-control rel" id="psw" name="psw" placeholder="登录密码">
                    </div>
                    <div class="inputOuter">
                        <i class="fa fa-qrcode fa-2x abs"></i>
                        <input type="text" class="form-control w70 rel" name="yzm" placeholder="验证码">
                        <img id="yzm" src="../inc/vcode.php" alt="点击刷新验证码">
                    </div>
                    <div class="submit" style="text-align: center;">
                        <button name="sublogin" type="button" class="btn btn-primary" id="btn""><i class="fa fa-check-square-o"></i>登录</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
