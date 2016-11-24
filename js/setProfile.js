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

    layui.use("layer", function () {
        var layer = layui.layer;
        //处理工作情况
        $("#workingBtn").on("click", function () {
            if($("#income").val().length == 0){
                layer.msg("年收入不能为空", {icon: 5, time: 1500}, function () {
                    $("#income").focus();
                });
                return false;
            }
            if(isNaN($("#income").val())){
                layer.msg("年收入必须为数字", {icon: 5, time: 1500}, function () {
                    $("#income").focus();
                });
                return false;
            }
            if ($("#income").val() < 0){
                layer.msg("年收入必须为非负数", {icon: 5, time: 1500}, function () {
                    $("#income").focus();
                });
                return false;
            }
            $.ajax({
                type: "post",
                url: "workingHandle.php",
                data: $("#form-working").serialize(),
                success: function (response) {
                    if(response == "success"){
                        layer.msg("数据更新成功", {icon: 1, time: 1000}, function () {
                            window.location.href = "profile.php";
                        });
                    }else if(response == "fail"){
                        layer.msg("数据未改动", {icon: 5, time: 1000});
                    }
                }
            });
        });
        //处理教育情况
        $("#eduBtn").on("click", function () {
            $.ajax({
                type: "post",
                url: "educationHandle.php",
                data: $("#form-education").serialize(),
                success: function (response) {
                    if(response == "success"){
                        layer.msg("数据更新成功", {icon: 1, time: 1000}, function () {
                            window.location.href = "profile.php";
                        });
                    }else if(response == "fail"){
                        layer.msg("数据未改动", {icon: 5, time: 1000});
                    }
                }
            });
        });
        //处理联系方式数据
        $("#contactBtn").on("click", function () {
            $.ajax({
                type: "post",
                url: "contactHandle.php",
                data: $("#form-contact").serialize(),
                success: function (response) {
                    if(response == "success"){
                        layer.msg("数据更新成功", {icon: 1, time: 1000}, function () {
                            window.location.href = "profile.php";
                        });
                    }else if(response == "fail"){
                        layer.msg("数据未改动", {icon: 5, time: 1000});
                    }
                }
            });
        });
        //处理联系方式数据
        $("#basicBtn").on("click", function () {
            $.ajax({
                type: "post",
                url: "basicHandle.php",
                data: $("#form-basic").serialize(),
                success: function (response) {
                    if(response == "success"){
                        layer.msg("数据更新成功", {icon: 1, time: 1000}, function () {
                            window.location.href = "profile.php";
                        });
                    }else if(response == "fail"){
                        layer.msg("数据未改动", {icon: 5, time: 1000});
                    }
                }
            });
        });
    });

});