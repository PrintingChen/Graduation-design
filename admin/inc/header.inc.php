<!-- 头部 -->
<div class="header bg-main">
    <div class="logo margin-big-left fadein-top">
        <h1 style="line-height: 45px;">
            <img src="../img/y.jpg" class="radius-circle" height="50">
            BBS管理中心
        </h1>
    </div>
    <div class="head-l">
        <a href="../index.php" class="button button-little bg-green" target="_blank">
            <span class="icon-name"><i class="fa fa-home fa-x"></i></span>
            前台首页
        </a>
        <a href="#" class="button button-little bg-red" id="logout">
            <span class="icon-name"><i class="fa fa-power-off fa-x"></i></span>
            退出登录
        </a>
    </div>

    <div class="time">
        <em class="manage-info">
            <?php
                //查询出当前用户信息
                if (isset($mid)){
                    $sql = "select * from manager where mid={$mid}";
                    $data_man = fetch_array(execute($link, $sql));
                    $powerType = "";
                    if ($data_man['power'] == 0){
                        $powerType = "普通管理员";
                    }else if($data_man['power'] == 1){
                        $powerType = "超级管理员";
                    }
                }
            ?>
            您好，<?php echo $_SESSION['manage']['name'];?>
            [<?php echo $powerType;?>]
        </em>
        系统时间：<span>2016年11月15日 20:39:57</span>
    </div>
</div>
<!-- ../头部 -->