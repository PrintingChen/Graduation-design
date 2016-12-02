<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>修改父版块</title>
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="js/pModuleModify.js"></script>
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
        exit();
    }
    //将需要修改的父版块的id存放起来
    $pid = $_GET['pid'];
    //验证需要修改的父版块的对应的pid是否合法
    if (!isset($pid) || !is_numeric($pid)) { //判断id是否存在或为数字或数字字符串
        promptBox('传参错误', 5, 'pModuleList.php');
        exit();
    }
    //查询出传入pid对应修改的父版块的信息
    $sql_pm = "select * from parent_module where pid={$pid}";
    //查询所传入的pid是否存在此条记录
    if (!nums($link, $sql_pm)) {
        promptBox('此条父版块信息不存在', 5, 'pModuleList.php');
        exit();
    }
    //查询出父版块信息
    $data_pm = fetch_array(execute($link, $sql_pm));
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
        <div class="panel-head"><strong><span class="fa fa-key"></span> 修改父版块 - <?php echo $data_pm['pmoduleName']?></strong><a
                href="pModuleList.php" style="float: right;"><i class="fa fa-mail-reply"></i></a></div>
        <div class="body-content">
        <!-- action="pModuleModify.php?pid=<?php //echo $_GET['pid']?>" method="post"-->
            <form id="form-mdfsmodule">
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">父版块名称：</label></div>
                    <div class="field">
                        <input type="text" name="pmName" class="form-control w50" placeholder="请输入父版块名称"
                               value="<?php echo $data_pm['pmoduleName'];?>"
                               data-notempty="true"
                               data-notempty-message="父版块名称不能为空"
                               data-regex="^[\u4e00-\u9fa5\w]{1,20}$"
                               data-regex-message="不能包含明感字符（如@、！等）"
                        />
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">版主名称：</label></div>
                    <div class="field">
                        <select name="moderName" id="moderName" class="form-control w50">
                        <?php
                            //查询出所有的用户，以便后面选择一个作为版主
                            $sql_user = "select * from user";
                            $res_user = execute($link, $sql_user);
                            $str = "<option value='0'>无</option>";
                            while ($data_user = fetch_array($res_user)){
                                $str .= "<option value='{$data_user['id']}'>{$data_user['name']}</option>";
                            }
                            //查询当前父版块是否存在版主
                            if ($data_pm['moderatorId']){//存在
                                //查询出当前父版块版主的信息
                                $sql_curr = "select * from user where id={$data_pm['moderatorId']}";
                                $data_curr = fetch_array(execute($link, $sql_curr));
                                echo "<option value='{$data_curr['id']}'>{$data_curr['name']}</option>".$str;
                            }else{
                                echo "<option value='0'>暂无版主</option>.$str";
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">父版块描述：</label></div>
                    <div class="field">
                        <textarea name="pmoduleDesc" id="pmoduleDesc" class="form-control w50" rows="10"><?php echo $data_pm['pmoduleDesc'];?></textarea>
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for=""></label></div>
                    <div class="field">
                        <button type="button" pid="<?php echo $pid;?>" class="btn btn-info btn-custom" id="btn-mdfpm"><i class="fa fa-check-square-o custom"></i>提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--../主体部分-->
</body>
</html>