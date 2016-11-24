$(function () {
    $(".logout").on("click", function () {
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.confirm("真的要退出登录吗？",{icon: 3, title: "提示"}, function(index){
                $.ajax({
                    type: "post",
                    url: "logout.php",
                    success: function (response) {
                        if(response == "1"){
                            layer.msg("您已退出站点，将以游客身份转入退出前页面，请稍候...", {icon: 1, time: 1000}, function (index) {
                                window.location.href = "index.php";
                                layer.close(index);
                            });
                        }else if(response == "0"){
                            layer.msg("退出失败", {icon: 1}, function (index) {
                                window.location.href = "index.php";
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