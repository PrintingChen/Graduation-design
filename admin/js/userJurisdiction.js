$(function () {
    //radio提交样式
    $("label").on("click", function () {
        $(this).addClass("checked").siblings().removeClass("checked");
    });
    //子版块数据
    $.ajax({
        type: "post",
        url: "getSMId.php",
        success: function (response) {
            window.dataId = jQuery.parseJSON(response);
        }
    });
    $.ajax({
        type : "post",
        url : "getSMData.php",
        success : function (response) {
            var data = jQuery.parseJSON(response);
            $str = "";
            for (var i=0;i<data.length;i++){
                $str += "<option value='"+dataId[i]+"'>"+data[i]+"</option>";
            }
            $("#smodule").append($str);
        }
    });
});