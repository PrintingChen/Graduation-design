<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <link rel="stylesheet" href="font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="js/jquery-1.12.2.min.js"></script>
    <script src="css/bootstrap/js/bootstrap.min.js"></script>
    <script src="layui/layui.js"></script>
    <script src="js/common.js"></script>
    <script src="js/index.js"></script>
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
    //父版块的信息
    $sql_pm = "select * from parent_module order by pid";
    $res_pm = execute($link, $sql_pm);
    //帖子总数
    $post_total = "select * from post";
    $res_total = execute($link, $post_total);
    $post_total_counts = mysqli_num_rows($res_total);
    //今日帖子总数
    $post_total_today = "select * from post where date_format(postTime,'%Y-%m-%d')=curdate()";
    $res_total_today = execute($link, $post_total_today);
    $total_today = mysqli_num_rows($res_total_today);
    //昨日帖子总数
    $post_total_yesterday = "select * from post where date_format(postTime,'%Y-%m-%d')=DATE_SUB(curdate(),INTERVAL 1 DAY)";
    $res_total_yesterday = execute($link, $post_total_yesterday);
    $total_yesterday = mysqli_num_rows($res_total_yesterday);
    //查询用户数量
    $user_counts = "select * from user order by id DESC";
    $res_counts = execute($link, $user_counts);
    $user_total = mysqli_num_rows($res_counts);
    $data_lastest = fetch_array($res_counts);//最新注册的用户
    //最新发布的帖子
    $post_lastest = "select * from post order by postId DESC limit 0,9";
    $res_lastest = execute($link, $post_lastest);
    //最新回复的帖子
    $reply_lastest = "select * from post order by updateTime DESC limit 0,9";
    $res_reply_lastest = execute($link, $reply_lastest);
