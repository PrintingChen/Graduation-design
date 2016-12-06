<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>编辑帖子</title>
    <link rel="stylesheet" href="font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/publish.css">
    <script src="js/jquery-1.12.2.min.js"></script>
    <script src="kindeditor/kindeditor-all-min.js"></script>
    <script src="kindeditor/lang/zh-CN.js"></script>
    <script src="css/bootstrap/js/bootstrap.min.js"></script>
    <script src="layui/layui.js"></script>
    <script src="js/common.js"></script>
</head>
<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once 'inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //查询公告内容
    $sql_n = "select * from notice where nid=1";
    $data_n = fetch_array(execute($link, $sql_n));
    $nc = $data_n["noticeContent"];
    //判断当前是否为登录状态
    $member_id = login_state($link);
    //引入处理登录信息
    include_once "inc/handlerLogin.php";
    //根据传过来的回复信息rid是否合法
    if (!isset($_GET['rid']) || !is_numeric($_GET['rid'])){
        promptBox('rid传参错误', 5, 'index.php');
        exit;
    };
    //查询是否存在此条回复信息
    $sql_reply = "select * from reply where rid={$_GET['rid']}";
    $data_reply = fetch_array(execute($link, $sql_reply));
    if (nums($link, $sql_reply) == 0) {
        promptBox('这条回复信息不存在', 5, 'index.php');
        exit;
    }
    //查询是否存在此条回复信息对应的帖子
    $sql_post = "select * from post where postId={$data_reply['tpostId']}";
    $data_post = fetch_array(execute($link, $sql_post));
    //查询编辑的回复信息对应的子版块，父版块，等信息
    $sq_msg = "select * from sub_module sm,parent_module pm where sm.sid={$data_post['tsmoduleId']} and pm.pid=sm.tParenModuleId";
    $data_msg = fetch_array(execute($link, $sq_msg));
?>
<body>
<!--引入头部-->
<?php include_once "inc/header.inc.php"?>
<!--引入导航-->
<?php include_once "inc/nav.inc.php"?>
<div class="container" style="width: 990px;">
    <div class="position">
        <div class="z">
            <a href="index.php" class="nvhm"><i class="fa fa-home"></i></a>
            <em><i class='fa fa-angle-right'></i></em>
            <a href='pModuleList.php?pid=<?php echo $data_msg['pid'];?>'><?php echo $data_msg['pmoduleName'];?></a>
            <em><i class='fa fa-angle-right'></i></em>
            <a href='sModuleList.php?sid=<?php echo $data_msg['sid'];?>'><?php echo $data_msg['smoduleName'];?></a>
            <em><i class='fa fa-angle-right'></i></em>
            <a href='postShow.php?postId=<?php echo $_GET['postId'];?>&sid=<?php echo $data_msg['sid'];?>'><?php echo $data_post['postTitle'];?></a>
            <em><i class='fa fa-angle-right'></i></em>
            编辑回复
        </div>
    </div>
    <form action="" id="publish-form">
        <div class="form-main">
            <ul class="nav nav-tabs" id="">
                <li class="active"><a href="#publish-cont" data-toggle="tab">编辑回复</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="publish-cont">
                    <div class="rows original">
                        <strong>原帖标题：</strong><?php echo $data_post['postTitle'];?>
                    </div>
                    <div class="rows post-content">
                        <textarea name="content" id="content">
                            <?php echo $data_reply['rcontent'];?>
                        </textarea>
                    </div>
                </div>
            </div>
            <div class="code">
                <input type="text" name="yzm" placeholder="输入验证码" id="yzm" class="form-control w25" style="display: inline-block;">
                <img style="cursor: pointer;" src="inc/vcode.php" class="yzmpic" title="点击刷新验证码">
            </div>
            <div class="posting">
                <button type="button" rid="<?php echo $_GET['rid'];?>" postId="<?php echo $data_post['postId'];?>" sid="<?php echo $data_msg['sid'];?>" class="btn btn-primary" id="replyEditBtn"><i class="fa fa-edit"></i>编辑保存</button>
            </div>
        </div>
    </form>
</div>
<!--引入底部-->
<?php include_once "inc/footer.inc.php"?>
</body>
</html>
<script>
    //富文本编辑器
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="content"]', {
            allowFileManager : true,
            width : '960',
            height : '400',
            afterBlur: function () {
                this.sync();
            }
        });
    });
    //刷新验证码
    $(".yzmpic").on("click",function(){
        $(this).attr("src","inc/vcode.php?key="+Math.random()*Math.pow(10,17)+"");
    });
    //发表帖子
    layui.use("layer", function () {
        var layer = layui.layer;
        $("#replyEditBtn").click(function () {
            //判断帖子内容长度
            if($("#content").val().length < 1){
                layer.msg("回复内容不能为空",{icon: 5, time: 1000}, function () {
                    $("#content").focus();
                });
                return false;
            }
            //判断验证码长度
            if($("#yzm").val().length != 4){
                layer.msg("验证码长度必须为4位",{icon: 5, time: 1000}, function () {
                    $("#yzm").focus();
                });
                return false;
            }
            $.ajax({
                type: "post",
                url: "replyEditHandle.php",
                data: {
                    "rid": $("#replyEditBtn").attr("rid"),
                    "rcontent": $("#content").val(),
                    "yzm": $("#yzm").val()
                },
                success: function (response) {
                    $postId = $("#replyEditBtn").attr("postId");
                    $sid = $("#replyEditBtn").attr("sid");
                    if(response == "yzmnoequal"){
                        layer.msg("验证码错误", {icon: 5, time: 1000}, function () {
                            $("#yzm").focus();
                        });
                    }else if(response == "success"){
                        layer.msg("编辑成功", {icon: 1, time: 1000});
                        setTimeout(function () {
                            window.location.href = "postShow.php?postId="+$postId+"&sid="+$sid+"";
                        }, 1500);
                    }else if (response == "fail"){
                        layer.msg("编辑失败", {icon: 5, time: 1000});
                    }
                }
            });
        });
    });
</script>