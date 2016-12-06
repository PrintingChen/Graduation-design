<?php  $starttime = explode(' ',microtime());?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>搜索</title>
    <link rel="stylesheet" href="font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/search.css">
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
    //判断当前登录用户的访问状态
    if ($member_id){
        //查询用户状态
        $sql_status = "select * from user where id={$member_id}";
        $data_status = fetch_array(execute($link, $sql_status));
        $status = $data_status['isForbid'];
        //用户是否通过了验证状态
        $userStatus = $data_status["userStatus"];
    }
    //查询公告内容
    $sql_n = "select * from notice where nid=1";
    $data_n = fetch_array(execute($link, $sql_n));
    $nc = $data_n["noticeContent"];
    //引入处理登录信息
    include_once "inc/handlerLogin.php";
    //获取搜索的关键词
    if (isset($_GET['kw'])){
        $kw = $_GET["keywords"];
        //查询关键词对应的信息
        if (empty($kw)){
            $sql_kw = "select * from post where postTitle=''";
        }else{
            $sql_kw = "select * from post where postTitle like '%{$kw}%'";
        }
        $nums_kw = nums($link, $sql_kw);
        $pagesize = 3;
        $page = page($nums_kw, $pagesize);
        $sql_kwp = "select * from post where postTitle like '%{$kw}%' {$page['limit']}";
        $res_kwp = execute($link, $sql_kwp);
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
            <em><i class="fa fa-angle-right"></i></em>
            <a href="#">搜索</a>
        </div>
    </div>
<?php
    $endtime = explode(' ',microtime());
    $thistime = $endtime[0]+$endtime[1]-($starttime[0]+$starttime[1]);
    $thistime = round($thistime,3);
?>
    <div class="search-info">结果: 找到<span style="font-size: 16px; color: red;"><?php echo '"'.$kw.'"';?></span>相关内容 <?php echo $nums_kw;?> 个，用时 <?php echo $thistime;?> 秒</div>
    <div class="plist">
        <div class="pm-sm-top">
            <h2>搜索结果</h2>
            <span class="reply poa" style="right: 396px">回复 /</span>
            <span class="look poa" style="right:365px;">查看</span>
            <span class="author poa" style="right: 506px;">作者</span>
            <span class="lastTime poa" style="right: 227px;">最后发表时间</span>
        </div>
        <div class="plist-row">
            <table class="table table-condensed table-hover" id="plist-table">
                <?php
                if ($nums_kw) { //当搜索到帖子时
                    //输出搜索到所有的帖子
                    while ($data_kwp = fetch_array($res_kwp)) {
                        //帖子对应子版块
                        $sql_sm = "select * from sub_module where sid={$data_kwp['tsmoduleId']}";
                        $data_sm = fetch_array(execute($link, $sql_sm));
                        //发帖人
                        $sql_u = "select * from user where id={$data_kwp['postuid']}";
                        $data_u = fetch_array(execute($link, $sql_u));
                        //查询帖子对应的回复数等信息
                        $smu = "select * from reply where tpostId={$data_kwp['postId']}";
                        $data_smu = fetch_array(execute($link, $smu));
                        $rep_nums = nums($link, $smu);
                        //帖子发帖人的头像
                        $url = "";
                        if (!empty($data_u['photo'])) {
                            $url = $data_u['photo'];
                        } else {
                            $url = "img/noavatar_small.gif";
                        }
                        //判断这条帖子是否为精华帖子
                        $img = "";
                        $boutique = $data_kwp['isBoutique'];
                        if ($boutique){
                            $img = "<img id='jiajing' src='img/jiajing.gif'>";
                        }else{
                            $img = "";
                        }

                ?>
                        <tr>
                            <td class="ltd1" style="padding-left: 10px;">
                                <a href="userProfile.php?uid=<?php echo $data_u['id']; ?>">
                                    <img src="<?php echo $url; ?>" alt="发帖人" title="<?php echo $data_u['name'];?>" width="31" height="29">
                                </a>
                            </td>
                            <td class="ltd2">
                                <?php
                                if(isset($userStatus)){
                                    if ($userStatus == 1){ //用户需要人工验证
                                        echo "<a href='userNotVerify.php' title='{$data_kwp['postTitle']}'>{$data_kwp['postTitle']}</a>{$img}";
                                    }else{ //用户已通过系统自动验证
                                        if ($status == 1){ //用户被禁止发言
                                            echo "<a href='forbidTip.php' title='{$data_kwp['postTitle']}'>{$data_kwp['postTitle']}{$img}</a>";
                                        }else{
                                            echo "<a href='postShow.php?postId={$data_kwp['postId']}&sid={$data_sm['sid']}' title='{$data_kwp['postTitle']}'>{$data_kwp['postTitle']}</a>{$img}";
                                        }
                                    }
                                }else{ //游客
                                    echo "<a href='postShow.php?postId={$data_kwp['postId']}&sid={$data_sm['sid']}' title='{$data_kwp['postTitle']}'>{$data_kwp['postTitle']}</a>{$img}";
                                }
                                ?>

                            </td>
                            <td class="ltd4"><a href="userProfile.php?uid=<?php echo $data_u['id']; ?>"><?php echo $data_u['name'];?></a></td>
                            <td class="ltd5"><a href="#"><?php echo $rep_nums;?> / <?php echo $data_kwp['times'];?></a></td>
                            <td class="ltd3"><?php echo tranTime(strtotime($data_kwp['updateTime'])); ?></td>
                        </tr>
                    <?php }
                }else{
                    echo "<tr><td colspan='5' style='text-align: center;'>对不起，没有找到匹配结果。</td></tr>";
                }
                ?>
                <tr>
                    <td colspan="5">
                        <?php
                        /*if (isset($userStatus)){
                            if ($userStatus == 1){ //用户需要人工验证
                                echo "<a href='userNotVerify.php' class='btn btn-primary' style='float: left;display: inline-block;margin-right: 200px;'><i class='fa fa-edit'></i>发帖</a>";
                            }else{
                                if ($status == 1){ //禁止发言
                                    echo "<a href='forbidTip.php' class='btn btn-primary' style='float: left;display: inline-block;margin-right: 200px;'><i class='fa fa-edit'></i>发帖</a>";
                                }else{
                                    echo "<button type='button' sid={$_GET['sid']}  class='btn btn-primary' id='pubBtn'><i class='fa fa-edit'></i>发帖</button>";
                                }
                            }
                        }else{//游客
                            echo "<button type='button' sid={$_GET['sid']}  class='btn btn-primary' id='pubBtn'><i class='fa fa-edit'></i>发帖</button>";
                        }*/
                        ?>

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