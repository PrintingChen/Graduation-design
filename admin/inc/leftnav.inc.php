<!-- 左侧栏导航 -->
<div class="leftnav">
    <div class="leftnav-title">
        <strong>
            <span><i class="fa fa-list"></i></span>
            菜单列表
        </strong>
    </div>
    <h2>
        <span><i class="fa fa-gear"></i></span>
        个人设置
    </h2>
    <ul>
        <li>
            <a href="passModify.php">
                <span><i class="fa fa-caret-right"></i></span>
                修改密码
            </a>
        </li>
    </ul>
    <h2>
        <span><i class="fa fa-cogs"></i></span>
        基本设置
    </h2>
    <ul>
        <li>
            <a href="verify.php">
                <span><i class="fa fa-caret-right"></i></span>
                审核设置
            </a>
        </li>
        <li>
            <a href="systemNotice.php">
                <span><i class="fa fa-caret-right"></i></span>
                系统公告
            </a>
        </li>
        <li>
            <a href="sensitiveWord.php">
                <span><i class="fa fa-caret-right"></i></span>
                词语过滤
            </a>
        </li>
    </ul>
    <?php
        //查询当前登录的管理员的等级
        $sql_currm = "select * from manager where mid={$mid}";
        $data_currm = fetch_array(execute($link, $sql_currm));
        //var_dump($data_currm);exit;
        //echo $data_currm["power"];exit;
        if ($data_currm["power"] == 1){
    ?>
            <h2>
                <span><i class="fa fa-user"></i></span>
                管理员管理
            </h2>
            <ul>
                <li>
                    <a href="managerList.php">
                        <span><i class="fa fa-caret-right"></i></span>
                        管理员列表
                    </a>
                </li>
                <li>
                    <a href="addManager.php">
                        <span><i class="fa fa-caret-right"></i></span>
                        添加管理员
                    </a>
                </li>
            </ul>
    <?php
        }
    ?>
    <h2>
        <span><i class="fa fa-users"></i></span>
        用户管理
    </h2>
    <ul>
        <li>
            <a href="userList.php">
                <span><i class="fa fa-caret-right"></i></span>
                用户列表
            </a>
        </li>
        <li>
            <a href="addUser.php">
                <span><i class="fa fa-caret-right"></i></span>
                添加用户
            </a>
        </li>
        <li>
            <a href="forbidUserSearch.php">
                <span><i class="fa fa-caret-right"></i></span>
                禁止用户
            </a>
        </li>
        <li>
            <a href="verifyUser.php">
                <span><i class="fa fa-caret-right"></i></span>
                审核用户
            </a>
        </li>
    </ul>
    <h2>
        <span><i class="fa fa-th"></i></span>
        版块管理
    </h2>
    <ul>
        <li>
            <a href="pModuleList.php">
                <span><i class="fa fa-caret-right"></i></span>
                父版块列表
            </a>
        </li>
        <li>
            <a href="sModuleList.php">
                <span><i class="fa fa-caret-right"></i></span>
                子版块列表
            </a>
        </li>
        <li>
            <a href="addParentModule.php">
                <span><i class="fa fa-caret-right"></i></span>
                添加父版块
            </a>
        </li>
        <li>
            <a href="addSubModule.php">
                <span><i class="fa fa-caret-right"></i></span>
                添加子版块
            </a>
        </li>
    </ul>
    <h2>
        <span><i class="fa fa-comments"></i></span>
        内容管理
    </h2>
    <ul>
        <li>
            <a href="postList.php">
                <span><i class="fa fa-caret-right"></i></span>
                帖子列表
            </a>
        </li>
        <li>
            <a href="verifyPostStatus.php">
                <span><i class="fa fa-caret-right"></i></span>
                审核帖子
            </a>
        </li>
        <li>
            <a href="replyList.php">
                <span><i class="fa fa-caret-right"></i></span>
                回复列表
            </a>
        </li>
    </ul>
    <h2>
        <span><i class="fa fa-bar-chart"></i></span>
        系统信息
    </h2>
    <ul>
        <li>
            <a href="systemInfo.php">
                <span><i class="fa fa-caret-right"></i></span>
                信息统计
            </a>
        </li>
    </ul>
</div>
<!-- ../左侧栏导航 -->