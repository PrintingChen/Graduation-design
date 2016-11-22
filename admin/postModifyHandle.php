<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //更新数据
    $content = escape($link, $_POST['postContent']);
    $sql_upd = "update post set postTitle='{$_POST['postTitle']}', tsmoduleId={$_POST['selSModule']}, postContent='{$content}' where postId={$_POST['postId']}";
    execute($link, $sql_upd);
    if (mysqli_affected_rows($link)) {
        echo "success";
        exit;
    }else {
        echo "fail";
        exit;
    }
?>