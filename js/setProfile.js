/**
 * Created by chenyt on 2016/11/2.
 */
$(function () {
    //标签页切换
    $("#myTab a").on("click", function (e) {
        e.preventDefault();
        $(this).tab("show");
    });
    //左侧栏点击切换
    $("#navbar-left li").on("click",function () {
        //添加样式
        $(this).addClass("mdfpic").siblings().removeClass("mdfpic");
    });
    $("#navbar-left li").eq(0).on("click", function () {
        $(".head-pic").css("display", "block");
        $(".profile-info").css("display", "none");
        $(".mdf-psw").css("display", "none");
    });
    $("#navbar-left li").eq(1).on("click", function () {
        $(".head-pic").css("display", "none");
        $(".profile-info").css("display", "block");
        $(".mdf-psw").css("display", "none");
    });
    $("#navbar-left li").eq(2).on("click", function () {
        $(".head-pic").css("display", "none");
        $(".profile-info").css("display", "none");
        $(".mdf-psw").css("display", "block");
    });
    //验证表单
    $("#form-mdfpsw").formValidator();
    $("#form-contact").formValidator();
    $("#form-working").formValidator();

    //更新验证码
    $(".yzmpic").on("click",function(){
        $(this).attr("src","inc/vcode.php?key="+Math.random()*Math.pow(10,17)+"");
    });

    //生成年份
    var htmlYear = "";
    for(var year=2016;year>=1917;year--){
        htmlYear += "<option value='"+year+"'>"+year+"</option>";
    }
    $("#year").append(htmlYear);
    //生成月份
    var htmlMonth = "";
    for(var month=1;month<=12;month++){
        htmlMonth += "<option value='"+month+"'>"+month+"</option>";
    }
    $("#month").append(htmlMonth);
    //生成年份
    var htmlDay = "";
    for(var day=1;day<=31;day++){
        htmlDay += "<option value='"+day+"'>"+day+"</option>";
    }
    $("#day").append(htmlDay);

    //执行三级联动代码
    _init_area();

});