$(function() {
    //全选
    $("#selectAll").on("click", function () {
        $(":checkbox").prop("checked", true);
    });
    //反选
    $("#selectReverse").on("click", function () {
        $(":checkbox").each(function (i) {
            if (!$(this).prop("checked")) {
                $(this).prop("checked", true);
            } else {
                $(this).prop("checked", false)
            }
        });
    });
    layui.use("layer", function () {
        var layer = layui.layer;
        //添加敏感词
        $("#addSensitive").on("click", function () {
            if ($("#adds").val().length == 0){
                layer.msg("不能为空", {icon: 5, time:1500}, function () {
                    $("#adds").focus();
                });
                return false;
            }
            $.ajax({
                type: "post",
                url:　"addSensitive.php",
                data: {
                    "words": $("#adds").val()
                },
                success: function (response) {
                    if(response == "hasW"){
                        layer.msg("此敏感词已存在", {icon: 5, time: 1500}, function () {
                            $("#adds").focus();
                        });
                    }else if(response == "success"){
                        layer.msg("添加成功", {icon: 1, time: 1500}, function () {
                            window.location.href = "sensitiveWord.php";
                        });
                    }else if(response == "fail"){
                        layer.msg("添加失败", {icon: 5, time: 1500}, function () {
                            window.location.href = "sensitiveWord.php";
                            $("#adds").focus();
                        });
                    }
                }
            });
        });
        //删除单条记录
        $(".delswBtn").on("click", function () {
            var $swid = $(this).attr("swid");
            layer.confirm("确定要删除吗？", {icon: 3, title: "警告"}, function (index) {
                $.ajax({
                    type: "post",
                    url: "delsensitiveWord.php",
                    data: {
                        "swid": $swid
                    },
                    success: function (response) {
                        if(response == "success") {
                            layer.msg("删除成功", {icon: 1, time: 1500}, function () {
                                window.location.href = "sensitiveWord.php";
                            });
                        }else if(response == "fail"){
                            layer.msg("删除失败", {icon: 1, time: 1500}, function () {
                                window.location.href = "sensitiveWord.php";
                            });
                        }
                    }
                });
                layer.close(index);
            });
        });
        //删除多条记录
        $("#delAll").on("click", function () {
            layer.confirm("确定要删除吗？", {icon : 3, title: "警告"}, function (index) {
                $.ajax({
                    type : "post",
                    url : "delSelectSensitiveWord.php",
                    data : $("#sml").serialize(),
                    success : function (response) {
                        $notempty = response.substring(0,8);
                        if ($notempty == "notempty"){//要删除的记录不空时
                            $success = response.substring(8);
                            if($success == "success"){
                                layer.msg("批量删除成功", {icon : 1, time: 1500});
                                setTimeout(function () {
                                    window.location.href = "sensitiveWord.php";
                                }, 1000);
                            }else {
                                layer.msg("批量删除失败", {icon : 5, time: 1500});
                                window.location.href = "sensitiveWord.php";
                            }
                        }else{
                            layer.msg("删除失败，未选中记录", {icon: 5, time: 1500}, function () {
                                window.location.href = "sensitiveWord.php";
                            });
                        }
                    }
                });
                layer.close(index);
            });
        });
    });
});