$(function(){
    //layui组件
    layui.use("layer", function () {
        var layer = layui.layer;
        //删除单条记录
        $(".delPMBtn").on("click", function () {
            $this = $(this);
            layer.confirm("确定要删除吗？", {icon : 3, title: "提示"}, function (index) {
                $pid = $this.attr('pid');
                $.ajax({
                    type: "post",
                    url: "delPModule.php?pid="+$pid+"",
                    success: function (response) {
                        if(response == "hasSM"){
                            layer.msg("删除失败，请先将此父版块下面的子版块删除", {icon: 5, time: 2000});
                        }else if(response == "success"){
                            layer.msg("删除成功", {icon: 1, time: 1000}, function () {
                                window.location.href = "pModuleList.php";
                            });
                        }else if(response == "fail"){
                            layer.msg("删除失败", {icon: 5, time: 1000});
                        }
                    }
                });
                layer.close(index);
            });
        });
    });
});