?>
<body>
<!--引入头部-->
<?php include_once "inc/header.inc.php"?>
<!--引入导航-->
<?php include_once "inc/nav.inc.php"?>
<div class="container" style="width: 990px;">
    <!--  统计信息  -->
    <div class="chartz">
            <div class="col-md-9 col-sm-9">
                <p>
                    <i class="fa fa-bar-chart-o fa-x"></i>
                    今日：
                    <em><?php echo $total_today;?></em>
                    <span class="pipe">|</span>
                    昨日：
                    <em><?php echo $total_yesterday;?></em>
                    <span class="pipe">|</span>
                    帖子：
                    <em><?php echo $post_total_counts;?></em>
                    <span class="pipe">|</span>
                    会员：
                    <em><?php echo $user_total;?></em>
                    <span class="pipe">|</span>
                    欢迎最新会员：<?php echo $data_lastest['name'];?>
            </div>
            <div class="col-md-3 col-sm-3" id="publish">
                <a href="publish.php" class="btn btn-primary"><i class="fa fa-edit"></i>我要发帖</a>
            </div>
    </div>
    <!--  ../统计信息  -->
    <div class="infor">
        <div class="col-md-5 col-sm-4">
            <ul class="nav nav-tabs" id="myCar">
                <li class="active"><a href="#myCarArea" data-toggle="tab">最新图片</a></li>
            </ul>
            <div class="tab-content" id="myCarArea">
                <div class="wrapper">
                    <div id="myCarousel" class="carousel slide">
                        <ol class="carousel-indicators">
                            <li data-target="#myCarousel" data-slide-to="0"
                                class="active"></li>
                            <li data-target="#myCarousel" data-slide-to="1"></li>
                            <li data-target="#myCarousel" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="item active">
                                <a href="#"><img width="370" height="230" src="img/slider/bimg1.jpg" alt="第一张"></a>
                            </div>
                            <div class="item">
                                <a href="#"><img width="370" height="230" src="img/slider/bimg2.jpg" alt="第二张"></a>
                            </div>
                            <div class="item">
                                <a href="#"><img width="370" height="230" src="img/slider/bimg3.jpg" alt="第三张"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-sm-8">
            <ul class="nav nav-tabs" id="myRep">
                <li class="active"><a href="#lastPublish" data-toggle="tab">最新发表</a></li>
                <li><a href="#lastReply" data-toggle="tab">最新回复</a></li>
            </ul>
            <div class="tab-content" id="myCarArea">
                <!--最新发表-->
                <div class="tab-pane fade in active" id="lastPublish">
                <?php
                //输出最新发布帖子
                while ($data_post_lastest = fetch_array($res_lastest)){
                    //最新发表时间
                    $postTime = tranTime(strtotime($data_post_lastest['postTime']));
                    //查询出当前帖子对应所在的子版块信息和发布者的信息
                    $sql_msg = "select * from sub_module sm,user u where sm.sid={$data_post_lastest['tsmoduleId']} and u.id={$data_post_lastest['postuid']}";
                    $res_msg = execute($link, $sql_msg);
                    $data_msg = fetch_array($res_msg);
                ?>
                    <div class="rowl">
                        <a href="sModuleList.php?sid=<?php echo $data_msg['sid'];?>" class="section">[<?php echo $data_msg['smoduleName']?>]</a>
                        <a href="postShow.php?postId=<?php echo $data_post_lastest['postId'];?>&sid=<?php echo $data_msg['sid'];?>" class="postCont">[<?php echo $postTime;?>]&nbsp;&nbsp;<?php echo $data_post_lastest['postTitle'];?></a>
                        <a href="userProfile.php?uid=<?php echo $data_msg['id'];?>" class="publisher">[<?php echo $data_msg['name']?>]</a>
                    </div>
                <?php
                }
                ?>
                </div>
                <!--../最新发表-->
                <!--最新回复-->
                <div class="tab-pane fade" id="lastReply">
                    <?php
                    //输出最新回复的帖子
                    while ($data_reply_lastest = fetch_array($res_reply_lastest)){
                        //回复时间
                        $reppostTime = tranTime(strtotime($data_reply_lastest['updateTime']));
                        //查询出当前帖子对应所在的子版块信息和发布者的信息
                        $sql_rep_msg = "select * from sub_module sm,user u where sm.sid={$data_reply_lastest['tsmoduleId']} and u.id={$data_reply_lastest['postuid']}";
                        $res_rep_msg = execute($link, $sql_rep_msg);
                        $data_rep_msg = fetch_array($res_rep_msg);
                    ?>
                        <div class="rowl">
                            <a href="sModuleList.php?sid=<?php echo $data_rep_msg['sid'];?>" class="section">[<?php echo $data_rep_msg['smoduleName'];?>]</a>
                            <a href="postShow.php?postId=<?php echo $data_reply_lastest['postId'];?>&sid=<?php echo $data_rep_msg['sid'];?>" class="postCont">[<?php echo $reppostTime;?>]<?php echo $data_reply_lastest['postTitle']?></a>
                            <a href="userProfile.php?uid=<?php echo $data_rep_msg['id'];?>" class="publisher">[<?php echo $data_rep_msg['name']?>]</a>
                        </div>
                    <?php
                        }
                    ?>
                </div>
                <!--../最新回复-->
            </div>
        </div>
    </div>
    <?php
        //循环输出父版块
        while ($data_pm = fetch_array($res_pm)){
    ?>
            <div class="bm">
                <div class="bm_h">
                    <span class="o" style="background: url('img/collapsed_no.gif');"></span>
                    <?php
                        //显示版主的名称
                        if ($data_pm['moderatorId']){
                            $sql_moder = "select name from user where id={$data_pm['moderatorId']}";
                            $data_moder = fetch_array(execute($link, $sql_moder));
                            echo "<span class='district_moder'>分区版主：<a href='#'>{$data_moder['name']}</a></span>";
                        }else{
                            echo "<span class='district_moder'>分区版主：<a href='#'>暂无</a></span>";
                        }
                    ?>
                    <h2>
                        <a href="pModuleList.php?pid=<?php echo $data_pm['pid'];?>"><?php echo $data_pm['pmoduleName'];?></a>
                    </h2>
                    <p class="desc"><?php echo $data_pm['pmoduleDesc'];?></p>
                    <div style="clear: both"></div>
                </div>
                <div id="category" class="bm_c">
                    <table class="table table-condensed" id="section-table">
                        <tr>
                            <?php
                            //查询出当前父版块下面对应的所以子版块
                            $sql_sub = "select * from sub_module where tParenModuleId={$data_pm['pid']}";
                            $res_sub = execute($link, $sql_sub);
                            //判断当前父版块下面子版块的数量，如果没有则在当前父版块下面显示 则显示暂无子版块
                            if(mysqli_num_rows($res_sub)){ //有子版块时
                                //在这里循环输出各个子版块
                                while ($data_sub = fetch_array($res_sub)){
                                    //查询当前子版块的帖子总数
                                    $sql_total = "select * from post where tsmoduleId={$data_sub['sid']} ORDER BY postId DESC";
                                    $count_total = nums($link, $sql_total);
                                    $data_post = fetch_array(execute($link, $sql_total));
                                    //今日帖子数
                                    $sql_today = "select * from post where tsmoduleId={$data_sub['sid']} and date_format(postTime,'%Y-%m-%d')=curdate()";
                                    $count_today = nums($link, $sql_today);
                                    //查询当前子版块的回复总数
                                    $rep_total = "select * from post p,reply rep where tsmoduleId={$data_sub['sid']} and p.postId=rep.tpostId";
                                    $rep_count_total = nums($link, $rep_total);
                            ?>
                                <td class="fl_g">
                                    <div class="fl_icn_g">
                                        <!--img/common_icon.gif-->
                                        <a href="sModuleList.php?sid=<?php echo $data_sub['sid'];?>" title="<?php echo $data_sub['smoduleName'];?>"><img src="<?php echo 'admin/'.$data_sub['smodulePic']?>" width="81" height="44"></a>
                                    </div>
                                    <dl class="info-list">
                                        <dt>
                                            <a href="sModuleList.php?sid=<?php echo $data_sub['sid'];?>"><?php echo $data_sub['smoduleName'];?></a>
                                            <span class="badge" title="今日" style="background-color: #418bca;"><?php echo $count_today;?></span>
                                        </dt>
                                        <dd>
                                            <em>帖数: <?php echo $count_total;?>&nbsp;</em>
                                            <em>回复: <?php echo $rep_count_total;?></em>
                                        </dd>
                                        <dd>
                                            <em href="#" class="lastPub">最后发表：<span title="<?php echo tranTime(strtotime($data_post['postTime']));?>"><?php echo tranTime(strtotime($data_post['postTime']));?></span></em>
                                        </dd>
                                    </dl>
                                </td>
                        <?php }?>
                        <?php }else{?>
                                <td>暂无子版块...</td>
                        <?php }?>
                        </tr>
                    </table>
                </div>
            </div>
    <?php
    }
    ?>
</div>
<!--引入底部-->
<?php include_once "inc/footer.inc.php"?>
</body>
</html>