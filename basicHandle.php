<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once 'inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //判断当前是否为登录状态
    $member_id = login_state($link);
    //更新基本资料数据
    $birthday = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
    $homeplace = $_POST['birprov']."、".$_POST['bircity']."、".$_POST['birdistrict'];
    $sql_ins = "update user set reallyName='{$_POST['reallyName']}',sex='{$_POST['sex']}',birthday='{$birthday}',homeplace='{$homeplace}',bloodType='{$_POST['bloodtype']}' where id='{$member_id}'";
    execute($link, $sql_ins);
    if (mysqli_affected_rows($link)) {
        echo "success";
        exit;
    }else {
        echo "fail";
        exit;
    }


?>