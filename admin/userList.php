<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户列表</title>
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/userList.css">
    <script src="../js/jquery-1.12.2.min.js"></script>
    <script src="js/admin-common.js"></script>
    <script src="../js/formValidator.js"></script>
    <script>
        $(function(){
            //验证表单
            $("#form-mdfpsw").formValidator();
            //全选
            $("#selectAll").on("click", function(){
                $(":checkbox").prop("checked", true);
            });
            //反选
            $("#selectReverse").on("click", function(){
                $(":checkbox").each(function (i) {
                    if(!$(this).prop("checked")){
                        $(this).prop("checked", true);
                    }else {
                        $(this).prop("checked", false)
                    }
                });
            });
        });
    </script>
</head>
<body>
<!--引入头部-->
<?php include_once 'inc/header.inc.php';?>
<!--引入侧边栏-->
<?php include_once 'inc/leftnav.inc.php';?>
<!--引入位置信息-->
<?php include_once 'inc/position.inc.php';?>
<!--主体部分-->
<div class="admin">
    <form action="">
        <div class="panel admin-panel">
            <div class="panel-head"><strong><span class="fa fa-list"></span> 用户列表</strong></div>
            <div class="padding border-bottom">
                <ul class="search" style="padding-left: 10px;">
                    <li>按性别搜索：</li>
                    <li>
                        <select name="sex" id="sex" class="form-control">
                            <option value="男">男</option>
                            <option value="女">女</option>
                        </select>
                    </li>
                    <li>按头衔搜索：</li>
                    <li>
                        <select name="level" id="level" class="form-control">
                            <option value="普通用户">普通用户</option>
                            <option value="版块版主">版块版主</option>
                        </select>
                    </li>
                    <li>按关键字搜索：</li>
                    <li>
                        <input type="text" class="form-control" name="keywords" id="keywords" placeholder="请输入关键字">
                    </li>
                    <li>
                        <button class="btn btn-default button btn-c"><i class="fa fa-search custom"></i>搜索</button>
                    </li>
                </ul>
            </div>
            <div class="body-content" style="padding-bottom: 0;">
                <table class="table table-hover" style="margin-bottom: 0;">
                    <thead>
                        <th style="width: 50px;">ID</th>
                        <th>用户名</th>
                        <th>头衔</th>
                        <th>Email</th>
                        <th>发帖数</th>
                        <th>操作</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" id="check" name="checkbox">1</td>
                            <td>张三</td>
                            <td>普通用户</td>
                            <td>13456@qq.com</td>
                            <td>132</td>
                            <td>
                                <a href="userEdit.php" class="btn-primary btn"><i class="fa fa-edit"></i>修改</a>
                                <a href="#" class="btn-danger btn"><i class="fa fa-trash-o"></i>删除</a>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="checkbox"> 2</td>
                            <td>李四</td>
                            <td>普通用户</td>
                            <td>13456@qq.com</td>
                            <td>123</td>
                            <td>
                                <a href="userEdit.php" class="btn-primary btn"><i class="fa fa-edit"></i>修改</a>
                                <a href="#" class="btn-danger btn"><i class="fa fa-trash-o"></i>删除</a>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="checkbox"> 3</td>
                            <td>李四</td>
                            <td>普通用户</td>
                            <td>13456@qq.com</td>
                            <td>123</td>
                            <td>
                                <a href="#" class="btn-primary btn"><i class="fa fa-edit"></i>修改</a>
                                <a href="#" class="btn-danger btn"><i class="fa fa-trash-o"></i>删除</a>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="checkbox"> 4</td>
                            <td>李四</td>
                            <td>普通用户</td>
                            <td>13456@qq.com</td>
                            <td>123</td>
                            <td>
                                <a href="userEdit.php" class="btn-primary btn"><i class="fa fa-edit"></i>修改</a>
                                <a href="#" class="btn-danger btn"><i class="fa fa-trash-o"></i>删除</a>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="checkbox"> 5</td>
                            <td>李四</td>
                            <td>普通用户</td>
                            <td>13456@qq.com</td>
                            <td>123</td>
                            <td>
                                <a href="#" class="btn-primary btn"><i class="fa fa-edit"></i>修改</a>
                                <a href="#" class="btn-danger btn"><i class="fa fa-trash-o"></i>删除</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-align: left; padding-left: 13px;">
                                <a href="#" class="btn btn-primary" id="selectAll">全选</a>
                                <a href="#" class="btn btn-primary" id="selectReverse">反选</a>
                                <a href="#" class="btn-danger btn"><i class="fa fa-trash-o"></i>删除所选</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <ul class="pagination" style="margin-bottom: 0;">
                                    <li><a href="#">上一页</a></li>
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                    <li><a href="#">下一页</a></li>
                                    <li><a href="#">尾页</a></li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
<!--../主体部分-->
</body>
</html>