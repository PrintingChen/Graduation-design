<?php
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    //require_once 'common.inc.php';
function vcode($width = 75,$height = 30,$_rnd_num = 4,$_flag = false){
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
    
    vcode();

?>
