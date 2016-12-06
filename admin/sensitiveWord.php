<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>词语过滤</title>
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
    <script src="js/sensitiveWord.js"></script>
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
    };
    //查询敏感词的信息
    $sql_sw= "select * from sensitivewords";
    $res_sw = execute($link, $sql_sw);
    //计算管理员的数量
    $nums_sw = nums($link, $sql_sw);
    //用户分页
    $page = page($nums_sw, 7);
    $sql_page = "select * from sensitivewords {$page['limit']}";
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
            <div class="panel-head"><strong><span class="fa fa-list"></span> 词语过滤</strong></div>
            <div class="body-content" style="padding-bottom: 0; padding-top: 0;">
                <div class="sw">
                    <span>添加敏感词：</span>
                    <input type="text" placeholder="输入敏感词" class="form-control" id="adds" style="display: inline-block;width: 15%;">
                    <button type="button" id="addSensitive" class="btn btn-primary"><i class="fa fa-check-square-o custom"></i>提交</button>
                </div>
                <table class="table table-hover" style="margin-bottom: 0;">
                    <thead>
                        <th style="width: 50px;">ID</th>
                        <th class="a">不良词语</th>
                        <th class="b">操作者</th>
                        <th class="d">操作</th>
                    </thead>
                    <tbody>
                    <?php
                    //循环输出所有的敏感词
                    while ($data_sw = fetch_array($res_page)){
                        //操作者信息
                        $sql_m = "select * from manager where mid={$data_sw['tomid']}";
                        $data_m = fetch_array(execute($link, $sql_m))
                    ?>
                        <tr>
                            <td><input type="checkbox" id="check" name="del[]" value="<?php echo $data_sw['swid']?>"><?php echo $data_sw['swid']?></td>
                            <td><?php echo $data_sw['words']?></td>
                            <td><?php echo $data_m["managerName"];?></td>
                            <td>
                                <button type="button" swid="<?php echo $data_sw['swid'];?>" class="btn-danger btn delswBtn"><i class="fa fa-trash-o"></i>删除</button>
                                <a href="sensitiveWordModify.php?swid=<?php echo $data_sw['swid'];?>" class="btn btn-primary"><i class="fa fa-edit"></i>修改</a>
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