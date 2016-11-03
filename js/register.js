/**
 * Created by chenyt on 2016/11/2.
 */

$(function(){
    //验证表单
    $("#form-login").formValidator();
    //更新验证码
    $(".yzmpic").on("click",function(){
        $(this).attr("src","inc/vcode.php?key="+Math.random()*Math.pow(10,17)+"");
    });
});
