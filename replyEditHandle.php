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
    //验证验证码
    if ($_POST['yzm'] != $_SESSION['code']){
        echo "yzmnoequal";
        exit;
    }
    //更新回复内容
    $rcontent = escape($link, $_POST['rcontent']);
    $time = date("Y-m-d H:i:s", time());
    $sql_upd = "update reply set rcontent='{$rcontent}',rtime='{$time}' where rid={$_POST['rid']}";
    execute($link, $sql_upd);
    if (mysqli_affected_rows($link)){
        echo "success";
        exit;
    }else {
        echo "fail";
        exit;
    }
?>