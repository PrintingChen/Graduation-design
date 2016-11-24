<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>子版块栏目</title>
    <link rel="stylesheet" href="font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/pModuleList.css">
    <link rel="stylesheet" href="css/sModuleList.css">
    <script src="js/jquery-1.12.2.min.js"></script>
    <script src="layui/layui.js"></script>
    <script src="kindeditor/kindeditor-all-min.js"></script>
    <script src="kindeditor/lang/zh-CN.js"></script>
    <script src="js/common.js"></script>
    <script src="js/sModuleList.js"></script>
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
    $member_id = login_state($link);
    //引入处理登录信息
    include_once "inc/handlerLogin.php";
    //判断子版块sid是否合法
    if (!isset($_GET['sid']) || !is_numeric($_GET['sid'])){
        promptBox("子版块参数不合法", 5, "index.php");
        exit;
    }
    //查询是否存在此子版块信息
    $sql_sel = "select * from sub_Module where sid={$_GET['sid']}";
    $result_sel = execute($link, $sql_sel);
    $data_sm = fetch_array($result_sel);
    if (mysqli_num_rows($result_sel) == 0) {
        promptBox("不存在子版块信息", 5, "index.php");
        exit;
    }
    //传过来子版块的sid对应的父版块信息
    $sql_pm = "select * from parent_module where pid={$data_sm['tParenModuleId']}";
    $res_pm = execute($link, $sql_pm);
    $data_pm = fetch_array($res_pm);
    //查询除传过来的sid对应子版块的帖子总数(未分页)
    $post_total = "select * from post where tsmoduleId={$_GET['sid']}";
    $sm_total = nums($link, $post_total);
    //帖子分页
    $data_page = page($sm_total, 2);
    //查询除传过来的sid对应子版块的帖子总数(分页)
    $post_total = "select * from post where tsmoduleId={$_GET['sid']} order by postId DESC {$data_page['limit']}";
    $res_total = execute($link, $post_total);
    //查询子版块今日发的帖子总数
    $post_total_today = "select * from post where tsmoduleId={$_GET['sid']} and date_format(postTime,'%Y-%m-%d')=curdate()";
    $ptotal_today = nums($link, $post_total_today);
    //查询子版块昨日发的帖子总数
    $post_total_yesterday = "select * from post where tsmoduleId={$_GET['sid']} and date_format(postTime,'%Y-%m-%d')=DATE_SUB(curdate(),INTERVAL 1 DAY)";
    $ptotal_yesterday = nums($link, $post_total_yesterday);
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
            <em><i class="fa fa-angle-right"></i></em>
            <a href="pModuleList.php?pid=<?php echo $data_pm['pid'];?>"><?php echo $data_pm['pmoduleName'];?></a>
            <em><i class="fa fa-angle-right"></i></em>
            <a href="#"><?php echo $data_sm['smoduleName'];?></a>
        </div>
    </div>
    <div class="pm-wrap">
        <div class="pm">
            <strong><?php echo $data_sm['smoduleName'];?></strong>
            <em>今日：</em>
            <em><?php echo $ptotal_today;?></em>
            <span class="pipe">|</span>
            <em>昨日：</em>
            <em><?php echo $ptotal_yesterday;?></em>
            <span class="pipe">|</span>
            <em>主题：</em>
            <em><?php echo $sm_total;?></em>
        </div>
        <div class="pm-desc">
            <strong>描述：</strong><?php echo $data_sm['smoduleDesc'];?>
        </div>
    </div>
    <div class="plist">
        <div class="pm-sm-top">
            <h2>全部主题</h2>
        </div>
        <div class="plist-row">
            <table class="table table-condensed table-hover" id="plist-table">
                <?php
                if ($sm_total) {
                    //循环输出子版块的所有帖子
                    while ($data_sm_post = fetch_array($res_total)) {
                        //查询帖子对应的子版块和发帖人信息
                        $smu = "select * from user,sub_module where id={$data_sm_post['postuid']} and sid={$data_sm_post['tsmoduleId']}";
                        $data_smu = fetch_array(execute($link, $smu));
                        //帖子发帖人的头像
                        $url = "";
                        if (!empty($data_smu['photo'])) {
                            $url = $data_smu['photo'];
                        } else {
                            $url = "img/noavatar_small.gif";
                        }
                        ?>
                        <tr>
                            <td class="ltd1" style="padding-left: 10px;">
                                <a href="userProfile.php?uid=<?php echo $data_smu['id']; ?>">
                                    <img src="<?php echo $url; ?>" alt="发帖人" title="<?php echo $data_smu['name']; ?>" width="31" height="29">
                                </a>
                            </td>
                            <td class="ltd2">
                                <a href="postShow.php?postId=<?php echo $data_sm_post['postId'];?>&sid=<?php echo $data_smu['sid'];?>" title="<?php echo $data_sm_post['postTitle'];?>">
                                    <?php echo $data_sm_post['postTitle']; ?>
                                </a>
                            </td>
                            <td class="ltd3">发布时间：<?php echo tranTime(strtotime($data_sm_post['postTime'])); ?></td>
                            <td class="ltd4"><a href="#"></a></td>
                        </tr>
                    <?php }
                }else{
                    echo "<tr><td colspan='4'>暂无帖子...</td></tr>";
                }
                ?>
                <tr>
                    <td colspan="4">
                        <button type="button" sid=<?php echo $_GET['sid'];?>  class="btn btn-primary" id="pubBtn"><i class="fa fa-edit"></i>发帖</button>
                        <ul class="pagination" style="display: inline; margin: 0;padding: 0;">
                            <?php
                                echo $data_page['html'];
                            ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="fastpub">
        <div class="fastpub-h">
            <h2>快速发帖</h2>
        </div>
        <div class="fastpub-wrap">
            <form action="" id="fastPubForm">
                <div class="row mlr0">
                    <input type="text" name="post-title" id="post-title" class="form-control w40" placeholder="输入帖子标题">
                    <span>还可输入 <strong  class="len">40</strong> 个字符</span>
                </div>
                <div class="row mlr0" style="position: relative;">
                    <textarea name="content" id="content"></textarea>
                    <?php
                    //当没有登录时，显示不能快速发帖
                    if (empty($member_id)){
                        $htmlisLogin = <<<EOT
                           <div class="isLogin">
                                您需要登录后才可以发帖
                                <a href="login.php" class="xi2">登录</a> |
                                <a href="register.php" class="xi2">立即注册</a>
                           </div>
EOT;
                        echo $htmlisLogin;
                    }
                    ?>
                </div>
                <div class="row mlr0">
                    <input type="text" name="yzm" id="yzm" class="form-control w20" placeholder="输入验证码">
                    <img src="inc/vcode.php" alt="验证码" title="点击刷新验证码" id="yzmpic">
                </div>
                <div class="row mlr0">
                    <button type="button" sid="<?php echo $_GET['sid'];?>" id="fastPubBtn" class="btn btn-primary"><i class="fa fa-edit"></i>发表帖子</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--引入底部-->
