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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['pmoduleName'];?></title>
    <link rel="stylesheet" href="font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/pModuleList.css">
    <script src="js/jquery-1.12.2.min.js"></script>
    <script src="layui/layui.js"></script>
    <script src="js/common.js"></script>
    <script src="js/pModuleList.js"></script>
</head>


<body>
<!--引入头部-->
<?php include_once "inc/header.inc.php"?>
<!--引入导航-->
<?php include_once "inc/nav.inc.php"?>
<div class="container" style="width: 990px;">
    <?php
        if(isset($status)){//会员显示
            if ($status == 2){//会员，禁止显示
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
        }else{//会员，非禁止显示
    ?>
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
                        <span class="smdoule poa" style="right: 464px;">版块</span>
                        <span class="yesterday poa" style="right: 284px;">最新发表时间</span>
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
                                    //判断这条帖子是否为精华帖子
                                    $img = "";
                                    $boutique = $data_pm_post['isBoutique'];
                                    if ($boutique){
                                        $img = "<img id='jiajing' src='img/jiajing.gif'>";
                                    }else{
                                        $img = "";
                                    }
                            ?>
                                    <tr>
                                        <td class="ltd1" style="padding-left: 10px;">
                                            <a href="userProfile.php?uid=<?php echo $data_smu['id']; ?>">
                                                <img src="<?php echo $url; ?>" alt="发帖人" title="<?php echo $data_smu['name']; ?>" width="31" height="29">
                                            </a>
                                        </td>
                                        <td class="ltd2">
                                            <?php
                                                if ($userStatus == 1) { //用户需要人工验证
                                                    echo "<a href='userNotVerify.php' title='{$data_pm_post['postTitle']}'>{$data_pm_post['postTitle']}&nbsp;{$img}</a>";
                                                }else{
                                                    if ($status == 1){ //被禁止发言
                                                        echo "<a href='forbidTip.php' title='{$data_pm_post['postTitle']}'>{$data_pm_post['postTitle']}&nbsp;{$img}</a>";
                                                    }else{ //没有被禁止发言
                                                        echo "<a href='postShow.php?postId={$data_pm_post['postId']}' title='{$data_pm_post['postTitle']}'>{$data_pm_post['postTitle']}&nbsp;{$img}</a>";
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td class="ltd4">
                                            <a href="sModuleList.php?sid=<?php echo $data_smu['sid']?>">
                                                <?php echo $data_smu['smoduleName']; ?>
                                            </a>
                                        </td>
                                        <td class="ltd3"><?php echo tranTime(strtotime($data_pm_post['postTime']));?></td>
                                    </tr>
                                <?php }
                            }else{
                                echo "<tr><td colspan='4'>暂无帖子...</td></tr>";
                            }
                            ?>
                            <tr>
                                <td colspan="4">
                                    <?php
                                        if($userStatus == 1){ //用户需要人工验证
                                            echo "<a href='userNotVerify.php' class='btn btn-primary' style='float: left;display: inline-block;margin-right: 200px;'><i class='fa fa-edit'></i>发帖</a>";
                                        }else{
                                            if ($status == 1){ //禁止发言
                                                echo "<a href='forbidTip.php' class='btn btn-primary' style='float: left;display: inline-block;margin-right: 200px;'><i class='fa fa-edit'></i>发帖</a>";
                                            }else{
                                                echo "<button type='button' class='btn btn-primary' id='pubBtn'><i class='fa fa-edit'></i>发帖</button>";
                                            }
                                    }
                                    ?>
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
    <?php
            }
    ?>
    <?php
        }else {//非会员显示
    ?>
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
                    <span class="smdoule poa" style="right: 464px;">版块</span>
                    <span class="yesterday poa" style="right: 284px;">最新发表时间</span>
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
                                //判断这条帖子是否为精华帖子
                                $img = "";
                                $boutique = $data_pm_post['isBoutique'];
                                if ($boutique){
                                    $img = "<img id='jiajing' src='img/jiajing.gif'>";
                                }else{
                                    $img = "";
                                }
                        ?>
                                <tr>
                                    <td class="ltd1" style="padding-left: 10px;">
                                        <a href="userProfile.php?uid=<?php echo $data_smu['id']; ?>">
                                            <img src="<?php echo $url; ?>" alt="发帖人" title="<?php echo $data_smu['name']; ?>" width="31" height="29">
                                        </a>
                                    </td>
                                    <td class="ltd2">
                                        <a href="postShow.php?postId=<?php echo $data_pm_post['postId']; ?>" title="<?php echo $data_pm_post['postTitle']; ?>">
                                            <?php echo $data_pm_post['postTitle'];?>&nbsp;<?php echo $img;?>
                                        </a>
                                    </td>
                                    <td class="ltd4">
                                        <a href="sModuleList.php?sid=<?php echo $data_smu['sid']?>">
                                            <?php echo $data_smu['smoduleName']; ?>
                                        </a>
                                    </td>
                                    <td class="ltd3"><?php echo tranTime(strtotime($data_pm_post['postTime']));?></td>
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
    <?php
        }
    ?>

</div>
<!--引入底部-->
<?php include_once "inc/footer.inc.php"?>
</body>
</html>