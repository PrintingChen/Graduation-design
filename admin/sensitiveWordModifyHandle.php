<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //管理员信息
    $mid = manage_login_state($link);
    //修改敏感词的id
    $swid = $_GET['swid'];
    //echo $swid.$_POST["swname"];
    $sql = "select * from sensitivewords where swid={$swid}";
    $data_sw = fetch_array(execute($link, $sql));
    //判断修改的敏感词是否已经存在
    $sql_sw = "select * from sensitivewords where words='{$_POST['swname']}' and swid!={$swid}";
    if (nums($link, $sql_sw)) {
        echo "swexist";
        exit;
    }
    //更新敏感词
    $sql_upd = "update sensitivewords set words='{$_POST['swname']}', tomid={$mid} where swid={$swid}";
    execute($link, $sql_upd);
    if (mysqli_affected_rows($link)) {
        echo "success";
        exit;
    }else {
        echo "fail";
    }
?>