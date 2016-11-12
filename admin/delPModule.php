<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //判断要删除的版块id是否合法
    if (!isset($_GET['pid']) || !is_numeric($_GET['pid']) ) {

        //skip('pModuleList.php', 'error', 'id传参错误！');
        //exit();
    }


?>