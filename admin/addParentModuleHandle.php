<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //描述内容
    $pmoduleDesc = escape($link, $_POST['pmoduleDesc']);
    //查询提交的父版块是否已存在
    $sql_pm = "select pmoduleName from parent_module where pmoduleName='{$_POST['pmoduleName']}'";
    if (nums($link, $sql_pm) == 1) {
        echo "hasPM";
        exit;
    }
    //如果版块设置了版主
    if (!empty($_POST["addModerator"])){
        //将作为版主的用户的类型设置为1(表示是版主的标识)
        $sql_upd = "update user set userType=1 where id={$_POST["addModerator"]}";
        execute($link, $sql_upd);
    }
    //插入父版块
    $sql_ins = "insert into parent_module(pmoduleName, pmoduleDesc, moderatorId) values('{$_POST['pmoduleName']}', '{$pmoduleDesc}', '{$_POST['addModerator']}')";
    execute($link, $sql_ins);
    if (mysqli_affected_rows($link)) {
        echo "success";exit;
    }else {
        echo "fail";
        exit;
    }
?>