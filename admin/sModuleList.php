<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>子版块列表</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/userList.css">
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="../js/formValidator.js"></script>
    <script>
        $(function(){
            //全选
            $("#selectAll").on("click", function(){
                $(":checkbox").prop("checked", true);
            });
            //反选
            $("#selectReverse").on("click", function(){
                $(":checkbox").each(function (i) {
                    if(!$(this).prop("checked")){
                        $(this).prop("checked", true);
                    }else {
                        $(this).prop("checked", false)
                    }
                });
            });
            //
            $(".delPMBtn").on("click", function () {
                $this = $(this);
                layui.use("layer", function () {
                    var layer = layui.layer;
                    //layer.confirm("确定要删除吗？", {icon : 3, title: "提示"}, function (index) {
                    //console.log("delPModule.php?pid="+$this.attr('pid')+"");
                    //$this.attr("href", "delPModule.php?pid="+$this.attr('pid')+"");
                    //layer.close(index);
                    //});
                });
            });
        });
    </script>
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
    //查询出子版块的信息
    $sql_sm = "select * from sub_module";
    $res_sm = execute($link, $sql_sm);
    //计算子版块的数量
    $nums_sm = nums($link, $sql_sm);
    //子版块分页
    $page = page($nums_sm, 5);
    $sql_page = "select * from sub_module order by sid asc {$page['limit']}";
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
    <form action="">
        <div class="panel admin-panel">
            <div class="panel-head"><strong><span class="fa fa-list"></span> 子版块列表</strong></div>
            <div class="padding border-bottom">
                <ul class="search" style="padding-left: 10px;">
                    <li>按版块名称搜索：</li>
                    <li>
                        <select name="pmName" id="pmName" class="form-control">
                            <option value="">请选择版块名称</option>
                            <option value="前端开发">前端开发</option>
                            <option value="前端开发">后台开发</option>
                        </select>
                    </li>
                    <li>按版主搜索：</li>
                    <li>
                        <select name="moder" id="moder" class="form-control">
                            <option value="">请选择版主名称</option>
                            <option value="张三">张三</option>
                            <option value="张三">李四</option>
                        </select>
                    </li>
                    <li>按关键字搜索：</li>
                    <li>
                        <input type="text" class="form-control" name="keywords" id="keywords" placeholder="请输入关键字">
                    </li>
                    <li>
                        <button class="btn btn-default button btn-c"><i class="fa fa-search custom"></i>搜索</button>
                    </li>
                </ul>
            </div>
            <div class="body-content" style="padding-bottom: 0;">
                <table class="table table-hover" style="margin-bottom: 0;">
                    <thead>
                    <th>版块ID</th>
                    <th>子版块名称</th>
                    <th>所属父版块名称</th>
                    <th>操作</th>
                    <th></th>
                    <th></th>
                    </thead>
                    <tbody>
                    <?php
                    //输出所有的子版块
                    while ($data_sm = fetch_array($res_page)){
                        //查询出子版块对应的父版块的信息
                        $sql_pminfo = "select * from parent_module where pid={$data_sm['tParenModuleId']}";
                        $res_pminfo = execute($link, $sql_pminfo);
                        $data_pminfo = fetch_array($res_pminfo);
                    ?>
                        <tr>
                            <td><input type="checkbox" id="check" name="checkbox">&nbsp;<?php echo $data_sm['sid'];?></td>
                            <td><?php echo $data_sm['smoduleName'];?></td>
                            <td><?php echo $data_pminfo['pmoduleName'];?></td>
                            <td>
                                <!--delPModule.php?pid=//echo $data_pm['pid'];-->
                                <a href="sModuleModify.php?sid=<?php echo $data_sm['sid'];?>" class="btn-primary btn"><i class="fa fa-edit"></i>修改</a>
                                <a href="#" pid="<?php echo $data_sm['sid'];?>" class="btn-danger btn delPMBtn"><i class="fa fa-trash-o"></i>删除</a>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php }?>
                    <tr>
                        <td colspan="6" style="text-align: left; padding-left: 13px;">
                            <a href="#" class="btn btn-primary" id="selectAll">全选</a>
                            <a href="#" class="btn btn-primary" id="selectReverse">反选</a>
                            <a href="#" class="btn-danger btn"><i class="fa fa-trash-o"></i>删除所选</a>
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