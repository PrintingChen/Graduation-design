<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>修改密码</title>
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="js/passModify.js"></script>
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
<!--引入头部-->
<?php include_once 'inc/header.inc.php';?>
<!--引入侧边栏-->
<?php include_once 'inc/leftnav.inc.php';?>
<!--引入位置信息-->
<?php include_once 'inc/position.inc.php';?>
<!--主体部分-->
<div class="admin">
    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="fa fa-key"></span> 修改密码</strong></div>
        <div class="body-content">
            <form id="form-mdfpsw">
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">当前账号：</label></div>
                    <div class="field">
                        <label for="" style="line-height:35px;">
                            <?php echo $data_currm["managerName"];?>
                        </label>
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">原始密码：</label></div>
                    <div class="field">
                        <input type="password" name="opsw" id="opsw" class="form-control w50" placeholder="请输入原始密码"
                               data-notempty="true"
                               data-notempty-message="原始密码不能为空"
                               data-regex="^\w+$"
                               data-regex-message="格式不匹配，密码由数字、字母或下划线所组成"
                        />
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">新密码：</label></div>
                    <div class="field">
                        <input type="password" name="npsw" id="npsw" class="form-control w50" placeholder="请输入新密码"
                               data-notempty="true"
                               data-notempty-message="新密码不能为空"
                               data-regex="^\w+$"
                               data-regex-message="格式不匹配，新密码由数字、字母或下划线所组成"
                        />
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">确认新密码：</label></div>
                    <div class="field">
                        <input type="password" name="renpsw" id="renpsw" class="form-control w50" placeholder="请再次输入新密码"
                               data-notempty="true"
                               data-notempty-message="确认新密码不能为空"
                               data-equalto="#npsw"
                               data-equalto-message="与新密码不一致"
                        />
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for=""></label></div>
                    <div class="field">
                        <button type="button" id="mdfBtn" class="btn btn-info btn-custom"><i class="fa fa-check-square-o custom"></i>提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--../主体部分-->
</body>
</html>