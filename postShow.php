<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>帖子展示</title>
    <link rel="stylesheet" href="font/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/publish.css">
    <link rel="stylesheet" href="css/postShow.css">
    <script src="js/jquery-1.12.2.min.js"></script>
    <script src="layui/layui.js"></script>
    <script src="js/common.js"></script>
    <script src="kindeditor/kindeditor-all-min.js"></script>
    <script src="kindeditor/lang/zh-CN.js"></script>
    <script src="js/postShow.js"></script>
    <script src="js/handle.js"></script>
</head>
<?php
    //开启session
    session_start();
    //定义常量ON来获取访问页面的权限
    define('ON', true);
    //引入公共文件
    require_once 'inc/common.inc.php';
    //调用数据库连接函数
    $link = connect();
    //查询公告内容
    $sql_n = "select * from notice where nid=1";
    $data_n = fetch_array(execute($link, $sql_n));
    $nc = $data_n["noticeContent"];
    //判断当前是否为登录状态
    $member_id = login_state($link);

    //引入处理登录信息
    include_once "inc/handlerLogin.php";
    /*判断postId*/
    if (!isset($_GET['postId']) || !is_numeric($_GET['postId'])){
        promptBox('postId传参错误', 5, 'index.php');
        exit;
    };
    //存放帖子id
    $postId = $_GET['postId'];
    //查询是否存在此条帖子信息
    $sql_post = "select * from post where postId={$postId}";
    if (nums($link, $sql_post) == 0) {
        promptBox('这条帖子信息不存在', 5, 'index.php');
        exit;
    }
    //更新查看的次数
    $sql_times = "update post set times=times+1 where postId={$postId}";
    execute($link, $sql_times);
    //查询当前帖子对应的所属的子版块，发帖人等信息
    $post_msg = "select * from post p,sub_module sm,parent_module pm,user u where p.postId={$postId} and p.tsmoduleId=sm.sid and p.postuid=u.id and sm.tParenModuleId=pm.pid";
    $res_post = execute($link, $post_msg);
    $data_post = fetch_array($res_post);
    //判断用户类型
    $userType = "";
    if ($data_post["userType"] == 1){
        $userType = "版主";
    }else{
        $userType = "普户";
    }
    //查询当前帖子对应的父版块
    $topm_sql = "select * from parent_module where pid={$data_post['tParenModuleId']}";
    $data_topm = fetch_array(execute($link, $topm_sql));
    //判断是否为版主
    if($member_id){
        $sql_p = "select * from parent_module where pmoduleName='{$data_topm['pmoduleName']}' and moderatorId={$member_id}";
        $nums_p = nums($link, $sql_p);
    }
    //用户头像地址
    $imgurl = "";
    if (!empty($data_post['photo'])){
        $imgurl = $data_post['photo'];
    }else{
        $imgurl = "img/noavatar_middle.gif";
    }
    //查询当前发帖人的帖子总数
    $post_total = "select * from post where postuid={$data_post['id']}";
    $post_counts = nums($link, $post_total);

    //查询出当前帖子的回复信息(用来分页)
    $post_reply = "select * from reply where tpostId=$postId";
    $rep_total = nums($link, $post_reply);
    $page_size = 2;
    $page = page($rep_total, $page_size);
    //查询出当前帖子的回复信息(limit分页显示)
    $post_reply = "select * from reply where tpostId=$postId {$page['limit']}";
    $res_post_reply = execute($link, $post_reply);
    //判断这条帖子是否为精华帖子
    $img = "";
    $isBoutique = "<a id='boutique' postId='{$postId}' sid='{$data_post['sid']}' href='JavaScript:void(0);'>精华</a>
                   <span class='pipe'>|</span>";
    $cancelBoutique = "";
    $boutique = $data_post['isBoutique'];
    if ($boutique){
        $img = "<img id='jinhua' src='img/jinhua.gif'>";
        $isBoutique = "";
        $cancelBoutique = "<a id='cancelBoutique' postId='{$postId}' sid='{$data_post['sid']}' href='JavaScript:void(0);'>取消精华</a>
                           <span class='pipe'>|</span>";
    }
    //判断帖子是否屏蔽
    $shield = "<a id='shield' postId='{$postId}' sid='{$data_post['sid']}' href='javascript:void(0);'>屏蔽</a>";
    $cancelshield = "";
    $ishield = $data_post['isShield'];
    if ($ishield){
        $shield = "";
        $cancelshield = "<a id='cancelshield' postId='{$postId}' sid='{$data_post['sid']}' href='javascript:void(0);'>取消屏蔽</a>";
    }
    //判断当前的帖子发帖人是否是当前登录用户发的帖子(或者时版主)，如果是则显示删除，编辑功能
    $edit = "";
    $delete = "";
    if (($data_post['id'] == $member_id) || ($member_id == $data_topm['moderatorId'])){
        $edit = "<a class='editBtn' id='editpBtn' shield='{$ishield}' postId='{$postId}' sid='{$data_post['sid']}' postStatus='{$data_post['postStatus']}' href='javascript:void(0);'>编辑</a>";
        $delete = "<p postId='{$postId}' class='deleteBtn'>删除</p>";
    }

