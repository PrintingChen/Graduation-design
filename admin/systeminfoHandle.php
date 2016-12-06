<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //管理员是否登录
    if (!($mid = manage_login_state($link))) {
        promptBox('您还未登录！', 5, 'login.php');
        exit;
    }
    //父板块总数
    $query="select * from parent_module";
    $count_pm=nums($link,$query);
    //子板块总数
    $query="select * from sub_module";
    $count_sm=nums($link,$query);
    //帖子总数
    $query="select * from post";
    $count_p=nums($link,$query);
    //回帖总数
    $query="select * from reply";
    $count_rep=nums($link,$query);
    //用户总数
    $query="select * from user";
    $count_u=nums($link,$query);
    //管理员总数
    $query="select * from manager";
    $count_man=nums($link,$query);

    $arr = [$count_pm, $count_sm, $count_p, $count_rep, $count_u, $count_man];

    echo json_encode($arr);

?>