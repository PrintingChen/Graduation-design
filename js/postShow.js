//富文本编辑器
$(function () {
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="fastrepcont"]', {
            allowFileManager : true,
            width : '765',
            height : '138',
            afterBlur: function () {
                this.sync();
            }
        });
    });
    //刷新验证码
    $(".yzmpic").on("click",function(){
        $(this).attr("src","inc/vcode.php?key="+Math.random()*Math.pow(10,17)+"");
    });

    //回复帖子
    layui.use("layer", function () {
        var layer = layui.layer;
        //判断是否登录状态
        $("#pubBtn").on("click", function () {
            $sid = $(this).attr("sid");
            $.ajax({
                type: "post",
                url: "isLoginHandle.php",
                success: function (response) {
                    if(response == "success"){
                        window.location.href = "publish.php?sid="+$sid;
                    }else if(response == "fail"){
                        layer.msg("您还未登录，无法发布帖子", {icon: 5, time: 1000}, function () {
                            window.location.href = "login.php";
                        });
                    }
                }
            });
        });
        $("#pubBtn1").on("click", function () {
            $sid = $(this).attr("sid");
            $.ajax({
                type: "post",
                url: "isLoginHandle.php",
                success: function (response) {
                    if(response == "success"){
                        window.location.href = "publish.php?sid="+$sid;
                    }else if(response == "fail"){
                        layer.msg("您还未登录，无法发布帖子", {icon: 5, time: 1000}, function () {
                            window.location.href = "login.php";
                        });
                    }
                }
            });
        });
        $("#repBtn").on("click", function () {
            $postId = $(this).attr("postId");
            $.ajax({
                type: "post",
                url: "isLoginHandle.php",
                success: function (response) {
                    if(response == "success"){
                        window.location.href = "reply.php?postId="+$postId;
                    }else if(response == "fail"){
                        layer.msg("您还未登录，无法发表回复", {icon: 5, time: 1000}, function () {
                            window.location.href = "login.php";
                        });
                    }
                }
            });
        });
        $("#repBtn1").on("click", function () {
            $postId = $(this).attr("postId");
            $.ajax({
                type: "post",
                url: "isLoginHandle.php",
                success: function (response) {
                    if(response == "success"){
                        window.location.href = "reply.php?postId="+$postId;
                    }else if(response == "fail"){
                        layer.msg("您还未登录，无法发表回复", {icon: 5, time: 1000}, function () {
                            window.location.href = "login.php";
                        });
                    }
                }
            });
        });
        //判断引用回复是否登录状态
        $(".quoteRepBtn").on("click", function () {
            $postId = $(this).attr("postId");
            $quoteId = $(this).attr("quoteId");
            $.ajax({
                type: "post",
                url: "isLoginHandle.php",
                success: function (response) {
                    if (response == "success") {
                        window.location.href = "quoteReply.php?postId="+$postId+"&quoteId="+$quoteId;
                    } else if (response == "fail") {
                        layer.msg("您还未登录，无法回复帖子", {icon: 5, time: 1500}, function () {
                            setTimeout(function () {
                                window.location.href = "login.php";
                            });
                        }, 1500);
                    }
                }
            });
        });
        //删除自己发的帖子
        $(".deleteBtn").on("click", function () {
            $postId = $(this).attr("postId");
            layer.confirm("确定要删除吗", {icon: 3}, function (index) {
                $.ajax({
                    type: "post",
                    url: "postDelete.php",
                    data: {
                        "postId": $postId
                    },
                    success: function (response) {
                        if (response == "success"){
                            layer.msg("删除成功", {icon: 1, time: 1000}, function () {
                                setTimeout(function () {
                                    window.location.href = "index.php";
                                });
                            }, 1500);
                        }else if(response == "fail"){
                            layer.msg("删除失败", {icon: 5, time: 1000});
                        }
                    }
                });
                layer.close(index);
            });
        });
        //删除自己的回复
        $(".deleteRepBtn").on("click", function () {
            $rid = $(this).attr("rid");
            $sid = $(this).attr("sid");
            $postId= $(this).attr("postId");
            layer.confirm("确定要删除吗", {icon: 3}, function (index) {
                $.ajax({
                    type: "post",
                    url: "replyDelete.php",
                    data: {
                        "rid": $rid
                    },
                    success: function (response) {
                        if (response == "success"){
                            layer.msg("删除成功", {icon: 1, time: 1000}, function () {
                                setTimeout(function () {
                                    window.location.href = "postShow.php?postId="+$postId+"&sid="+$sid;
                                });
                            }, 1000);
                        }else if(response == "fail"){
                            layer.msg("删除失败", {icon: 5, time: 1000});
                        }
                    }
                });
                layer.close(index);
            });
        });
        //处理回复
        $("#reply").click(function () {
            //判断帖子内容长度
            if($("#fastrepcont").val().length < 1){
                layer.msg("回复内容不能为空",{icon: 5, time: 1000}, function () {
                    $("#fastrepcont").focus();
                });
                return false;
            }
            //判断验证码长度
            if($("#yzm").val().length != 4){
                layer.msg("验证码长度必须为4位",{icon: 5, time: 1000}, function () {
                    $("#yzm").focus();
                });
                return false;
            }
            //回复处理
            $.ajax({
                type: "post",
                url: "replyHandle.php",
                data: {
                    "content": $("#fastrepcont").val(),
                    "yzm": $("#yzm").val(),
                    "postId": $("#reply").attr("postId")
                },
                success: function (response) {
                    $postId = response.substring(7);//帖子的id
                     if(response == "yzmnoequal"){
                        layer.msg("验证码错误", {icon: 5, time: 1000});
                    }else if(response == "fail"){
                        layer.msg("回复失败", {icon: 5, time: 1000});
                        setTimeout(function () {
                            window.location.href = "postShow.php?postId="+$postId+"";
                        }, 1500);
                    }else{
                        layer.msg("回复成功", {icon: 1, time: 1000});
                        setTimeout(function () {
                            window.location.href = "postShow.php?postId="+$postId+"";
                        }, 1500);
                    }
                }
            });
        });
    });
});