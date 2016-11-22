<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>删除父版块</title>
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../layui/layui.js"></script>
</head>
<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //管理员是否登录
    if (!manage_login_state($link)) {
        promptBox('您还未登录！', 5, 'login.php');
        exit();
    }
    //将需要修改的子版块的id存放起来
    $pid = $_GET['pid'];
    //验证需要修改的子版块的对应的sid是否合法
    if (!isset($pid) || !is_numeric($pid)) { //判断id是否存在或为数字或数字字符串
        promptBox('传参错误', 5, 'pModuleList.php');
        exit();
    }
    //查询所传入的pid是否存在此条记录
    $sql_pm = "select * from parent_module where pid={$pid}";
    if (!nums($link, $sql_pm)) {
        promptBox('此条父版块信息不存在', 5, 'pModuleList.php');
        exit();
    }
    //删除之前判断此父版块之下是否有子版块，如果有则要先将子版块删除之后，方可删除此父版块
    $sql_sel = "select * from sub_module where tParenModuleId={$pid}";
    if (nums($link, $sql_sel)) {
        promptBox('删除失败，请先将此父版块下面的子版块删除', 5, 'pModuleList.php');
        exit;
    }else{
        //开始实现删除操作
        $sql = "delete from parent_module where pid={$pid}";
        execute($link, $sql);
        if (mysqli_affected_rows($link)) {
            promptBox('删除成功', 6, 'pModuleList.php');
            exit;
        }else {
            promptBox('删除失败', 5, 'pModuleList.php');
            exit;
        }
    }
?>
<body>

</body>
</html>
