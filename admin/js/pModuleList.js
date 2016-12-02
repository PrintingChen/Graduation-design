$(function(){
    //全选
    $("#selectAll").on("click", function(){
        $(":checkbox").prop("checked", true);
    });
    //反选
    $("#selectReverse").on("click", function(){
        $(":checkbox").each(function (i) {
            if(!$(this).prop("checked")){
                $(this).prop("checked", true);
            }else {
                $(this).prop("checked", false)
            }
        });
    });
    //layui组件
    layui.use("layer", function () {
        var layer = layui.layer;
        //删除单条记录
        $(".delPMBtn").on("click", function () {
            $this = $(this);
            layer.confirm("确定要删除吗？", {icon : 3, title: "提示"}, function (index) {
                $pid = $this.attr('pid');
                $.ajax({
                    type: "post",
                    url: "delPModule.php?pid="+$pid+"",
                    success: function (response) {
                        if(response == "hasSM"){
                            layer.msg("删除失败，请先将此父版块下面的子版块删除", {icon: 5, time: 2000});
                        }else if(response == "success"){
                            layer.msg("删除成功", {icon: 1, time: 1000}, function () {
                                window.location.href = "pModuleList.php";
                            });
                        }else if(response == "fail"){
                            layer.msg("删除失败", {icon: 5, time: 1000});
                        }
                    }
                });
                layer.close(index);
            });
        });
        //删除多条记录
        $("#delAll").on("click", function () {
            layer.confirm("确定要删除吗？", {icon : 3, title: "提示"}, function (index) {
                $.ajax({
                    type : "post",
                    url : "delSelectParentModule.php",
                    data : $("#sml").serialize(),
                    success : function (response) {
                        if(response == "1"){
                            layer.msg("批量删除成功", {icon : 1, time: 1500});
                            setTimeout(function () {
                                window.location.href = "pModuleList.php";
                            }, 800);
                        }else {
                            layer.msg("批量删除失败", {icon : 5, time: 1500});
                            setTimeout(function () {
                                window.location.href = "pModuleList.php";
                            }, 800);
                        }
                    }
                });
                layer.close(index);
            });
        });

        //ajax获取搜索条件的数据
        //父版块数据
        $.ajax({
            type : "post",
            url : "getPMData.php",
            dataType : "json",
            success : function (response) {
                $str = "";
                for (var $key in response){
                    $str += "<option>"+response[$key]+"</option>";
                }
                $("#pmName").append($str);
            }
        });
        //版主的信息
        $.ajax({
            type : "post",
            url : "getModerData.php",
            dataType : "json",
            success : function (response) {
                $str = "";
                for (var $key in response){
                    $str += "<option>"+response[$key]+"</option>";
                }
                $("#moder").append($str);
            }
        });
    });
});