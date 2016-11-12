<?php
header('Content-type:text/html;charset=utf-8');
//防止非法调用，需设置一个常量来授权
if (!defined('ON')){
    exit('非法调用！！！');
}

/**
 * check_module_name() 检测版块名称是否合法
 * @param string $data
 * @return string $data
 */
function check_smodule_name($link, $data){
    $data = trim($data); //去掉前后的空格
    $pattern = '/[<>\'\"\ \  ]/';
    if (empty($data)) {
        promptBox("子版块名称不得为空", 5, "addSubModule.php");
        exit();
    }
    //判断长度
    if (mb_strlen($data) > 20 || mb_strlen($data) < 0) {
        promptBox("子版块名称不能大于20个字符", 5, "addSubModule.php");
        exit();
    }
    //排除非法字符
    if (preg_match($pattern, $data)) {
        promptBox("子版块名称不得包含非法字符", 5, "addSubModule.php");
        exit();
    }
    return escape($link, $data);
}


?>
