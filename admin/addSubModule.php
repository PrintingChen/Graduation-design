<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加子版块</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/addUser.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="js/addSubModule.js"></script>
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
    //处理提交的数据
    if (isset($_POST['addSModule'])){
        //引入验证文件
        include 'inc/addSubModule.func.php';
        //验证版块名称
        check_smodule_name($link, $_POST['smoduleName']);
        //验证描述内容
        $smoduleDesc = escape($link, $_POST['smoduleDesc']);
        //查询提交的父版块是否已存在
        $sql_sm = "select smoduleName from sub_module where smoduleName='{$_POST['smoduleName']}'";
        if (nums($link, $sql_sm) == 1) {
            promptBox('此子版块已存在，添加失败', 5, 'addSubModule.php');
            exit;
        }
        //插入子版块
        //写上服务器上文件系统的路径，而不是url地址
        $save_path='uploads'.date('/Y/m/d/');
        $upload = upload($save_path,'8M','smpic');
        if($upload['return']){
            $sql_ins = "insert into sub_module(smoduleName, tParenModuleId, smodulePic, smoduleDesc) values('{$_POST['smoduleName']}', '{$_POST['tpmoduleName']}', '{$upload['save_path']}', '{$smoduleDesc}')";
            execute($link, $sql_ins);
            if (mysqli_affected_rows($link)) {
                promptBox('添加成功', 6,'addSubModule.php');
            }else {
                promptBox('添加失败', 5,'addSubModule.php');
                exit();
            }
            /*$query="update sub_module set smodulePic='{$upload['save_path']}'";
            execute($link, $query);
            if(mysqli_affected_rows($link)==1){
                promptBox("头像上传成功", 6, "addSubModule.php");
            }else{
                promptBox("头像上传失败", 5, "addSubModule.php");
            }*/
        }else{
            promptBox("头像上传失败", 5, "addSubModule.php");
            exit();
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
    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="fa fa-plus-square-o"></span> 添加子版块</strong></div>
        <div class="body-content">
            <form method="post" id="form-smodule" enctype="multipart/form-data">
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">选择所属父版块：</label></div>
                    <div class="field">
                        <select class="form-control w50" name="tpmoduleName" id="tpmoduleName">
                        <?php
                        //查询出所有的父版块
                        $sql_pmn = "select * from parent_module";
                        $res_pmn = execute($link, $sql_pmn);
                        while ($data_pmn = fetch_array($res_pmn)){
                            echo "<option value='{$data_pmn['pid']}'>{$data_pmn['pmoduleName']}</option>";
                        }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">子版块名称：</label></div>
                    <div class="field">
                        <input type="text" class="form-control w50" id="smoduleName" name="smoduleName" placeholder="请输入子版块名称"
                               data-notempty="true"
                               data-notempty-message="子版块名称不能为空"
                               data-regex="^[\u4e00-\u9fa5\w]{1,20}$"
                               data-regex-message="不能包含明感字符（如@、！等）"
                        />
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">子版块图片：</label></div>
                    <div class="field">
                        <input type="file" class="form-control w50" id="smpic" name="smpic"/>
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">子版块描述：</label></div>
                    <div class="field">
                        <textarea class="form-control w50" name="smoduleDesc" id="smoduleDesc" placeholder="请输入对子版块的描述" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for=""></label></div>
                    <div class="field">
                        <button class="btn btn-info btn-custom" type="submit" name="addSModule"><i class="fa fa-check-square-o custom"></i>提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>