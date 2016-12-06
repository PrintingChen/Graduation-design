<?php
    //引入公共文件
    require_once 'inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();

    if(isset($_POST['sublogin'])){
        //接收提交的用户名和密码
        $user = $_POST['user'];
        $psw = md5($_POST['psw']);
        //查询是否存在此用户
        $sql_sel = "select * from user where name='{$user}' and psw='{$psw}'";
        if (nums($link, $sql_sel) == 1) {
            $data_u = fetch_array(execute($link, $sql_sel));
            $loginTimes = $data_u["loginTimes"]+1;
            //登录成功后将用户的信息存放在cookie里面
            setcookie('bs[userName]', $user);
            setcookie('bs[psw]', $psw);
            //更新登录的时间和登陆次数
            $time = Date('Y-m-d H:i:s', time());
            $sql = "update user set lastLogin='{$time}',loginTimes={$loginTimes} where name='{$user}'";
            execute($link, $sql);
            promptBox("欢迎您回来，现在将转入登录前页面", 6, "index.php");
        }else {
            promptBox("用户名或密码错误", 5, "index.php");
        }
    }
?>
