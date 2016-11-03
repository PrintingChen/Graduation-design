<?php
    
    header("content-type:text/html;charset=utf-8;");
    //防止非法调用，需设置一个常量来授权
    if (!defined('ON')){
        exit('非法调用^_^');
    }
    //引入核心函数库
    require_once 'mysql.func.php';
    require_once "global.func.php";
    
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PWD', '');
    define('DB_DATABASE', 'bbsapp');
    define('DB_PORT', 3306);

    //项目在服务器上的绝对路径
    define('SA_PATH',dirname(dirname(__FILE__)));
    //项目在web根目录下面的位置
    define('SUB_URL',str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('\\','/',SA_PATH)).'/');






?>
