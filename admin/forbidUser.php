<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>禁止用户</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/userEdit.css">
    <link rel="stylesheet" href="css/userJurisdiction.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="../layui/laydate/laydate.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="js/forbidUser.js"></script>
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
    //将需要禁止的用户的uid存放起来
    $uid = $_GET['uid'];
    //验证需要禁止的用户的对应的uid是否合法
    if (!isset($_GET['uid']) || !is_numeric($_GET['uid'])) { //判断uid是否存在或为数字或数字字符串
        promptBox('传参错误', 5, 'userList.php');
        exit();
    }
    //查询出传入uid对应修改的用户的信息
    $sql_user = "select * from user where id={$_GET['uid']}";
    //查询所传入的uid是否存在此条记录
    if (!nums($link, $sql_user)) {
        promptBox('此用户信息不存在', 5, 'userList.php');
        exit();
    }
    //查询出用户信息
    $data_user = fetch_array(execute($link, $sql_user));
    //用户的状态
    $forbidStatusText = "";
    $forbidStatus = $data_user['isForbid'];
    if ($forbidStatus == 0){
        $forbidStatusText = "正常状态";
    }else if ($forbidStatus == 1){
        $forbidStatusText = "禁止发言";
    }else if ($forbidStatus == 2){
        $forbidStatusText = "禁止访问";
    }

    //当前用户的权限信息
    /*$look = $data_user['lookStatus'];
    $report = $data_user['reportStatus'];
    $reply = $data_user['replyStatus'];
    $length = mb_strlen($look)-1;
    $sid = substr($look,0,$length);
    $lookStatus = substr($look, $length, 1);
    $reportStatus = substr($report, $length, 1);
    $replyStatus = substr($reply, $length, 1);
    $sql_sm = "select * from sub_module where sid={$sid}";
    $data_sm = fetch_array(execute($link, $sql_sm));*/
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
    <form id="forbid-form">
        <div class="panel admin-panel">
            <div class="panel-head"><strong><span class="fa fa-edit"></span> 禁止用户</strong><a href="userList.php" style="float: right;" title="返回上一层"><i class="fa fa-mail-reply"></i></a></div>
            <div class="body-content" style="padding-bottom: 0;">
                <div class="panel-head" style="border-bottom: 0;border-top: 1px solid #ccc;color: #09C;"><strong>编辑用户的特殊权限</strong></div>
                <table class="table" style="margin-bottom: 0;">
                    <tr>
                        <td class="w20">禁止用户名：</td>
                        <td>
                            <input type="text" value="<?php echo $data_user['name'];?>" disabled name="user" id="user" class="form-control w50">
                        </td>
                    </tr>
                    <tr>
                        <td class="w20">当前状态:</td>
                        <td>
                            <?php echo $forbidStatusText;?>
                        </td>
                    </tr>
                    <tr>
                        <td class="w20"><strong>禁止类型:</strong></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="w20"></td>
                        <td>
                            <input type="radio" name="status" id="default-status" value="0" <?php if($forbidStatus==0){echo "checked";}?>><label
                                for="default-status">正常状态</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="w20"></td>
                        <td>
                            <input type="radio" name="status" id="forbid-report" value="1" <?php if($forbidStatus==1){echo "checked";}?>><label for="forbid-report">禁止发言</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="w20"></td>
                        <td>
                            <input type="radio" name="status" id="forbid-look" value="2" <?php if($forbidStatus==2){echo "checked";}?>><label for="forbid-look">禁止访问</label>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="button" uid="<?php echo $_GET['uid'];?>" class="btn btn-primary" id="editStatus"><i class="fa fa-check-square-o custom"></i>提交</button>
                        </td>
                    </tr>
                </table>
                <script>
                    layui.use("layer", function () {
                        var layer = layui.layer;
                        $("#editStatus").on("click", function () {
                            $uid = $(this).attr("uid");
                            $.ajax({
                                type: "post",
                                url: "forbidUserHandle.php?uid="+$uid+"",
                                data: $("#forbid-form").serialize(),
                                success: function (response) {
                                    if (response == "success"){
                                        layer.msg("权限设置成功", {icon: 1, time: 1500}, function () {
                                            window.location.href = "forbidUser.php?uid="+$uid+"";
                                        });
                                    }else if (response == "fail"){
                                        layer.msg("权限未改变", {icon: 5, time: 1500});
                                    }
                                }
                            });
                        });
                    });

                </script>
            </div>
        </div>
    </form>
</div>
<!--主体部分-->
</body>
</html>