<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //将需要删除的管理员的mid存放起来
    $mid = $_POST['mid'];
    //开始实现删除操作
    $sql = "delete from manager where mid={$mid}";
    execute($link, $sql);
    if (mysqli_affected_rows($link)) {
        //将与该管理员的相关帖子、回复等信息同时删除
        $del_post = "delete from post where postuid={$mid}";
        execute($link, $del_post);
        $del_rep = "delete from reply where ruid={$mid}";
        execute($link, $del_rep);
        echo "success";
        exit;
    }else {
        echo "fail";
        exit;
    }
?>
