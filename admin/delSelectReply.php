<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //获取需要删除的回复的rid
    $arr = $_POST['delSelect'];
    if (!empty($arr)){ //当选中有要删除的记录时
        echo "notempty";
        $del_reply = array();
        foreach ($arr as $key=>$value){
            array_push($del_reply, "delete from reply where rid={$value}");
        }
        execute_multi($link, $del_reply, $error); //将帖子删除
        if ($error == null) {
            echo "success";
            exit;
        } else {
            echo "fail";
            exit;
        }
    }else{
        echo "empty";
        exit;
    }

?>