<?php
    //防止非法调用，需设置一个常量来授权
    if (!defined('ON')){
        exit('非法调用！！！');
    }    

    /**
     * skip() 跳转函数
     * @param string $url 指定跳转的路径
     * @param string $issuccess 指定的提示字体颜色
     * @param string $msg 指定的提示信息
     * @return
     */
	function skip($url,$issuccess,$msg) {
	    $html = <<<EOT
    	    <!DOCTYPE html>
            <html>
            <head>
            <meta charset="UTF-8">
            <meta http-equiv="refresh" content="3;url=$url" />
            <title>提示页</title>
            <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="css/common.css">
            <style>
                #notice{width: 750px;line-height: 80px;padding: 15px;margin: 20px auto;border: 3px solid #F2F2F2;}
                #notice p{height: 25px;line-height: 25px;text-align: center;}
                #notice p.mt10{margin-top: 10px;}
                #notice p.mb10{margin-bottom: 10px;}
                #notice p a{color: #336699;}
                #notice p.success{color: #5CB85C;}
                #notice p.error{color: #C9302C;}
            </style>
            </head>
            <body>
            <div id="header">
                <div class="container" style="width: 960px;padding: 0;">
                    <div class="logo">logo</div>
                    <div class="info">
                        <form action="" id="info-form">
                            <div class="info-wrap">
                                <table cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td style="text-align: left; width: 70px;">
                                            <select name="" id="sel">
                                                <option value="">用户名</option>
                                                <option value="">email</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="user" id="user"></td>
                                        <td style="padding-right: 10px;border-right: 1px solid #eee;"><label for="auto-login"><input type="checkbox" name="" id="auto-login">自动登录</label></td>
                                        <td style="padding-left: 10px;"><a href="#" style="color: #666;">找回密码</a></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;text-indent: 5px;">密码：</td>
                                        <td><input type="password" name="psw" id="psw"></td>
                                        <td style="padding-right: 10px;border-right: 1px solid #eee;"><button type="submit" id="sub-btn">登录</button></td>
                                        <td style="padding-left: 10px;"><a href="register.php" target="_blank" id="login">立即注册</a></td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                        <!--登录之后-->
                        <!--<ul>
                            <li class="person"><a href="#"><strong>李四</strong></a></li>|
                            <li><a href="#">我的帖子</a></li> |
                            <li><a href="setProfile.php">设置</a></li> |
                            <li><a href="#">退出</a></li> |
                            <li class="headpic"><a href="profile.php"><img src="img/noavatar_small.gif" alt="头像"></a></li>
                        </ul>-->
                    </div>
                </div>
            </div>
            <nav class="navbar navbar-default" id="navbar" style="margin: 0 auto;">
                <div class="container" style="background: #488FCE;width: 960px;">
                    <div class="collapse navbar-collapse" id="nav">
                        <ul class="navbar-nav nav">
                            <li><a href="">首页</a></li>
                            <li><a href="">item1</a></li>
                            <li><a href="">item2</a></li>
                            <li><a href="">item3</a></li>
                        </ul>
                    </div>
                    <div class="input-group" id="search">
                        <form action="">
                            <input type="text" name="keywords" class="form-control" placeholder="请输入搜索内容" style="top: 8px;width: 80%">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-success">搜索</button>
                            </span>
                        </form>
                    </div>
                </div>
            </nav>
            <div id="notice">
                <p class="mt10 {$issuccess}">{$msg}</p>
                <p class="mb10"><a class="skip" href="{$url}">如果您的浏览器没有自动跳转，请点击此链接</a></p>
            </div>
            </body>
            </html>
EOT;
	    echo $html;
	}

    function skip_manage($url,$pic,$msg) {//
        $html = <<<EOT
            <!DOCTYPE html>
            <html>
            <head>
            <meta charset="UTF-8">
            <meta http-equiv="refresh" content="3;url=$url" />
            <title>提示页</title>
            <link rel="stylesheet" href="style/public.css">
            <link rel="stylesheet" href="style/confirm.css">
            </head>
            <body>
            <p class="notice"><span class="pic {$pic}">{$msg}<a class="skip" href="{$url}">3秒后自动跳转……</a></span></p>
            </body>
            </html>
EOT;
        echo $html;
    }
    
	/**
	 * promptBox() 提示框
	 * @param unknown $msg 提示信息
	 * @param unknown $icon 图标
	 * @param unknown $url 跳转地址
	 */
    function promptBox($msg, $icon, $url){
        $html = <<<EOT
                <link rel="stylesheet" href="layui/css/layui.css">
                <script src="layui/layui.js"></script>
                <script>
                    layui.use('layer', function(){
                      var layer = layui.layer;
                      layer.msg('{$msg}',{icon: {$icon},time: 2000}, function(){
                            window.location.href="{$url}";
                      });
                    });
                </script>
EOT;
        echo $html;
    }


    /**
     * vcode()是生成验证码函数
     * @access public
     * @param number $width 表示验证码的长度
     * @param number $height 表示验证码的高度
     * @param number $_rnd_num 表示验证码的位数
     * @param bool $_flag 表示验证码是否要边框
     * @return void 这个函数执行后返回一个验证码
     */
    function vcode($width = 75, $height = 30,  $_rnd_num = 4,
        $_flag = false){
        //创建随机码
        $_nmsg = null;
        for ($i = 0; $i < $_rnd_num; $i++) {
            $_nmsg .= dechex(mt_rand(0, 15));
        }
    
        //将随机码存放在session
        session_start();
        $_SESSION['code'] = $_nmsg;
    
        //创建画布
        $im = imagecreatetruecolor($width, $height);
    
        //设置颜色
        $color = imagecolorallocate($im, rand(200,255), rand(200,255), rand(150,255));
        $white = imagecolorallocate($im, 255, 255, 255);
    
        //填充背景颜色
        imagefill($im, 0, 0, $white);
    
        //设置边框
        if ($_flag) {
            $black = imagecolorallocate($im, 0, 0, 0);
            imagerectangle($im, 0, 0, $width-1, $height-1, $black);
        }
    
        //填充6条直线
        for ($i = 0; $i < 6; $i++) {
            $_rnd_color = imagecolorallocate($im, mt_rand(100, 255), mt_rand(100, 255), mt_rand(100, 255));
            imageline($im, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $_rnd_color);
        }
    
        //填充随机100个雪花
        for ($i = 0; $i < 100; $i++) {
            $_rnd_color = imagecolorallocate($im, mt_rand(150, 255), mt_rand(150, 255), mt_rand(150, 255));
            imagestring($im, 1, mt_rand(0, $width), mt_rand(0, $height), '*', $_rnd_color);
        }
    
        //输出验证码
        for ($i = 0; $i < strlen($_SESSION['code']); $i++) {
            $_rnd_color = imagecolorallocate($im, mt_rand(0, 150), mt_rand(0, 200), mt_rand(0, 150));
            imagestring($im, 5, mt_rand(1,10)+$i*$width/$_rnd_num, mt_rand(0,$height/2), $_SESSION['code'][$i], $_rnd_color);
            //imageTTFText($im, int size, int angle, int x, int y, int col, string fontfile, string text);
            //imagettftext($im, 5, rand(-5, 5), rand(1,10)+$i*$width/$_rnd_num, mt_rand(0,$height/2), $_rnd_color, "font/ManyGifts.ttf", $_SESSION['code'][$i]);
            
        }
    
        //输出图像
        header("Content-type:image/png");
        imagepng($im);
    
        //释放资源
        imagedestroy($im);
    }
    

    /**
     * check_vcode() 检测验证码
     * @param string $first_vcode
     * @param string $end_vcode
     * @return void
     */
    function check_vcode($first_vcode, $end_code) {
        if (strtolower($first_vcode) != strtolower($end_code)) {
            skip('register.php', 'error', '验证码出错^_^');
            exit();
        }
    }
    
    /**
     * login_state() 判断当前的登录状态（前台）
     */
    function login_state($link){
        if (isset($_COOKIE['bs']['userName']) && isset($_COOKIE['bs']['psw'])){
            $sql = "select * from user where name='{$_COOKIE['bs']['userName']}' and psw='{$_COOKIE['bs']['psw']}'";
            $result = execute($link, $sql);
            if (mysqli_num_rows($result) == 1) {
                $data = fetch_array($result);
                return $data['id'];
            }else{
                return false;
            }
        }else {
            return false;
        }
    }

    /**
     * manage_login_state() 判断当前的登录状态（后台）
     */
    function manage_login_state($link){
        if (isset($_SESSION['manage']['name']) && isset($_SESSION['manage']['psw'])){
            $sql = "select * from ws_manage where name='{$_SESSION['manage']['name']}' and psw='{$_SESSION['manage']['psw']}'";
            $result = execute($link, $sql);
            if (mysqli_num_rows($result) == 1) {
                return true;
            }else{
                return false;
            }
        }else {
            return false;
        }
    }

    /**
     * page() 分页函数
     * @param int $count 总记录数
     * @param int $page_size  每页显示的记录数
     * @param number $num_btn 要展示的页码按钮数目
     * @param string $page    分页的get参数
     * @return multitype:string    返回值：array('limit','html')
     */
    function page($count,$page_size,$num_btn=10,$page='page'){
        if(!isset($_GET[$page]) || !is_numeric($_GET[$page]) || $_GET[$page]<1){
            $_GET[$page]=1;
        }

        if ($count == 0) { //当版块没有帖子时,返回空数组
            $data=array(
                'limit'=>'',
                'html'=>''
            );
            return $data;
        }

        //总页数
        $page_num_all=ceil($count/$page_size);
        if($_GET[$page]>$page_num_all){
            $_GET[$page]=$page_num_all;
        }
        $start=($_GET[$page]-1)*$page_size;
        $limit="limit {$start},{$page_size}";
    
        $current_url=$_SERVER['REQUEST_URI'];//获取当前url地址
        $arr_current=parse_url($current_url);//将当前url拆分到数组里面
        $current_path=$arr_current['path'];//将文件路径部分保存起来
        $url='';
        if(isset($arr_current['query'])){
            parse_str($arr_current['query'],$arr_query);
            unset($arr_query[$page]);
            if(empty($arr_query)){
                $url="{$current_path}?{$page}=";
            }else{
                $other=http_build_query($arr_query);
                $url="{$current_path}?{$other}&{$page}=";
            }
        }else{
            $url="{$current_path}?{$page}=";
        }
        $html=array();
        if($num_btn>=$page_num_all){
            //把所有的页码按钮全部显示
            for($i=1;$i<=$page_num_all;$i++){//这边的$page_num_all是限制循环次数以控制显示按钮数目的变量,$i是记录页码号
                if($_GET[$page]==$i){
                    $html[$i]="<span>{$i}</span>";
                }else{
                    $html[$i]="<a href='{$url}{$i}'>{$i}</a>";
                }
            }
        }else{
            $num_left=floor(($num_btn-1)/2);
            $start=$_GET[$page]-$num_left;
            $end=$start+($num_btn-1);
            if($start<1){
                $start=1;
            }
            if($end>$page_num_all){
                $start=$page_num_all-($num_btn-1);
            }
            for($i=0;$i<$num_btn;$i++){
                if($_GET[$page]==$start){
                    $html[$start]="<span>{$start}</span>";
                }else{
                    $html[$start]="<a href='{$url}{$start}'>{$start}</a>";
                }
                $start++;
            }
            //如果按钮数目大于等于3的时候做省略号效果
            if(count($html)>=3){
                reset($html);
                $key_first=key($html);
                end($html);
                $key_end=key($html);
                if($key_first!=1){
                    array_shift($html);
                    array_unshift($html,"<a href='{$url}=1'>1</a>...");
                }
                if($key_end!=$page_num_all){
                    array_pop($html);
                    array_push($html,"<a href='{$url}={$page_num_all}'>{$page_num_all}</a>...");
                }
            }
        }
        if($_GET[$page]!=1){
            $prev=$_GET[$page]-1;
            array_unshift($html,"<a href='{$url}{$prev}'>« 上一页</a>");
        }
        if($_GET[$page]!=$page_num_all){
            $next=$_GET[$page]+1;
            array_push($html,"<a href='{$url}{$next}'>下一页 »</a>");
        }
        $html=implode(' ',$html);
        $data=array(
            'limit'=>$limit,
            'html'=>$html
        );
        return $data;
    }

    /**
    *upload() 文件上传函数
    */
    function upload($save_path,$custom_upload_max_filesize,$key,$type=array('jpg','jpeg','gif','png')){
        $return_data=array();
        //获取phpini配置文件里面的upload_max_filesize值
        $phpini=ini_get('upload_max_filesize');
        //获取phpini配置文件里面的upload_max_filesize值的单位
        $phpini_unit=strtoupper(substr($phpini,-1));
        //获取phpini配置文件里面的upload_max_filesize值的数字部分
        $phpini_number=substr($phpini,0,-1);
        //计算出转换成字节应该乘以的倍数
        $phpini_multiple=get_multiple($phpini_unit);
        //转换成字节
        $phpini_bytes=$phpini_number*$phpini_multiple;

        $custom_unit=strtoupper(substr($custom_upload_max_filesize,-1));
        $custom_number=substr($custom_upload_max_filesize,0,-1);
        $custom_multiple=get_multiple($custom_unit);
        $custom_bytes=$custom_number*$custom_multiple;

        if($custom_bytes>$phpini_bytes){
            $return_data['error']='传入的$custom_upload_max_filesize大于PHP配置文件里面的'.$phpini;
            $return_data['return']=false;
            return $return_data;
        }
        $arr_errors=array(
                1=>'上传的文件超过了 php.ini中 upload_max_filesize 选项限制的值',
                2=>'上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值',
                3=>'文件只有部分被上传',
                4=>'没有文件被上传',
                6=>'找不到临时文件夹',
                7=>'文件写入失败'
        );
        if(!isset($_FILES[$key]['error'])){
            $return_data['error']='由于未知原因导致，上传失败，请重试！';
            $return_data['return']=false;
            return $return_data;
        }
        if ($_FILES[$key]['error']!=0) {
            $return_data['error']=$arr_errors[$_FILES['error']];
            $return_data['return']=false;
            return $return_data;
        }
        if(!is_uploaded_file($_FILES[$key]['tmp_name'])){
            $return_data['error']='您上传的文件不是通过 HTTP POST方式上传的！';
            $return_data['return']=false;
            return $return_data;
        }
        if($_FILES[$key]['size']>$custom_bytes){
            $return_data['error']='上传文件的大小超过了程序作者限定的'.$custom_upload_max_filesize;
            $return_data['return']=false;
            return $return_data;
        }
        $arr_filename=pathinfo($_FILES[$key]['name']);
        if(!isset($arr_filename['extension'])){
            $arr_filename['extension']='';
        }
        if(!in_array($arr_filename['extension'],$type)){
            $return_data['error']='后缀名不是'.implode(',',$type).'中的一个';
            $return_data['return']=false;
            return $return_data;
        }
        if(!file_exists($save_path)){
            if(!mkdir($save_path,0777,true)){
                $return_data['error']='上传文件保存目录创建失败，请检查权限!';
                $return_data['return']=false;
                return $return_data;
            }
        }
        $new_filename=str_replace('.','',uniqid(mt_rand(100000,999999),true));
        if($arr_filename['extension']!=''){
            $new_filename.=".{$arr_filename['extension']}";
        }
        $save_path=rtrim($save_path,'/').'/';
        if(!move_uploaded_file($_FILES[$key]['tmp_name'],$save_path.$new_filename)){
            $return_data['error']='临时文件移动失败，请检查权限!';
            $return_data['return']=false;
            return $return_data;
        }
        $return_data['save_path']=$save_path.$new_filename;
        $return_data['filename']=$new_filename;
        $return_data['return']=true;
        return $return_data;
    }



?>
