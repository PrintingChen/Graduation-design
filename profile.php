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
<div id="position">
    <div class="container">
        <i class="fa fa-map-marker"></i>
        <a href="profile.php"><?php echo $res_info['name'];?></a>
        >>
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
                        <a href="#">帖子数 <?php echo $count;?></a>
                        <span class="pipe">|</span>
                        <a href="#">回帖数 <?php echo $reply_count;?></a>
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
<?php include_once "inc/footer.inc.php"?>
</body>
</html>