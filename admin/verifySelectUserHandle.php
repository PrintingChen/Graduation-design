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
    //获取需要审核的用户的id
    $arr = $_POST['ver'];
    if (!empty($arr)){ //当选中有要审核的记录时
        echo "notempty";
        $ver_user = array();
        foreach ($arr as $key=>$value){
            array_push($ver_user, "update user set userStatus=0  where id={$value}");
        }
        execute_multi($link, $ver_user, $error);
        if ($error == null) {
            echo "success";
            exit;
        } else {
            echo "fail";
            exit;
        }
    }else{
        echo "empty";
        exit;
    }


?>