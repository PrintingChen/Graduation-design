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
                $sid = $this.attr('sid');
                window.location.href = "delSModule.php?sid="+$sid+"";
                layer.close(index);
            });
        });

        //删除多条记录
        $("#delAll").on("click", function () {
            layer.confirm("确定要删除吗？", {icon : 3, title: "提示"}, function (index) {
                $.ajax({
                    type : "post",
                    url : "delSelectSubModule.php",
                    data : $("#sml").serialize(),
                    success : function (response, status, xhr) {
                        if(response == "1"){
                            layer.msg("批量删除成功", {icon : 1, time: 1500});
                            setTimeout(function () {
                                window.location.href = "sModuleList.php";
                            }, 800);
                        }else {
                            layer.msg("批量删除失败", {icon : 5, time: 1500});
                            setTimeout(function () {
                                window.location.href = "sModuleList.php";
                            }, 800);
                        }
                    }
                });
                layer.close(index);
            });
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
    //子版块数据
    $.ajax({
        type : "post",
        url : "getSMData.php",
        dataType : "json",
        success : function (response) {
            $str = "";
            for (var $key in response){
                $str += "<option>"+response[$key]+"</option>";
            }
            $("#smName").append($str);
        }
    });
});