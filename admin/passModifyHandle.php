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
    $mid = manage_login_state($link);
    $opsw = md5($_POST['opsw']);
    $npsw = md5($_POST['npsw']);
    //将提交过来的旧密码比对数据库里面的密码是否一致
    $sql_compare = "select * from manager where mid={$mid} and managerPsw='{$opsw}'";
    $nums = nums($link, $sql_compare);
    if ($nums) {
        //开始更新密码
        $sql_mdfpsw = "update manager set managerPsw='{$npsw}' where mid={$mid}";
        execute($link, $sql_mdfpsw);
        if (mysqli_affected_rows($link)) {
            //密码修改成功后将原来登录的信息SESSION删除掉
            session_unset(); //释放当前会话注册的所有会话变量
            session_destroy(); //销毁当前会话中的全部数据
            setcookie(session_name(), '', time()-3600, '/'); //销毁保存在客户端的卡号
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