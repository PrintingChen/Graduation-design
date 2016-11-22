<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>父版块搜索</title>
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
            //layui组件
            layui.use("layer", function () {
                var layer = layui.layer;
                //删除单条记录
                $(".delPMBtn").on("click", function () {
                    $this = $(this);
                    layer.confirm("确定要删除吗？", {icon : 3, title: "提示"}, function (index) {
                        $pid = $this.attr('pid');
                        window.location.href = "delPModule.php?pid="+$pid+"";
                        layer.close(index);
                    });
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
    //查询出父版块的信息
    $sql_pm = "select * from parent_module";
    $res_pm = execute($link, $sql_pm);
    //计算父版块的数量
    $nums_pm = nums($link, $sql_pm);
    //父版块分页
    $page = page($nums_pm, 5);
    $sql_page = "select * from parent_module order by pid asc {$page['limit']}";
    $res_page = execute($link, $sql_page);
    //当提交数据之后
    if (isset($_GET['search'])){
        //var_dump( $_GET );exit;
        //获取查询条件
        $wherelist = array();
        if(!empty($_GET['pmName'])){
            $wherelist[] = "pmoduleName like '%{$_GET['pmName']}%'";
        }
        if(!empty($_GET['moder'])){
            //查询版主的信息
            $sql_moder = "select id from user where name='{$_GET['moder']}'";
            $data_moder = fetch_array(execute($link, $sql_moder));
            $wherelist[] = "moderatorId={$data_moder['id']}";
        }
        //组装查询条件
        if(count($wherelist) > 0){
            $where = " where ".implode(' AND ' , $wherelist);
        }
        //判断查询条件
        //$where = isset($where) ? $where : '';
        if (isset($where)){
            $sql_search = "select * from parent_module {$where}";
            $res_search = execute($link, $sql_search);
            //查询记录数
            $nums = nums($link, $sql_search);
        }else{
            $sql_search = "select * from parent_module where pmoduleName='' and moderatorId=''";
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
            <div class="panel-head"><strong><span class="fa fa-list"></span> 父版块搜索结果列表</strong><a href="pModuleList.php" style="float: right;" title="返回上一层"><i class="fa fa-mail-reply"></i></a></div>
            <div class="body-content" style="padding-bottom: 0;">
                <table class="table table-hover" style="margin-bottom: 0;">
                    <thead>
                    <th>版块ID</th>
                    <th>父版块名称</th>
                    <th>版主名称</th>
                    <th>操作</th>
                    <th></th>
                    <th></th>
                    </thead>
                    <tbody>
                    <?php
                    //输出查询到的所有的父版块
                    if ($nums){
                        while ($data_pm = fetch_array($res_search)){
                            //查询出父版块对应的版主的信息
                            $sql_moder = "select * from user where id={$data_pm['moderatorId']}";
                            $res_moder = execute($link, $sql_moder);
                            $data_moder = fetch_array($res_moder);
                            ?>
                            <tr>
                                <td><input type="checkbox" value="<?php echo $data_pm['pid']?>" id="check" name="del[]">&nbsp;<?php echo $data_pm['pid'];?></td>
                                <td><?php echo $data_pm['pmoduleName'];?></td>
                                <td><?php echo $data_moder['name'];?></td>
                                <td>
                                    <a href="pModuleModify.php?pid=<?php echo $data_pm['pid'];?>" class="btn-primary btn"><i class="fa fa-edit"></i>修改</a>
                                    <a href="#" pid="<?php echo $data_pm['pid'];?>" class="btn-danger btn delPMBtn"><i class="fa fa-trash-o"></i>删除</a>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php }
                    }else{
                        echo "<tr><td colspan='6'>搜索不到记录，请重试...</td></tr>";
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