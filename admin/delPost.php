<?php
    //开启session
    //session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    $sql_del = "delete from post where postId={$_POST['postId']}";
    execute($link, $sql_del);
    if (mysqli_affected_rows($link)){
        //当删除当前条帖子成功之后，再将属于这条的帖子的回复信息也全部删除
        $sql_del_rep = "delete from reply where tpostId={$_POST['postId']}";
        execute($link, $sql_del_rep);
        echo "success";
        exit;
    }else{
        echo "fail";
        exit;
    }
?>