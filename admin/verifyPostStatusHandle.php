<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //将需要审核的帖子的postId存放起来
    $postId = $_POST['postId'];
    //将帖子设置通过审核
    $sql = "update post set postStatus=0 where postId={$postId}";
    execute($link, $sql);
    if (mysqli_affected_rows($link)) {
        echo "success";
        exit;
    }else {
        echo "fail";
        exit;
    }
?>
