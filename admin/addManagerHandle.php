<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //echo $_POST['userName'].$_POST['password'].$_POST['repassword'].$_POST['power'];
    //添加管理员之前判断是否已存在此管理员
    $sql = "select * from manager where managerName='{$_POST['userName']}'";
    if (nums($link, $sql) == 1){
        echo 'hasMan';
        exit;
    }else{
        //开始提交管理员
        $psw = md5($_POST['password']);
        $sql_add = "insert into manager(managerName, managerPsw, power) values('{$_POST['userName']}', '{$psw}', {$_POST['power']})";
        execute($link, $sql_add);
        if (mysqli_affected_rows($link)) {
            echo "success";
        }else {
            echo "fail";
        }
    }
?>