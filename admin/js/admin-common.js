//扩展时间
Date.prototype.Format = function (fmt) {
    var o = {
        "M+": this.getMonth() + 1, //月份
        "d+": this.getDate(), //日
        "h+": this.getHours(), //小时
        "m+": this.getMinutes(), //分
        "s+": this.getSeconds(), //秒
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度
        "S": this.getMilliseconds() //毫秒
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}
$(function(){
    //更新时间
    setInterval(function(){
        var timer = new Date().Format("yyyy-MM-dd hh:mm:ss");
        var timerArr = timer.split("-");
        $(".time span").html("").append(timerArr[0]+"年"+timerArr[1]+"月"+timerArr[2].split(" ")[0]+"日 "+timerArr[2].split(" ")[1]);
    },500);

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

    //注销
    layui.use("layer", function (index) {
        var layer = layui.layer;
        $("#logout").on("click", function () {
            layer.confirm("确定要注销吗", {icon: 3, title: "提示"}, function (index) {
                $.ajax({
                    type: "post",
                    url: "logout.php",
                    success: function (response) {
                        if(response == "0"){
                            layer.msg("您还未登录", {icon: 5, time: 800}, function (index) {
                                window.location.href = "login.php";
                            });
                        }else if (response == "1"){
                            layer.msg("注销成功", {icon: 1, time: 800}, function (index) {
                                window.location.href = "login.php";
                            });
                        }
                    }
                });
                layer.close(index);
            });
        });
    });
});
