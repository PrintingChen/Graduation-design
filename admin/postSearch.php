<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>帖子搜索</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/userList.css">
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
        if(!empty($_GET['keywords'])){
            $wherelist[] = "postTitle like '%{$_GET['keywords']}%'";
        }
        //组装查询条件
        if(count($wherelist) > 0){
            $where = " where ".implode(' AND ' , $wherelist);
        }
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
                        <th class="th8">操作</th>
                    </thead>
                    <tbody>
                    <?php
                    //输出查询到的所有帖子
                    if ($nums){ //当搜索到记录时
                        while ($data_post = fetch_array($res_search)){
                            //var_dump($data_post);exit;
                            //查询出子版块对应的回复信息，发帖作者
                            $sql_postinfo = "select * from user u,reply rep,sub_module sm where rep.tpostId={$data_post['postId']} and sm.sid={$data_post['tsmoduleId']} and u.id={$data_post['postuid']}";
                            $rep_count = nums($link, $sql_postinfo);
                            $res_postinfo = execute($link, $sql_postinfo);
                            $data_postinfo = fetch_array($res_postinfo);
                    ?>
                            <tr>
                                <td><input type="checkbox" value="<?php echo $data_post['postId'];?>" id="check" name="del[]">&nbsp;<?php echo $data_post['postId'];?></td>
                                <td class="ae"><a href="../postShow.php?postId=<?php echo $data_post['postId'];?>&sid=<?php echo $data_postinfo['sid'];?>"><?php echo $data_post['postTitle'];?></a></td>
                                <td class="ae"><a href="../sModuleList.php?sid=<?php echo $data_postinfo['sid'];?>"><?php echo $data_postinfo['smoduleName'];?></a></td>
                                <td><?php echo $data_postinfo['name'];?></td>
                                <td><?php echo $rep_count;?></td>
                                <td><?php echo $data_post['times'];?></td>
                                <td><?php echo $data_post['updateTime'];?></td>
                                <td>
                                    <a href="postModify.php?postId=<?php echo $data_post['postId'];?>&sid=<?php echo $data_postinfo['sid'];?>" class="btn-primary btn"><i class="fa fa-edit"></i>修改</a>
                                    <button type="button" postId="<?php echo $data_post['postId'];?>" class="btn-danger btn delPostBtn"><i class="fa fa-trash-o"></i>删除</button>
                                </td>
                            </tr>
                        <?php }
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