?>
<script>
</script>
<body>
<!--引入头部-->
<?php include_once "inc/header.inc.php"?>
<!--引入导航-->
<?php include_once "inc/nav.inc.php"?>
<div class="container" style="width: 990px;">
    <div class="position">
        <div class="z">
            <a href="index.php" class="nvhm"><i class="fa fa-home"></i></a>
            <em><i class="fa fa-angle-right"></i></em>
            <a href="pModuleList.php?pid=<?php echo $data_post['pid']?>"><?php echo $data_post['pmoduleName'];?></a>
            <em><i class="fa fa-angle-right"></i></em>
            <a href="sModuleList.php?sid=<?php echo $data_post['sid']?>"><?php echo $data_post['smoduleName'];?></a>
            <em><i class="fa fa-angle-right"></i></em>
            <?php echo $data_post['postTitle'];?>
        </div>
    </div>
    <div class="pgt">
        <button type="button" sid=<?php echo $data_post['sid'];?> id="pubBtn" class="btn btn-primary"><i class="fa fa-edit"></i>发帖</button>
        <button type="button" postId=<?php echo $postId;?> id="repBtn" class="btn btn-primary"><i class="fa fa-reply-all"></i>回复</button>
        <ul class="pagination" style="display: inline; margin: 0;padding: 0; float: right;">
            <?php
                echo $page['html'];
            ?>
        </ul>
    </div>
    <?php
        if(isset($member_id) && isset($nums_p) && $nums_p){
    ?>
            <div id="modmenu" class="xi2 pbm">
                <a id="delTheme" postId=<?php echo $postId;?> sid=<?php echo $data_post['sid'];?> href="javascript:void(0);">删除主题</a>
                <span class="pipe">|</span>
                <?php echo $isBoutique;?>
                <?php echo $cancelBoutique;?>
                <a id="move" href="#">移动</a>
                <span class="pipe">|</span>
                <a href="#">置顶</a>
                <span class="pipe">|</span>
                <?php echo $shield;?>
                <?php echo $cancelshield;?>
            </div>
    <?php
        }
    ?>

