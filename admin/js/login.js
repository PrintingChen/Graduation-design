$(function(){
    //更新验证码
    $("#yzm").on("click",function(){
        $(this).attr("src","../inc/vcode.php?key="+Math.random()*Math.pow(10,17)+"");
    });
});
