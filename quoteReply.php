<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>引用回复</title>
    <link rel="stylesheet" href="font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/publish.css">
    <link rel="stylesheet" href="css/reply.css">
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
    //判断当前是否为登录状态
    if(!($member_id = login_state($link))){
        promptBox("您还未登录，无法发布帖子", 5, "index.php");
        exit;
    }
    //引入处理登录信息
    include_once "inc/handlerLogin.php";
    //判断回复对应帖子的postId是否合法
    if (!isset($_GET['postId']) || !is_numeric($_GET['postId'])) {
        promptBox("回复帖子postId不合法", 5, "index.php");
        exit;
    }
    //判断引用回复帖子的quoteId是否合法
    if (!isset($_GET['quoteId']) || !is_numeric($_GET['quoteId'])){
        promptBox("引用回复quotId不合法", 5, "index.php");
        exit;
    }
    //查询引用回复对应帖子的信息
    $sql_re_post = "select * from post,user where postId={$_GET['postId']} and user.id=postuid";
    $data_re_post = fetch_array(execute($link, $sql_re_post));

    //查询是否存在此条引用回复的信息
    $sql_post = "select * from user u,reply rep where rid={$_GET['quoteId']} and ruid=u.id";
    $res_post = execute($link, $sql_post);
    $data_post = fetch_array($res_post);
    if (mysqli_num_rows($res_post) != 1) {
        promptBox("回复的帖子不存在", 5, "index.php");
        exit;
    }
    //使用计算在这一条回复之前（包括这一条在内）的所有的记录数来算出楼层数
    $sql = "select * from reply where tpostId={$_GET['postId']} and rid<={$_GET['quoteId']}";
    $floor = nums($link, $sql);
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
            <em><i class='fa fa-angle-right'></i>
                引用回复
        </div>
    </div>
    <form action="" id="reply-form">
        <div class="form-main">
            <ul class="nav nav-tabs" id="">
                <li class="active"><a href="#publish-cont" data-toggle="tab" style="font-style: normal;">回复帖子</a></li>
            </ul>
            <div class="pc">
                <div class="original-post">
                    <strong>楼主原帖：<?php echo $data_re_post['name'];?> 发表于 <?php echo tranTime(strtotime($data_re_post['postTime']));?></strong><br>
                    <div class="c"><?php echo $data_re_post['postContent'];?></div>
                </div>
                <p style="font-weight: 700;">引用回复 <?php echo $floor;?> 楼 <span> <?php echo $data_post['name'];?></span> 发表于 <?php echo tranTime(strtotime($data_post['rtime']));?></p>
                <div class="pc-title"><?php echo nl2br($data_post['rcontent']);?></div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="publish-cont">
                    <div class="rows post-content">
                        <textarea name="content" id="content"></textarea>
                    </div>
                </div>
            </div>
            <div class="code">
                <input type="text" name="yzm" placeholder="输入验证码" id="yzm" class="form-control w25" style="display: inline-block;">
                <img style="cursor: pointer;" src="inc/vcode.php" class="yzmpic" title="点击刷新验证码">
            </div>
            <div class="posting">
                <button type="button" postId="<?php echo $_GET['postId'];?>" quoteId="<?php echo $_GET['quoteId'];?>" class="btn btn-primary" id="reply"><i class="fa fa-edit"></i>发表回复</button>
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
    //回复帖子
    layui.use("layer", function () {
        var layer = layui.layer;
        $("#reply").click(function () {
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
            //引用回复处理
            $.ajax({
                type: "post",
                url: "quoteReplyHandle.php",
                data: {
                    "content": $("#content").val(),
                    "yzm": $("#yzm").val(),
                    "postId": $("#reply").attr("postId"),
                    "quoteId": $("#reply").attr("quoteId")
                },
                success: function (response) {
                    $postId = response.substring(7);//帖子的id
                    if(response == "yzmnoequal"){
                        layer.msg("验证码错误", {icon: 5, time: 1000});
                    }else if(response == "fail"){
                        layer.msg("回复失败", {icon: 5, time: 1000});
                        setTimeout(function () {
                            window.location.href = "postShow.php?postId="+$postId+"";
                        }, 1500);
                    }else{
                        layer.msg("回复成功", {icon: 6, time: 1000});
                        setTimeout(function () {
                            window.location.href = "postShow.php?postId="+$postId+"";
                        }, 1500);
                    }
                }
            });
        });
    });
</script>