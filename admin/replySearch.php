<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>回复搜索</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/userList.css">
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/replySearch.js"></script>
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
        if(!empty($_GET['post-person'])){
            $wherelist[] = "ruid={$_GET['post-person']}";
        }
        if(!empty($_GET['keywords'])){
            $wherelist[] = "rcontent like '%{$_GET['keywords']}%'";
        }
        //组装查询条件
        if(count($wherelist) > 0){
            $where = " where ".implode(' AND ' , $wherelist);
        }
        //判断查询条件
        //$where = isset($where) ? $where : '';
        if (isset($where)){
            $sql_search = "select * from reply {$where}";
            $res_search = execute($link, $sql_search);
            //查询记录数
            $nums = nums($link, $sql_search);
        }else{
            $sql_search = "select * from reply where rcontent=''";
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
            <div class="panel-head"><strong><span class="fa fa-list"></span> 回复搜索结果列表</strong><a href="replyList.php" style="float: right;" title="返回上一层"><i class="fa fa-mail-reply"></i></a></div>
            <div class="body-content" style="padding-bottom: 0;">
                <table class="table table-hover" style="margin-bottom: 0;">
                    <thead>
                    <th class="th1">ID</th>
                    <th class="th2">回复内容</th>
                    <th class="th3">回复内主题</th>
                    <th class="th4">回复作者</th>
                    <th class="th7">最后回复</th>
                    <th class="th8">操作</th>
                    </thead>
                    <tbody>
                    <?php
                    //输出查询到的所有回复
                    if ($nums){ //当搜索到记录时
                        while ($data_reply = fetch_array($res_search)){
                            //var_dump($data_post);exit;
                            //查询出回复信息对应的回帖作者，回复主题等信息
                            $sql_replyinfo = "select * from user u,post p where p.postId={$data_reply['tpostId']} and u.id={$data_reply['ruid']}";
                            $rep_count = nums($link, $sql_replyinfo);
                            $res_replyinfo = execute($link, $sql_replyinfo);
                            $data_replyinfo = fetch_array($res_replyinfo);
                    ?>
                            <tr>
                                <td><input type="checkbox" value="<?php echo $data_reply['rid'];?>" id="check" name="del[]">&nbsp;<?php echo $data_reply['rid'];?></td>
                                <td class="ae"><a href="#"><?php echo $data_reply['rcontent'];?></a></td>
                                <td class="ae"><a href="../postShow.php?postId=<?php echo $data_replyinfo['postId'];?>"><?php echo $data_replyinfo['postTitle'];?></a></td>
                                <td class="ae"><a href="#"><?php echo $data_replyinfo['name'];?></a></td>
                                <td>
                                    <?php
                                    //如果没有回复的话则显示帖子的发表时间
                                    if (!empty($data_reply['rtime'])){
                                        echo $data_reply['rtime'];
                                    }else{
                                        echo $data_replyinfo['postTime'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="replyModify.php?rid=<?php echo $data_reply['rid'];?>" class="btn-primary btn "><i class="fa fa-edit"></i>修改</a>
                                    <button type="button" rid="<?php echo $data_reply['rid'];?>" class="btn-danger btn delRepBtn"><i class="fa fa-trash-o"></i>删除</button>
                                </td>
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