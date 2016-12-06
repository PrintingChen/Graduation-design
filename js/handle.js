$(function () {
    layui.use("layer", function () {
        var layer = layui.layer;
        //设置精华
        $("#boutique").on("click", function () {
            $postId = $("#boutique").attr("postId");
            $sid = $("#boutique").attr("sid");
            layer.confirm("设置为精华帖吗?", {icon: 3, title: "提示"}, function (index) {
                $.ajax({
                    type: "post",
                    url: "isBoutiqueHandle.php",
                    data: {
                        "postId": $postId
                    },
                    success: function (response) {
                        if(response == "success"){
                            layer.msg("设置成功", {icon: 1, time: 1000}, function () {
                                window.location.href = "postShow.php?postId="+$postId+"&sid="+$sid+"";
                            });
                        }else if(response == "fail"){
                            layer.msg("已是精华帖", {icon: 6, time: 1000});
                        }
                    }
                });
                layer.close(index);
            });
        });
        //取消精华
        $("#cancelBoutique").on("click", function () {
            $postId = $("#cancelBoutique").attr("postId");
            $sid = $("#cancelBoutique").attr("sid");
            layer.confirm("取消精华吗?", {icon: 3, title: "提示"}, function (index) {
                $.ajax({
                    type: "post",
                    url: "cancelBoutiqueHandle.php",
                    data: {
                        "postId": $postId
                    },
                    success: function (response) {
                        if(response == "success"){
                            layer.msg("取消成功", {icon: 1, time: 1000}, function () {
                                window.location.href = "postShow.php?postId="+$postId+"&sid="+$sid+"";
                            });
                        }else if(response == "fail"){
                            layer.msg("已经取消", {icon: 6, time: 1000});
                        }
                    }
                });
                layer.close(index);
            });
        });
        //设置屏蔽
        $("#shield").on("click", function () {
            $postId = $("#shield").attr("postId");
            $sid = $("#shield").attr("sid");
            layer.confirm("屏蔽这条帖子吗?", {icon: 3, title: "提示"}, function (index) {
                $.ajax({
                    type: "post",
                    url: "isShieldHandle.php",
                    data: {
                        "postId": $postId
                    },
                    success: function (response) {
                        if(response == "success"){
                            layer.msg("屏蔽成功", {icon: 1, time: 1000}, function () {
                                window.location.href = "postShow.php?postId="+$postId+"&sid="+$sid+"";
                            });
                        }else if(response == "fail"){
                            layer.msg("已经屏蔽了", {icon: 6, time: 1000});
                        }
                    }
                });
                layer.close(index);
            });
        });
        //取消屏蔽
        $("#cancelshield").on("click", function () {
            $postId = $("#cancelshield").attr("postId");
            $sid = $("#cancelshield").attr("sid");
            layer.confirm("取消屏蔽吗?", {icon: 3, title: "提示"}, function (index) {
                $.ajax({
                    type: "post",
                    url: "cancelShieldHandle.php",
                    data: {
                        "postId": $postId
                    },
                    success: function (response) {
                        if(response == "success"){
                            layer.msg("取消成功", {icon: 1, time: 1000}, function () {
                                window.location.href = "postShow.php?postId="+$postId+"&sid="+$sid+"";
                            });
                        }else if(response == "fail"){
                            layer.msg("已经取消屏蔽了", {icon: 6, time: 1000});
                        }
                    }
                });
                layer.close(index);
            });
        });
        //删除主题
        $("#delTheme").on("click", function () {
            $postId = $(this).attr("postId");
            $sid = $(this).attr("sid");
            layer.confirm("确定要删除这条主题吗？", {icon: 3, title: "警告"}, function (index) {
                $.ajax({
                    type: "post",
                    url: "postDelete.php",
                    data: {
                        "postId": $postId
                    },
                    success: function (response) {
                        if (response == "success"){
                            layer.msg("删除成功", {icon: 1, time: 1000}, function () {
                                window.location.href = "sModuleList.php?sid="+$sid+"";
                            });
                        }else if(response == "fail"){
                            layer.msg("删除失败", {icon: 5, time: 1000});
                        }
                    }
                });
                layer.close(index);
            });
        });
        //当帖子被屏蔽时，编辑功能无法使用
        $("#editpBtn").on("click", function () {
            $postId = $("#editpBtn").attr("postId");
            $shield = $("#editpBtn").attr("shield");
            $postStatus = $("#editpBtn").attr("postStatus");
            //console.log($postStatus == "1");
            if ($shield == "1" || $postStatus == "1"){//帖子被屏蔽时
                layer.msg("您的主题已被屏蔽或者未通过审核，无法编辑", {icon: 5, time: 2000});
            }else if($shield == "0"){
                window.location.href = "postEdit.php?postId="+$postId+"";
            }
        });
    });
});