<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once 'inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //查询出敏感词
    $arr_sw = array();
    $sql_sw = "select * from sensitivewords";
    $res_sw = execute($link, $sql_sw);
    while ($data_sw = fetch_array($res_sw)){
        array_push($arr_sw, $data_sw['words']);
    }
    echo json_encode($arr_sw);
?>
