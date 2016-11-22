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
    <script>
        $(function(){
            //验证表单
            $("#form-mdfpsw").formValidator();
        });
    </script>
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
    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="fa fa-key"></span> 修改密码</strong></div>
        <div class="body-content">
            <form action="" id="form-mdfpsw">
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">管理员账号：</label></div>
                    <div class="field"><label for="" style="line-height:35px;">admin</label></div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">原始密码：</label></div>
                    <div class="field">
                        <input type="password" class="form-control w50" placeholder="请输入原始密码"
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
                        <input type="password" id="password" class="form-control w50" placeholder="请输入新密码"
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
                        <input type="password" class="form-control w50" placeholder="请再次输入新密码"
                               data-notempty="true"
                               data-notempty-message="确认新密码不能为空"
                               data-equalto="#password"
                               data-equalto-message="与新密码不一致"
                        />
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for=""></label></div>
                    <div class="field">
                        <button class="btn btn-info btn-custom"><i class="fa fa-check-square-o custom"></i>提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--../主体部分-->
</body>
</html>