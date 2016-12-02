<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    $pid = $_GET['pid'];
    $sql = "select * from parent_module where pid={$pid}";
    $data_pmn = fetch_array(execute($link, $sql));
    //判断修改的父版块名称是否已经存在
    $sql_pmn = "select * from parent_module where pmoduleName='{$_POST['pmName']}' and pid!={$pid}";
    if (nums($link, $sql_pmn)) {
        echo "pmexist";
        exit;
    }
    //修改版主
    if (!empty($_POST["moderName"])){
        //将作为版主的用户的类型设置为1(表示是版主的标识)
        $sql_upd = "update user set userType=1 where id={$_POST["moderName"]}";
        execute($link, $sql_upd);
    }else{
        $sql_u = "update user set userType=0 where id={$data_pmn['moderatorId']}";
        execute($link, $sql_u);
    }
    //验证描述内容
    $pmoduleDesc = escape($link, $_POST['pmoduleDesc']);
    if ($_POST['moderName'] == "暂无版主"){
        $sql_upd = "update parent_module set pmoduleName='{$_POST['pmName']}', pmoduleDesc='{$pmoduleDesc}' where pid={$pid}";
    }else{
        $sql_upd = "update parent_module set pmoduleName='{$_POST['pmName']}', moderatorId={$_POST['moderName']}, pmoduleDesc='{$pmoduleDesc}' where pid={$pid}";
    }
    execute($link, $sql_upd);
    if (mysqli_affected_rows($link)) {
        echo "success";
        exit;
    }else {
        echo "fail";
    }
?>