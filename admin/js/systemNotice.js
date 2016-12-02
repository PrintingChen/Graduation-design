$(function () {
    layui.use("layer", function () {
        var layer = layui.layer;
        $("#editNotice").on("click", function () {
            $.ajax({
                type: "post",
                url: "systemNoticeHandle.php",
                data: $("#notice-form").serialize(),
                success: function (response) {
                    if(response == "success"){
                        layer.msg("公告设置成功", {icon: 1, time: 1500}, function () {
                            window.location.href = "systemNotice.php";
                        });
                    }else if (response == "fail"){
                        layer.msg("未改动公告内容", {icon: 5, time: 1500}, function () {
                            $("#nc").focus();
                        });
                    }
                }
            });
        });
    });
});