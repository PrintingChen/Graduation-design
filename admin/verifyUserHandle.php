<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //将需要删除的用户的uid存放起来
    $uid = $_POST['uid'];
    //将用户设置通过审核
    $sql = "update user set userStatus=0 where id={$uid}";
    execute($link, $sql);
    if (mysqli_affected_rows($link)) {
        echo "success";
        exit;
    }else {
        echo "fail";
        exit;
    }
?>
