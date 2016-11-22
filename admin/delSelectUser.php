<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //获取需要删除的用户的id
    $arr = $_POST['del'];
    $del_user = array();
    $del_post = array();
    $del_reply = array();
    foreach ($arr as $key=>$value){
        array_push($del_user, "delete from user where id={$value}");
        array_push($del_post, "delete from post where postuid={$value}");
        array_push($del_reply, "delete from reply where ruid={$value}");
    }
    execute_multi($link, $del_user, $error);
    if ($error == null) {
        //删除成功后，将用户对应的帖子，回复信息也删除掉
        execute_multi($link, $del_post, $error);
        execute_multi($link, $del_reply, $error);
        echo "success";
        exit;
    } else {
        echo "fail";
        exit;
    }

?>