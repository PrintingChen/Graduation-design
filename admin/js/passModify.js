$(function(){
    //验证表单
    $("#form-mdfpsw").formValidator();
    layui.use("layer", function () {
        var layer = layui.layer;
        $("#mdfBtn").on("click", function () {
            /*//旧密码不能为空
            if($("#opsw").val() == 0){
                layer.msg("原密码不能为空", {icon: 5, time: 1000}, function () {
                    $("#opsw").focus();
                });
                return false;
            }*/
            //新密码不能为空
            if($("#npsw").val() == 0){
                layer.msg("新密码不能为空", {icon: 5, time: 1000}, function () {
                    $("#npsw").focus();
                });
                return false;
            }
            //确认密码
            if($("#renpsw").val() != $("#npsw").val()){
                layer.msg("两次密码不一致", {icon: 5, time: 1000}, function () {
                    $("#renpsw").focus();
                });
                return false;
            }
            $.ajax({
                type: "post",
                url: "passModifyHandle.php",
                data: $("#form-mdfpsw").serialize(),
                success: function (response) {
                    if(response == "opswerror"){
                        layer.msg("原密码有误", {icon: 5, time: 1000}, function () {
                            $("#opsw").focus();
                        });
                    }else if(response == "success"){
                        layer.msg("密码修改成功", {icon: 1, time: 1000}, function () {
                            window.location.href = "login.php";
                        });
                    }else if(response == "fail"){
                        layer.msg("密码未改动", {icon: 5, time: 1000});
                    }
                }
            });
        });
    });
});