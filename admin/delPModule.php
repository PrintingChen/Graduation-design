<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //将需要删除的子版块的id存放起来
    $pid = $_GET['pid'];
    //删除之前判断此父版块之下是否有子版块，如果有则要先将子版块删除之后，方可删除此父版块
    $sql_sel = "select * from sub_module where tParenModuleId={$pid}";
    if (nums($link, $sql_sel)) {
        echo "hasSM";
        exit;
    }else{
        //开始实现删除操作
        $sql = "delete from parent_module where pid={$pid}";
        execute($link, $sql);
        if (mysqli_affected_rows($link)) {
            echo "success";
            exit;
        }else {
            echo "fail";
            exit;
        }
    }
?>
