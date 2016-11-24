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
    //更新密码
    if($_POST['yzm'] != $_SESSION['code']){
        echo "yzmnotequal";
        exit;
    }
    $opsw = md5($_POST['opsw']);
    $npsw = md5($_POST['npsw']);
    //将提交过来的旧密码比对数据库里面的密码是否一致
    $sql_compare = "select * from user where id='{$member_id}' and psw='{$opsw}'";
    $nums = nums($link, $sql_compare);
    if (nums($link, $sql_compare)) {
        //开始更新密码
        $sql_mdfpsw = "update user set psw='{$npsw}' where id='{$member_id}'";
        execute($link, $sql_mdfpsw);
        if (mysqli_affected_rows($link)) {
            //密码修改成功后将原来登录的信息cookie删除掉
            setcookie('bs[userName]', '', time()-36000);
            setcookie('bs[psw]', '', time()-36000);
            echo "success";
            exit;
        }else {
            echo "fail";
            exit;
        }
    }else{
        echo "opswerror";
        exit;
    }
?>