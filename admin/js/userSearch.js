$(function(){
    //验证表单
    $("#form-mdfpsw").formValidator();
    //全选
    $("#selectAll").on("click", function(){
        $(":checkbox").prop("checked", true);
    });
    //反选
    $("#selectReverse").on("click", function(){
        $(":checkbox").each(function (i) {
            if(!$(this).prop("checked")){
                $(this).prop("checked", true);
            }else {
                $(this).prop("checked", false)
            }
        });
    });

    //layui组件
    layui.use("layer", function () {
        var layer = layui.layer;
        //删除单条记录
        $(".delUserBtn").on("click", function () {
            $this = $(this);
            layer.confirm("确定要删除吗？", {icon : 3, title: "提示"}, function (index) {
                $uid = $this.attr('uid');
                $.ajax({
                    type: "post",
                    url: "delUser.php",
                    data: {
                        "uid": $uid
                    },
                    success: function (response) {
                        if (response == "success"){
                            layer.msg("删除成功", {icon: 1, time: 1000}, function (index) {
                                window.location.href = "userList.php";
                                layer.close(index);
                            });
                        }else if(response == "fail"){
                            layer.msg("删除失败", {icon: 6, time: 1000}, function (index) {
                                window.location.href = "userList.php";
                                layer.close(index);
                            });
                        }
                    }
                });
                layer.close(index);
            });
        });
    });
});