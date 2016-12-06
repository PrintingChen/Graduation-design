<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>修改敏感词</title>
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="js/sensitiveWordModify.js"></script>
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
        promptBox('您还未登录', 5, 'login.php');
        exit();
    }
    //将需要修改的敏感词的swid存放起来
    $swid = $_GET['swid'];
    //验证需要修改的敏感词的对应的swid是否合法
    if (!isset($swid) || !is_numeric($swid)) { //判断id是否存在或为数字或数字字符串
        promptBox('传参错误', 5, 'sensitiveWord.php');
        exit();
    }
    //查询出传入swid对应修改的敏感词的信息
    $sql_sw = "select * from sensitivewords where swid={$swid}";
    //查询所传入的swid是否存在此条记录
    if (!nums($link, $sql_sw)) {
        promptBox('这个敏感词不存在', 5, 'sensitiveWord.php');
        exit();
    }
    //查询当条敏感词的信息
    $data_sw = fetch_array(execute($link, $sql_sw));
    //操作者信息
    $sql_m = "select * from manager where mid={$data_sw['tomid']}";
    $data_m = fetch_array(execute($link, $sql_m));
?>
<body>
<!--引入头部-->
<?php include_once 'inc/header.inc.php';?>
<!--引入侧边栏-->
<?php include_once 'inc/leftnav.inc.php';?>
<!--引入位置信息-->
<?php include_once 'inc/position.inc.php';?>
<!--主体部分-->
<div class="admin">
    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="fa fa-key"></span> 修改敏感词 - <?php echo $data_sw['words']?></strong><a
                href="sensitiveWord.php" style="float: right;"><i class="fa fa-mail-reply"></i></a></div>
        <div class="body-content">
            <!-- action="pModuleModify.php?pid=<?php //echo $_GET['pid']?>" method="post"-->
            <form id="form-mdfsmodule">
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">敏感词：</label></div>
                    <div class="field">
                        <input type="text" name="swname" class="form-control w50" placeholder="请输父敏感词"
                               value="<?php echo $data_sw['words'];?>"
                               data-notempty="true"
                               data-notempty-message="敏感词不能为空"
                        />
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">操作者：</label></div>
                    <div class="field">
                        <input type="text" disabled value="<?php echo $data_m['managerName'];?>" class="form-control w50">
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for=""></label></div>
                    <div class="field">
                        <button type="button" swid="<?php echo $swid;?>" class="btn btn-info btn-custom" id="mdfswBtn"><i class="fa fa-check-square-o custom"></i>提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--../主体部分-->
</body>
</html>