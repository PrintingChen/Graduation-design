<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>父版块栏目</title>
    <link rel="stylesheet" href="font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/pModuleList.css">
    <script src="js/jquery-1.12.2.min.js"></script>
    <script src="layui/layui.js"></script>
    <script src="js/common.js"></script>
    <script src="js/pModuleList.js"></script>
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
    //判断父版块pid是否合法
    if (!isset($_GET['pid']) || !is_numeric($_GET['pid'])){
        promptBox("父版块参数不合法", 5, "index.php");
        exit;
    }
    //查询是否存在此父版块信息
    $sql_sel = "select * from parent_Module where pid={$_GET['pid']}";
    $result_sel = execute($link, $sql_sel);
    $data = fetch_array($result_sel);
    if (mysqli_num_rows($result_sel) == 0) {
        promptBox("不存在父版块信息", 5, "index.php");
        exit;
    }
    //查询出当前父版块下的所有子版块
    $sql_sm = "select * from sub_module where tParenModuleId={$_GET['pid']}";
    $res_sm = execute($link, $sql_sm);
    //查询出传过来的id对应的所有子版块
    $sql_son = "select * from sub_module where tParenModuleId={$_GET['pid']}";
    $result_son = execute($link, $sql_son);
    $sm_total = nums($link, $sql_son);//子版块数量
    $sid_son = ''; //所有子版块的id
    while (@$data_son = mysqli_fetch_assoc($result_son)) { //将查询出来的所有的子版块id连接在一起
        $sid_son .= $data_son['sid'].',';
    }
    $sid_son = trim($sid_son, ','); //去掉子版块号前后的逗号
    if ($sid_son == '') {
        $sid_son = -1;
    }
    //查询所有子版块对应的帖子
    $sql_total = "select * from post where tsmoduleId in({$sid_son})";
    $result_total = execute($link, $sql_total);
    $data_total = mysqli_num_rows($result_total);
    //分页
    $data_page = page($data_total, 5);
    //查询父版块下的所有帖子(分页了)
    $pm_post = "select * from post where tsmoduleId in({$sid_son}) order by postId DESC {$data_page['limit']}";
    $pmres_post = execute($link, $pm_post);
    //父版块下帖子总数
    $sql_post_total = "select * from post where tsmoduleId in({$sid_son})";
    $pm_post_total = nums($link, $sql_post_total);
    //查询父版块今日的帖子总数
    $sql_total_today = "select * from post where tsmoduleId in({$sid_son}) and date_format(postTime,'%Y-%m-%d')=curdate()";
    $ptotal_today = nums($link, $sql_total_today);
    //查询父版块昨日的帖子总数
    $sql_total_yesterday = "select * from post where tsmoduleId in({$sid_son}) and date_format(postTime,'%Y-%m-%d')=DATE_SUB(curdate(),INTERVAL 1 DAY)";
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
            <a href="#"><?php echo $data['pmoduleName'];?></a>
        </div>
    </div>
    <div class="pm-wrap">
        <div class="pm">
            <strong><?php echo $data['pmoduleName'];?></strong>
            <em>今日：</em>
            <em><?php echo $ptotal_today;?></em>
            <span class="pipe">|</span>
            <em>昨日：</em>
            <em><?php echo $ptotal_yesterday;?></em>
            <span class="pipe">|</span>
            <em>主题：</em>
            <em><?php echo $pm_post_total;?></em>
        </div>
        <div class="pm-desc">
            <strong>描述：</strong><?php echo $data['pmoduleDesc'];?>
        </div>
    </div>
    <div class="pm-sm">
        <div class="pm-sm-top" style="position: relative;">
            <span class="o" style="background: url('img/collapsed_no.gif');"></span>
            <h2>子版块</h2>
            <style>
                .poa{
                    position: absolute;
                }
                .today{
                    right: 265px;
                }
                .yesterday{
                    right: 230px;
                }
            </style>
            <span class="today poa">今日 /</span>
            <span class="yesterday poa">昨日</span>
        </div>
        <div class="pm-sm-list">
            <table class="table table-condensed table-hover" id="smtable">
        <?php
        if($sm_total) { //当存在子版块时
            //输出所有的子版块
            while ($data_sm = fetch_array($res_sm)) {
                //查询出对应子版块的帖子和发帖人信息
                $sql_post = "select * from post p, user u where tsmoduleId={$data_sm['sid']} and u.id=p.postuid";
                $res_post = execute($link, $sql_post);
                $data_msg = fetch_array($res_post);
                //查询当前子版块下的所有帖子以及最新发表的帖子信息和发布者的信息
                $post_total = "select * from post,user where tsmoduleId={$data_sm['sid']} and postuid=user.id order by postId DESC ";
                $post_lastest = fetch_array(execute($link, $post_total));
                $totals = nums($link, $post_total);
                //查询当前子版块下今日的所有帖子
                $sql_total_today = "select * from post where tsmoduleId={$data_sm['sid']} and date_format(postTime,'%Y-%m-%d')=curdate()";
                $result_total_today = execute($link, $sql_total_today);
                $stotal_today = mysqli_num_rows($result_total_today);
                //查询当前子版块下昨日帖子总数
                $post_total_yesterday = "select * from post where tsmoduleId={$data_sm['sid']} and date_format(postTime,'%Y-%m-%d')=DATE_SUB(curdate(),INTERVAL 1 DAY)";
                $res_total_yesterday = execute($link, $post_total_yesterday);
                $stotal_yesterday = mysqli_num_rows($res_total_yesterday);
        ?>
                <tr>
                    <td class="td1"><!--img/forum.gif-->
                        <a href="sModuleList.php?sid=<?php echo $data_sm['sid'];?>"><img src="<?php echo 'admin/'.$data_sm['smodulePic'];?>" width="31" height="29"></a>
                    </td>
                    <td class="td2"><a href="sModuleList.php?sid=<?php echo $data_sm['sid'];?>"><?php echo $data_sm['smoduleName']; ?>(<?php echo $totals; ?>)</a></td>
                    <td class="td3">
                        <span class="xi2" title="今日"><?php echo $stotal_today; ?></span>
                        <span class="xi1" title="昨日"> / <?php echo $stotal_yesterday; ?></span>
                    </td>
                    <td class="td4">
                        <div class="fl_by"><a href="postShow.php?postId=<?php echo $post_lastest['postId']; ?>"
                                              style="color: #369;"><?php echo $post_lastest['postTitle']; ?></a></div>
                        <div class="fl_by"><?php echo tranTime(strtotime($post_lastest['postTime'])); ?> <a
                                href="#"><?php echo $post_lastest['name']; ?></a></div>
                    </td>
                </tr>
            <?php }
        }else{
            echo "<tr><td colspan='4' style='padding-left: 15px;'>暂无子版块...</td></tr>";
        }
        ?>
            </table>
        </div>
    </div>
    <div class="plist">
        <div class="pm-sm-top">
            <h2>全部主题</h2>
        </div>
        <div class="plist-row">
            <table class="table table-condensed table-hover" id="plist-table">
        <?php
        if ($pm_post_total) {
            //循环输出父版块的所有帖子
            while ($data_pm_post = fetch_array($pmres_post)) {
                //查询帖子对应的子版块和发帖人信息
                $smu = "select * from sub_module sm, user u where sm.sid={$data_pm_post['tsmoduleId']} and u.id={$data_pm_post['postuid']}";
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
                        <a href="userProfile.php?uid=<?php echo $data_smu['id']; ?>"><img src="<?php echo $url; ?>"
                                                                                          alt="发帖人"
                                                                                          title="<?php echo $data_smu['name']; ?>"
                                                                                          width="31" height="29"></a>
                    </td>
                    <td class="ltd2"><a href="postShow.php?postId=<?php echo $data_pm_post['postId']; ?>"
                                        title="<?php echo $data_pm_post['postTitle']; ?>"><?php echo $data_pm_post['postTitle']; ?></a>
                    </td>
                    <td class="ltd3">发布时间：<?php echo tranTime(strtotime($data_pm_post['postTime'])); ?></td>
                    <td class="ltd4"><a href="#">[<?php echo $data_smu['smoduleName']; ?>]</a></td>
                </tr>
        <?php }
        }else{
            echo "<tr><td colspan='4'>暂无帖子...</td></tr>";
        }
            ?>
                <tr>
                    <td colspan="4">
                        <button type="button" class="btn btn-primary" id="pubBtn"><i class="fa fa-edit"></i>发帖</button>
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
</div>
<!--引入底部-->
<?php include_once "inc/footer.inc.php"?>
</body>
</html>