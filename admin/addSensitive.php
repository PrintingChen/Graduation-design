<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //管理员id
    $mid = manage_login_state($link);
    //查询提交的敏感词是否已存在
    $sql_w = "select * from sensitivewords where words='{$_POST['words']}'";
    if (nums($link, $sql_w) == 1) {
        echo "hasW";
        exit;
    }
    //添加敏感词
    $sql_ins = "insert into sensitivewords(words, tomid) values('{$_POST["words"]}', {$mid})";
    execute($link, $sql_ins);
    if (mysqli_affected_rows($link)) {
        echo "success";
        exit;
    }else {
        echo "fail";
        exit;
    }
?>