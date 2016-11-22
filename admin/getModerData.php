<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //查询出子版块的信息
    $sql_user = "select * from user";
    $res_user = execute($link, $sql_user);
    $userName = array();
    while ($data_user = fetch_array($res_user)){
        array_push($userName, $data_user['name']);
    }
    echo json_encode($userName);
?>