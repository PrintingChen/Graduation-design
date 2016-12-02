$(function(){
    //验证表单
    $("#addman-form").formValidator();
    //ajax添加用户
    $("#addManBtn").on("click", function () {
        layui.use("layer", function () {
            var layer = layui.layer;
            //验证用户名不能为空
            if ($("#userName").val().length == 0){
                layer.msg("用户名不能为空", {icon: 5, time: 1000}, function () {
                    $("#userName").focus();
                });
                return false;
            }
            //验证密码不能为空
            $reg = /^\w+$/;
            if ($("#password").val().length == 0){
                layer.msg("密码不能为空", {icon: 5, time: 1000}, function () {
                    $("#password").focus();
                });
                return false;
            }
            if (!$reg.test($("#password").val())){
                layer.msg("密码只能有数字、字母和下划线组成", {icon: 5, time: 1200}, function () {
                    $("#password").focus();
                });
                return false;
            }
            //验证码确认密码
            if ($("#password").val() != $("#repassword").val()){
                layer.msg("两次密码不一致", {icon: 5, time: 1200}, function () {
                    $("#repassword").focus();
                });
                return false;
            }
            $.ajax({
                type : "post",
                url : "addManagerHandle.php",
                data : $("#addman-form").serialize(),
                success : function (response) {
                    if(response == "hasMan"){
                        layer.msg("此管理员已存在", {icon : 5, time : 1500}, function () {
                            $("#userName").focus();
                        });
                    }else if(response == "success"){
                        layer.msg("添加成功", {icon : 1, time : 1000}, function () {
                            window.location.href = "managerList.php";
                        });
                    }else if(response == "fail"){
                        layer.msg("添加失败", {icon : 5, time : 1500});
                    }
                }
            });
        });
    });
});