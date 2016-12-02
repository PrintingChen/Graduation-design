$(function () {
    layui.use("layer", function () {
        var layer = layui.layer;
        $("#editUser").on("click", function () {
            $uid = $(this).attr("uid");
            $.ajax({
                type: "post",
                url: "userEditHandle.php?uid="+$uid+"",
                data:　$("#editUserform").serialize(),
                success: function (response) {
                    if(response == "success"){
                        layer.msg("用户数据更新成功", {icon: 1, time: 2000}, function () {
                            window.location.href = "userList.php";
                        });
                    }else if(response == "fail"){
                        layer.msg("用户数据未改动", {icon: 5, time: 2000});
                    }
                }
            });
        });
    });
});