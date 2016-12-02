$(function(){
    //验证表单
    $("#form-mdfpsw").formValidator();
    //ajax添加用户
    $("#btn-adduser").on("click", function () {
        layui.use("layer", function () {
            var layer = layui.layer;
            //验证用户名不能为空
            if ($("#userName").val().length == 0){
                layer.msg("用户名不能为空", {icon: 5, time: 1000}, function () {
                    $("#userName").focus();
                });
                return false;
            }
            //验证密码不能为空
            $reg = /^\w+$/;
            if ($("#password").val().length == 0){
                layer.msg("密码不能为空", {icon: 5, time: 1000}, function () {
                    $("#password").focus();
                });
                return false;
            }
            if (!$reg.test($("#password").val())){
                layer.msg("密码只能有数字、字母和下划线组成", {icon: 5, time: 1200}, function () {
                    $("#password").focus();
                });
                return false;
            }
            //验证码确认密码
            if ($("#password").val() != $("#repassword").val()){
                layer.msg("两次密码不一致", {icon: 5, time: 1200}, function () {
                    $("#repassword").focus();
                });
                return false;
            }
            //验证邮箱
            $reg_email = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+/;
            if ($("#email").val().length == 0){
                layer.msg("邮箱不能为空", {icon: 5, time: 1000}, function () {
                    $("#email").focus();
                });
                return false;
            }
            if (!$reg_email.test($("#email").val())){
                layer.msg("邮箱由数字、字母、下划线或-所组成", {icon: 5, time: 1200}, function () {
                    $("#email").focus();
                });
                return false;
            }
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