<?php
    header('Content-type:text/html;charset=utf-8');
    //防止非法调用，需设置一个常量来授权
    if (!defined('ON')){
        exit('非法调用^_^');
    }
    /**
     * check_user() 检测用户名
     * @param resource $link
     * @param string $data
     * @return Ambigous <string, string/array>
     */
    function check_user($link, $data){
        //去掉前后的空格
        $data = trim($data);
        //用户名不能为空
        if ( empty($data) ) {
            skip('register.php', 'error', '用户名不能为空^_^');
            exit();
        }
        //用户名不能小于2位并且大于20位
        if ( mb_strlen($data) < 2 && mb_strlen($data) > 10 ) {
            skip('register.php', 'error', '用户名不能小于2位并且大于20位^_^');
            exit();
        }
        //限制敏感字符
        $pattern = '/[<>\'\"\ \	!@#$%^&*]/';
        if ( preg_match($pattern, $data) ) {
            skip('register.php', 'error', '用户名不能包含敏感字符^_^');
            exit();
        }
        return escape($link, $data);
    }

    /**
     * check_pwd() 检测密码
     * @param resource $link
     * @param string $data
     * @return Ambigous <string, string/array>
     */
    function check_pwd($link, $data){
        //密码长度不得小于6位或大于15位
        if ( mb_strlen($data) < 6 || mb_strlen($data) > 15 ) {
            skip('register.php', 'error', '密码长度不能小于6位或大于15位^_^');
            exit();
        }
        //密码必须是字母，数字或者下划线的组合
        $pattern1 = '/^\w+$/';
        if(!preg_match($pattern1, $data)){
            skip('register.php', 'error', '密码必须是字母，数字或者下划线^_^');
            exit();
        }
        return escape($link, md5($data));
    }

    /**
     * check_email() 检测邮箱
     * @param resource $link
     * @param string $data
     * @return Ambigous <string, string/array>
     */
    function check_email($link, $data){
        //邮箱不得为空
        if (empty($data)){
            skip('register.php', 'error', '邮箱不得为空^_^');
            exit();
        }
        $pattern = '/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/';
        if (!preg_match($pattern, $data)) {
            skip('register.php', 'error', '邮箱不合法^_^');
            exit();
        }
        return escape($link, $data);
    }
?>