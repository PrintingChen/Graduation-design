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
    <script src="layui/layui.js"></script>
    <script src="css/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/formValidator.js"></script>
    <script src="js/area.js"></script>
    <script src="js/setProfile.js"></script>
    <script src="js/common.js"></script>

</head>
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
    if(!($member_id = login_state($link))){
        promptBox("您还未登录", 5, "index.php");
        exit;
    }
    //查询出当前用户的信息
    $sql_info = "select * from user where id='{$member_id}'";
    $res_info = fetch_array(execute($link, $sql_info));
    //引入处理登录信息
    include_once "inc/handlerLogin.php";
    //处理提交的修改头像的数据
    if (isset($_POST['subUploadpic'])){
        //将提交的数据插入到数据库当中
        //写上服务器上文件系统的路径，而不是url地址
        $save_path='uploads'.date('/Y/m/d/');
        $upload=upload($save_path,'8M','upload');
        if($upload['return']){
            $query="update user set photo='{$upload['save_path']}' where id={$member_id}";
            execute($link, $query);
            if(mysqli_affected_rows($link)==1){
                promptBox("头像上传成功", 6,"profile.php");
            }else{
                promptBox("头像上传失败", 5, "profile.php");
            }
        }else{
            skip("setProfile.php", "error",$upload["error"]);
            exit();
        }
    }

