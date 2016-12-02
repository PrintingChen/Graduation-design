<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>修改帖子</title>
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../kindeditor/kindeditor-all-min.js"></script>
    <script src="../kindeditor/lang/zh-CN.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="js/postModify.js"></script>
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
    if (!($mid = manage_login_state($link))) {
        promptBox('您还未登录', 5, 'login.php');
        exit;
    }
    //验证需要修改的帖子的对应的postId是否合法
    if (!isset($_GET['postId']) || !is_numeric($_GET['postId'])) { //判断postId是否存在或为数字或数字字符串
        promptBox('帖子传参错误', 5, 'postList.php');
        exit;
    }
    //验证帖子是否存在
    if (nums($link, "select * from post where postId={$_GET['postId']}") !=1){
        promptBox('帖子信息不存在', 5, 'postList.php');
        exit;
    }
    //需要修改的帖子相关信息
    $sql_msg = "select * from post p,user u,sub_module sm where postId={$_GET['postId']} and u.id=p.postuid and sid=tsmoduleId";
    $data_msg = fetch_array(execute($link, $sql_msg));
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
    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="fa fa-key"></span> 修改帖子 - <?php echo $data_msg['postTitle'];?></strong></div>
        <div class="body-content">
            <form id="form-mdfsmodule">
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">标题：</label></div>
                    <div class="field">
                        <input type="text" name="postTitle" class="form-control w50" id="postTitle" placeholder="请输标题名称"
                               value="<?php echo $data_msg['postTitle'];?>"
                               data-notempty="true"
                               data-notempty-message="标题名称不能为空"
                               data-regex="^[\u4e00-\u9fa5\w]{1,20}$"
                               data-regex-message="不能包含明感字符（如@、！等）"
                        />
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">作者：</label></div>
                    <div class="field">
                        <input type="text" class="form-control w50" value="<?php echo $data_msg['name'];?>" disabled>
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">所属版块：</label></div>
                    <div class="field">
                        <select name="selSModule" id="selSModule" class="form-control w50">
                            <option value="">请选择一个子版块</option>
                            <?php
                            //输出子版块的名称
                            $sql_sm = "select * from sub_module";
                            $res_sm = execute($link, $sql_sm);
                            while ($data_sm = fetch_array($res_sm)) {
                                if (isset($_GET['sid']) && $_GET['sid'] == $data_sm['sid'] ) {
                                    echo "<option selected value='{$data_sm['sid']}'>{$data_sm['smoduleName']}</option>";
                                }else{
                                    echo "<option value='{$data_sm['sid']}'>{$data_sm['smoduleName']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">帖子内容：</label></div>
                    <div class="field">
                        <textarea name="postContent" id="smoduleDesc" class="form-control w50">
                            <?php echo $data_msg['postContent'];?>
                        </textarea>
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for=""></label></div>
                    <div class="field">
                        <button type="button" name="btn-mdfsm" postId="<?php echo $_GET['postId'];?>" class="btn btn-info btn-custom" id="btn-mdfsm"><i class="fa fa-check-square-o custom"></i>提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--../主体部分-->
</body>
</html>
<script>
</script>