<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台主页</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="js/admin-common.js"></script>
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
    //父板块总数
    $query="select * from parent_module";
    $count_pm=nums($link,$query);
    //子板块总数
    $query="select * from sub_module";
    $count_sm=nums($link,$query);
    //帖子总数
    $query="select * from post";
    $count_p=nums($link,$query);
    //回帖总数
    $query="select * from reply";
    $count_rep=nums($link,$query);
    //用户总数
    $query="select * from user";
    $count_u=nums($link,$query);
    //管理员总数
    $query="select * from manager";
    $count_man=nums($link,$query);
?>
<body>
    <?php include_once 'inc/header.inc.php'; ?>
    <!--引入侧边栏-->
    <?php include_once 'inc/leftnav.inc.php';?>
    <!--引入位置信息-->
    <?php include_once 'inc/position.inc.php';?>
    <!--主体部分-->
    <div class="admin">
        <div class="main">
            <h2>系统配置信息</h2>
            <table class="table table-bordered">
                <tr>
                    <td><i class="fa fa-check-square-o s"></i>系统名称：基于PHP的BBS论坛系统</td>
                    <td><i class="fa fa-check-square-o s"></i>服务器操作系统：<?php echo PHP_OS?></td>
                    <td style="width: 37%;"><i class="fa fa-check-square-o s"></i>服务器软件：<?php echo $_SERVER['SERVER_SOFTWARE']?></td>
                </tr>
                <tr>
                    <td><i class="fa fa-check-square-o s"></i>MySQL 版本：<?php echo  mysqli_get_server_info($link)?></td>
                    <td><i class="fa fa-check-square-o s"></i>PHP 版本：<?php echo phpversion()?></td>
                    <td><i class="fa fa-check-square-o s"></i>最大上传文件：<?php echo ini_get('upload_max_filesize')?></td>
                </tr>
                <tr>
                    <td><i class="fa fa-check-square-o s"></i>内存限制：<?php echo ini_get('memory_limit')?></td>
                    <td><i class="fa fa-check-square-o s"></i><a target="_blank" href="phpinfo.php">PHP 配置信息</a></td>
                    <td><i class="fa fa-check-square-o s"></i>程序安装位置：<?php echo SA_PATH?></td>
                </tr>
            </table>
            <h2>系统基本信息</h2>
            <table class="table table-bordered">
                <tr>
                    <td><i class="fa fa-check-square-o s"></i>父板块总数：<?php echo $count_pm;?></td>
                    <td><i class="fa fa-check-square-o s"></i>子板块总数：<?php echo $count_sm;?></td>
                    <td style="width: 37%;"><i class="fa fa-check-square-o s"></i>帖子总数：<?php echo $count_p;?></td>
                </tr>
                <tr>
                    <td><i class="fa fa-check-square-o s"></i>回帖总数：<?php echo $count_rep;?></td>
                    <td><i class="fa fa-check-square-o s"></i>用户总数：<?php echo $count_u;?></td>
                    <td><i class="fa fa-check-square-o s"></i>管理员总数：<?php echo $count_man;?></td>
                </tr>
            </table>
        </div>
        <div class="dinfo">
            <p>系统开发者：陈印棠&nbsp;&nbsp;&nbsp;指导老师：云善明</p>
        </div>
    </div>
    <!--主体部分-->
</body>
</html>