<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人资料</title>
    <link rel="stylesheet" href="font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/profile.css">
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
    if(!($member_id = login_state($link))){
        promptBox("您还未登录", 5, "index.php");
        exit;
    }
    //判断当前登录用户的访问状态
    if ($member_id){
        //查询用户状态
        $sql_status = "select * from user where id={$member_id}";
        $data_status = fetch_array(execute($link, $sql_status));
        $status = $data_status['isForbid'];
        //最后发表时间
        $sql_pub = "select * from post where postuid={$member_id} ORDER BY postTime DESC";
        $data_pub = fetch_array(execute($link, $sql_pub));
    }
    //查询当前用户的帖子总数
    $sql_total = "select * from post where postuid={$member_id}";
    $count = nums($link, $sql_total);
    //查询当前用户的回帖总数
    $sql_reply_total = "select * from reply where ruid={$member_id}";
    $reply_count = nums($link, $sql_reply_total);
?>
<body>
<!--引入头部-->
<?php include_once "inc/header.inc.php"?>
<!--引入导航-->
<?php include_once "inc/nav.inc.php"?>
<?php
    if(isset($status)) {//会员显示
        if ($status == 2) {//会员，禁止显示
?>
            <div class="container">
                <div class="forbid-status">
                    <img src="img/error.jpg" alt="">
                    抱歉，您的 IP 地址不在允许范围内，或您的账号被禁用，无法访问本站点
                </div>
            </div>
<?php
        } else {//会员，非禁止显示
 ?>
            <div id="position">
                <div class="container">
                    <i class="fa fa-home"></i>
                    <a href="profile.php"><?php echo $res_info['name'];?></a>
                    >
                    <a href="register.php">个人资料</a>
                </div>
            </div>
            <div id="profile">
                <div class="container">
                    <div class="profile-h">
                        <a href="profile.php"><img src="<?php echo $img_url;?>" width="48" height="48"></a>
                        <div class="info">
                            <?php echo $res_info['name']?>个人资料<br>
                            UID：<?php echo $res_info['id']?>
                        </div>
                    </div>
                    <div class="person-info">
                        <div class="block">
                            <h2 class="mbn"><?php echo $res_info['name']?> <img src="img/ol.gif" alt=""> <span class="xw0">(UID：<?php echo $res_info['id']?>)</span></h2>
                            <ul class="pbm">
                                <li>
                                    <em class="xg2">统计信息</em>
                                    <a href="myPost.php">帖子数 <?php echo $count;?></a>
                                    <span class="pipe">|</span>
                                    <a href="myReply.php">回帖数 <?php echo $reply_count;?></a>
                                </li>
                            </ul>
                            <ul class="pbm pf_l">
                                <li>
                                    <em class="xg2">真实姓名</em>
                                    <?php echo $res_info['reallyName']?>
                                </li>
                                <li>
                                    <em class="xg2">性别</em>
                                    <?php echo $res_info['sex']?>
                                </li>
                                <li>
                                    <em class="xg2">生日</em>
                                    <?php echo $res_info['birthday']?>
                                </li>
                                <li>
                                    <em class="xg2">出生地</em>
                                    <?php echo $res_info['homeplace']?>
                                </li>
                                <li>
                                    <em class="xg2">个人主页</em>
                                    <a href="#"><?php echo $res_info['website']?></a>
                                </li>
                                <li>
                                    <em class="xg2">邮箱</em>
                                    <?php echo $res_info['email']?>
                                </li>
                                <li>
                                    <em class="xg2">血型</em>
                                    <?php echo $res_info['bloodType']?>
                                </li>
                                <li>
                                    <em class="xg2">固定电话</em>
                                    <?php echo $res_info['fixedTel']?>
                                </li>
                                <li>
                                    <em class="xg2">手机</em>
                                    <?php echo $res_info['phone']?>
                                </li>
                                <li>
                                    <em class="xg2">QQ</em>
                                    <?php echo $res_info['qq']?>
                                </li>
                                <li>
                                    <em class="xg2">毕业学校</em>
                                    <?php echo $res_info['school']?>
                                </li>
                                <li>
                                    <em class="xg2">学历</em>
                                    <?php echo $res_info['degree']?>
                                </li>
                                <li>
                                    <em class="xg2">公司</em>
                                    <?php echo $res_info['company']?>
                                </li>
                                <li>
                                    <em class="xg2">职业</em>
                                    <?php echo $res_info['profession']?>
                                </li>
                                <li>
                                    <em class="xg2">职位</em>
                                    <?php echo $res_info['job']?>
                                </li>
                            </ul>
                        </div>
                        <div class="block">
                            <h2 class="mbn">活跃状况</h2>
                            <ul class="pbm">
                                <li>
                                    <em class="xg2">用户类型</em>
                                    <?php
                                        if($data_status["userType"] == 1){
                                            echo "版主";
                                        }else{
                                            echo "普通用户";
                                        }
                                    ?>
                                </li>
                            </ul>
                            <ul class="pbm pf_l" style="border-bottom: none;">
                                <li>
                                    <em class="xg2">注册时间</em>
                                    <?php echo $res_info['registerTime']?>
                                </li>
                                <li>
                                    <em class="xg2">最后访问时间</em>
                                    <?php echo $res_info['lastLogin']?>
                                </li>
                                <li>
                                    <em class="xg2">注册IP</em>
                                    <?php echo $_SERVER['REMOTE_ADDR'];?>
                                </li>
                                <li>
                                    <em class="xg2">上次访问IP</em>
                                    <?php echo $_SERVER['REMOTE_ADDR'];?>
                                </li>
                                <li>
                                    <em class="xg2">上次活动时间</em>
                                    <?php echo $res_info['lastLogin']?>
                                </li>
                                <li>
                                    <em class="xg2">上次发表时间</em>
                                    <?php echo $data_pub["postTime"];?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
<?php
        }
    }else{//非会员显示
?>
        <div id="position">
            <div class="container">
                <i class="fa fa-home"></i>
                <a href="profile.php"><?php echo $res_info['name'];?></a>
                >
                <a href="register.php">个人资料</a>
            </div>
        </div>
        <div id="profile">
            <div class="container">
                <div class="profile-h">
                    <a href="profile.php"><img src="<?php echo $img_url;?>" width="48" height="48"></a>
                    <div class="info">
                        <?php echo $res_info['name']?>个人资料<br>
                        UID：<?php echo $res_info['id']?>
                    </div>
                </div>
                <div class="person-info">
                    <div class="block">
                        <h2 class="mbn"><?php echo $res_info['name']?> <img src="img/ol.gif" alt=""> <span class="xw0">(UID：<?php echo $res_info['id']?>)</span></h2>
                        <ul class="pbm">
                            <li>
                                <em class="xg2">统计信息</em>
                                <a href="myPost.php">帖子数 <?php echo $count;?></a>
                                <span class="pipe">|</span>
                                <a href="myReply.php">回帖数 <?php echo $reply_count;?></a>
                            </li>
                        </ul>
                        <ul class="pbm pf_l">
                            <li>
                                <em class="xg2">真实姓名</em>
                                <?php echo $res_info['reallyName']?>
                            </li>
                            <li>
                                <em class="xg2">性别</em>
                                <?php echo $res_info['sex']?>
                            </li>
                            <li>
                                <em class="xg2">生日</em>
                                <?php echo $res_info['birthday']?>
                            </li>
                            <li>
                                <em class="xg2">出生地</em>
                                <?php echo $res_info['homeplace']?>
                            </li>
                            <li>
                                <em class="xg2">个人主页</em>
                                <a href="#"><?php echo $res_info['website']?></a>
                            </li>
                            <li>
                                <em class="xg2">邮箱</em>
                                <?php echo $res_info['email']?>
                            </li>
                            <li>
                                <em class="xg2">血型</em>
                                <?php echo $res_info['bloodType']?>
                            </li>
                            <li>
                                <em class="xg2">固定电话</em>
                                <?php echo $res_info['fixedTel']?>
                            </li>
                            <li>
                                <em class="xg2">手机</em>
                                <?php echo $res_info['phone']?>
                            </li>
                            <li>
                                <em class="xg2">QQ</em>
                                <?php echo $res_info['qq']?>
                            </li>
                            <li>
                                <em class="xg2">毕业学校</em>
                                <?php echo $res_info['school']?>
                            </li>
                            <li>
                                <em class="xg2">学历</em>
                                <?php echo $res_info['degree']?>
                            </li>
                            <li>
                                <em class="xg2">公司</em>
                                <?php echo $res_info['company']?>
                            </li>
                            <li>
                                <em class="xg2">职业</em>
                                <?php echo $res_info['profession']?>
                            </li>
                            <li>
                                <em class="xg2">职位</em>
                                <?php echo $res_info['job']?>
                            </li>
                        </ul>
                    </div>
                    <div class="block">
                        <h2 class="mbn">活跃状况</h2>
                        <ul class="pbm">
                            <li>
                                <em class="xg2">用户类型</em>
                                普通用户
                            </li>
                        </ul>
                        <ul class="pbm pf_l" style="border-bottom: none;">
                            <li>
                                <em class="xg2">注册时间</em>
                                <?php echo $res_info['registerTime']?>
                            </li>
                            <li>
                                <em class="xg2">最后访问时间</em>
                                <?php echo $res_info['lastLogin']?>
                            </li>
                            <li>
                                <em class="xg2">注册IP</em>
                                <?php echo $_SERVER['REMOTE_ADDR'];?>
                            </li>
                            <li>
                                <em class="xg2">上次访问IP</em>
                                <?php echo $_SERVER['REMOTE_ADDR'];?>
                            </li>
                            <li>
                                <em class="xg2">上次活动时间</em>
                                <?php echo $res_info['lastLogin']?>
                            </li>
                            <li>
                                <em class="xg2">上次发表时间</em>
                                Eisneim
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
?>

<?php include_once "inc/footer.inc.php"?>
</body>
</html>