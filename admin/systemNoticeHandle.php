<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //设置公告内容
    $sql_upd = "update notice set noticeContent='{$_POST["noticeContent"]}' where nid=1";
    execute($link, $sql_upd);
    if (mysqli_affected_rows($link)) {
        echo "success";
        exit;
    }else {
        echo "fail";
        exit;
    }

?>