<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户列表</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/userList.css">
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/pModuleList.js"></script>
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
    $mid = manage_login_state($link);
    //查询出父版块的信息
    $sql_pm = "select * from parent_module";
    $res_pm = execute($link, $sql_pm);
    //计算父版块的数量
    $nums_pm = nums($link, $sql_pm);
    //父版块分页
    $page = page($nums_pm, 2);
    $sql_page = "select * from parent_module order by pid asc {$page['limit']}";
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
    <form id="sml" action="pModuleSearch.php">
        <div class="panel admin-panel">
            <div class="panel-head"><strong><span class="fa fa-list"></span> 父版块列表</strong></div>
            <div class="padding border-bottom">
                <ul class="search" style="padding-left: 10px;">
                    <li>按版块名称搜索：</li>
                    <li>
                        <select name="pmName" id="pmName" class="form-control">
                            <option value="">请选择版块名称</option>
                        </select>
                    </li>
                    <li>按版主搜索：</li>
                    <li>
                        <select name="moder" id="moder" class="form-control">
                            <option value="">请选择版主名称</option>
                        </select>
                    </li>
                    <li>
                        <button name="search" class="btn btn-default button btn-c"><i class="fa fa-search custom"></i>搜索</button>
                    </li>
                </ul>
            </div>
            <div class="body-content" style="padding-bottom: 0;">
                <table class="table table-hover" style="margin-bottom: 0;">
                    <thead>
                        <th>版块ID</th>
                        <th>父版块名称</th>
                        <th>版主</th>
                        <th>操作</th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                    <?php
                        //输出所有的父版块
                        while ($data_pm = fetch_array($res_page)){
                            //查询出版块对应的版主信息
                            $sql_moder = "select * from user where id={$data_pm['moderatorId']}";
                            $res_moder = execute($link, $sql_moder);
                            //判断版块是否存在版主
                            if(mysqli_num_rows($res_moder)){
                                $data_moder = fetch_array($res_moder);
                                $moder = $data_moder['name'];
                            }else{
                                $moder = "暂无";
                            }
                    ?>
                        <tr>
                            <td><input type="checkbox" value="<?php echo $data_pm['pid']?>" id="check" name="del[]">&nbsp;<?php echo $data_pm['pid'];?></td>
                            <td><?php echo $data_pm['pmoduleName'];?></td>
                            <td><?php echo $moder;?></td>
                            <td>
                                <a href="pModuleModify.php?pid=<?php echo $data_pm['pid'];?>" class="btn-primary btn"><i class="fa fa-edit"></i>修改</a>
                                <a href="#" pid="<?php echo $data_pm['pid'];?>" class="btn-danger btn delPMBtn"><i class="fa fa-trash-o"></i>删除</a>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php }?>
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