$(function () {
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
        //审核单条记录
        $(".verifyPBtn").on("click", function () {
            $this = $(this);
            $postId = $this.attr('postId');
            layer.confirm("确定审核通过吗？", {icon : 3, title: "提示"}, function (index) {
                $.ajax({
                    type: "post",
                    url: "verifyPostStatusHandle.php",
                    data: {
                        "postId": $postId
                    },
                    success: function (response) {
                        if (response == "success"){
                            layer.msg("审核通过成功", {icon: 1, time: 1500}, function (index) {
                                window.location.href = "verifyPostStatus.php";
                                layer.close(index);
                            });
                        }else if(response == "fail"){
                            layer.msg("审核失败", {icon: 5, time: 1500}, function (index) {
                                window.location.href = "verifyPostStatus.php";
                                layer.close(index);
                            });
                        }
                    }
                });
                layer.close(index);
            });
        });

        //审核多条记录
        $("#verpAll").on("click", function () {
            layer.confirm("确定全部审核通过吗？", {icon : 3, title: "提示"}, function (index) {
                $.ajax({
                    type : "post",
                    url : "verifySelectPostStatusHandle.php",
                    data : $("#sml").serialize(),
                    success : function (response) {
                        $notempty = response.substring(0,8);
                        if ($notempty == "notempty"){//要审核的记录不空时
                            $success = response.substring(8);
                            if($success == "success"){
                                layer.msg("批量审核通过成功", {icon : 1, time: 1500});
                                setTimeout(function () {
                                    window.location.href = "verifyPostStatus.php";
                                }, 1000);
                            }else {
                                layer.msg("批量审核失败", {icon : 5, time: 1500});
                                window.location.href = "verifyPostStatus.php";
                            }
                        }else{
                            layer.msg("审核失败，未选中记录", {icon: 5, time: 1500}, function () {
                                window.location.href = "verifyPostStatus.php";
                            });
                        }
                    }
                });
                layer.close(index);
            });
        });
    });
});