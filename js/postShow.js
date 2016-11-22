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
                        layer.msg("回复成功", {icon: 6, time: 1000});
                        setTimeout(function () {
                            window.location.href = "postShow.php?postId="+$postId+"";
                        }, 1500);
                    }
                }
            });
        });
    });
});