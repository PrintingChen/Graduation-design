<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //查询出父版块的信息
    $sql_pm = "select * from parent_module";
    $res_pm = execute($link, $sql_pm);
    $pmName = array();
    while ($data_pm = fetch_array($res_pm)){
        array_push($pmName, $data_pm['pmoduleName']);
    }
    echo json_encode($pmName);
?>
