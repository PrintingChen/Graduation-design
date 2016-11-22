<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户栏目</title>
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
    <script src="js/userList.js"></script>
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
    if (!manage_login_state($link)) {
        promptBox('您还未登录！', 5, 'login.php');
        exit();
    }
    //查询用户的信息
    $sql_user = "select * from user";
    $res_user = execute($link, $sql_user);
    //计算用户的数量
    $nums_user = nums($link, $sql_user);
    //用户分页
    $page = page($nums_user, 3);
    $sql_page = "select * from user order by id asc {$page['limit']}";
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
            <div class="panel-head"><strong><span class="fa fa-list"></span> 用户栏目</strong></div>
            <div class="padding border-bottom">
                <ul class="search" style="padding-right: 22px;">
                    <li>
                        <button name="search" class="btn btn-default button btn-c"><i class="fa fa-search custom"></i>搜索</button>
                    </li>
                    <li>
                        <input type="text" class="form-control" name="keywords" id="keywords" placeholder="请输入关键字">
                    </li>
                    <li>关键字搜索：</li>
                </ul>
            </div>
            <div class="body-content" style="padding-bottom: 0;">
                <table class="table table-hover" style="margin-bottom: 0;">
                    <thead>
                        <th style="width: 50px;">ID</th>
                        <th>用户名</th>
                        <th>头衔</th>
                        <th>Email</th>
                        <th>发帖数</th>
                        <th>操作</th>
                    </thead>
                    <tbody>
                    <?php
                       //循环输出所有的用户
                        while ($data_user = fetch_array($res_page)){
                            //查询当前用户的帖子数量
                            $sql_post = "select * from post where postuid={$data_user['id']}";
                            $post_count = nums($link, $sql_post);
                    ?>
                        <tr>
                            <td><input type="checkbox" id="check" name="del[]" value="<?php echo $data_user['id']?>"><?php echo $data_user['id']?></td>
                            <td><?php echo $data_user['name']?></td>
                            <td><?php if($data_user['level'] != 0){ echo "版主";}else{ echo "普通用户";}?></td>
                            <td><?php echo $data_user['email']?></td>
                            <td><?php echo $post_count;?></td>
                            <td>
                                <a href="" class="btn-primary btn"><i class="fa fa-toggle-on"></i>权限</a>
                                <a href="userEdit.php?uid=<?php echo $data_user['id']?>" class="btn-primary btn"><i class="fa fa-edit"></i>修改</a>
                                <button type="button" uid="<?php echo $data_user['id'];?>" class="btn-danger btn delUserBtn"><i class="fa fa-trash-o"></i>删除</button>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                        <tr>
                            <td colspan="6" style="text-align: left; padding-left: 13px;">
                                <a href="#" class="btn btn-primary" id="selectAll">全选</a>
                                <a href="#" class="btn btn-primary" id="selectReverse">反选</a>
                                <button type="button" class="btn-danger btn" id="delAll" name="delAll"><i class="fa fa-trash-o"></i>删除所选</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="position: relative;">
                                <ul class="pagination" style="margin-bottom: 0;">
                                    <?php
                                        echo $page['html'];
                                    ?>
                                </ul>
                                <span style="position: absolute;margin-left: 20px;top:12px;color:#428bca;">第 <?php echo $_GET['page']?> 页，共 <?php echo $page['totalPage']?> 页</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
<!--../主体部分-->
</body>
</html>