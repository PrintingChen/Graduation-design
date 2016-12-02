$(function() {
    //更新验证码
    $("#yzm").on("click", function () {
        $(this).attr("src", "../inc/vcode.php?key=" + Math.random() * Math.pow(10, 17) + "");
    });
    //
    $("#btn").on("click", function () {
        layui.use("layer", function () {
            var layer = layui.layer;
            $.ajax({
                type: "post",
                url: "loginHandle.php",
                data: $("#loginform").serialize(),
                success: function (response, status, xhr) {
                    if (response == 0) {
                        layer.msg("验证码错误", {icon: 5, time: 1500}, function () {
                            $("#yzminput").focus();
                        });
                    } else if (response == 2) {
                        layer.msg("登录名或者密码错误或此管理员不存在", {icon: 5, time: 1500});
                    } else if (response == 1) {
                        layer.msg("登录成功", {icon: 1, time: 1500});
                        setTimeout(function () {
                            window.location.href = "index.php";
                        }, 1500);
                    }
                }
            });
        });
        //特别注意：如果button默认type=submit的提交按钮不使用return false来阻止默认的提交事件的话不能实现跳转
        //        如果type=button的提交按钮则不用return false
        //return false;
    });
});
