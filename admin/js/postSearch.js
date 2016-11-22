$(function(){
    //layui组件
    layui.use("layer", function () {
        var layer = layui.layer;
        //删除单条记录
        $(".delPostBtn").on("click", function () {
            $this = $(this);
            layer.confirm("确定要删除吗？", {icon : 3, title: "提示"}, function (index) {
                $postId = $this.attr('postId');
                $.ajax({
                    type: "post",
                    url: "delPost.php",
                    data: {
                        "postId": $postId
                    },
                    success: function (response) {
                        if (response == "success"){
                            layer.msg("删除成功", {icon: 1, time: 1000}, function (index) {
                                window.location.href = "postList.php";
                                layer.close(index);
                            });
                        }else if(response == "fail"){
                            layer.msg("删除失败", {icon: 6, time: 1000}, function (index) {
                                window.location.href = "postList.php";
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