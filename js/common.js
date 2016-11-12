$(function () {
    $(".logout").on("click", function () {
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.confirm("真的要退出登录吗？",{icon: 3, title: "提示"}, function(index){
                window.location.href="logout.php";
                layer.close(index);
            });
        });
    });
});