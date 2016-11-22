<?php
    //开启session
    //session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    $sql_del = "delete from reply where rid={$_POST['rid']}";
    execute($link, $sql_del);
    if (mysqli_affected_rows($link)){
        echo "success";
        exit;
    }else{
        echo "fail";
        exit;
    }
?>