?>
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
                <form method="post" id="upload-pic" enctype="multipart/form-data">
                    <div>
                        <h3 class="desc">当前我的头像</h3>
                        <p style="font-size: 12px">如果您还没有设置自己的头像，系统会显示为默认头像，您需要自己上传一张新照片来作为自己的个人头像</p>
                    </div>
                    <div class="head"><img src="<?php echo $img_url;?>" width="200" height="200"></div>
                    <div class="set-headpic">
                        <h3 class="desc">设置我的新头像</h3>
                        <p style="font-size: 12px">请选择一个新照片进行上传编辑。</p>
                    </div>
                    <div class="upload-area">
                        <input type="file" name="upload" id="upload">
                    </div>
                    <div>
                        <button name="subUploadpic" class="btn btn-primary" id="upload-btn"><i class="fa fa-check-square-o"></i>提交</button>
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
                        <form id="form-basic">
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
                                    <?php
                                        //将生日分割成数组
                                        $bir = explode("-", $res_info['birthday']);
                                    ?>
                                    <select name="year" id="year">
                                        <option value="<?php //echo $bir[0]?>"><?php //echo $bir[0]?></option>
                                        <option value="">年</option>
                                    </select>
                                    <select name="month" id="month">
                                        <option value="<?php //echo $bir[1]?>"><?php //echo $bir[1]?></option>
                                        <option value="">月</option>
                                    </select>
                                    <select name="day" id="day">
                                        <option value="<?php //echo $bir[2]?>"><?php //echo $bir[2]?></option>
                                        <option value="">日</option>
                                    </select>
                                    <?php //echo $bir[0]."年".$bir[1]."月".$bir[2]."日";?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">出生地：</label></div>
                                <div class="col-md-10 w40">
                                    <?php
                                        //将出生地分割成数组
                                        $home = explode("、", $res_info['homeplace']);
                                    ?>
                                    <select name="birprov" id="birprov">
                                        <option value="<?php //echo $home[0]?>"><?php echo $home[0]?></option>
                                    </select>
                                    <select name="bircity" id="bircity">
                                        <option value="<?php //echo $home[1]?>"><?php echo $home[1]?></option>
                                    </select>
                                    <select name="birdistrict" id="birdistrict">
                                        <option value="<?php //echo $home[2]?>"><?php echo $home[2]?></option>
                                    </select>
                                </div>
                                <?php //echo $home[0].$home[1].$home[2];?>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">血型：</label></div>
                                <div class="col-md-10 w40">
                                    <select name="bloodtype" id="bloodtype">
                                        <option value="<?php echo $res_info['bloodType'];?>"><?php echo $res_info['bloodType'];?></option>
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
                                    <button type="button" name="subBasic" class="btn btn-primary" id="basicBtn"><i class="fa fa-check-square-o" style="margin-right: 3px;"></i>提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="contact-info">
                        <form id="form-contact">
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
                                    <button type="button" name="subContact" class="btn btn-primary" id="contactBtn"><i class="fa fa-check-square-o" style="margin-right: 3px;"></i>提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="education">
                        <form id="form-education">
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
                                    <select name="degrees" id="degrees" class="form-control">
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
                                    <button type="button" name="subEducation" class="btn btn-primary" id="eduBtn"><i class="fa fa-check-square-o" style="margin-right: 3px;"></i>提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="working">
                        <!--method="post"-->
                        <form id="form-working">
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
                                           data-greaterthan="10"
                                           data-greaterthan-message="不能小于10"
                                    >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for=""></label></div>
                                <div class="col-md-10 w40">
                                    <button type="button" name="subWorking" class="btn btn-primary" id="workingBtn"><i class="fa fa-check-square-o" style="margin-right: 3px;"></i>提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mdf-psw">
                <p>您必须填写原密码才能修改下面的资料</p>
                <script>
                    $(function () {
                        layui.use("layer", function () {
                            var layer = layui.layer;
                            //更新密码
                            $("#mdfpswBtn").on("click", function () {
                                //验证数据
                                //旧密码不能为空
                                if($("#opsw").val() == 0){
                                    layer.msg("旧密码不能为空", {icon: 5, time: 1000}, function () {
                                        $("#opsw").focus();
                                    });
                                    return false;
                                }
                                //新密码不能为空
                                if($("#npsw").val() == 0){
                                    layer.msg("新密码不能为空", {icon: 5, time: 1000}, function () {
                                        $("#npsw").focus();
                                    });
                                    return false;
                                }
                                //确认密码
                                if($("#repsw").val() != $("#npsw").val()){
                                    layer.msg("两次密码不一致", {icon: 5, time: 1000}, function () {
                                        $("#repsw").focus();
                                    });
                                    return false;
                                }
                                //验证码
                                if($("#yzm").val().length != 4){
                                    layer.msg("验证码必须为4位", {icon: 5, time: 1000}, function () {
                                        $("#yzm").focus();
                                    });
                                    return false;
                                }
                                $.ajax({
                                    type: "post",
                                    url: "userModifyPswHandle.php",
                                    data: $("#form-mdfpsw").serialize(),
                                    success: function (response) {
                                        if(response == "yzmnotequal"){
                                            layer.msg("验证码错误", {icon: 5, time: 1000}, function () {
                                                $("#yzm").focus();
                                            });
                                        }else if(response == "opswerror"){
                                            layer.msg("原密码有误", {icon: 5, time: 1000}, function () {
                                                $("#opsw").focus();
                                            });
                                        }else if(response == "success"){
                                            layer.msg("密码修改成功", {icon: 1, time: 1000}, function () {
                                                window.location.href = "login.php";
                                            });
                                        }else if(response == "fail"){
                                            layer.msg("密码未改动", {icon: 5, time: 1000});
                                        }
                                    }
                                });
                            });
                        });
                    });
                </script>
                <form id="form-mdfpsw">
                    <div class="form-group">
                        <div class="col-md-2"><label for="">旧密码：</label></div>
                        <div class="col-md-10 w40">
                            <input type="password" name="opsw" id="opsw" class="form-control"
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
                            <input type="password" name="repsw" id="repsw" class="form-control"
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
                            <input type="text" name="yzm" id="yzm" class="form-control"
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
                            <button type="button" name="subMdfpsw" class="btn btn-primary" id="mdfpswBtn"><i class="fa fa-check-square-o" style="margin-right: 3px;"></i>提交</button>
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