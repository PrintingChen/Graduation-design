$(function () {
    //导航
    //请求父版块pid
    $.ajax({
        type: "post",
        url: "admin/getPMId.php",
        success: function (response) {
            window.dataId = jQuery.parseJSON(response);
        }
    });
    //请求父版块名称
    $.ajax({
        type: "post",
        url: "admin/getPMData.php",
        success: function (response) {
            var data = jQuery.parseJSON(response);
            var li = "";
            for (var i=0;i<data.length;i++){
                li += "<li><a href='pModuleList.php?pid="+dataId[i]+"'>"+data[i]+"</a></li>";
            }
            $("#navbar-list").append(li);
        }
    });

    //退出登录
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