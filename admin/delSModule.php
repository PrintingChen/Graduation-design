
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>删除子版块</title>
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
    if (!($mid = manage_login_state($link))) {
        promptBox('您还未登录！', 5, 'login.php');
        exit();
    }
    //将需要修改的子版块的id存放起来
    $sid = $_GET['sid'];
    //验证需要修改的子版块的对应的sid是否合法
    if (!isset($sid) || !is_numeric($sid)) { //判断id是否存在或为数字或数字字符串
        promptBox('传参错误', 5, 'sModuleList.php');
        exit();
    }
    //查询所传入的sid是否存在此条记录
    $sql_sm = "select * from sub_module where sid={$sid}";
    if (!nums($link, $sql_sm)) {
        promptBox('此条子版块信息不存在', 5, 'sModuleList.php');
        exit();
    }
    //开始实现删除操作
    $sql = "delete from sub_module where sid={$sid}";
    execute($link, $sql);
    if (mysqli_affected_rows($link)) {
        promptBox('删除成功', 6, 'sModuleList.php');
        exit();
    }else {
        promptBox('删除失败', 5, 'sModuleList.php');
        exit();
    }
?>
<body>

</body>
</html>
