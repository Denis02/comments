<!DOCTYPE html>
<html lang="uk">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="autor" content="Кучевський Денис" />
    <meta name="description" content="Новини" />
    <title>Новини</title>

<!--    <link rel="stylesheet" type="text/css" href="--><?//=RESOURCES_DIR?><!--css/app.css">-->
    <style type="text/css">

        .answers{margin-left: 50px}

        .panel-shadow {
            box-shadow: rgba(0, 0, 0, 0.3) 7px 7px 7px;
        }
        .panel-white {
            border: 1px solid #dddddd;
        }
        .panel-white  .panel-heading {
            color: #333;
            background-color: #fff;
            border-color: #ddd;
        }
        .panel-white  .panel-footer {
            background-color: #fff;
            border-color: #ddd;
        }

        .post .post-heading {
            height: 95px;
            padding: 20px 15px;
        }
        .post .post-heading .avatar {
            width: 60px;
            height: 60px;
            display: block;
            margin-right: 15px;
        }
        .post .post-heading .meta .title {
            margin-bottom: 0;
        }
        .post .post-heading .meta .title a {
            color: black;
        }
        .post .post-heading .meta .title a:hover {
            color: #aaaaaa;
        }
        .post .post-heading .meta .time {
            margin-top: 8px;
            color: #999;
        }
        .post .post-image .image {
            width: 100%;
            height: auto;
        }
        .post .post-description {
            padding: 15px;
        }
        .post .post-description p {
            font-size: 14px;
        }
        .post .post-description .stats {
            margin-top: 20px;
        }
        .post .post-description .stats .stat-item {
            display: inline-block;
            margin-right: 15px;
        }
        .post .post-description .stats .stat-item .icon {
            margin-right: 8px;
        }
        .post .post-footer {
            border-top: 1px solid #ddd;
            padding: 15px;
        }
        .post .post-footer .input-group-addon a {
            color: #454545;
        }
        .post .post-footer .comments-list {
            padding: 0;
            margin-top: 20px;
            list-style-type: none;
        }
        .post .post-footer .comments-list .comment {
            display: block;
            width: 100%;
            margin: 20px 0;
        }
        .post .post-footer .comments-list .comment .avatar {
            width: 35px;
            height: 35px;
        }
        .post .post-footer .comments-list .comment .comment-heading {
            display: block;
            width: 100%;
        }
        .post .post-footer .comments-list .comment .comment-heading .user {
            font-size: 14px;
            font-weight: bold;
            display: inline;
            margin-top: 0;
            margin-right: 10px;
        }
        .post .post-footer .comments-list .comment .comment-heading .time {
            font-size: 12px;
            color: #aaa;
            margin-top: 0;
            display: inline;
        }
        .post .post-footer .comments-list .comment .comment-body {
            margin-left: 50px;
        }
        .post .post-footer .comments-list .comment > .comments-list {
            margin-left: 50px;
        }
    </style>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />

</head>
<body>
<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>

<nav class="navbar navbar-inverse">
    <div class="container">
        <ul class="nav navbar-nav">
            <li><a href="/">
                    <span class="glyphicon glyphicon-home"></span>
                    Головна</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php
            if(isset($_SESSION['user']))
                echo '<li><a href="#">
                        <span class="glyphicon glyphicon-user"></span>
                        '.unserialize($_SESSION['user'])->name.'</a></li>
                        <li><a href="/logout">
                        <span class="glyphicon glyphicon-log-out"></span>
                        Вийти</a></li>';
            else
                echo '<li><a href="/registration">
                        <span class="glyphicon glyphicon-user"></span>
                        Реєстрація</a></li>
                        <li><a href="/login">
                        <span class="glyphicon glyphicon-log-in"></span>
                        Увійти</a></li>';
            ?>
        </ul>
    </div>
</nav>

<div class="container-fluid">
    <?php
    if (isset($content))
        echo $content;
    ?>
</div>

</body>
</html>
