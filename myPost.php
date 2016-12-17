<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我的帖子</title>
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
    $member_id = login_state($link);
    //判断当前登录用户的访问状态
    if ($member_id){
        //查询用户状态
        $sql_status = "select * from user where id={$member_id}";
        $data_status = fetch_array(execute($link, $sql_status));
        $status = $data_status['isForbid'];
        //用户是否通过了验证状态
        $userStatus = $data_status["userStatus"];
    }
    //当前用户的信息
    $sql_user = "select * from user where id={$member_id}";
    $data_user = fetch_array(execute($link, $sql_user));
    //引入处理登录信息
    include_once "inc/handlerLogin.php";
    //查询当前用户所有的帖子
    $sql_post = "select * from post where postuid={$member_id}";
    $post_total = nums($link, $sql_post);
    //分页
    $pagesize = 5;
    $page = page($post_total, $pagesize);
    //分页查询帖子
    $post = "select * from post where postuid={$member_id} ORDER BY postId DESC {$page['limit']}";
    $res_post = execute($link, $post);
    //当前用户今日的帖子总数
    $sql_total_today = "select * from post where postuid={$member_id} and date_format(postTime,'%Y-%m-%d')=curdate()";
    $ptotal_today = nums($link, $sql_total_today);
    //当前用户昨日的帖子总数
    $sql_total_yesterday = "select * from post where postuid={$member_id} and date_format(postTime,'%Y-%m-%d')=DATE_SUB(curdate(),INTERVAL 1 DAY)";
    $ptotal_yesterday = nums($link, $sql_total_yesterday);
?>

<body>
<!--引入头部-->
<?php include_once "inc/header.inc.php"?>
<!--引入导航-->
<?php include_once "inc/nav.inc.php"?>
<div class="container" style="width: 990px;">
    <?php
    if(isset($status)) {//会员显示
        if ($status == 2) {//会员，禁止显示
            ?>
            <div class="container" style="background-color: #EDEDF0; padding-bottom: 50px;">
                <div class="module-error">
                    <div class="error-main clearfix">
                        <div class="labeli"><img src="img/error.png" alt=""></div>
                        <div class="info">
                            <h3 class="title">你的访问受限!!!</h3>
                            <div class="reason">
                                <p>可能的原因：</p>
                                <p>您的 IP 地址不在允许范围内，或您的账号被禁用，无法访问本站点</p>
                            </div>
                            <div class="oper">
                                <p><a href="javascript:history.go(-1);">返回上一级页面&gt;</a></p>
                                <p><a href="index.php">回到网站首页&gt;</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {//会员，非禁止显示
            ?>
            <div class="position">
                <div class="z">
                    <a href="index.php" class="nvhm"><i class="fa fa-home"></i></a>
                    <em><i class="fa fa-angle-right"></i></em>
                    <a href="#">我的帖子</a>
                </div>
            </div>
            <div class="pm-wrap">
                <div class="pm">
                    <strong>我的帖子</strong>
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
                    <?php
                        if ($userStatus == 1){ //用户需要人工验证
                            echo "<a href='userNotVerify.php' class='btn btn-primary'><i class='fa fa-edit'></i>发帖</a>";
                        }else{
                            if ($status == 1){ //禁止发言
                                echo "<a href='forbidTip.php' class='btn btn-primary'><i class='fa fa-edit'></i>发帖</a>";
                            }else{
                                echo "<a href='publish.php' class='btn btn-primary'><i class='fa fa-edit'></i>发帖</a>";
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="pm-sm">
                <div class="pm-sm-top" style="position: relative;">
                    <h2>全部主题</h2>
                    <span class="reply poa" style="right: 165px">回复 /</span>
                    <span class="look poa" style="right:132px;">查看</span>
                    <span class="author poa" style="right: 255px;">作者</span>
                    <span class="module poa" style="right: 404px;">版块</span>
                    <span class="lastTime poa" >最后发表时间</span>
                </div>
                <div class="pm-sm-list">
                    <table class="table table-condensed table-hover" id="smtable">
                        <?php
                        if($post_total) { //当存在帖子时
                            //输出所有的帖子
                            while ($data_post = fetch_array($res_post)) {
                                //查询出当前帖子对应的所属子版块、,user u,reply rep where and u.id={$member_id} and rep.tpostId={$data_post['postId']}
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
                                    <td class="td2">
                                        <?php
                                            if ($userStatus == 1){ //用户需要人工验证
                                                echo "<a href='userNotVerify.php'>{$data_post['postTitle']}</a>";
                                            }else {
                                                if ($status == 1) { //禁止发言
                                                    echo "<a href='forbidTip.php'>{$data_post['postTitle']}</a>";
                                                } else {
                                                    echo "<a href='postShow.php?postId={$data_post['postId']}&sid={$data_sm['sid']}'>{$data_post['postTitle']}</a>";
                                                }
                                            }
                                        ?>

                                    </td>
                                    <td class="td5"><a href="sModuleList.php?sid=<?php echo $data_sm['sid'];?>"><?php echo $data_sm['smoduleName'];?></a></td>
                                    <td class="td6"><a href="profile.php?uid=<?php echo $data_user['id'];?>"><?php echo $data_user['name'];?></a></td>
                                    <td class="td3">
                                        <span class="xi2" title="回复"><?php echo $rep_total; ?></span>
                                        <span class="xi1" title="查看"> / <?php echo $data_post['times']; ?></span>
                                    </td>
                                    <td class="td7" style="width: 15%;"><?php echo tranTime(strtotime($data_post['postTime']));?></td>
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
            <?php
        }
    }else{//非会员显示
        ?>
        <div class="position">
            <div class="z">
                <a href="index.php" class="nvhm"><i class="fa fa-home"></i></a>
                <em><i class="fa fa-angle-right"></i></em>
                <a href="#">我的帖子</a>
            </div>
        </div>
        <div class="pm-wrap">
            <div class="pm">
                <strong>我的帖子</strong>
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
                <span class="reply poa" style="right: 165px">回复 /</span>
                <span class="look poa" style="right:132px;">查看</span>
                <span class="author poa" style="right: 255px;">作者</span>
                <span class="module poa" style="right: 404px;">版块</span>
                <span class="lastTime poa" >最后发表时间</span>
            </div>
            <div class="pm-sm-list">
                <table class="table table-condensed table-hover" id="smtable">
                    <?php
                    if($post_total) { //当存在帖子时
                        //输出所有的帖子
                        while ($data_post = fetch_array($res_post)) {
                            //查询出当前帖子对应的所属子版块、,user u,reply rep where and u.id={$member_id} and rep.tpostId={$data_post['postId']}
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
                                <td class="td7" style="width: 15%;"><?php echo tranTime(strtotime($data_post['postTime']));?></td>
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
        <?php
    }
    ?>

</div>
<!--引入底部-->
<?php include_once "inc/footer.inc.php"?>
</body>
</html>