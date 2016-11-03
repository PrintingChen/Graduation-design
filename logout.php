<?php
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once 'inc/common.inc.php';

    //删除cookie
    if (isset($_COOKIE['bs']['userName']) || isset($_COOKIE['bs']['psw'])) {
        setcookie('bs[userName]', "", time()-36000);
        setcookie('bs[psw]', "", time()-36000);
    }
    if (isset($_COOKIE['bs']['userName']) || isset($_COOKIE['bs']['psw'])) {
        //promptBox("退出成功", 6, "index.php");
        skip('index.php', 'success', '退出成功^_^');
        exit();
    }else{
        //promptBox("退出失败", 5, "index.php");
        skip('index.php', 'error', '退出失败^_^');
        exit();
    }
?>
