$(function(){
    //验证表单
    $("#form-mdfsmodule").formValidator();
    //使用富文本编辑器
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="postContent"]', {
            allowFileManager : true,
            width : '800',
            height : '300',
            afterBlur: function () {
                this.sync();
            }
        });
    });
    
    layui.use("layer", function () {
        var layer = layui.layer;
        //修改帖子信息处理
        $("#btn-mdfsm").on("click", function () {
            $.ajax({
                type: "post",
                url: "postModifyHandle.php",
                data: {
                    "postTitle": $("#postTitle").val(),
                    "selSModule": $("#selSModule").val(),
                    "postContent": $("#smoduleDesc").val(),
                    "postId": $("#btn-mdfsm").attr("postId")
                },
                success: function (response) {
                    if (response == "success"){
                        layer.msg("修改成功", {icon: 1, time: 1000}, function () {
                            setTimeout(function () {
                                window.location.href = "postList.php";
                            }, 1000);
                        });
                    }else if(response == "fail"){
                        layer.msg("修改失败", {icon: 5, time: 1000});
                    }
                }
            });
        });
    });
});