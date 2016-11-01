<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>完善个人资料</title>
    <link rel="stylesheet" href="font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <script src="js/jquery-1.12.2.min.js"></script>
    <script src="css/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/formValidator.js"></script>
    <script src="js/area.js"></script>

    <script></script>
    <script>
        $(function () {
            //标签页切换
            $("#myTab a").on("click", function (e) {
                e.preventDefault();
                $(this).tab("show");
            });
            //左侧栏点击切换
            $("#navbar-left li").on("click",function () {
                //添加样式
                $(this).addClass("mdfpic").siblings().removeClass("mdfpic");
            });
            $("#navbar-left li").eq(0).on("click", function () {
                $(".head-pic").css("display", "block");
                $(".profile-info").css("display", "none");
                $(".mdf-psw").css("display", "none");
            });
            $("#navbar-left li").eq(1).on("click", function () {
                $(".head-pic").css("display", "none");
                $(".profile-info").css("display", "block");
                $(".mdf-psw").css("display", "none");
            });
            $("#navbar-left li").eq(2).on("click", function () {
                $(".head-pic").css("display", "none");
                $(".profile-info").css("display", "none");
                $(".mdf-psw").css("display", "block");
            });
            //验证表单
            $("#form-mdfpsw").formValidator();

            //生成年份
            var htmlYear = "";
            for(var year=2016;year>=1917;year--){
                htmlYear += "<option value='"+year+"'>"+year+"</option>";
            }
            $("#year").append(htmlYear);
            //生成月份
            var htmlMonth = "";
            for(var month=1;month<=12;month++){
                htmlMonth += "<option value='"+month+"'>"+month+"</option>";
            }
            $("#month").append(htmlMonth);
            //生成年份
            var htmlDay = "";
            for(var day=1;day<=31;day++){
                htmlDay += "<option value='"+day+"'>"+day+"</option>";
            }
            $("#day").append(htmlDay);

            //执行三级联动代码
            _init_area();

        });
    </script>
    <style>
        #setprofile{
            margin-top: 10px;
        }
        #setprofile .container{
            border: 1px solid #ccc;
            padding: 0;
        }
        #navbar-left{
            background-color: #E8F0F7;
            padding: 0;
            height: 670px;
        }
        #navbar-left h2{
            font-size:  16px;
            font-weight: 600;
            padding: 10px 0 10px 10px;
            border-bottom: 1px dashed #CCC;
        }
        #navbar-left ul li{
            height: 33px;
            line-height: 33px;
            border-bottom: 1px dashed #CCC;
            padding-left: 10px;
        }
        #navbar-left ul li a{
            display: block;
            text-decoration: none;
        }
        #navbar-left ul li a:hover{
        }
        #myTab{
            margin-top: 5px;
        }
        #myTabContent{
            padding: 10px;
        }
        #navbar-left ul li.mdfpic{
            background-color: #fff;
        }
        .head-pic,.profile-info,.mdf-psw{
            position: absolute;
            display: none;
            width: 98%;
        }
        .head-pic{
            padding-top: 15px;
        }
        .desc{
            font-size: 15px;
            font-weight: 600;
            padding: 3px 0;
        }
        .head{
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .upload-area {
            position: relative;
            display: inline-block;
            background: #D0EEFF;
            border: 1px solid #99D3F5;
            border-radius: 4px;
            padding: 4px 12px;
            overflow: hidden;
            color: #1E88C7;
            text-decoration: none;
            text-indent: 0;
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .upload-area input {
            width: 450px;
            height: 250px;
            font-size: 100px;
            opacity: 0;
        }
        #upload:hover{
            cursor: pointer;
        }
        .upload-area i{
            position: absolute;
            left: 50%;
            top: 50%;
            margin-left: -33px;
            margin-top: -35px;
        }
        #upload-btn i{
            margin-right: 3px;
        }
        .mdf-psw{
            padding: 15px;
        }
        .mdf-psw p{
            padding: 5px 0;
            border-bottom: 1px dashed #ccc;
        }
        .form-group {
            height: 40px;
            line-height: 40px;
            margin-top: 10px;
        }
        .w40{
            width: 40%;
        }
        .input-help.error-message,.input-help.success-message {
            display: inline-block;
            margin-left: 15px;
            position: absolute;
            left: 280px;
            top: -8px;
            width: 107%;
        }
        .input-help.success-message p i{
            color: #5CB85C;
        }
        .input-help.error-message p,.input-help.success-message p{
            border: none;
            color: #C9302C;
        }
        .w40 img{
            margin-right: 20px;
        }
    </style>
</head>
<body>
<!--引入头部-->
<?php include_once "inc/header.inc.php"?>
<!--引入导航-->
<?php include_once "inc/nav.inc.php"?>
<div id="position">
    <div class="container">
        <i class="fa fa-map-marker"></i>
        <a href="#">李四</a>
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
                <form action="" id="upload-pic">
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
                        <form action="" id="form-basic">
                            <div class="form-group">
                                <div class="col-md-2"><label for="">用户名：</label></div>
                                <div class="col-md-10 w40">
                                    李四
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">真实姓名：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="reallyName" id="reallyName" class="form-control">
                                    </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">性别：</label></div>
                                <div class="col-md-10 w40">
                                    <select name="sex" id="sex">
                                        <option value="0">保密</option>
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
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o" style="margin-right: 3px;"></i>提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="contact-info">
                        <form action="" id="form-basic">
                            <div class="form-group">
                                <div class="col-md-2"><label for="">用户名：</label></div>
                                <div class="col-md-10 w40">
                                    李四
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">固定电话：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="fixed-tel" id="fixed-tel" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">手机：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="phone" id="phone" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">QQ：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="qq" id="qq" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">个人主页：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="homepage" id="homepage" class="form-control" value="http://">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for=""></label></div>
                                <div class="col-md-10 w40">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o" style="margin-right: 3px;"></i>提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="education">
                        <form action="" id="form-basic">
                            <div class="form-group">
                                <div class="col-md-2"><label for="">用户名：</label></div>
                                <div class="col-md-10 w40">
                                    李四
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">毕业学校：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="school" id="school" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">学历：</label></div>
                                <div class="col-md-10 w40">
                                    <select name="degrees" id="degrees ">
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
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o" style="margin-right: 3px;"></i>提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="working">
                        <form action="" id="form-basic">
                            <div class="form-group">
                                <div class="col-md-2"><label for="">用户名：</label></div>
                                <div class="col-md-10 w40">
                                    李四
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">公司：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="company" id="company" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">职业：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="profession" id="profession" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">职位：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="job" id="job" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for="">年收入：</label></div>
                                <div class="col-md-10 w40">
                                    <input type="text" name="income" id="income" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"><label for=""></label></div>
                                <div class="col-md-10 w40">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o" style="margin-right: 3px;"></i>提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mdf-psw">
                <p>您必须填写原密码才能修改下面的资料</p>
                <form action="" id="form-mdfpsw">
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
                            <img src="img/yzm.png" alt=""><span style="cursor: pointer;">点击换一张</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2"><label for=""></label></div>
                        <div class="col-md-10 w40">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o" style="margin-right: 3px;"></i>提交</button>
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