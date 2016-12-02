<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>审核用户</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/userList.css">
    <style>
        .padding.border-bottom .search li{float: right;}
    </style>
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/verifyUser.js"></script>
</head>
<?php
    //开启session
    @session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //管理员是否登录
    if (!($mid = manage_login_state($link))) {
        promptBox('您还未登录！', 5, 'login.php');
        exit();
    }
    //查询未通过审核的用户的信息
    $sql_user = "select * from user where userStatus=1";
    $res_user = execute($link, $sql_user);
    //计算用户的数量
    $nums_user = nums($link, $sql_user);
    //用户分页
    $page = page($nums_user, 3);
    $sql_page = "select * from user where userStatus=1 order by id asc {$page['limit']}";
    $res_page = execute($link, $sql_page);

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
    <form id="sml" action="userSearch.php">
        <div class="panel admin-panel">
            <div class="panel-head"><strong><span class="fa fa-list"></span> 审核用户</strong><a href="userList.php" style="float: right;" title="返回上一层"><i class="fa fa-mail-reply"></i></a></div>
            <div class="body-content" style="padding-bottom: 0;">
                <table class="table table-hover" style="margin-bottom: 0;">
                    <thead>
                        <th style="width: 50px;">ID</th>
                        <th class="a" style="width: 16%;">用户名</th>
                        <th class="b" style="width: 10%;">头衔</th>
                        <th class="c" style="width: 25%;">Email</th>
                        <th style="width: 5%;">发帖数</th>
                        <th style="width: 17%;">审核状态</th>
                        <th class="d">操作</th>
                        <th></th>
                    </thead>
                    <tbody>
                    <?php
                    if($nums_user){ //如果存在有未审核通过的用户
                    ?>
                        <?php
                        //循环输出所有的用户
                        while ($data_user = fetch_array($res_page)){
                            //查询当前用户的帖子数量
                            $sql_post = "select * from post where postuid={$data_user['id']}";
                            $post_count = nums($link, $sql_post);
                            ?>
                            <tr>
                                <td><input type="checkbox" id="check" name="ver[]" value="<?php echo $data_user['id']?>"><?php echo $data_user['id']?></td>
                                <td><?php echo $data_user['name']?></td>
                                <td>
                                    <?php
                                        if($data_user['userType'] != 0){
                                            echo "版主";
                                        }else{
                                            echo "普通用户";
                                        }
                                    ?>
                                </td>
                                <td><?php echo $data_user['email']?></td>
                                <td><?php echo $post_count;?></td>
                                <td>
                                    <?php
                                    //用户的状态
                                    if ($data_user['userStatus'] == 1){ //未验证通过
                                        echo "<span style='color:#D9534F;'>未通过</span>";
                                    }else{
                                        echo "<span style='color:#22CC77;'>通过</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <button type="button" uid="<?php echo $data_user['id'];?>" class="btn-primary btn verifyBtn"><i class="fa fa-check-circle"></i>通过</button>
                                </td>
                                <td></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td colspan="8" style="text-align: left; padding-left: 13px;">
                                <a href="#" class="btn btn-primary" id="selectAll">全选</a>
                                <a href="#" class="btn btn-primary" id="selectReverse">反选</a>
                                <button type="button" class="btn-primary btn" id="passAll"><i class="fa fa-check-circle"></i>全部通过</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8" style="position: relative;">
                                <ul class="pagination" style="margin-bottom: 0;">
                                    <?php
                                    echo $page['html'];
                                    ?>
                                </ul>
                                <span style="position: absolute;margin-left: 20px;top:12px;color:#428bca;">第 <?php echo $_GET['page']?> 页，共 <?php echo $page['totalPage']?> 页</span>
                            </td>
                        </tr>
                    <?php
                    }else{
                    ?>
                        <tr>
                            <td colspan="8">暂无未审核用户...</td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
<!--../主体部分-->
</body>
</html>