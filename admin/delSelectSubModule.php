<?php
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //获取需要删除的记录的id
    $arr = $_POST['del'];
    $sql_arr = array();
    foreach ($arr as $key=>$value){
        array_push($sql_arr, "delete from sub_module where sid={$value}");
    }
    execute_multi($link, $sql_arr, $error);
    if ($error == null) {
        //删除成功
        echo 1;
    } else {
        echo 2;
    }

?>