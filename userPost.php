<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>帖子查看</title>
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
    //判断当前是否为登录状态
    if (!($member_id = login_state($link))){
        promptBox("请先登录后才能继续浏览", 5, "login.php");
        exit;
    }
    //当前登录用户的信息
    $sql_mem = "select * from user where id={$member_id}";
    $data_mem = fetch_array(execute($link, $sql_mem));
    //验证需要查看用户的uid是否合法
    if (!isset($_GET['uid']) || !is_numeric($_GET['uid'])){
        promptBox('uid传参错误', 5, 'index.php');
        exit;
    };
    //查询需要查看用户的信息
    $sql_user = "select * from user where id={$_GET['uid']}";
    $data_user = fetch_array(execute($link, $sql_user));
    //引入处理登录信息
    include_once "inc/handlerLogin.php";
    //查询当前用户所有的帖子
    $sql_post = "select * from post where postuid={$_GET['uid']}";
    $post_total = nums($link, $sql_post);
    //分页
    $pagesize = 5;
    $page = page($post_total, $pagesize);
    //分页查询帖子
    $post = "select * from post where postuid={$_GET['uid']} ORDER BY postId DESC {$page['limit']}";
    $res_post = execute($link, $post);
    //当前用户今日的帖子总数
    $sql_total_today = "select * from post where postuid={$_GET['uid']} and date_format(postTime,'%Y-%m-%d')=curdate()";
    $ptotal_today = nums($link, $sql_total_today);
    //当前用户昨日的帖子总数
    $sql_total_yesterday = "select * from post where postuid={$_GET['uid']} and date_format(postTime,'%Y-%m-%d')=DATE_SUB(curdate(),INTERVAL 1 DAY)";
    $ptotal_yesterday = nums($link, $sql_total_yesterday);
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
            <a href="#"><?php echo $data_user['name'];?>的帖子</a>
        </div>
    </div>
    <div class="pm-wrap">
        <div class="pm">
            <strong>帖子列表</strong>
            <em>今日：</em>
            <em><?php echo $ptotal_today;?></em>
            <span class="pipe">|</span>
            <em>昨日：</em>
            <em><?php echo $ptotal_yesterday;?></em>
            <span class="pipe">|</span>
            <em>主题：</em>
            <em><?php echo $post_total;?></em>
        </div>
        <div class="pm-desc">
            <a href="publish.php" class="btn btn-primary"><i class="fa fa-edit"></i>发帖</a>
        </div>
    </div>
    <div class="pm-sm">
        <div class="pm-sm-top" style="position: relative;">
            <h2>全部主题</h2>
            <span class="reply poa">回复 /</span>
            <span class="look poa">查看</span>
            <span class="author poa">作者</span>
            <span class="module poa">版块</span>
            <span class="lastTime poa">最后发表时间</span>
        </div>
        <div class="pm-sm-list">
            <table class="table table-condensed table-hover" id="smtable">
                <?php
                if($post_total) { //当存在帖子时
                    //输出所有的帖子
                    while ($data_post = fetch_array($res_post)) {
                        //查询出当前帖子对应的所属子版块、
                        $sql_sm = "select * from sub_module where sid={$data_post['tsmoduleId']}";
                        $data_sm = fetch_array(execute($link, $sql_sm));
                        //当前帖子的回复数
                        $sql_rep = "select * from reply where tpostId={$data_post['postId']}";
                        $rep_total = nums($link, $sql_rep);
                        ?>
                        <tr>
                            <td class="td1">
                                <a href="#"><img src="img/folder_new.gif" width="31" height="29"></a>
                            </td>
                            <td class="td2"><a href="postShow.php?postId=<?php echo $data_post['postId'];?>&sid=<?php echo $data_sm['sid'];?>"><?php echo $data_post['postTitle'];?></a></td>
                            <td class="td5"><a href="sModuleList.php?sid=<?php echo $data_sm['sid'];?>"><?php echo $data_sm['smoduleName'];?></a></td>
                            <td class="td6"><a href="profile.php?uid=<?php echo $data_user['id'];?>"><?php echo $data_user['name'];?></a></td>
                            <td class="td3">
                                <span class="xi2" title="回复"><?php echo $rep_total; ?></span>
                                <span class="xi1" title="查看"> / <?php echo $data_post['times']; ?></span>
                            </td>
                            <td class="td7"><?php echo tranTime(strtotime($data_post['postTime']));?></td>
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