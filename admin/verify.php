<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>审核设置</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/userEdit.css">
    <style>
        input[type=radio]{
            margin-right:6px;
        }
    </style>
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="../layui/laydate/laydate.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="js/verify.js"></script>
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
    //状态信息
    $sql = "select * from settings where id=1";
    $data = fetch_array(execute($link, $sql));
    //注册状态
    $u_status = "";
    if ($data["isverifyuser"] == 0){
        $u_status = "自动验证";
    }else if ($data["isverifyuser"] == 1){
        $u_status = "人工验证";
    }
    //帖子状态
    $p_status = "";
    if ($data["isverifypost"] == 0){
        $p_status = "自动验证";
    }else if ($data["isverifypost"] == 1){
        $p_status = "人工验证";
    }

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
    <form id="verify-register">
        <div class="panel admin-panel">
            <div class="panel-head"><strong><span class="fa fa-edit"></span> 审核设置</strong><a href="index.php" style="float: right;" title="返回上一层"><i class="fa fa-mail-reply"></i></a></div>
            <div class="body-content" style="padding-bottom: 0;">
                <div class="panel-head" style="border-bottom: 0;border-top: 1px solid #ccc;color: #09C;"><strong>新用户注册验证:</strong></div>
                <table class="table" style="margin-bottom: 0;">
                    <tr>
                        <td style="width: 110px;"></td>
                        <td class="ti">
                            当前状态：<?php echo $u_status;?>
                        </td>
                        <td style="border-bottom: 1px solid #ddd;"></td>
                    </tr>
                    <tr>
                        <td style="width: 110px;"></td>
                        <td class="ti">
                            <?php
                                if ($data["isverifyuser"] == 0){
                                    echo "<input type='radio' name='reg' id='default-reg' value='0' checked><label for='default-reg'>自动验证</label>";
                                }else if ($data["isverifyuser"] == 1){
                                    echo "<input type='radio' name='reg' id='default-reg' value='0'><label for='default-reg'>自动验证</label>";
                                }
                            ?>
                        </td>
                        <td style="border-bottom: 1px solid #ddd;"></td>
                    </tr>
                    <tr>
                        <td style="width: 110px;"></td>
                        <td class="ti">
                            <?php
                                if ($data["isverifyuser"] == 0){
                                    echo "<input type='radio' name='reg' id='allow-reg' value='1'><label for='allow-reg'>人工验证</label>";
                                }else if ($data["isverifyuser"] == 1){
                                    echo "<input type='radio' name='reg' id='allow-reg' value='1' checked><label for='allow-reg'>人工验证</label>";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="button" class="btn btn-primary" id="editreg"><i class="fa fa-check-square-o custom"></i>提交</button></td>
                        <td></td>
                    </tr>
                </table>
    </form>
            <form id="verify-post">
                <div class="panel-head" style="border-bottom: 0;border-top: 1px solid #ccc;color: #09C;"><strong>帖子审核验证:</strong></div>
                <table class="table" style="margin-bottom: 0;">
                    <tr>
                        <td style="width: 110px;"></td>
                        <td class="ti">
                            当前状态：<?php echo $p_status;?>
                        </td>
                        <td style="border-bottom: 1px solid #ddd;"></td>
                    </tr>
                    <tr>
                        <td style="width: 110px;"></td>
                        <td class="ti">
                            <?php
                                if ($data["isverifypost"] == 0){
                                    echo "<input type='radio' name='vpost' id='default-vpost' value='0' checked><label for='default-vpost'>自动验证</label>";
                                }else if ($data["isverifypost"] == 1){
                                    echo "<input type='radio' name='vpost' id='default-vpost' value='0'><label for='default-vpost'>自动验证</label>";
                                }
                            ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="width: 110px;"></td>
                        <td class="ti">
                            <?php
                                if ($data["isverifypost"] == 0){
                                    echo "<input type='radio' name='vpost' id='allow-vpost' value='1'><label for='allow-vpost'>人工验证</label>";
                                }else if ($data["isverifypost"] == 1){
                                    echo "<input type='radio' name='vpost' id='allow-vpost' value='1' checked><label for='allow-vpost'>人工验证</label>";
                                }
                            ?>
                        </td>
                        <td style="border-bottom: 1px solid #ddd;"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="button" class="btn btn-primary" id="editP"><i class="fa fa-check-square-o custom"></i>提交</button></td>
                    </tr>
                </table>
            </form>
            </div>
        </div>
</div>
<!--主体部分-->
</body>
</html>