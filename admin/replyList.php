<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>回复列表</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/postList.css">
    <link rel="stylesheet" href="css/replyList.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="js/replyList.js"></script>
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
    //回复分页函数
    $sql_total = "select * from reply";
    $reply_total = nums($link, $sql_total);
    $pagesize = 5;
    $page = page($reply_total,$pagesize);
    //回复信息
    $sql_reply = "select * from reply order by rid ASC {$page['limit']}";
    $res_reply = execute($link, $sql_reply);
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
    <form id="sml" action="replySearch.php">
        <div class="panel admin-panel">
            <div class="panel-head"><strong><span class="fa fa-list"></span> 回复列表</strong></div>
            <div class="padding border-bottom">
                <ul class="search" style="padding-left: 10px;">
                    <li>按作者名称：</li>
                    <li>
                        <select name="post-person" id="pmName" class="form-control">
                            <option value="">选择作者</option>
                            <?php
                            //输出所有的作者
                            $sql_user_d = "select * from user";
                            $res_user_d = execute($link, $sql_user_d);
                            while ($data_user_d = fetch_array($res_user_d)){
                                echo "<option value='{$data_user_d['id']}'>{$data_user_d['name']}</option>";
                            }
                            ?>
                        </select>
                    </li>
                    <li>按关键字：</li>
                    <li>
                        <input type="text" name="keywords" placeholder="输入关键字" class="form-control">
                    </li>
                    <li>
                        <button name="search" class="btn btn-default button btn-c"><i class="fa fa-search custom"></i>搜索</button>
                    </li>
                </ul>
            </div>
            <div class="body-content" style="padding-bottom: 0;">
                <table class="table table-hover" style="margin-bottom: 0;" id="plist">
                    <thead>
                        <th class="th1">ID</th>
                        <th class="th2">回复内容</th>
                        <th class="th3">回复主题</th>
                        <th class="th4">回复作者</th>
                        <th class="th7">最后回复</th>
                        <th class="th8">操作</th>
                    </thead>
                    <tbody>
                    <?php
                    //输出显示所有的回复信息
                    while ($data_reply = fetch_array($res_reply)){
                        //查询出当前帖子的回帖人、所属帖子、等信息
                        $rep_msg = "select * from user u, post p where u.id={$data_reply['ruid']} and p.postId={$data_reply['tpostId']}";
                        $data_msg = fetch_array(execute($link, $rep_msg));
                    ?>
                        <tr>
                            <td><input type="checkbox" value="<?php echo $data_reply['rid'];?>" id="check" name="delSelect[]"><?php echo $data_reply['rid'];?></td>
                            <td class="ae"><a href="#"><?php echo $data_reply['rcontent'];?></a></td>
                            <td class="ae"><a href="../postShow.php?postId=<?php echo $data_msg['postId'];?>"><?php echo $data_msg['postTitle'];?></a></td>
                            <td class="ae"><a href="#"><?php echo $data_msg['name'];?></a></td>
                            <td>
                                <?php
                                //如果没有回复的话则显示帖子的发表时间
                                if (!empty($data_reply['rtime'])){
                                    echo $data_reply['rtime'];
                                }else{
                                    echo $data_msg['postTime'];
                                }
                                ?>
                            </td>
                            <td>
                                <a href="replyModify.php?rid=<?php echo $data_reply['rid'];?>" class="btn-primary btn"><i class="fa fa-edit"></i>修改</a>
                                <button type="button" rid="<?php echo $data_reply['rid'];?>" class="btn-danger btn delPostBtn"><i class="fa fa-trash-o"></i>删除</button>
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
                            <span style="position: absolute;margin-left: 20px;top:12px;color:#428bca;">第 <?php echo $_GET['page'];?> 页，共 <?php echo $page['totalPage'];?> 页</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
<!--主体部分-->
</body>
</html>