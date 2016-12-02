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
    $mid = manage_login_state($link);
    $name =  $_POST['name'];
    //查询是否存在此用户
    $sql = "select * from user where name='{$name}'";
    $data = fetch_array(execute($link, $sql));
    $uid = $data['id'];
    $nums = nums($link, $sql);
    if ($nums == 1){
        echo "success".$uid;
        exit;
    }else{
        echo "fail";
        exit;
    }


?>