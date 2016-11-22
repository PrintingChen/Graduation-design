<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once 'inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //验证验证码
    if ($_POST['yzm'] != $_SESSION['code']){
        echo "yzmnoequal";
        exit;
    }
    $psw = md5($_POST['psw']);
    //echo .$psw.$_POST['yzm'];
    //查询是否存在用户信息
    $sql = "select * from user where name='{$_POST['userName']}' and psw='{$psw}'";
    $nums = nums($link, $sql);
    if ($nums == 1){
        //设置cookie
        setcookie('bs[userName]', $_POST['userName']);
        setcookie('bs[psw]', $psw);
        //更新登录的时间
        $time = Date('Y-m-d H:i:s', time());
        $sql_upd = "update user set lastLogin='{$time}' where name='{$_POST['userName']}'";
        execute($link, $sql_upd);
        echo "success";
        exit;
    }else{
        echo "fail";
        exit;
    }

?>