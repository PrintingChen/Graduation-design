<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>发布帖子</title>
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
    //判断当前是否为登录状态
    if(!($member_id = login_state($link))){
        promptBox("您还未登录，无法发布帖子", 5, "login.php");
        exit;
    }
    //引入处理登录信息
    include_once "inc/handlerLogin.php";
    //根据传过来的子版块id查询出对应的信息
    if (isset($_GET['sid'])){
        $sql_msg = "select * from sub_module sm,parent_module pm where sid={$_GET['sid']} and pm.pid=sm.tParenModuleId";
        $data_msg = fetch_array(execute($link, $sql_msg));
    }
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
            <?php
            //如果子版块的id传参的话
            if (isset($_GET['sid'])){
                echo "<em><i class='fa fa-angle-right'></i></em>
                        <a href='pModuleList.php?pid={$data_msg['pid']}'>{$data_msg['pmoduleName']}</a>
                        <em><i class='fa fa-angle-right'></i></em>
                        <a href='sModuleList.php?sid={$data_msg['sid']}'>{$data_msg['smoduleName']}</a><em><i class='fa fa-angle-right'></i></em>
                        发表帖子";
            }else{
                echo "<em><i class='fa fa-angle-right'></i></em>发表帖子";
            }
            ?>
        </div>
    </div>
    <form action="" id="publish-form">
        <div class="form-main">
            <ul class="nav nav-tabs" id="">
                <li class="active"><a href="#publish-cont" data-toggle="tab">发表帖子</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="publish-cont">
                    <div class="rows" style="margin-top: 10px;">
                        <select name="selSModule" id="selSModule" class="form-control w25">
                            <option value="">请选择一个子版块</option>
                            <?php
                            //输出版块的名称
                            $where = "";
                            //如果父版块的pid传参的话
                            if (isset($_GET['pid']) && is_numeric($_GET['pid'])) {
                                $where = " where pid={$_GET['pid']}";
                            }
                            $sql_pm = "select * from parent_module{$where}";
                            $res_pm = execute($link, $sql_pm);
                            while (@$data_pm = fetch_array($res_pm)) {
                                echo "<optgroup label='{$data_pm['pmoduleName']}'>";
                                $sql_sm = "select * from sub_module where tParenModuleId={$data_pm['pid']}";
                                $res_sm = execute($link, $sql_sm);
                                while (@$data_sm = fetch_array($res_sm)){
                                    if (isset($_GET['sid']) && $_GET['sid'] == $data_sm['sid'] ) {
                                        echo "<option selected value='{$data_sm['sid']}'>{$data_sm['smoduleName']}</option>";
                                    }else{
                                        echo "<option value='{$data_sm['sid']}'>{$data_sm['smoduleName']}</option>";
                                    }
                                }
                                echo "</optgroup>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="rows">
                        <input type="text" name="post-title" id="post-title" class="form-control w35" placeholder="请输入帖子标题" style="display: inline-block;">
                        <span>还可输入 <strong class="len">40</strong> 个字符</span>
                    </div>
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
                <button type="button" name="publishBtn" class="btn btn-primary" id="publish"><i class="fa fa-edit"></i>发表帖子</button>
            </div>
        </div>
    </form>
</div>
<!--引入底部-->
<?php include_once "inc/footer.inc.php"?>
</body>
</html>
<script>
    //提示帖子标题字数长度
    $("#post-title").on("keyup", function () {
        $val = 40-$(this).val().length;
        if ($val<0) $val = 0;
        $(".len").html($val);
    });
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
        $("#publish").click(function () {
            //必须选则一个子版块
            if($("#selSModule").val().length == 0){
                layer.msg("必须选择一个子版块",{icon: 5, time: 1000}, function () {
                    $("#selSModule").focus();
                });
                return false;
            }
            //判断标题长度
            $title_len = $("#post-title").val().length;
            if($title_len < 1 || $title_len > 40){
                layer.msg("标题长度不合法",{icon: 5, time: 1000}, function () {
                    $("#post-title").focus();
                });
                return false;
            }
            //判断帖子内容长度
            if($("#content").val().length < 1){
                layer.msg("帖子内容不能为空",{icon: 5, time: 1000}, function () {
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
                url: "publishHandle.php",
                data: $("#publish-form").serialize(),
                success: function (response) {
                    $postId = response.substring(7);//帖子的id
                    if(response == "yzmnoequal"){
                        layer.msg("验证码错误", {icon: 5, time: 1000});
                    }else if(response == "fail"){
                        layer.msg("发布失败", {icon: 5, time: 1000});
                        setTimeout(function () {
                            window.location.href = "publish.php";
                        }, 1500);
                    }else{
                        layer.msg("发布帖子成功", {icon: 1, time: 1000});
                        setTimeout(function () {
                            window.location.href = "postShow.php?postId="+$postId+"";
                        }, 1500);
                    }
                }
            });
            return true;
        });
    });
</script>