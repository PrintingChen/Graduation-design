<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once 'inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //是否登录
    $member_id = login_state($link);
    if ($_POST['yzm'] != $_SESSION['code']){
        echo "yzmnoequal";
        exit;
    }
    $content = escape($link, $_POST['content']);
    $sql_post = "insert into post(postTitle, postContent, tsmoduleId, postuid, postTime) 
                            values('{$_POST['post-title']}', '{$content}', {$_POST['selSModule']},
                                  {$member_id}, now()
                            )";
    execute($link, $sql_post);
    if (mysqli_affected_rows($link) == 1) {
        //查询出发布成功的当前帖子的id，用于发布成功后的跳转
        $sql = "select * from post order by postTime desc";
        $result = execute($link, $sql);
        $data = fetch_array($result);
        echo "success".$data['postId'];
        exit;
    }else {
        echo "fail";
        exit;
    }



?>