<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户详情图表</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="js/echarts.common.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="js/userChart.js"></script>
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
        exit;
    }
    //用户id
    $uid = $_GET["uid"];
    //验证需要修改的用户的对应的uid是否合法
    if (!isset($uid) || !is_numeric($uid)) { //判断uid是否存在或为数字或数字字符串
        promptBox('传参错误', 5, 'userList.php');
        exit();
    }
    //查询出传入uid对应修改的用户的信息
    $sql_user = "select * from user where id={$uid}";
    //查询所传入的uid是否存在此条记录
    if (!nums($link, $sql_user)) {
        promptBox('此用户信息不存在', 5, 'userList.php');
        exit();
    }
    //查询出用户信息
    $data_user = fetch_array(execute($link, $sql_user));

?>
<body>
<?php include_once 'inc/header.inc.php'; ?>
<!--引入侧边栏-->
<?php include_once 'inc/leftnav.inc.php';?>
<!--引入位置信息-->
<?php include_once 'inc/position.inc.php';?>
<!--主体部分-->
<div class="admin">
    <a href="userList.php" style="float: right;" title="返回上一层"><i class="fa fa-mail-reply"></i></a>
    <div id="chart" uid="<?php echo $uid;?>" style="width: 600px;height:400px;margin: 50px auto;"></div>
</div>
<!--主体部分-->
</body>
</html>