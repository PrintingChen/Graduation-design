<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>禁止用户</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/addUser.css">
    <link rel="stylesheet" href="css/forbidUserSearch.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="js/addUser.js"></script>
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
<script>
    $(function () {
        layui.use("layer", function () {
            var layer = layui.layer;
            $("#mdflevel").on("click", function () {
                $.ajax({
                    type: "post",
                    url: "forbidUserSearchHandle.php",
                    data: $("#level-form").serialize(),
                    success: function (response) {
                        $success = response.substring(0,7);
                        $uid = response.substring(7);
                        if (response == "fail"){
                            layer.msg("指定用户不存在", {icon: 5, time: 1500}, function () {
                                $("input[type=text]").focus();
                            });
                        }else{
                            window.location.href = "forbidUser.php?uid="+$uid+"";
                        }
                    }
                });
            });
        });
    });
</script>
<div class="admin">
    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="fa fa-plus-square-o"></span> 禁止用户</strong></div>
        <div class="body-content">
            <form id="level-form">
                <table class="table">
                    <tr>
                        <td style="width: 40%;"></td>
                        <td>请先输入您要进行操作的用户名</td>
                        <td style="width: 40%;"></td>
                    </tr>
                    <tr>
                        <td style="width: 40%;"></td>
                        <td>
                            <input type="text" name="name" class="form-control" style="">
                        </td>
                        <td style="width: 40%;"></td>
                    </tr>
                    <tr>
                        <td style="width: 40%;"></td>
                        <td>
                            <button type="button" class="btn btn-primary" id="mdflevel"><i class="fa fa-check-square-o custom"></i>确定</button>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
</body>
</html>