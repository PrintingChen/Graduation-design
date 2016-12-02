$(function(){
    //验证表单
    $("#form-mdfsmodule").formValidator();
    layui.use("layer", function () {
        var layer = layui.layer;
        $("#btn-mdfpm").on("click", function () {
            $pid = $(this).attr("pid");
            $.ajax({
                type: "post",
                url: "pModuleModifyHandle.php?pid="+$pid+"",
                data: $("#form-mdfsmodule").serialize(),
                success: function (response) {
                    if(response == "pmexist"){
                        layer.msg("修改的父版块已存在", {icon: 5, time: 1500}, function () {
                            $("input[name=pmName]").focus();
                        });
                    }else if(response == "success"){
                        layer.msg("修改成功", {icon: 1, time: 1000}, function () {
                            window.location.href = "pModuleList.php";
                        });
                    }else if(response == "fail"){
                        layer.msg("数据未改动", {icon: 5, time: 1500});
                    }
                }
            });
        });
    });
});