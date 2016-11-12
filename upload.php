<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once 'inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
if (isset($_POST['sub'])){
    $save_path='uploads'.date('/Y/m/d/');
    $upload = upload($save_path,'8M','upload');
    if($upload['return']){
        echo $upload['save_path'];
        //$query="update sub_module set smodulePic='{$upload['save_path']}'";
        //execute($link, $query);
        //if(mysqli_affected_rows($link)==1){
         //   echo 1;
            //promptBox("头像上传成功", 6, "addSubModule.php");
        //}else{
         //   echo 2;
            //promptBox("头像上传失败", 5, "addSubModule.php");
        //}
    }else{
        echo 3;
        //skip("addSubModule.php", "error", $upload["error"]);
        exit();
    }
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="upload" id="">
    <input type="submit" name="sub" value="upload1">
</form>
</body>
</html>