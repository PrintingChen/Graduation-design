<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>系统公告</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/userEdit.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="js/systemNotice.js"></script>
</head>
<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //管理员是否登录
    if (!($mid = manage_login_state($link))) {
        promptBox('您还未登录！', 5, 'login.php');
        exit;
    }
    //查询公告的内容
    $sql_n = "select * from notice where nid=1;";
    $data_n = fetch_array(execute($link, $sql_n));
?>
<body>
<!--引入头部-->
<?php include_once 'inc/header.inc.php';?>
<!--引入侧边栏-->
<?php include_once 'inc/leftnav.inc.php';?>
<!--引入位置信息-->
<?php include_once 'inc/position.inc.php';?>
<!--主体部分-->
<div class="admin">
    <form id="notice-form">
        <div class="panel admin-panel">
            <div class="panel-head"><strong><span class="fa fa-edit"></span> 系统公告</strong><a href="index.php" style="float: right;" title="返回上一层"><i class="fa fa-mail-reply"></i></a></div>
            <div class="body-content" style="padding-bottom: 0;">
                <table class="table" style="margin-bottom: 0;">
                    <tr>
                        <td style="width: 110px;"></td>
                        <td class="ti">
                            当前公告内容：
                            <em>
                                <?php
                                    if (empty($data_n["noticeContent"])){
                                        echo "暂无公告";
                                    }else{
                                        echo "<span style='color: #428BCA;'>{$data_n['noticeContent']}</span>";
                                    }
                                ?>
                            </em>
                        </td>
                        <td style="border-bottom: 1px solid #ddd;"></td>
                    </tr>
                    <tr>
                        <td style="width: 110px;"></td>
                        <td class="ti">
                            设置公告内容：
                        </td>
                        <td style="border-bottom: 1px solid #ddd;"></td>
                    </tr>
                    <tr>
                        <td style="width: 110px;"></td>
                        <td class="ti">
                            <textarea name="noticeContent" id="nc" cols="30" rows="10" class="form-control" placeholder="输入设置的公告内容"><?php echo $data_n["noticeContent"];?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="button" class="btn btn-primary" id="editNotice"><i class="fa fa-check-square-o custom"></i>提交</button></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
</div>
<!--主体部分-->
</body>
</html>