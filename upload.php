<?php
/**
 * Created by PhpStorm.
 * User: chenyt
 * Date: 2016/11/22
 * Time: 下午 08:46
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="js/jquery-1.12.2.min.js"></script>
    <script src="layui/layui.js"></script>
    <script>
        $(function () {
            layui.use('upload', function(){
                layui.upload({
                    url: '上传接口url'
                    ,success: function(res){
                        console.log(res); //上传成功返回值，必须为json格式
                    }
                });
            });
        });
    </script> 
</head>
<body>
<input type="file" name="file（可随便定义）" class="layui-upload-file">
</body>
</html>