<!--帖子展示-->
<?php
    if($_GET['page'] == 1){
      $postTitle = htmlspecialchars($data_post['postTitle']);
      $postTime = tranTime(strtotime($data_post['postTime']));
      $postContent = ""; //帖子内容
      //判断帖子是否已通过审核
      if ($data_post["postStatus"] == 1){
          $postContent = "<span id='lock'><i class='fa fa-lock'></i><em class='tip'>提示：该帖内容还未通过审核，请联系管理员或版主</em></span>";
      }else{
          //判断帖子是否被屏蔽
          if ($data_post['isShield']){
              $postContent = "<span id='lock'><i class='fa fa-lock'></i><em class='tip'>提示：该帖被管理员或版主屏蔽，请联系管理员或版主</em></span>";
          }else{
              $postContent = nl2br($data_post['postContent']);
          }
      }

      $html=<<<EOT
        <div class="wrapContent">
            <div class="col-md-2 col-sm-2 col-xs-2" id="wcleft">
                <div class="hm ptn">
                    <span class="xg1">查看:</span>
                    <span class="xi1">{$data_post['times']}</span>
                    <span class="pipe">|</span>
                    <span class="xg1">回复:</span>
                    <span class="xi1">{$rep_total}</span>
                </div>
                <div class="pls"></div>
                <div class="author">
                    <a href="#" class="xw1">{$data_post['name']}</a>
                </div>
                <div class="avatar">
                    <a href="userProfile.php?uid={$data_post['id']}&postId={$postId}"><img src="{$imgurl}" width="120" height="120"></a>
                </div>
                <div class="theme">
                    <table>
                        <tr>
                            <td><a href="userPost.php?uid={$data_post['id']}">{$post_counts}</a></td>
                            <td><a href="userPost.php?uid={$data_post['id']}">{$post_counts}</a></td>
                            <td style="border: none;"><a href="#">**</a></td>
                        </tr>
                        <tr>
                            <td>主题</td>
                            <td>帖子</td>
                            <td style="border: none;">{$userType}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-10 col-sm-10 col-xs-10" id="wcright">
                <div class="ptitle">
                    <h1>{$postTitle}</h1>
                </div>
                <div class="pls plsright"></div>
                {$img}
                <div class="authi">
                    <img class="authicn vm" src="img/online_moderator.gif" alt="">
                    <em>发表于 {$postTime}</em>
                    <span class="pipe">|</span>
                    <strong class="floor" style="color: #f00;">楼主</strong>
                    <div class="pcontent">
                        {$postContent}
                    </div>
                    <div class="po">
                        {$edit}{$delete}
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
EOT;
        echo $html;
 }?>