<?php include_once "inc/footer.inc.php"?>
</body>
</html>
<script>
    $(function () {
        $("#fastPubBtn").on("click", function () {
            layui.use("layer", function () {
                var layer = layui.layer;
                //帖子标题不能为空
                if ($("#post-title").val().length == 0){
                    layer.msg("帖子标题不能为空", {icon: 5, time: 1000}, function () {
                        $("#post-title").focus();
                    });
                    return false;
                }
                //帖子标题不能超过40个字符
                if ($("#post-title").val().length > 40){
                    layer.msg("帖子标题不能超过40个字符", {icon: 5, time: 1000}, function () {
                        $("#post-title").focus();
                    });
                    return false;
                }
                //帖子内容不能为空
                if ($("#content").val().length == 0){
                    layer.msg("帖子内容不能为空", {icon: 5, time: 1000}, function () {
                        $("#content").focus();
                    });
                    return false;
                }
                //验证码长度必须为4位
                if ($("#yzm").val().length != 4){
                    layer.msg("验证码必须为4位", {icon: 5, time: 1000}, function () {
                        $("#yzm").focus();
                    });
                    return false;
                }
                //请求插入数据
                $.ajax({
                    type: "post",
                    url: "smFPubHandle.php",
                    data: {
                        "post-title": $("#post-title").val(),
                        "content": $("#content").val(),
                        "yzm": $("#yzm").val(),
                        "sid": $("#fastPubBtn").attr("sid")
                    },
                    success: function (response) {
                        $postId = response.substring(7);//刚发布帖子的sid
                        if(response == "yzmnotequal"){
                            layer.msg("验证码错误", {icon: 5, time: 1000}, function () {
                                $("#yzm").focus();
                            });
                        }else if(response == "fail"){
                            layer.msg("发布失败", {icon: 5, time: 1000});
                            setTimeout(function () {
                                window.location.href = "publish.php";
                            }, 1500);
                        }else{
                            layer.msg("发布帖子成功", {icon: 6, time: 1000});
                            setTimeout(function () {
                                window.location.href = "postShow.php?postId="+$postId+"";
                            }, 1500);
                        }
                    }
                });
            });
        });
    });
</script>
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
            width : '915',
            height : '230',
            afterBlur: function () {
                this.sync();
            }
        });
    });
    //刷新验证码
    $("#yzmpic").on("click",function(){
        $(this).attr("src","inc/vcode.php?key="+Math.random()*Math.pow(10,17)+"");
    });
</script>