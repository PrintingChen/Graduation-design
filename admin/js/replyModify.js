$(function () {
    //使用富文本编辑器
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="rcontent"]', {
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
        //修改回复信息处理
        $("#btn-mdfsm").on("click", function () {
            $.ajax({
                type: "post",
                url: "replyModifyHandle.php",
                data: {
                    "rid": $("#btn-mdfsm").attr("rid"),
                    "rcontent": $("#rcontent").val()
                },
                success: function (response) {
                    if (response == "success"){
                        layer.msg("修改成功", {icon: 1, time: 1000}, function () {
                            setTimeout(function () {
                                window.location.href = "replyList.php";
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