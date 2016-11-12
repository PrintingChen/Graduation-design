<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //将提交的密码加密
    $managerPsw = md5($_POST['psw']);
    //查询提交过来的数据是否存在
    /*
     * 0 表示验证码错误
     * 1 表示没有错误，验证全部通过
     * 2 表示登录名或者密码错误
    */

    if ($_POST['yzm'] == $_SESSION['code']){
        $sql_man = "select * from manager where managerName='{$_POST['userName']}' and managerPsw='{$managerPsw}'";
        $res_man = execute($link, $sql_man);
        if (mysqli_num_rows($res_man) == 1){
            $_SESSION['manage']['name'] = $_POST['userName'];
            $_SESSION['manage']['psw'] = $managerPsw;
            echo 1;
        }else{
            echo 2;
        }
    }else{
        echo 0;
    }


?>