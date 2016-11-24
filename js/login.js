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
        //处理登录信息
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
            if($("#yzm").val().length != 4){
                layer.msg("验证码长度为4位",{icon: 5, time: 1000}, function () {
                    $("#yzm").focus();
                });
                return false;
            }
            $.ajax({
                type: "post",
                url: "loginHandle.php",
                data: $("#form-login").serialize(),
                success: function (response) {
                    if(response == "yzmnoequal"){
                        layer.msg("验证码错误", {icon: 5, time: 1000}, function () {
                            $("#yzm").focus();
                        });
                    }else if(response == "success"){
                        layer.msg("登录成功", {icon: 1, time: 1000});
                        setTimeout(function () {
                            window.location.href = "index.php";
                        }, 1000);
                    }else if (response == "fail"){
                        layer.msg("用户名或密码错误", {icon: 5, time: 1000});
                    }
                }
            });
        });
    });


});
