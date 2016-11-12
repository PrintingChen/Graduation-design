<div id="header">
    <div class="container" style="width: 960px;padding: 0;">
        <div class="logo">logo</div>
        <div class="info">
            <?php
                //头像地址
                $img_url = null;
                if (isset($member_id) && $member_id) {
                    $sql_photo = "select photo from user where id={$member_id}";
                    $member_result = execute($link, $sql_photo); //出错点
                    $res_photo = fetch_array($member_result);
                    if ($res_photo['photo'] != '') {
                        $img_url = $res_photo['photo'];
                    }else{
                        $img_url = 'img/noavatar_small.gif';
                    }
                }else{
                    $img_url = 'img/noavatar_small.gif';
                }
                if(isset($member_id) && $member_id){
                    //查询出当前用户的信息
                    $sql_info = "select * from user where id='{$member_id}'";
                    $res_info = fetch_array(execute($link, $sql_info));
                    $html = <<<EOT
                        <ul>
                            <li class="person"><a href="#"><strong>{$res_info['name']}</strong></a></li>|
                            <li><a href="#">我的帖子</a></li> |
                            <li><a href="setProfile.php">设置</a></li> |
                            <li><a class="logout" href="#">退出</a></li> 
                            <li class="headpic"><a href="profile.php"><img src="{$img_url}" width="48" height="48"></a></li>
                        </ul>
EOT;

                    echo $html;
                }else{
                    $html = <<<EOT
                        <form method="post" id="info-form">
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
                                        <td style="padding-right: 10px;border-right: 1px solid #eee;"><button type="submit" name="sublogin" id="sub-btn">登录</button></td>
                                        <td style="padding-left: 10px;"><a href="register.php" target="_blank" id="login">立即注册</a></td>
                                    </tr>
                                </table>
                            </div>
                        </form>
EOT;
                    echo $html;
                }
            ?>

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