<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加用户</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/addUser.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/admin-common.js"></script>
    <script>
        $(function(){
            //验证表单
            $("#form-mdfpsw").formValidator();
            //ajax添加用户
            $("#btn-adduser").on("click", function () {
                layui.use("layer", function () {
                    var layer = layui.layer;
                    $.ajax({
                        type : "post",
                        url : "addUserHandle.php",
                        data : $("#form-mdfpsw").serialize(),
                        success : function (response) {
                            if(response == "empty"){
                                layer.msg("数据不能为空", {icon : 5, time : 800});
                            }else if(response == "useryes"){
                                layer.msg("此用户已存在", {icon : 5, time : 800});
                            }else if(response == "ok"){
                                layer.msg("用户添加成功", {icon : 6, time : 800});
                                setTimeout(function () {
                                    window.location.href = "userList.php";
                                }, 1000);
                            }else if(response == "no"){
                                layer.msg("用户添加失败", {icon : 5, time : 800});
                            }
                        }
                    });
                });
            });
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
        <div class="panel-head"><strong><span class="fa fa-plus-square-o"></span> 添加用户</strong></div>
        <div class="body-content">
            <form id="form-mdfpsw">
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">用户名：</label></div>
                    <div class="field">
                        <input type="text" class="form-control w50" id="userName" name="userName" placeholder="请输入用户名"
                               data-notempty="true"
                               data-notempty-message="用户名不能为空"
                        />
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">密码：</label></div>
                    <div class="field">
                        <input type="password" name="password" id="password" class="form-control w50" placeholder="请输入密码"
                               data-notempty="true"
                               data-notempty-message="密码不能为空"
                               data-regex="^\w+$"
                               data-regex-message="格式不匹配，密码由数字、字母或下划线所组成"
                        />
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">确认密码：</label></div>
                    <div class="field">
                        <input type="password" name="repassword" class="form-control w50" placeholder="请再次输入密码"
                               data-notempty="true"
                               data-notempty-message="确认密码不能为空"
                               data-equalto="#password"
                               data-equalto-message="两次密码不一致"
                        />
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">Email：</label></div>
                    <div class="field">
                        <input type="email" name="email" class="form-control w50" placeholder="请输入邮箱地址"
                               data-notempty="true"
                               data-notempty-message="邮箱地址不能为空"
                               data-regex="^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$"
                               data-regex-message="格式不匹配，邮箱由数字、字母、下划线或-所组成（如：abc123@qq.com"
                        />
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for=""></label></div>
                    <div class="field">
                        <button type="button" id="btn-adduser" class="btn btn-info btn-custom"><i class="fa fa-check-square-o custom"></i>提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>