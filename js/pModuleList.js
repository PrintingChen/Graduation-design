$(function () {
    layui.use("layer", function () {
        var layer = layui.layer;
        //判断是否登录状态
        $("#pubBtn").on("click", function () {
            $.ajax({
                type: "post",
                url: "isLoginHandle.php",
                success: function (response) {
                    if(response == "success"){
                        window.location.href = "publish.php";
                    }else if(response == "fail"){
                        layer.msg("您还未登录，无法发布帖子", {icon: 5, time: 1000}, function () {
                            window.location.href = "login.php";
                        });
                    }
                }
            });
        });
    });
});