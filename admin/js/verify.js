$(function () {
    layui.use("layer", function () {
        var layer = layui.layer;
        //设置审核用户状态
        $("#editreg").on("click", function () {
            $.ajax({
                type: "post",
                url: "verifyReg.php",
                data: $("#verify-register").serialize(),
                success: function (response) {
                   if(response == "success"){
                       layer.msg("设置新用户注册审核成功", {icon: 1, time: 1500}, function () {
                           window.location.href = "verify.php";
                       });
                   }else if(response == "fail"){
                       layer.msg("未改动审核方式", {icon: 5, time: 1500});
                   }
                }
            });
        });
        //设置帖子审核状态
        $("#editP").on("click", function () {
            $.ajax({
                type: "post",
                url: "verifyPost.php",
                data: $("#verify-post").serialize(),
                success: function (response) {
                   if(response == "success"){
                       layer.msg("设置帖子审核成功", {icon: 1, time: 1500}, function () {
                           window.location.href = "verify.php";
                       });
                   }else if(response == "fail"){
                       layer.msg("未改动审核方式", {icon: 5, time: 1500});
                   }
                }
            });
        });
    });
});