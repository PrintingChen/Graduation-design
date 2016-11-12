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
    <script src="js/formValidator.js"></script>
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
//判断当前是否为登录状态
if (login_state($link)){
    skip('index.php', 'error', '您已经登录，无法进行此操作^_^');
    exit();
}
//处理提交后的数据
if(isset($_POST['sub'])){
    //验证验证码是否一致
    check_vcode($_POST['yzm'], $_SESSION['code']);
    //引入验证文件
    include_once "inc/register.func.php";
    //定义一个空的数组来存放过滤之后的数据
    $clean = array();
    $clean['userName'] = check_user($link, $_POST['userName']);
    $clean['psw'] = check_pwd($link, $_POST['psw']);
    $clean['email'] = check_email($link, $_POST['email']);
    //插入数据之前先判断用户名或者邮箱是否已被注册
    $sql_name = "select * from user where name='{$clean['userName']}'";
    if (nums($link, $sql_name)) {
        skip('register.php', 'error', '该用户名已注册，请更换用户名^_^');
        exit();
    }
    $sql_email = "select * from user where email='{$clean['email']}'";
    if (nums($link, $sql_email)) {
        skip('register.php', 'error', '该邮箱已注册，请更换邮箱^_^');
        exit();
    }
    //开始插入数据
    $sql_ins = "insert into user(name,psw,email,registerTime,lastLogin) values('{$clean['userName']}','{$clean['psw']}','{$clean['email']}',NOW(),NOW())";
    $result = execute($link, $sql_ins);
    //判断数据是否插入成功
    if (mysqli_affected_rows($link) == 1) {
        //设置cookie
        setcookie('bs[userName]', $clean['userName']);
        setcookie('bs[psw]', $clean['psw']);
        //更新注册的时间
        $time = Date('Y-m-d H:i:s', time());
        $sql = "update user set registerTime='{$time}' where name='{$clean['userName']}'";
        execute($link, $sql);
        skip('index.php', 'success', '恭喜你，注册成功^_^');
        exit();
    }else {
        skip('register.php', 'error', '很抱歉，注册失败^_^');
        exit();
    }
}
?>
<body>
<!--引入头部-->
<?php include_once "inc/header.inc.php"?>
<!--引入导航-->
<?php include_once "inc/nav.inc.php"?>
<div id="position">
    <div class="container">
        <i class="fa fa-map-marker"></i>
        <a href="index.php">首页</a>
        >>
        <a href="register.php">立即注册</a>
    </div>
</div>
<div class="container" id="container">
    <div class="bm" id="main-message">
        <div class="bm-h">
            <span class="y">
                <a href="#">已有帐号？现在登录</a>
            </span>
            <h3 class="login-info">
                立即注册
            </h3>
        </div>
        <form action="register.php" id="form-login" method="post">
            <div class="form-group">
                <div class="col-md-3 tac"><label for="">用户名：</label></div>
                <div class="col-md-9">
                    <input type="text" name="userName" class="form-control w40"
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
                    <input type="password" name="repsw" class="form-control w40"
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
                    <input type="text" name="email" class="form-control w40"
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
                    <input type="text" name="yzm" class="form-control w40"
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
                <div class="col-md-9 w40"><button type="submit" name="sub" class="btn btn-primary"><i class="fa fa-check-square-o custom"></i>提交</button></div>
            </div>
        </form>
    </div>
</div>
<?php include_once "inc/footer.inc.php"?>
</body>
</html>