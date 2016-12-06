<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>审核帖子</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/postList.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="js/verifyPostStatus.js"></script>
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
    //帖子分页函数
    $sql_total = "select * from post where postStatus=1";
    $post_total = nums($link, $sql_total);
    $pagesize = 5;
    $page = page($post_total,$pagesize);
    //帖子信息
    $sql_post = "select * from post where postStatus=1 order by postId ASC {$page['limit']}";
    $res_post = execute($link, $sql_post);
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
            <div class="panel-head"><strong><span class="fa fa-list"></span> 帖子列表</strong><a href="postList.php" style="float: right;" title="返回上一层"><i class="fa fa-mail-reply"></i></a></div>
            <div class="body-content" style="padding-bottom: 0;">
                <table class="table table-hover" style="margin-bottom: 0;" id="plist">
                    <thead>
                        <th class="th1">ID</th>
                        <th class="th2">标题</th>
                        <th class="th3">版块名称</th>
                        <th class="th4">作者</th>
                        <th class="th5">回复</th>
                        <th class="th6">浏览</th>
                        <th class="th7">最后发表</th>
                        <th class="th9">审核状态</th>
                        <th class="th8">操作</th>
                    </thead>
                    <tbody>
                    <?php
                        if ($post_total){
                    ?>
                            <?php
                            //输出显示所有的帖子
                            while ($data_post = fetch_array($res_post)){
                                //查询出当前帖子的发帖人、所属子版块、回复数等信息
                                $sql_user = "select * from user where id={$data_post['postuid']}";
                                $data_user = fetch_array(execute($link, $sql_user));
                                //所属子版块
                                $sql_sm = "select * from sub_module where sid={$data_post['tsmoduleId']}";
                                $data_sm = fetch_array(execute($link, $sql_sm));
                                //回复数
                                $sql_rep = "select * from reply where tpostId={$data_post['postId']} ORDER BY rid DESC";
                                $data_rep = fetch_array(execute($link, $sql_rep));
                                $rep_total = nums($link, $sql_rep);
                                ?>
                                <tr>
                                    <td><input type="checkbox" value="<?php echo $data_post['postId']?>" id="check" name="verSelect[]"><?php echo $data_post['postId']?></td>
                                    <td class="ae"><a href="../postShow.php?postId=<?php echo $data_post['postId'];?>&sid=<?php echo $data_sm['sid'];?>"><?php echo $data_post['postTitle'];?></a></td>
                                    <td class="ae"><a href="../sModuleList.php?sid=<?php echo $data_sm['sid'];?>"><?php echo $data_sm['smoduleName'];?></a></td>
                                    <td class="ae"><a href="../userProfile.php?uid=<?php echo $data_user['id'];?>"><?php echo $data_user['name'];?></a></td>
                                    <td><?php echo $rep_total;?></td>
                                    <td><?php echo $data_post['times'];?></td>
                                    <td>
                                        <?php
                                        //如果没有回复的话则显示帖子的发表时间
                                        if (!empty($data_rep['rtime'])){
                                            echo $data_rep['rtime'];
                                        }else{
                                            echo $data_post['postTime'];
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        //帖子的状态
                                        if ($data_post['postStatus'] == 1){ //未验证通过
                                            echo "<span style='color:#D9534F;'>未通过</span>";
                                        }else{
                                            echo "<span style='color:#22CC77;'>通过</span>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button type="button" postId="<?php echo $data_post['postId'];?>" class="btn-primary btn verifyPBtn"><i class="fa fa-check-circle"></i>通过</button>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="9" style="text-align: left; padding-left: 13px;">
                                    <a href="#" class="btn btn-primary" id="selectAll">全选</a>
                                    <a href="#" class="btn btn-primary" id="selectReverse">反选</a>
                                    <button type="button" class="btn-primary btn" id="verpAll"><i class="fa fa-check-circle"></i>全部审核</button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9" style="position: relative;">
                                    <ul class="pagination" style="margin-bottom: 0;">
                                        <?php
                                        echo $page['html'];
                                        ?>
                                    </ul>
                                    <span style="position: absolute;margin-left: 20px;top:12px;color:#428bca;">第 <?php echo $_GET['page'];?> 页，共 <?php echo $page['totalPage'];?> 页</span>
                                </td>
                            </tr>
                    <?php
                        }else{
                    ?>
                            <tr>
                                <td colspan="9">暂无未审核帖子...</td>
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
<!--主体部分-->
</body>
</html>