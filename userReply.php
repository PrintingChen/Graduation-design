<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户回复</title>
    <link rel="stylesheet" href="font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/pModuleList.css">
    <link rel="stylesheet" href="css/myPost.css">
    <script src="js/jquery-1.12.2.min.js"></script>
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
    if (!($member_id = login_state($link))){
        promptBox("请先登录后才能继续浏览", 5, "login.php");
        exit;
    }
    //判断uid
    if (!isset($_GET['uid']) || !is_numeric($_GET['uid'])){
        promptBox("传参错误", 5, "index.php");
        exit;
    };
    //当前用户的信息
    $sql_user = "select * from user where id={$_GET['uid']}";
    $data_user = fetch_array(execute($link, $sql_user));
    //引入处理登录信息
    include_once "inc/handlerLogin.php";
    //查询当前用户所有的回复
    $sql_reply = "select * from reply where ruid={$_GET['uid']}";
    $reply_total = nums($link, $sql_reply);
    //分页
    $pagesize = 10;
    $page = page($reply_total, $pagesize);
    //分页查询回复
    $reply = "select * from reply where ruid={$_GET['uid']} ORDER BY rid DESC {$page['limit']}";
    $res_reply = execute($link, $reply);
    //当前用户今日的回帖总数
    $sql_total_today = "select * from reply where rid={$_GET['uid']} and date_format(rtime,'%Y-%m-%d')=curdate()";
    $rtotal_today = nums($link, $sql_total_today);
    //当前用户昨日的回帖总数
    $sql_total_yesterday = "select * from reply where rid={$_GET['uid']} and date_format(rtime,'%Y-%m-%d')=DATE_SUB(curdate(),INTERVAL 1 DAY)";
    $rtotal_yesterday = nums($link, $sql_total_yesterday);
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
            <a href="#"><?php echo $data_user['name'];?>的回帖</a>
        </div>
    </div>
    <div class="pm-wrap">
        <div class="pm">
            <strong><?php echo $data_user['name'];?>回帖</strong>
            <em>今日：</em>
            <em><?php echo $rtotal_today;?></em>
            <span class="pipe">|</span>
            <em>昨日：</em>
            <em><?php echo $rtotal_yesterday;?></em>
            <span class="pipe">|</span>
            <em>主题：</em>
            <em><?php echo $reply_total;?></em>
        </div>
        <div class="pm-desc">
            <a href="publish.php" class="btn btn-primary"><i class="fa fa-edit"></i>发帖</a>
        </div>
    </div>
    <div class="pm-sm">
        <div class="pm-sm-top" style="position: relative;">
            <h2>全部回复</h2>
            <span class="reply poa" style="right: 163px;">回复 /</span>
            <span class="look poa" style="right:131px;">查看</span>
            <span class="author poa" style="right: 235px;">最后回复者</span>
            <span class="module poa" style="right: 403px;">版块</span>
            <span class="lastTime poa">最后发表时间</span>
        </div>
        <div class="pm-sm-list">
            <table class="table table-condensed table-hover" id="smtable">
                <?php
                if($reply_total) { //当存在回复
                    //输出所有回复对应的帖子
                    while ($data_reply = fetch_array($res_reply)) {
                        //查询出当前回复对应的所属帖子，子版块
                        $sql_msg = "select * from post p,sub_module sm where postId={$data_reply['tpostId']} and sm.sid=p.tsmoduleId";
                        $data_msg = fetch_array(execute($link, $sql_msg));
                        //对应帖子的最后回复信息
                        $sql_lr = "select * from reply where tpostId={$data_msg['postId']} ORDER BY rtime DESC";
                        $data_lr = fetch_array(execute($link, $sql_lr));
                        $nums_lr = nums($link, $sql_lr);
                        //回复对应帖子的最后回复人
                        $lastRep = "select * from user where id={$data_lr['ruid']}";
                        $data_lastRep = fetch_array(execute($link, $lastRep));
                ?>
                        <tr>
                            <td class="td1">
                                <a href="#"><img src="img/folder_new.gif" width="31" height="29"></a>
                            </td>
                            <td class="td2"><a href="postShow.php?postId=<?php echo $data_msg['postId'];?>&sid=<?php echo $data_msg['sid'];?>"><?php echo $data_msg['postTitle'];?></a></td>
                            <td class="td5"><a href="sModuleList.php?sid=<?php echo $data_msg['sid'];?>"><?php echo $data_msg['smoduleName'];?></a></td>
                            <td class="td6"><a href="profile.php?uid=<?php echo $data_lastRep['id'];?>"><?php echo $data_lastRep['name'];?></a></td>
                            <td class="td3">
                                <span class="xi2" title="回复"><?php echo $nums_lr;?></span>
                                <span class="xi1" title="查看"> / <?php echo $data_msg['times']; ?></span>
                            </td>
                            <td class="td7" style="width: 15%;"><?php echo tranTime(strtotime($data_lr['rtime']));?></td>
                        </tr>
                    <?php }
                }else{
                    echo "<tr><td colspan='4' style='padding-left: 15px;'>暂无帖子...</td></tr>";
                }
                ?>
                <tr>
                    <td colspan="6">
                        <a class="btn btn-default" id="pubBtn" style="margin-right: 260px;border-color: #fff;"></a class="btn btn-default">
                        <ul class="pagination" style="display: inline; margin: 0;padding: 0;">
                            <?php
                            echo $page['html'];
                            ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!--引入底部-->
<?php include_once "inc/footer.inc.php"?>
</body>
</html>