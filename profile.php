<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人资料</title>
    <link rel="stylesheet" href="font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <style>
        #profile{
            margin-top: 10px;
        }
        #profile .container{
            border: 1px solid #ccc;
            padding: 0;
        }
        #profile .container .profile-h{
            height: 100px;
            background-color: #E5EDF2;
            border-bottom: 1px solid #ccc;
        }
        #profile .container .profile-h a{
            display: inline-block;
            padding: 2px;
            background-color: #fff;
            border-radius: 3px;
            margin-top: 15px;
            margin-left: 15px;
        }
        #profile .container .profile-h a img{
            border-radius: 3px;
        }
        .person-info{
            background-color: #fff;
            padding:  10px;
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
        <a href="register.php">个人资料</a>
    </div>
</div>
<div id="profile">
    <div class="container">
        <div class="profile-h">
            <a href="profile.php"><img src="img/noavatar_small.gif" alt=""></a>
            李四个人资料
        </div>
        <div class="person-info">
            sdf
        </div>
    </div>
</div>
</body>
</html>