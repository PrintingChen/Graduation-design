<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>编辑用户</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/userEdit.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="js/admin-common.js"></script>
</head>
<body>
<!--引入头部-->
<?php include_once 'inc/header.inc.php';?>
<!--引入侧边栏-->
<?php include_once 'inc/leftnav.inc.php';?>
<!--引入位置信息-->
<?php include_once 'inc/position.inc.php';?>
<!--主体部分-->
<div class="admin">
    <form action="">
        <div class="panel admin-panel">
            <div class="panel-head"><strong><span class="fa fa-edit"></span> 编辑用户</strong></div>
            <div class="body-content" style="padding-bottom: 0;">
                <table class="table">
                    <tr>
                        <td class="w20">用户名：</td>
                        <td>张三</td>
                    </tr>
                    <tr>
                        <td class="w20">密码重置：</td>
                        <td>
                            <input type="radio" name="resetpass" id="yes"><label for="yes">是</label>
                            <input type="radio" name="resetpass" id="no" checked><label for="no">否</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="w20">头像：</td>
                        <td>
                            <img src="img/noavatar_middle.gif" alt="头像">
                            <br>
                            <input type="checkbox" name="delhead" id="delhead">
                            <label for="delhead">删除头像</label>
                        </td>
                    </tr>
                    <tr>
                        <td>权限：</td>
                        <td>
                            <select name="level" id="">
                                <option value="">普通会员</option>
                                <option value="">版主</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>真是姓名：</td>
                        <td>张三丰</td>
                    </tr>
                    <tr>
                        <td>性别：</td>
                        <td>男</td>
                    </tr>
                    <tr>
                        <td>生日：</td>
                        <td>1990年1月1日</td>
                    </tr>
                    <tr>
                        <td>Email：</td>
                        <td>13245789@qq.com</td>
                    </tr>
                    <tr>
                        <td>发帖数：</td>
                        <td>123</td>
                    </tr>
                    <tr>
                        <td>注册 IP:</td>
                        <td>192.168.0.1</td>
                    </tr>
                    <tr>
                        <td>注册时间：</td>
                        <td>2016年10月26日 16:52:20</td>
                    </tr>
                    <tr>
                        <td>上次登录时间：</td>
                        <td>2016年10月26日 16:52:20</td>
                    </tr>
                    <tr>
                        <td>上次发表时间：</td>
                        <td>2016年10月27日 16:52:20</td>
                    </tr>
                    <tr>
                        <td>上次访问 IP：</td>
                        <td>192.168.0.1</td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
</div>
<!--主体部分-->
</body>
</html>