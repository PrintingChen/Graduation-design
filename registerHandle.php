<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once 'inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //验证验证码
    if ($_POST['yzm'] != $_SESSION['code']){
        echo "yzmnoequal";
        exit;
    }
    //插入数据之前先判断用户名或者邮箱是否已被注册
    $sql_name = "select * from user where name='{$_POST['userName']}'";
    if (nums($link, $sql_name)) {
        echo "nameislogin";
        exit();
    }
    $sql_email = "select * from user where email='{$_POST['email']}'";
    if (nums($link, $sql_email)) {
        echo "emailislogin";
        exit;
    }
    //开始插入数据
    $psw = md5($_POST['psw']);
    $sql_ins = "insert into user(name,psw,email,registerTime,lastLogin) values('{$_POST['userName']}','{$psw}','{$_POST['email']}',NOW(),NOW())";
    //echo $sql_ins;exit;
    $result = execute($link, $sql_ins);
    //判断数据是否插入成功
    if (mysqli_affected_rows($link) == 1) {
        //设置cookie
        setcookie('bs[userName]', $_POST['userName']);
        setcookie('bs[psw]', $psw);
        //更新注册的时间
        $time = Date('Y-m-d H:i:s', time());
        $sql = "update user set registerTime='{$time}' where name='{$_POST['userName']}'";
        execute($link, $sql);
        echo "success";
        exit;
    }else {
        echo "fail";
        exit;
    }
?>
<?php
/*//验证验证码是否一致
    check_vcode($_POST['yzm'], $_SESSION['code']);
    //引入验证文件
    include_once "inc/register.func.php";
    //定义一个空的数组来存放过滤之后的数据
    $clean = array();
    $clean['userName'] = check_user($link, $_POST['userName']);
    $clean['psw'] = check_pwd($link, $_POST['psw']);
    $clean['email'] = check_email($link, $_POST['email']);
    //插入数据之前先判断用户名或者邮箱是否已被注册
    $sql_name = "select * from user where name='{$clean['userName']}'";
    if (nums($link, $sql_name)) {
        skip('register.php', 'error', '该用户名已注册，请更换用户名^_^');
        exit();
    }
    $sql_email = "select * from user where email='{$clean['email']}'";
    if (nums($link, $sql_email)) {
        skip('register.php', 'error', '该邮箱已注册，请更换邮箱^_^');
        exit();
    }
    //开始插入数据
    $sql_ins = "insert into user(name,psw,email,registerTime,lastLogin) values('{$clean['userName']}','{$clean['psw']}','{$clean['email']}',NOW(),NOW())";
    $result = execute($link, $sql_ins);
    //判断数据是否插入成功
    if (mysqli_affected_rows($link) == 1) {
        //设置cookie
        setcookie('bs[userName]', $clean['userName']);
        setcookie('bs[psw]', $clean['psw']);
        //更新注册的时间
        $time = Date('Y-m-d H:i:s', time());
        $sql = "update user set registerTime='{$time}' where name='{$clean['userName']}'";
        execute($link, $sql);
        skip('index.php', 'success', '恭喜你，注册成功^_^');
        exit();
    }else {
        skip('register.php', 'error', '很抱歉，注册失败^_^');
        exit();
    }*/
?>