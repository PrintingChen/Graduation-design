<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once '../inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //需要修改的用户的uid
    $uid = $_GET["uid"];
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
            echo "success";
            exit;
        }else {
            echo "fail";
            exit;
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
            echo "success";
            exit;
        }else {
            echo "fail";
            exit;
        }
    }
?>