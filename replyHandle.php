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
    //验证验证码
    if ($_POST['yzm'] != $_SESSION['code']){
        echo "yzmnoequal";
        exit;
    }
    //将回复的数据入库
    $sql_ins = "insert into reply(tpostId,rcontent,ruid,rtime) values({$_POST['postId']}, '{$_POST['content']}', $member_id, now())";
    $res_ins = execute($link, $sql_ins);
    if (mysqli_affected_rows($link) == 1) {
        //当前条帖子回复成功后，更新当前帖子的更新时间
        $time = date("Y-m-d H:i:s", time());
        $sql_upd = "update post set updateTime='{$time}' where postId={$_POST['postId']}";
        execute($link, $sql_upd);
        echo "success".$_POST['postId'];
        exit;
    }else {
        echo "fail";
        exit;
    }
?>