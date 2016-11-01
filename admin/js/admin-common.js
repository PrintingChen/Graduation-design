/**
 * Created by chenyt on 2016/10/23.
 */
$(function(){
    // 点击左侧栏目收缩
    $(".leftnav h2").on("click", function(){
        $(this).next().slideToggle(200);
        $(this).toggleClass("on");
    });
    $(".leftnav ul li").on("click", function(){
        $(this).addClass("on").siblings().removeClass("on");
        //设置导航信息
        $(".positionText").html($("a",$(this)).get(0).innerText);
    });
});