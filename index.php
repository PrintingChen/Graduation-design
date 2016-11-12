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
?>
<body>
<!--引入头部-->
<?php include_once "inc/header.inc.php"?>
<!--引入导航-->
<?php include_once "inc/nav.inc.php"?>
<div class="container" style="width: 990px;">
    <!--  统计信息  -->
    <?php
        //查询用户数量
        $user_counts = "select id from user";
        $res_counts = execute($link, $user_counts);
        $total = mysqli_num_rows($res_counts);
    ?>
    <div class="chartz">
            <div class="col-md-9 col-sm-9">
                <p>
                    <i class="fa fa-bar-chart-o fa-x"></i>
                    今日：
                    <em>100</em>
                    <span class="pipe">|</span>
                    昨日：
                    <em>100</em>
                    <span class="pipe">|</span>
                    帖子：
                    <em>100</em>
                    <span class="pipe">|</span>
                    会员：
                    <em><?php echo $total;?></em>
                    <span class="pipe">|</span>
                    欢迎新会员：张三
            </div>
            <div class="col-md-3 col-sm-3" id="publish">
                <a href="#" class="btn btn-primary"><i class="fa fa-edit"></i>我要发帖</a>
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
                <div class="tab-pane fade in active" id="lastPublish">
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题帖子的标题帖子的帖子的标题帖子的标题标题帖子的标题帖子的标题帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                </div>
                <div class="tab-pane fade" id="lastReply">
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                    <div class="rowl">
                        <a href="#" class="section">[官方原创]</a>
                        <a href="#" class="postCont">[2016/11/6]帖子的标题</a>
                        <a href="#" class="publisher">[张三]</a>
                    </div>
                </div>
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
                        <a href="#"><?php echo $data_pm['pmoduleName'];?></a>
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
                            //判断当前父版块下面子版块的数量，如果没有则在当前父版块下面显示 暂无子版块
                            if(mysqli_num_rows($res_sub)){
                                //在这里循环输出各个子版块
                                while ($data_sub = fetch_array($res_sub)){
                            ?>
                                <td class="fl_g">
                                    <div class="fl_icn_g">
                                        <!--img/common_icon.gif-->
                                        <a href="#"><img src="<?php echo 'admin/'.$data_sub['smodulePic']?>" width="81" height="44"></a>
                                    </div>
                                    <dl class="info-list">
                                        <dt>
                                            <a href="#"><?php echo $data_sub['smoduleName'];?></a>
                                            <span class="badge" title="今日" style="background-color: #418bca;">11</span>
                                        </dt>
                                        <dd>
                                            <em>帖数: 851&nbsp;</em>
                                            <em>回复: 489</em>
                                        </dd>
                                        <dd>
                                            <a href="#" class="lastPub">最后发表：<span title="2016-11-7 15:41">5&nbsp;小时前</span></a>
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