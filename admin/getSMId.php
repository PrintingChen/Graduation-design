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
    $sql_sm = "select * from sub_module";
    $res_sm = execute($link, $sql_sm);
    $sid= array();
    while ($data_sm = fetch_array($res_sm)){
        array_push($sid, $data_sm['sid']);
    }
    echo json_encode($sid);
?>
