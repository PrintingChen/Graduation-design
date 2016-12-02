<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>帖子搜索</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/userList.css">
    <link rel="stylesheet" href="css/postList.css">
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/postSearch.js"></script>
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
    //当提交数据之后
    if (isset($_GET['search'])){
        //获取查询条件
        $wherelist = array();
        if(!empty($_GET['smName'])){
            $wherelist[] = "tsmoduleId={$_GET['smName']}";
        }
        if(!empty($_GET['post-person'])){
            $wherelist[] = "postuid={$_GET['post-person']}";
        }
        if(!empty($_GET['verify-status'])){
            $st = $_GET['verify-status'] - 1;
            $wherelist[] = "postStatus={$st}";
        }
        if(!empty($_GET['keywords'])){
            $wherelist[] = "postTitle like '%{$_GET['keywords']}%'";
        }
        //组装查询条件
        if(count($wherelist) > 0){
            $where = " where ".implode(' AND ' , $wherelist);
        }
        //echo $where;exit;
        //判断查询条件
        //$where = isset($where) ? $where : '';
        if (isset($where)){
            $sql_search = "select * from post {$where}";
            $res_search = execute($link, $sql_search);
            //查询记录数
            $nums = nums($link, $sql_search);
        }else{
            $sql_search = "select * from post where postTitle='' and tsmoduleId=''";
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
            <div class="panel-head"><strong><span class="fa fa-list"></span> 帖子搜索结果列表</strong><a href="postList.php" style="float: right;" title="返回上一层"><i class="fa fa-mail-reply"></i></a></div>
            <div class="body-content" style="padding-bottom: 0;">
                <table class="table table-hover" style="margin-bottom: 0;">
                    <thead>
                        <th class="th1">ID</th>
                        <th class="th2">标题</th>
                        <th class="th3">版块名称</th>
                        <th class="th4">作者</th>
                        <th class="th5">回复</th>
                        <th class="th6">浏览</th>
                        <th class="th7">最后发表</th>
                        <th class="th9" style="width: 8%;">审核状态</th>
                        <th class="th8">操作</th>
                    </thead>
                    <tbody>
                    <?php
                    //输出查询到的所有帖子
                    if ($nums){ //当搜索到记录时
                        while ($data_post = fetch_array($res_search)){
                            //查询帖子对应的回复信息，
                            $sql_rep = "select * from reply where tpostId={$data_post['postId']} ORDER BY rtime DESC";
                            $data_rep = fetch_array(execute($link, $sql_rep));
                            $rep_count = nums($link, $sql_rep);
                            //帖子对应的子版块
                            $sql_sm = "select * from sub_module where sid={$data_post['tsmoduleId']}";
                            $data_sm = fetch_array(execute($link, $sql_sm));
                            //发帖作者
                            $sql_u = "select * from user where id={$data_post['postuid']}";
                            $data_u = fetch_array(execute($link, $sql_u));
                    ?>
                            <tr>
                                <td>
                                    <input type="checkbox" value="<?php echo $data_post['postId'];?>" id="check" name="del[]">&nbsp;<?php echo $data_post['postId'];?>
                                </td>
                                <td class="ae">
                                    <a href="../postShow.php?postId=<?php echo $data_post['postId'];?>&sid=<?php echo $data_sm['sid'];?>"><?php echo $data_post['postTitle'];?></a>
                                </td>
                                <td class="ae">
                                    <a href="../sModuleList.php?sid=<?php echo $data_sm['sid'];?>"><?php echo $data_sm['smoduleName'];?></a>
                                </td>
                                <td><?php echo $data_u['name'];?></td>
                                <td><?php echo $rep_count;?></td>
                                <td><?php echo $data_post['times'];?></td>
                                <td><?php echo $data_post['updateTime'];?></td>
                                <td>
                                    <?php
                                        if ($data_post['postStatus'] == 1){ //未验证通过
                                            echo "<span style='color:#D9534F;'>未通过</span>";
                                        }else{
                                            echo "<span style='color:#22CC77;'>通过</span>";
                                        }
                                    ?>
                                </td>
                                <td>
                                    <a href="postModify.php?postId=<?php echo $data_post['postId'];?>&sid=<?php echo $data_sm['sid'];?>" class="btn-primary btn"><i class="fa fa-edit"></i>修改</a>
                                    <button type="button" postId="<?php echo $data_post['postId'];?>" class="btn-danger btn delPostBtn"><i class="fa fa-trash-o"></i>删除</button>
                                </td>
                            </tr>
                        <?php }
                    }else{
                        echo "<tr><td colspan='9'>搜索不到记录，请重试...</td></tr>";
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