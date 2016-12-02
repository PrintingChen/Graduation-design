<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>修改回复</title>
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../kindeditor/kindeditor-all-min.js"></script>
    <script src="../kindeditor/lang/zh-CN.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="js/replyModify.js"></script>
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
        exit;
    }
    //验证需要修改的回复的对应的rid是否合法
    if (!isset($_GET['rid']) || !is_numeric($_GET['rid'])) { //判断rid是否存在或为数字或数字字符串
        promptBox('回复信息传参错误', 5, 'replyList.php');
        exit;
    }
    //验证回复信息是否存在
    $sql_rep = "select * from reply where rid={$_GET['rid']}";
    $data_rep = fetch_array(execute($link, $sql_rep));
    if (nums($link, $sql_rep) !=1){
        promptBox('回复信息不存在', 5, 'replyList.php');
        exit;
    }
    //需要修改的回复相关信息
    $sql_msg = "select * from post p,user u where  p.postId={$data_rep['tpostId']} and u.id={$data_rep['ruid']}";
    $data_msg = fetch_array(execute($link, $sql_msg));
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
        <div class="panel-head"><strong><span class="fa fa-key"></span> 修改回复</strong></div>
        <div class="body-content">
            <form id="form-mdfsmodule">
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">回复主题：</label></div>
                    <div class="field">
                        <input type="text" class="form-control w45" value="<?php echo $data_msg['postTitle'];?>" disabled/>
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">回复作者：</label></div>
                    <div class="field">
                        <input type="text" class="form-control w50" value="<?php echo $data_msg['name'];?>" disabled>
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">回复内容：</label></div>
                    <div class="field">
                        <textarea name="rcontent" id="rcontent" class="form-control">
                            <?php echo $data_rep['rcontent'];?>
                        </textarea>
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for=""></label></div>
                    <div class="field">
                        <button type="button" name="btn-mdfsm" rid="<?php echo $data_rep['rid'];?>" class="btn btn-info btn-custom" id="btn-mdfsm"><i class="fa fa-check-square-o custom"></i>提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--../主体部分-->
</body>
</html>
<script>
</script>