$(function(){
    //验证表单
    $("#form-smodule").formValidator();
    layui.use('layer', function(){
        var layer = layui.layer;
        $("#form-smodule").submit(function () {
            //验证版块名称
            $moduleNameVal = $("#smoduleName").val();
            if ($moduleNameVal.length == 0){
                layer.msg('子版块不能为空',{icon: 5,time: 1000}, function(){
                    $("#smoduleName").focus();
                });
                return false;
            }
            if ($moduleNameVal.length > 20){
                layer.msg('子版块长度不能超过20个字符',{icon: 5,time: 1000}, function(){
                    $("#smoduleName").focus();
                });
                return false;
            }
            if (/[<>\'\"!！@#$￥%^&*（）()~]/.test($moduleNameVal)){
                layer.msg('不能包含明感字符',{icon: 5,time: 1000}, function(){
                    $("#smoduleName").focus();
                });
                return false;
            }
            //验证描述内容
            $descVal = $("#smoduleDesc").val();
            if ($descVal.length > 100){
                layer.msg('描述内容长度不能超过100个字符',{icon: 5,time: 1000}, function(){
                    $("#smoduleDesc").focus();
                });
                return false;
            }
            if (/[<>\'\"!！@#$￥%^&*（）()~]/.test($descVal)){
                layer.msg('不能包含明感字符',{icon: 5,time: 1000}, function(){
                    $("#smoduleDesc").focus();
                });
                return false;
            }
            return true;
        });
    });
});