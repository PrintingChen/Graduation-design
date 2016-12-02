<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>修改子版块</title>
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="js/sModuleModify.js"></script>
    <script>
        $(function(){
            //验证表单
            $("#form-mdfsmodule").formValidator();
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
    //管理员是否登录
    if (!($mid = manage_login_state($link))) {
        promptBox('您还未登录', 5, 'login.php');
        exit();
    }
    //将需要修改的子版块的id存放起来
    $sid = $_GET['sid'];
    //验证需要修改的子版块的对应的sid是否合法
    if (!isset($sid) || !is_numeric($sid)) { //判断id是否存在或为数字或数字字符串
        promptBox('传参错误', 5, 'sModuleList.php');
        exit();
    }
    //查询出传入sid对应修改的子版块的信息
    $sql_sm = "select * from sub_module where sid={$sid}";
    //查询所传入的sid是否存在此条记录
    if (!nums($link, $sql_sm)) {
        promptBox('此条子版块信息不存在', 5, 'sModuleList.php');
        exit();
    }
    //查询出子版块信息
    $data_sm = fetch_array(execute($link, $sql_sm));
    //查询出这个子版块所属的父版块信息
    $sql_pmi = "select * from parent_module where pid={$data_sm['tParenModuleId']}";
    $data_pmi = fetch_array(execute($link, $sql_pmi));
    //开始处理提交修改的信息
    if (isset($_POST['btn-mdfsm'])) {
        //判断修改的子版块名称是否已经存在
        $sql_smn = "select * from sub_module where smoduleName='{$_POST['smName']}' and sid!={$sid}";
        if (nums($link, $sql_smn)) {
            promptBox('修改失败，此条子版块信息已经存在', 5, 'sModuleModify.php?sid='.$sid.'');
            exit;
        }
        //验证描述内容
        $smoduleDesc = escape($link, $_POST['smoduleDesc']);
        //判断图片是否上传成功
        //写上服务器上文件系统的路径，而不是url地址
        $save_path='uploads'.date('/Y/m/d/');
        $upload = upload($save_path,'8M','mdfsmhead');
        if($upload['return']){
            $sql_upd = "update sub_module set smoduleName='{$_POST['smName']}', tParenModuleId={$_POST['tpmName']}, smodulePic='{$upload['save_path']}', smoduleDesc='{$smoduleDesc}' where sid={$_GET['sid']}";
            execute($link, $sql_upd);
            if (mysqli_affected_rows($link)) {
                promptBox('修改成功', 6,'sModuleList.php');
                exit;
            }else {
                promptBox('修改失败', 5,'sModuleModify.php?sid='.$sid.'');
               // exit();
            }
        }else{
            //当图片没有修改时
            $sql_upd = "update sub_module set smoduleName='{$_POST['smName']}', tParenModuleId={$_POST['tpmName']}, smoduleDesc='{$smoduleDesc}' where sid={$_GET['sid']}";
            execute($link, $sql_upd);
            if (mysqli_affected_rows($link)) {
                promptBox('修改成功', 6,'sModuleList.php');
                //exit;
            }else {
                promptBox('修改失败', 5,'sModuleModify.php?sid='.$sid.'');
                //exit();
            }
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
        <div class="panel-head"><strong><span class="fa fa-key"></span> 修改子版块 - <?php echo $data_sm['smoduleName']?></strong></div>
        <div class="body-content">
            <form action="sModuleModify.php?sid=<?php echo $_GET['sid']?>" method="post" id="form-mdfsmodule" enctype="multipart/form-data">
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">子版块图片：</label></div>
                    <div class="field">
                        <img src="<?php echo $data_sm['smodulePic'];?>" width="260" height="130">
                        <input type="file" name="mdfsmhead" class="form-control w50" id="mdfsmhead" style="margin-top: 5px;float:none;">
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">子版块名称：</label></div>
                    <div class="field">
                        <input type="text" name="smName" class="form-control w50" placeholder="请输入子版块名称"
                               value="<?php echo $data_sm['smoduleName'];?>"
                               data-notempty="true"
                               data-notempty-message="子版块名称不能为空"
                               data-regex="^[\u4e00-\u9fa5\w]{1,20}$"
                               data-regex-message="不能包含明感字符（如@、！等）"
                        />
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for="">所属父版块：</label></div>
                    <div class="field">
                        <select name="tpmName" id="tpmName" class="form-control w50">
                            <option value="<?php echo $data_pmi['pid'];?>"><?php echo $data_pmi['pmoduleName'];?></option>
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
                    <div class="info"><label for="">子版块描述：</label></div>
                    <div class="field">
                        <textarea name="smoduleDesc" id="smoduleDesc" class="form-control w50" rows="10"><?php echo $data_sm['smoduleDesc'];?></textarea>
                    </div>
                </div>
                <div class="form-group" style="overflow: hidden;">
                    <div class="info"><label for=""></label></div>
                    <div class="field">
                        <button name="btn-mdfsm" class="btn btn-info btn-custom" id="btn-mdfsm"><i class="fa fa-check-square-o custom"></i>提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--../主体部分-->
</body>
</html>