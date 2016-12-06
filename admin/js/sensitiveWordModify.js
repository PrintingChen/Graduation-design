$(function(){
    //验证表单
    $("#form-mdfsmodule").formValidator();
    layui.use("layer", function () {
        var layer = layui.layer;
        //修改敏感词
        $("#mdfswBtn").on("click", function () {
            $swid = $(this).attr("swid");
            $.ajax({
                type: "post",
                url: "sensitiveWordModifyHandle.php?swid="+$swid+"",
                data: $("#form-mdfsmodule").serialize(),
                success: function (response) {
                    if(response == "swexist"){
                        layer.msg("修改的敏感词已存在", {icon: 5, time: 1500}, function () {
                            $("input[name=swname]").focus();
                        });
                    }else if(response == "success"){
                        layer.msg("修改成功", {icon: 1, time: 1500}, function () {
                            window.location.href = "sensitiveWord.php";
                        });
                    }else if(response == "fail"){
                        layer.msg("敏感词未改动", {icon: 5, time: 1500}, function () {
                            $("input[name=swname]").focus();
                        });
                    }
                }
            });
        });
    });
});