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
    $uid = $_GET["uid"];
    //用户信息
    $sql_u="select * from user where id={$uid}";
    $data_u=fetch_array(execute($link,$sql_u));
    //帖子总数
    $sql_p="select * from post where postuid={$uid}";
    $count_p=nums($link,$sql_p);
    //回帖总数
    $sql_rep="select * from reply where ruid={$uid}";
    $count_rep=nums($link,$sql_rep);

    $arr = [$count_p, $count_rep, $data_u["loginTimes"], $data_u["name"]];

    echo json_encode($arr);

?>