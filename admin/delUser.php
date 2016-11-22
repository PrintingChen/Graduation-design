<?php
    //开启session
    //session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //将需要删除的用户的uid存放起来
    $uid = $_POST['uid'];
    //开始实现删除操作
    $sql = "delete from user where id={$uid}";
    execute($link, $sql);
    if (mysqli_affected_rows($link)) {
        //将与该用户的相关帖子、回复等信息同时删除
        $del_post = "delete from post where postuid={$uid}";
        execute($link, $del_post);
        $del_rep = "delete from reply where ruid={$uid}";
        execute($link, $del_rep);
        echo "success";
        exit;
    }else {
        echo "fail";
        exit;
    }
?>
