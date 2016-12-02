$(function(){
    //验证表单
    $("#sml").formValidator();
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
        $(".delManBtn").on("click", function () {
            $this = $(this);
            $mid = $this.attr('mid');
            layer.confirm("确定要删除吗？", {icon : 3, title: "提示"}, function (index) {
                $.ajax({
                    type: "post",
                    url: "delManager.php",
                    data: {
                        "mid": $mid
                    },
                    success: function (response) {
                        if (response == "success"){
                            layer.msg("删除成功", {icon: 1, time: 1000}, function (index) {
                                window.location.href = "managerList.php";
                                layer.close(index);
                            });
                        }else if(response == "fail"){
                            layer.msg("删除失败", {icon: 5, time: 1000}, function (index) {
                                window.location.href = "managerList.php";
                                layer.close(index);
                            });
                        }
                    }
                });
                layer.close(index);
            });
        });
        //删除多条记录
        $("#delAll").on("click", function () {
            layer.confirm("确定要删除吗？", {icon : 3, title: "提示"}, function (index) {
                $.ajax({
                    type : "post",
                    url : "delSelectManager.php",
                    data : $("#sml").serialize(),
                    success : function (response) {
                        $notempty = response.substring(0,8);
                        if ($notempty == "notempty"){//要删除的记录不空时
                            $success = response.substring(8);
                            if($success == "success"){
                                layer.msg("批量删除成功", {icon : 1, time: 1500});
                                setTimeout(function () {
                                    window.location.href = "managerList.php";
                                }, 1000);
                            }else {
                                layer.msg("批量删除失败", {icon : 5, time: 1500});
                                window.location.href = "managerList.php";
                            }
                        }else{
                            layer.msg("删除失败，未选中记录", {icon: 5, time: 1500}, function () {
                                window.location.href = "managerList.php";
                            });
                        }
                    }
                });
                layer.close(index);
            });
        });
        //重置密码
        $(".resetPsw").on("click", function () {
            $mid = $(this).attr("mid");
            layer.confirm("确定重置密码吗？", {icon: 3, title: "警告"}, function (index) {
                $.ajax({
                    type: "post",
                    url: "resetManagerPsw.php",
                    data: {
                        "mid": $mid
                    },
                    success: function (response) {
                        if (response == "success"){
                            layer.msg("重置成功", {icon: 1, time: 2000});
                        }else if(response == "fail"){
                            layer.msg("已经重置，无需重复操作", {icon: 5, time: 2000});
                        }
                    }
                });
                layer.close(index);
            });
        });
    });
});