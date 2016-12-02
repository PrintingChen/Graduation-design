<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加父版块</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/addUser.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="js/addParentModule.js"></script>
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
        <div class="panel-head"><strong><span class="fa fa-plus-square-o"></span> 添加父版块</strong></div>
        <div class="body-content">
            <form id="form-pmodule">
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">父版块名称：</label></div>
                    <div class="field">
                        <input type="text" class="form-control w50" id="pmoduleName" name="pmoduleName" placeholder="请输入父版块名称"
                               data-notempty="true"
                               data-notempty-message="父版块名称不能为空"
                               data-regex="^[\u4e00-\u9fa5\w]{1,20}$"
                               data-regex-message="不能包含明感字符（如@、！等）"
                        />
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">添加版主：</label></div>
                    <div class="field">
                        <select name="addModerator" id="addModerator" class="form-control w50">
                            <option value="0">请选择一个作为版主（可选）</option>
                        <?php
                            //查询出所有的会员
                            $sql_user = "select * from user";
                            $res_user = execute($link, $sql_user);
                            while ($data_user = fetch_array($res_user)){
                                echo "<option value='{$data_user['id']}'>{$data_user['name']}</option>";
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">描述：</label></div>
                    <div class="field">
                        <textarea class="form-control w50" name="pmoduleDesc" id="pmoduleDesc" placeholder="请输入对父版块的描述" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for=""></label></div>
                    <div class="field">
                        <button class="btn btn-info btn-custom" type="button" id="addPModule"><i class="fa fa-check-square-o custom"></i>提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>