$(function(){
    //layui组件
    layui.use("layer", function () {
        var layer = layui.layer;
        //删除单条记录
        $(".delRepBtn").on("click", function () {
            $this = $(this);
            layer.confirm("确定要删除吗？", {icon : 3, title: "提示"}, function (index) {
                $rid = $this.attr('rid');
                $.ajax({
                    type: "post",
                    url: "delReply.php",
                    data: {
                        "rid": $rid
                    },
                    success: function (response) {
                        if (response == "success"){
                            layer.msg("删除成功", {icon: 1, time: 1000}, function (index) {
                                window.location.href = "replyList.php";
                                layer.close(index);
                            });
                        }else if(response == "fail"){
                            layer.msg("删除失败", {icon: 5, time: 1000}, function (index) {
                                window.location.href = "replyList.php";
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