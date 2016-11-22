$(function(){
    //验证表单
    $("#form-login").formValidator();
    //更新验证码
    $(".yzmpic").on("click",function(){
        $(this).attr("src","inc/vcode.php?key="+Math.random()*Math.pow(10,17)+"");
    });
    
    //layui组件
    layui.use("layer", function () {
        var layer = layui.layer;
        //处理注册信息
        $("#loginBtn").on("click", function () {
            //数据项不能为空
            if($("#userName").val().length == 0){
                layer.msg("用户名未填写",{icon: 5, time: 1000}, function () {
                    $("#userName").focus();
                });
                return false;
            }
            if($("#password").val().length == 0){
                layer.msg("密码未填写",{icon: 5, time: 1000}, function () {
                    $("#password").focus();
                });
                return false;
            }
            if($("#repsw").val().length == 0){
                layer.msg("确认密码未填写",{icon: 5, time: 1000}, function () {
                    $("#repsw").focus();
                });
                return false;
            }
            if($("#email").val().length == 0){
                layer.msg("邮箱未填写",{icon: 5, time: 1000}, function () {
                    $("#email").focus();
                });
                return false;
            }
            if($("#yzm").val().length == 0){
                layer.msg("验证码未填写",{icon: 5, time: 1000}, function () {
                    $("#yzm").focus();
                });
                return false;
            }
            $.ajax({
                type: "post",
                url: "registerHandle.php",
                data: $("#form-login").serialize(),
                success: function (response) {
                    if(response == "yzmnoequal"){
                        layer.msg("验证码错误", {icon: 5, time: 1000}, function () {
                            $("#yzm").focus();
                        });
                    }else if (response == "nameislogin"){
                        layer.msg("该用户名已被注册", {icon: 5, time: 1000}, function () {
                            $("#userName").focus();
                        });
                    }else if(response == "emailislogin"){
                        layer.msg("该邮箱已被注册", {icon: 5, time: 1000}, function () {
                            $("#email").focus();
                        });
                    }else if(response == "success"){
                        layer.msg("注册成功", {icon: 6, time: 1000});
                        setTimeout(function () {
                            window.location.href = "index.php";
                        }, 1500);
                    }
                }
            });
        });
    });

    
});
