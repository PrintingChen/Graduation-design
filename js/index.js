$(function () {
    //轮播自动播放
    $('#myCarousel').carousel({
        //自动4秒播放
        interval : 3000,
    });
    //点击收缩版块
    $("#category_collapsed").on("click", function () {
        $parent = $(this).parent().parent().parent();
        if($parent.children(".bm_c").css("display") == "block"){
            $parent.children(".bm_c").css("display", "none");
            $(this).attr("src", "img/collapsed_yes.gif");
        }else{
            $parent.children(".bm_c").css("display", "block");
            $(this).attr("src", "img/collapsed_no.gif");
        }
    });
    $(".o").each(function (i) {
        $(this).on("click", function () {
            $(this).css('background','url("img/collapsed_yes.gif")');
            if($('.bm_c').eq(i).css('display') == 'block'){
                $('.bm_c').eq(i).css('display','none');
            }else{
                $(this).css('background','url("img/collapsed_no.gif")');
                $('.bm_c').eq(i).css('display','block');
            }
        });
    });
    
    layui.use("layer", function () {
        var layer = layui.layer;
        //判断是否登录状态
        $("#pubBtn").on("click", function () {
            $.ajax({
                type: "post",
                url: "isLoginHandle.php",
                success: function (response) {
                    if(response == "success"){
                        window.location.href = "publish.php";
                    }else if(response == "fail"){
                        layer.msg("您还未登录，无法发布帖子", {icon: 5, time: 1000}, function () {
                            window.location.href = "login.php";
                        });
                    }
                }
            });
        });
    });
});