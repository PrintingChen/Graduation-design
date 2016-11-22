<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>编辑用户</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/userEdit.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="../layui/layui.js"></script>
    <script src="../layui/laydate/laydate.js"></script>
    <script src="../js/formValidator.js"></script>
    <script src="js/admin-common.js"></script>
    <script>
        $(function () {
            //edit
            /*$("#editUser").on("click", function () {
                $.ajax({
                    type: "post",
                    url: "userEditHandle.php",
                    data:　$("#editUserform").serialize(),
                    success: function (response) {
                        console.log(response);
                    }
                });
            });*/
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
    if (!manage_login_state($link)) {
        promptBox('您还未登录！', 5, 'login.php');
        exit();
    }
    //将需要修改的用户的id存放起来
    $uid = $_GET['uid'];
    //验证需要修改的用户的对应的uid是否合法
    if (!isset($uid) || !is_numeric($uid)) { //判断uid是否存在或为数字或数字字符串
        promptBox('传参错误', 5, 'userList.php');
        exit();
    }
    //查询出传入uid对应修改的用户的信息
    $sql_user = "select * from user where id={$uid}";
    //查询所传入的uid是否存在此条记录
    if (!nums($link, $sql_user)) {
        promptBox('此用户信息不存在', 5, 'userList.php');
        exit();
    }
    //查询出用户信息
    $data_user = fetch_array(execute($link, $sql_user));
    //用户的头像地址
    if (!empty($data_user['photo'])){
        $imgurl = "../".$data_user['photo'];
    }else{
        $imgurl = "../img/noavatar_middle.gif";
    }
    //更新数据
    if (isset($_POST['editUser'])){
        //密码需要更新时
        if (!empty($_POST['repasswoerd'])){
            $sql_upd = "update user set reallyName='{$_POST['reallyName']}', psw='{$_POST['repassword']}', 
                        sex='{$_POST['sex']}', birthday='{$_POST['birthday']}',
                        email='{$_POST['email']}', qq='{$_POST['qq']}', website='{$_POST['website']}',
                        fixedTel='{$_POST['fixedTel']}', phone='{$_POST['phone']}',
                        school='{$_POST['school']}', degree='{$_POST['degree']}', 
                        company='{$_POST['company']}', 	profession='{$_POST['profession']}',
                        job='{$_POST['job']}', income='{$_POST['income']}' where id={$uid}";
            execute($link, $sql_upd);
            if (mysqli_affected_rows($link)) {
                promptBox('修改成功', 6,'userList.php');
                //exit;
            }else {
                promptBox('修改失败', 5,'userEdit.php?uid='.$uid.'');
                //exit();
            }
        }else{
            //密码不需要更新时
            $sql_upd = "update user set reallyName='{$_POST['reallyName']}', 
                        sex='{$_POST['sex']}', birthday='{$_POST['birthday']}',
                        email='{$_POST['email']}', qq='{$_POST['qq']}', website='{$_POST['website']}',
                        fixedTel='{$_POST['fixedTel']}', phone='{$_POST['phone']}',
                        school='{$_POST['school']}', degree='{$_POST['degree']}', 
                        company='{$_POST['company']}', 	profession='{$_POST['profession']}',
                        job='{$_POST['job']}', income='{$_POST['income']}' where id={$uid}";
            execute($link, $sql_upd);
            if (mysqli_affected_rows($link)) {
                promptBox('修改成功', 6,'userList.php');
                //exit;
            }else {
                promptBox('修改失败', 5,'userEdit.php?uid='.$uid.'');
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
    <form action="userEdit.php?uid=<?php echo $uid;?>" id="editUserform" method="post">
        <div class="panel admin-panel">
            <div class="panel-head"><strong><span class="fa fa-edit"></span> 编辑用户 - <?php echo $data_user['name']?></strong><a href="userList.php" style="float: right;" title="返回上一层"><i class="fa fa-mail-reply"></i></a></div>
            <div class="body-content" style="padding-bottom: 0;">
                <table class="table">
                    <tr>
                        <td class="w20">用户名：</td>
                        <td><?php echo $data_user['name']?></td>
                    </tr>
                    <tr>
                        <td class="w20">密码重置：</td>
                        <td>
                            <input type="password" name="repasswoerd" id="repasswoerd" class="form-control w50" style="margin-right: 30px;">
                            <span style="color: #999;">如果不更改密码此处请留空</span>
                        </td>
                    </tr>
                    <tr>
                        <td>权限：</td>
                        <td>
                            <?php if($data_user['level'] != 0){ echo "版主";}else{ echo "普通用户";}?>
                        </td>
                    </tr>
                    <tr>
                        <td>真实姓名：</td>
                        <td>
                            <input type="text" name="reallyName" value="<?php echo $data_user['reallyName']?>" class="form-control w50"
                                   data-regex="^[\u4e00-\u9fa5\w]{2,10}$"
                                   data-regex-message="用户名在2-10字符之间，不能包含明感字符（如@、！等）"
                            >
                        </td>
                    </tr>
                    <tr>
                        <td>性别：</td>
                        <td>
                            <select name="sex" id="sex" class="form-control w50">
                                <option value="">
                                    <?php
                                        if($data_user['sex'] == 1){
                                            echo "男";
                                        }else if($data_user['sex'] == 0){
                                            echo "女";
                                        }else if($data_user['sex'] == 2){
                                            echo "保密";
                                        }
                                    ?>
                                </option>
                                <option value="2">保密</option>
                                <option value="1">男</option>
                                <option value="0">女</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>生日：</td>
                        <td>
                            <input onclick="laydate()" name="birthday" value="<?php echo $data_user['birthday']?>" class=" form-control w50">
                        </td>
                    </tr>
                    <tr>
                        <td>Email：</td>
                        <td>
                            <input type="text" name="email" value="<?php echo $data_user['email']?>" class="form-control w50">
                        </td>
                    </tr>
                    <tr>
                        <td>QQ：</td>
                        <td>
                            <input type="text" name="qq" value="<?php echo $data_user['qq']?>" class="form-control w50">
                        </td>
                    </tr>
                    <tr>
                        <td>主页地址：</td>
                        <td>
                            <input type="text" name="website" value="<?php echo $data_user['website']?>" class="form-control w50">
                        </td>
                    </tr>
                    <tr>
                        <td>固定电话：</td>
                        <td>
                            <input type="text" name="fixedTel" value="<?php echo $data_user['fixedTel']?>" class="form-control w50">
                        </td>
                    </tr>
                    <tr>
                        <td>移动电话：</td>
                        <td>
                            <input type="text" name="phone" value="<?php echo $data_user['phone']?>" class="form-control w50">
                        </td>
                    </tr>
                    <tr>
                        <td>毕业学校：</td>
                        <td>
                            <input type="text" name="school" value="<?php echo $data_user['school']?>" class="form-control w50">
                        </td>
                    </tr>
                    <tr>
                        <td>学历：</td>
                        <td>
                            <select name="degree" id="degree" class="form-control w50">
                                <option value=""><?php echo $data_user['degree']?></option>
                                <option value="博士">博士</option>
                                <option value="硕士">硕士</option>
                                <option value="本科">本科</option>
                                <option value="专科">专科</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>所在公司：</td>
                        <td>
                            <input type="text" name="company" value="<?php echo $data_user['company']?>" class="form-control w50">
                        </td>
                    </tr>
                    <tr>
                        <td>职业：</td>
                        <td>
                            <input type="text" name="profession" value="<?php echo $data_user['profession']?>" class="form-control w50">
                        </td>
                    </tr>
                    <tr>
                        <td>职位：</td>
                        <td>
                            <input type="text" name="job" value="<?php echo $data_user['job']?>" class="form-control w50">
                        </td>
                    </tr>
                    <tr>
                        <td>年收入：</td>
                        <td>
                            <input type="text" name="income" value="<?php echo $data_user['income']?>" class="form-control w50">
                        </td>
                    </tr>
                    <tr>
                        <td>发帖数：</td>
                        <td>123</td>
                    </tr>
                    <tr>
                        <td>注册 IP:</td>
                        <td><?php echo $_SERVER['REMOTE_ADDR'];?></td>
                    </tr>
                    <tr>
                        <td>注册时间：</td>
                        <td><?php echo $data_user['registerTime']?></td>
                    </tr>
                    <tr>
                        <td>上次登录时间：</td>
                        <td><?php echo $data_user['lastLogin']?></td>
                    </tr>
                    <tr>
                        <td>上次发表时间：</td>
                        <td>2016年10月27日 16:52:20</td>
                    </tr>
                    <tr>
                        <td>上次访问 IP：</td>
                        <td>192.168.0.1</td>
                    </tr>
                    <tr>
                        <td>
                            <button name="editUser" class="btn btn-primary" id="editUser"><i class="fa fa-check-square-o custom"></i>提交</button>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
</div>
<!--主体部分-->
</body>
</html>