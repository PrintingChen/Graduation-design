<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //判断各项数据是否为空
    if (!empty($_POST['userName']) && !empty($_POST['password']) && !empty($_POST['repassword']) && !empty($_POST['email'])){
        //添加用户之前判断是否已存在需要添加的用户
        $sql_userName = "select * from user where name='{$_POST['userName']}'";
        if (nums($link, $sql_userName) != 0){
            echo 'useryes';
            exit;
        }
        //开始提交用户
        $psw = md5($_POST['password']);
        $sql_add = "insert into user(name, psw, email) values('{$_POST['userName']}', '{$psw}', '{$_POST['email']}')";
        execute($link, $sql_add);
        if (mysqli_affected_rows($link)) {
            echo "ok";
        }else {
            echo "no";
        }
    }else{
        echo "empty";
    }
?>