<!--../帖子展示-->
<!--回复信息展示-->
    <?php
    //楼层自增
    $floor = ($_GET['page']-1)*$page_size+1;
    //循环输出回复的信息
    $rep_url = "img/noavatar_middle.gif";
    while ($data_reply = fetch_array($res_post_reply)){
        //查询出当条回复的回帖人、时间等信息
        $sql_sel = "select * from user u where {$data_reply['ruid']}=u.id";
        $data_reply_msg = fetch_array(execute($link, $sql_sel));
        //判断回帖人类型
        $userTypep = "";
        if ($data_reply_msg["userType"] == 1){
            $userTypep = "版主";
        }else{
            $userTypep = "普户";
        }
        //回复者头像
        if (isset($data_reply_msg['photo']) && !empty($data_reply_msg['photo'])){
            $rep_url = $data_reply_msg['photo'];
        }else{
            $rep_url = "img/noavatar_middle.gif";
        }
        //查询当条回复回帖人的帖子数
        $sql_ruser_post = "select * from post where postuid={$data_reply_msg['id']}";
        $ruser_post_counts = nums($link, $sql_ruser_post);
    ?>
        <div class="wrapContent">
            <div class="col-md-2 col-sm-2 col-xs-2" id="wcleft">
                <div class="pls plsrep"></div>
                <div class="author">
                    <a href="#" class="xw1"><?php echo $data_reply_msg['name'];?></a>
                </div>
                <div class="avatar">
                    <a href="userProfile.php?uid=<?php echo $data_reply_msg['id'];?>&postId=<?php echo $postId;?>">
                        <img src="<?php echo $rep_url;?>" width="120" height="120">
                    </a>
                </div>
                <div class="theme">
                    <table>
                        <tr>
                            <td><a href="userPost.php?uid=<?php echo $data_reply_msg['id'];?>"><?php echo $ruser_post_counts;?></a></td>
                            <td><a href="userPost.php?uid=<?php echo $data_reply_msg['id'];?>"><?php echo $ruser_post_counts;?></a></td>
                            <td style="border: none;"><a href="#">**</a></td>
                        </tr>
                        <tr>
                            <td>主题</td>
                            <td>帖子</td>
                            <td style="border: none;"><?php echo $userTypep;?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-10 col-sm-10 col-xs-10" id="wcright">
                <div class="pls plsright prsrep"></div>
                <div class="authi authirep">
                    <img class="authicn vm" src="img/online_moderator.gif" alt="">
                    <em>发表于 <?php echo tranTime(strtotime($data_reply['rtime']));?></em>
                    <strong class="floor">
                        <?php
                            $floors = $floor++;
                            if ($floors == 1){
                                echo "沙发";
                            }else if ($floors == 2){
                                echo "板凳";
                            }else if ($floors == 3){
                                echo "地板";
                            }else{
                                echo $floors.' 楼';
                            }
                        ?>
                    </strong>
                    <div class="pcontent pcontentrep">
                        <?php if($data_reply['quoteId']){
                            $sql = "select * from reply where tpostId={$postId} and rid<={$data_reply['quoteId']}";
                            $i = nums($link, $sql); //楼层数
                            //查询引用回复的那条信息的发布人的相关信息
                            $sql_sel = "select * from reply rep,user u where rep.rid={$data_reply['quoteId']} and u.id=rep.ruid";
                            $result = execute($link, $sql_sel);
                            $data = fetch_array($result);
                            ?>
                            <div class="quote">
                                <span class="block">
                                    <h2>回复 <?php echo $i;?> 楼 <?php echo $data['name']?> <?php echo tranTime(strtotime($data_reply['rtime']));?> 发表的: </h2>
                                    <p><?php echo $data['rcontent'];?></p>
                                </span>
                            </div>
                        <?php }?>
                        <?php echo nl2br($data_reply['rcontent']);?>
                    </div>
                    <div class="po">
                        <a href="javascript:void(0);" class="quoteBtn quoteRepBtn" postId="<?php echo $postId;?>" quoteId="<?php echo $data_reply['rid'];?>">回复</a>
                        <?php
                        //判断是否为当前登录用户自己发的帖（或者时版主），如果是则显示 编辑功能
                        if (($member_id == $data_reply_msg['id']) || ($member_id == $data_topm['moderatorId'])){
                            echo "<a class='editBtn' href='replyEdit.php?rid={$data_reply['rid']}&postId={$postId}'>编辑</a>";
                            echo "<p rid='{$data_reply['rid']}' sid='{$data_post['sid']}' postId='{$postId}' class='deleteRepBtn'>删除</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php
    }
    ?>
<!--../回复信息展示-->
    <div class="pgt">
        <button type="button" sid=<?php echo $data_post['sid'];?> id="pubBtn1" class="btn btn-primary"><i class="fa fa-edit"></i>发帖</button>
        <button type="button" postId=<?php echo $postId;?> id="repBtn1" class="btn btn-primary"><i class="fa fa-reply-all"></i>回复</button>
        <ul class="pagination" style="display: inline; margin: 0;padding: 0; float: right;">
            <?php
                echo $page['html'];
            ?>
        </ul>
    </div>
    <div class="fastpub">
        <div class="col-md-2 col-sm-2 col-xs-2" id="fastpub-left">
            <div class="fastpub-avatar">
                <a href="#"><img src="<?php echo $rep_url;?>" width="120" height="120"></a>
            </div>
        </div>
        <div class="col-md-10 col-sm-10 col-xs-10" id="fastpub-right">
            <textarea name="fastrepcont" id="fastrepcont"></textarea>
            <?php
            //当没有登录时，显示不能快速发帖
            if (empty($member_id)){
                $htmlisLogin = <<<EOT
                           <div class="isLogin">
                                您需要登录后才可以发帖
                                <a href="login.php" class="xi2">登录</a> |
                                <a href="register.php" class="xi2">立即注册</a>
                           </div> 
EOT;
                echo $htmlisLogin;
            }
            ?>
            <div class="row" style="padding-left: 15px;margin-top: 5px;">
                <input type="text" name="yzm" id="yzm" class="form-control w15" placeholder="填写验证码">
                <img src="inc/vcode.php" class="yzmpic" alt="验证码" title="点击刷新验证码">
            </div>
            <div class="row" style="padding-left: 15px;margin-top: 5px;">
                <button type="button" postId="<?php echo $postId;?>" class="btn btn-primary" id="reply"><i class="fa fa-reply-all"></i>发表回复</button>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!--引入底部-->
<?php include_once "inc/footer.inc.php"?>
</body>
</html>