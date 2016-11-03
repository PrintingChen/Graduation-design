<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once 'inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //判断当前是否为登录状态
    $member_id = login_state($link);
    //查询出当前用户的信息
    $sql_info = "select * from user where id='{$member_id}'";
    $res_info = fetch_array(execute($link, $sql_info));
    //引入处理登录信息
    include_once "inc/handlerLogin.php";
    //处理提交的基本资料的数据
    if (isset($_POST['subBasic'])){
        //将提交的数据插入到数据库当中
        $birthday = $_POST['year']."年".$_POST['month']."月".$_POST['day']."日";
        $homeplace = $_POST['birprov'].$_POST['bircity'].$_POST['birdistrict'];
        $sql_ins = "update user set reallyName='{$_POST['reallyName']}',sex='{$_POST['sex']}',birthday='{$birthday}',homeplace='{$homeplace}',bloodType='{$_POST['bloodtype']}' where id='{$member_id}'";
        execute($link, $sql_ins);
        if (mysqli_affected_rows($link)) {
            promptBox("数据更新成功", 6, "setProfile.php");
        }else {
            promptBox("数据更新失败", 5, "setProfile.php");
        }
    }
    //处理提交的联系方式的数据
    if (isset($_POST['subContact'])){
        //将提交的数据插入到数据库当中
        $sql_contact = "update user set fixedTel='{$_POST['fixed-tel']}',phone='{$_POST['phone']}',qq='{$_POST['qq']}',website='{$_POST['homepage']}' where id='{$member_id}'";
        execute($link, $sql_contact);
        if (mysqli_affected_rows($link)) {
            promptBox("数据更新成功", 6, "setProfile.php");
        }else {
            promptBox("数据更新失败", 5, "setProfile.php");
        }
    }
    //处理提交的教育情况的数据
    if (isset($_POST['subEducation'])){
        //将提交的数据插入到数据库当中
        $sql_edu = "update user set school='{$_POST['school']}',degree='{$_POST['degrees']}' where id='{$member_id}'";
        execute($link, $sql_edu);
        if (mysqli_affected_rows($link)) {
            promptBox("数据更新成功", 6, "setProfile.php");
        }else {
            promptBox("数据更新失败", 5, "setProfile.php");
        }
    }
    //处理提交的工作情况的数据
    if (isset($_POST['subWorking'])){
    //将提交的数据插入到数据库当中
    $sql_working = "update user set company='{$_POST['company']}',profession='{$_POST['profession']}',job='{$_POST['job']}',income='{$_POST['income']}' where id='{$member_id}'";
    execute($link, $sql_working);
    if (mysqli_affected_rows($link)) {
        promptBox("数据更新成功", 6, "setProfile.php");
    }else {
        promptBox("数据更新失败", 5, "setProfile.php");
    }
}
    //处理提交的修改密码的数据
    if (isset($_POST['subMdfpsw'])){
    //将提交的数据插入到数据库当中
    check_vcode($_POST['yzm'], $_SESSION['code']);
    $opsw = md5($_POST['opsw']);
    $npsw = md5($_POST['npsw']);
    //将提交过来的旧密码比对数据库里面的密码是否一致
    $sql_compare = "select * from user where id='{$member_id}' and psw='{$opsw}'";
    if (nums($link, $sql_compare)) {
        //开始更新密码
        $sql_mdfpsw = "update user set psw='{$npsw}' where id='{$member_id}'";
        execute($link, $sql_mdfpsw);
        if (mysqli_affected_rows($link)) {
            //密码修改成功后将原来登录的信息cookie删除掉
            setcookie('bs[userName]', '', time()-36000);
            setcookie('bs[psw]', '', time()-36000);
            promptBox("数据更新成功，请重新登录", 6, "index.php");
        }else {
            promptBox("数据更新失败", 5, "setProfile.php");
        }
    }else{
        skip('setProfile.php', 'error', '旧密码错误^_^');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>完善个人资料</title>
    <link rel="stylesheet" href="font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/setProfile.css">
    <script src="js/jquery-1.12.2.min.js"></script>
    <script src="css/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/formValidator.js"></script>
    <script src="js/area.js"></script>
    <script src="js/setProfile.js"></script>
</head>
<body>
<!--引入头部-->
<?php include_once "inc/header.inc.php"?>
<!--引入导航-->
<?php include_once "inc/nav.inc.php"?>
<div id="position">
    <div class="container">
        <i class="fa fa-map-marker"></i>
        <a href="#"><?php echo $res_info['name'];?></a>
        >>
        <a href="register.php">完善个人资料</a>
    </div>
</div>
<div id="setprofile">
    <div class="container">
        <div class="col-md-2 col-sm-2" id="navbar-left">
            <h2>设置</h2>
            <ul>
                <li><a href="#">修改头像</a></li>
                <li><a href="#">个人资料</a></li>
                <li><a href="#">密码安全</a></li>
            </ul>
        </div>
        <div class="col-md-10 col-sm-10" style="height: 670px; position: relative;">
            <div class="head-pic" style="display: block;">
                <form action="" method="post" id="upload-pic">
                    <div>
                        <h3 class="desc">当前我的头像</h3>
                        <p style="font-size: 12px">如果您还没有设置自己的头像，系统会显示为默认头像，您需要自己上传一张新照片来作为自己的个人头像</p>
                    </div>
                    <div class="head"><img src="img/noavatar_big.gif" alt=""></div>
                    <div class="set-headpic">
                        <h3 class="desc">设置我的新头像</h3>
                        <p style="font-size: 12px">请选择一个新照片进行上传编辑。</p>
                    </div>
                    <div class="upload-area">
                        <i class="fa fa-plus-square-o fa-5x"></i>
                        <input type="file" name="upload" id="upload">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary" id="upload-btn"><i class="fa fa-check-square-o"></i>提交</button>
                    </div>
                </form>
            </div>
            <div class="profile-info">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#basic-data" data-toggle="tab">基本资料</a></li>
                    <li><a href="#contact-info" data-toggle="tab">联系方式</a></li>
                    <li><a href="#education" data-toggle="tab">教育情况</a></li>
                    <li><a href="#working" data-toggle="tab">工作情况</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade in active" id="basic-data">
                        <form action="" method="post" id="form-basic">
                            <div class="form-group">
                                <div class="col-md-2"><label for="">用户名：</label></div>
                                <div class="col-md-10 w40">
                                    <?php echo $res_info['name'];?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">真实姓名：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="reallyName" id="reallyName" class="form-control" value="<?php echo $res_info['reallyName'];?>" placeholder="<?php echo $res_info['reallyName'];?>">
                                    </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">性别：</label></div>
                                <div class="col-md-10 w40">
                                    <select name="sex" id="sex">
                                        <option value="<?php echo $res_info['sex']; ?>"><?php echo $res_info['sex']; ?></option>
                                        <option value="保密">保密</option>
                                        <option value="男">男</option>
                                        <option value="女">女</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">生日：</label></div>
                                <div class="col-md-10 w40">
                                    <select name="year" id="year">
                                        <option value="">年</option>
                                    </select>
                                    <select name="month" id="month">
                                        <option value="">月</option>
                                    </select>
                                    <select name="day" id="day">
                                        <option value="">日</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">出生地：</label></div>
                                <div class="col-md-10 w40">
                                    <select name="birprov" id="birprov"></select>
                                    <select name="bircity" id="bircity"></select>
                                    <select name="birdistrict" id="birdistrict"></select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">血型：</label></div>
                                <div class="col-md-10 w40">
                                    <select name="bloodtype" id="bloodtype">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="O">O</option>
                                        <option value="AB">AB</option>
                                        <option value="other">其他</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for=""></label></div>
                                <div class="col-md-10 w40">
                                    <button type="submit" name="subBasic" class="btn btn-primary"><i class="fa fa-check-square-o" style="margin-right: 3px;"></i>提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="contact-info">
                        <form action="" method="post" id="form-contact">
                            <div class="form-group">
                                <div class="col-md-2"><label for="">用户名：</label></div>
                                <div class="col-md-10 w40">
                                    <?php echo $res_info['name'];?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">固定电话：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="fixed-tel" value="<?php echo $res_info['fixedTel'];?>" placeholder="<?php echo $res_info['fixedTel'];?>" id="fixed-tel" class="form-control"
                                           data-regex="^\d{4}-\d{7}$"
                                           data-regex-message="格式不匹配，如（0778-3142659）"
                                    >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">手机：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="phone" value="<?php echo $res_info['phone'];?>" placeholder="<?php echo $res_info['phone'];?>" id="phone" class="form-control"
                                           data-regex="^1\d{10}$"
                                           data-regex-message="格式不匹配，如（13378942675）"
                                    >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">QQ：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="qq" value="<?php echo $res_info['qq'];?>" placeholder="<?php echo $res_info['qq'];?>" id="qq" class="form-control"
                                           data-regex="^\d{5,10}$"
                                           data-regex-message="格式不匹配，如（19873468）"
                                    >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">个人主页：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="homepage" value="<?php echo $res_info['website'];?>" placeholder="<?php echo $res_info['website'];?>" id="homepage" class="form-control" value="http://">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for=""></label></div>
                                <div class="col-md-10 w40">
                                    <button type="submit" name="subContact" class="btn btn-primary"><i class="fa fa-check-square-o" style="margin-right: 3px;"></i>提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="education">
                        <form action="" method="post" id="form-education">
                            <div class="form-group">
                                <div class="col-md-2"><label for="">用户名：</label></div>
                                <div class="col-md-10 w40">
                                    <?php echo $res_info['name'];?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">毕业学校：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="school" value="<?php echo $res_info['school'];?>" placeholder="<?php echo $res_info['school'];?>" id="school" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">学历：</label></div>
                                <div class="col-md-10 w40">
                                    <select name="degrees" id="degrees">
                                        <option value="<?php echo $res_info['degree']?>"><?php echo $res_info['degree']?></option>
                                        <option value="博士">博士</option>
                                        <option value="硕士">硕士</option>
                                        <option value="本科">本科</option>
                                        <option value="专科">专科</option>
                                        <option value="中学">中学</option>
                                        <option value="小学">小学</option>
                                        <option value="其他">其他</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for=""></label></div>
                                <div class="col-md-10 w40">
                                    <button type="submit" name="subEducation" class="btn btn-primary"><i class="fa fa-check-square-o" style="margin-right: 3px;"></i>提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="working">
                        <form action="" method="post" id="form-working">
                            <div class="form-group">
                                <div class="col-md-2"><label for="">用户名：</label></div>
                                <div class="col-md-10 w40">
                                    <?php echo $res_info['name'];?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">公司：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="company" value="<?php echo $res_info['company'];?>" placeholder="<?php echo $res_info['company'];?>" id="company" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">职业：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="profession" value="<?php echo $res_info['profession'];?>" placeholder="<?php echo $res_info['profession'];?>" id="profession" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">职位：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="job" value="<?php echo $res_info['job'];?>" placeholder="<?php echo $res_info['job'];?>" id="job" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">年收入：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="income" value="<?php echo $res_info['income'];?>" placeholder="<?php echo $res_info['income'];?>" id="income" class="form-control"
                                           data-regex="^[^0-][0-9.]+$"
                                           data-regex-message="格式不匹配，不能为负数"
                                    >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for=""></label></div>
                                <div class="col-md-10 w40">
                                    <button type="submit" name="subWorking" class="btn btn-primary"><i class="fa fa-check-square-o" style="margin-right: 3px;"></i>提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mdf-psw">
                <p>您必须填写原密码才能修改下面的资料</p>
                <form action="" method="post" id="form-mdfpsw">
                    <div class="form-group">
                        <div class="col-md-2"><label for="">旧密码：</label></div>
                        <div class="col-md-10 w40">
                            <input type="password" name="opsw" class="form-control"
                                   data-notempty="true"
                                   data-notempty-message="旧密码不能为空"
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2"><label for="">新密码：</label></div>
                        <div class="col-md-10 w40">
                            <input type="password" name="npsw" id="npsw" class="form-control"
                                   data-notempty="true"
                                   data-notempty-message="新密码不能为空"
                                   data-regex="^\w+$"
                                   data-regex-message="格式不匹配，密码由数字、字母或下划线所组成"
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2"><label for="">确认新密码：</label></div>
                        <div class="col-md-10 w40">
                            <input type="password" name="repsw" class="form-control"
                                   data-notempty="true"
                                   data-notempty-message="确认新密码不能为空"
                                   data-equalto="#npsw"
                                   data-equalto-message="两次密码不一致"
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2"><label for="">验证码：</label></div>
                        <div class="col-md-10 w40">
                            <input type="text" name="yzm" class="form-control"
                                   data-notempty="true"
                                   data-notempty-message="验证码不能为空"
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2"><label for=""></label></div>
                        <div class="col-md-10 w40">
                            <img class="yzmpic" style="cursor: pointer;" src="inc/vcode.php" alt="验证码"><span>点击图片换一张</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2"><label for=""></label></div>
                        <div class="col-md-10 w40">
                            <button type="submit" name="subMdfpsw" class="btn btn-primary"><i class="fa fa-check-square-o" style="margin-right: 3px;"></i>提交</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once "inc/footer.inc.php"?>
</body>
</html>