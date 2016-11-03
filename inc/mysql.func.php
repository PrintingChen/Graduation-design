<?php
    header('Content-type:text/html;charset=utf-8');
    //防止非法调用，需设置一个常量来授权
    if (!defined('ON')){
        exit('非法调用！！！');
    }
    
    /**
     * connect() 数据库连接函数
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $database
     * @param string $port
     * @return $link
     */
    function connect($host=DB_HOST, $user=DB_USER, $password=DB_PWD, $database=DB_DATABASE, $port=DB_PORT){
        $link = @mysqli_connect($host, $user, $password, $database, $port);
        if (mysqli_connect_errno()){
            exit(mysqli_connect_error());
        }
        mysqli_set_charset($link, 'utf8');
        return $link;
    }

    /**
     * execute() 执行一条sql语句函数
     * @param resource $link
     * @param string $query
     * @return $result 返回结果集或布尔值
     */
    function execute($link, $sql){
        $result = mysqli_query($link, $sql);
        if (mysqli_errno($link)) {
            exit(mysqli_error($link));
        }
        return $result;
    }

    /**
     * execute_bool() 执行一条sql语句函数 
     * @param resource $link
     * @param string $query
     * @return boolean $result 返回一个布尔值,执行成功返回true,执行失败返回false
     */
    function execute_bool($link, $sql){
        $result = mysqli_real_query($link, $sql);
        if (mysqli_errno($link)) {
            exit(mysqli_error($link));
        }
        return $result;
    }
    
    /**
     * execute_multi() 一次性执行多条语句
     * @param unknown $link
     * @param unknown $arr_sqls
     * @param unknown $error
     * @return multitype:NULL |boolean
     */
    function execute_multi($link,$arr_sqls,&$error){
        $sqls=implode(';',$arr_sqls).';';
        if(mysqli_multi_query($link,$sqls)){
            $data=array();
            $i=0;//计数
            do {
                if(@$result=mysqli_store_result($link)){
                    $data[$i]=mysqli_fetch_all($result);
                    mysqli_free_result($result);
                }else{
                    $data[$i]=null;
                }
                $i++;
                if(!mysqli_more_results($link)) break;
            }while (mysqli_next_result($link));
            if($i==count($arr_sqls)){
                return $data;
            }else{
                $error="sql语句执行失败：<br />&nbsp;数组下标为{$i}的语句:{$arr_sqls[$i]}执行错误<br />&nbsp;错误原因：".mysqli_error($link);
                return false;
            }
        }else{
            $error='执行失败！请检查首条语句是否正确！<br />可能的错误原因：'.mysqli_error($link);
            return false;
        }
    }
    
    /**
     * nums() 获取记录数
     * @param resource $link
     * @param string $query
     * @return number
     */
    function nums($link, $sql){
        return mysqli_num_rows(execute($link, $sql));
    }
    
    /**
     * escape() 数据入库之前进行转义，确保数据能够顺利入库
     * @param resource $link
     * @param string/array $data
     * @return string $data
     */
    function escape($link, $data){
        //判断$data是否为string类型，如果是直接转义返回
        if (is_string($data)) {
            return mysqli_real_escape_string($link, $data);
        }
        //判断$data是否为数组，如果是则继续调用自身直至$data为string类型
        if (is_array($data)) {
            foreach ($data as $key=>$val) {
                $data[$key] = escape($link, $val);
            }
        }
        return $data;
    }
    
    /**
     * close() 关闭数据库函数
     * @param resource $link
     * @return void
     */
    function close($link){
        mysqli_close($link);
    }
    
    /**
     * fetch_array() 将结果集转换为关联数组
     * @param resource $result
     * @return array 关联数组
     */
    function fetch_array($result){
        return mysqli_fetch_assoc($result);
    }
?>
