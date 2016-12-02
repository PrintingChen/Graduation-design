<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户搜索</title>
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
    <script src="js/userSearch.js"></script>
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
        exit();
    }
    //查询用户的信息
    $sql_user = "select * from user";
    $res_user = execute($link, $sql_user);
    //当提交数据之后
    if (isset($_GET['search'])){
        //获取查询条件
        $wherelist = array();
        if(!empty($_GET['keywords'])){
            $wherelist[] = "name like '%{$_GET['keywords']}%' or email like '%{$_GET['keywords']}%'";
        }
        if(!empty($_GET['forbid-status'])){
            $fs = $_GET['forbid-status'] - 1;
            $wherelist[] = "isForbid={$fs}";
        }
        if(!empty($_GET['verify-status'])){
            $vs = $_GET['verify-status'] - 1;
            $wherelist[] = "userStatus={$vs}";
        }
        //组装查询条件
        if(count($wherelist) > 0){
            $where = " where ".implode(' AND ' , $wherelist);
        }
        //判断查询条件
        if (isset($where)){
            $sql_search = "select * from user {$where}";
            $res_search = execute($link, $sql_search);
            //查询记录数
            $nums = nums($link, $sql_search);
        }else{
            $sql_search = "select * from user where name='' and id=''";
            $res_search = execute($link, $sql_search);
            //查询记录数
            $nums = nums($link, $sql_search);
        }
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
    <form id="sml">
        <div class="panel admin-panel">
            <div class="panel-head"><strong><span class="fa fa-list"></span> 用户搜索结果列表</strong><a href="userList.php" style="float: right;" title="返回上一层"><i class="fa fa-mail-reply"></i></a></div>
            <div class="body-content" style="padding-bottom: 0;">
                <table class="table table-hover" style="margin-bottom: 0;">
                    <thead>
                        <th style="width: 50px;">ID</th>
                        <th>用户名</th>
                        <th>头衔</th>
                        <th>Email</th>
                        <th>发帖数</th>
                        <th>审核状态</th>
                        <th>权限状态</th>
                        <th>操作</th>
                    </thead>
                    <tbody>
                    <?php
                    //循环输出查询的所有的用户
                    if($nums){
                        while ($data_user = fetch_array($res_search)){
                            ?>
                            <tr>
                                <td><input type="checkbox" id="check" name="del[]" value="<?php echo $data_user['id']?>"><?php echo $data_user['id']?></td>
                                <td><?php echo $data_user['name']?></td>
                                <td>
                                    <?php
                                        if($data_user['userType'] == 1){
                                            echo "<span style='color:#428BCA;'>版主</span>";
                                        }else{
                                            echo "普通用户";
                                        }
                                    ?>
                                </td>
                                <td><?php echo $data_user['email']?></td>
                                <td>132</td>
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
                                    <?php
                                    //当前用户的权限状态
                                    if ($data_user['isForbid'] == 0){
                                        echo "正常状态";
                                    }else if($data_user['isForbid'] == 1){
                                        echo "<span style='color:#D9534F;'>禁止发言</span>";
                                    }else if($data_user['isForbid'] == 2){
                                        echo "<span style='color:#D9534F;'>禁止访问</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="userEdit.php?uid=<?php echo $data_user['id'];?>" class="btn-primary btn"><i class="fa fa-edit"></i>修改</a>
                                    <a href="#" uid="<?php echo $data_user['id'];?>" class="btn-danger btn delUserBtn"><i class="fa fa-trash-o"></i>删除</a>
                                </td>
                            </tr>
                        <?php
                        }
                    }else{
                        echo "<tr><td colspan='8'>搜索不到记录，请重试...</td></tr>";
                    }?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
<!--../主体部分-->
</body>
</html>