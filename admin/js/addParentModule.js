$(function(){
    //验证表单
    $("#form-pmodule").formValidator();
    layui.use('layer', function(){
        var layer = layui.layer;
        $("#addPModule").on("click",function () {
            //验证版块名称
            $moduleNameVal = $("#pmoduleName").val();
            if ($moduleNameVal.length == 0){
                layer.msg('父版块不能为空',{icon: 5,time: 1000}, function(){
                    $("#pmoduleName").focus();
                });
                return false;
            }
            if ($moduleNameVal.length > 20){
                layer.msg('父版块长度不能超过20个字符',{icon: 5,time: 1000}, function(){
                    $("#pmoduleName").focus();
                });
                return false;
            }
            if (/[<>\'\"!！@#$￥%^&*（）()~]/.test($moduleNameVal)){
                layer.msg('不能包含明感字符',{icon: 5,time: 1000}, function(){
                    $("#pmoduleName").focus();
                });
                return false;
            }
            //验证描述内容
            $descVal = $("#pmoduleDesc").val();
            if ($descVal.length > 100){
                layer.msg('描述内容长度不能超过100个字符',{icon: 5,time: 1000}, function(){
                    $("#pmoduleDesc").focus();
                });
                return false;
            }
            if (/[<>\'\"!！@#$￥%^&*（）()~]/.test($descVal)){
                layer.msg('不能包含明感字符',{icon: 5,time: 1000}, function(){
                    $("#pmoduleDesc").focus();
                });
                return false;
            }
            $.ajax({
                type: "post",
                url: "addParentModuleHandle.php",
                data: $("#form-pmodule").serialize(),
                success: function (response) {
                    if(response == "hasPM"){
                        layer.msg("添加的父版块已存在", {icon:5 ,time: 1500}, function () {
                            $("#pmoduleName").focus();
                        });
                    }else if(response == "success"){
                        layer.msg("添加成功", {icon: 1, time: 1500}, function () {
                            window.location.href = "pModuleList.php";
                        });
                    }else if(response == "fail"){
                        layer.msg("添加失败", {icon: 1, time: 1500});
                    }
                }
            });
        });
    });
});