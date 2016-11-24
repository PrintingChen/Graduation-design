//提示帖子标题字数长度
$("#post-title").on("keyup", function () {
    $val = 40-$(this).val().length;
    if ($val<0) $val = 0;
    $(".len").html($val);
});
//富文本编辑器
var editor;
KindEditor.ready(function(K) {
    editor = K.create('textarea[name="content"]', {
        allowFileManager : true,
        width : '960',
        height : '400',
        afterBlur: function () {
            this.sync();
        }
    });
});
//刷新验证码
$(".yzmpic").on("click",function(){
    $(this).attr("src","inc/vcode.php?key="+Math.random()*Math.pow(10,17)+"");
});
//发表帖子
layui.use("layer", function () {
    var layer = layui.layer;
    $("#publish").click(function () {
        //必须选则一个子版块
        if($("#selSModule").val().length == 0){
            layer.msg("必须选则一个子版块",{icon: 5, time: 1000}, function () {
                $("#selSModule").focus();
            });
            return false;
        }
        //判断标题长度
        $title_len = $("#post-title").val().length;
        if($title_len < 1 || $title_len > 40){
            layer.msg("标题长度不合法",{icon: 5, time: 1000}, function () {
                $("#post-title").focus();
            });
            return false;
        }
        //判断帖子内容长度
        if($("#content").val().length < 1){
            layer.msg("帖子内容不能为空",{icon: 5, time: 1000}, function () {
                $("#content").focus();
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
        $.ajax({
            type: "post",
            url: "publishHandle.php",
            data: $("#publish-form").serialize(),
            success: function (response) {
                $postId = response.substring(7);//帖子的id
                if(response == "yzmnoequal"){
                    layer.msg("验证码错误", {icon: 5, time: 1000});
                }else if(response == "fail"){
                    layer.msg("发布失败", {icon: 5, time: 1000});
                    setTimeout(function () {
                        window.location.href = "publish.php";
                    }, 1500);
                }else{
                    layer.msg("发布帖子成功", {icon: 1, time: 1000});
                    setTimeout(function () {
                        window.location.href = "postShow.php?postId="+$postId+"";
                    }, 1500);
                }
            }
        });
        return true;
    });
});