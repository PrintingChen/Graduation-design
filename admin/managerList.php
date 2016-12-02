<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>管理员栏目</title>
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
    <script src="js/managerList.js"></script>
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
        exit;
    }
    //查询管理员的信息
    $sql_manager = "select * from manager where power=0";
    $res_manager = execute($link, $sql_manager);
    //计算管理员的数量
    $nums_manager = nums($link, $sql_manager);
    //用户分页
    $page = page($nums_manager, 3);
    $sql_page = "select * from manager where power=0 order by mid asc {$page['limit']}";
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
    <form id="sml">
        <div class="panel admin-panel">
            <div class="panel-head"><strong><span class="fa fa-list"></span> 管理员栏目</strong></div>
            <div class="body-content" style="padding-bottom: 0;">
                <table class="table table-hover" style="margin-bottom: 0;">
                    <thead>
                        <th style="width: 50px;">ID</th>
                        <th class="a">用户名</th>
                        <th class="b">权限</th>
                        <th class="d">操作</th>
                    </thead>
                    <tbody>
                    <?php
                    //循环输出所有的管理员
                    while ($data_manager = fetch_array($res_page)){
                        $powerType = "";
                        if($data_manager['power'] == 0){
                            $powerType = "普通管理员";
                        }else if($data_manager['power'] == 1){
                            $powerType = "超级管理员";
                        }
                    ?>
                        <tr>
                            <td><input type="checkbox" id="check" name="del[]" value="<?php echo $data_manager['mid']?>"><?php echo $data_manager['mid']?></td>
                            <td><?php echo $data_manager['managerName']?></td>
                            <td><?php echo $powerType;?></td>
                            <td>
                                <button type="button" mid="<?php echo $data_manager['mid'];?>" class="btn-danger btn delManBtn"><i class="fa fa-trash-o"></i>删除</button>
                                <button type="button" mid="<?php echo $data_manager['mid'];?>" class="btn btn-info resetPsw" title="密码将重置为6个0"><i class="fa fa-refresh"></i>密码重置</button>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td colspan="4" style="text-align: left; padding-left: 13px;">
                            <a href="#" class="btn btn-primary" id="selectAll">全选</a>
                            <a href="#" class="btn btn-primary" id="selectReverse">反选</a>
                            <button type="button" class="btn-danger btn" id="delAll" name="delAll"><i class="fa fa-trash-o"></i>删除所选</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="position: relative;">
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