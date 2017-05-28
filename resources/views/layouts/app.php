<!DOCTYPE html>
<html lang="uk">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="autor" content="Кучевський Денис" />
    <meta name="description" content="Коментарі" />
    <title>Коментарі</title>

    <style type="text/css">
        .row{
            margin-bottom: 30px;
        }
        .answers{
            margin-left: 70px
        }
        .post{
            margin: 30px
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
        .post .post-description {
            padding: 15px;
        }
        .post .post-description .stats {
            margin-top: 20px;
        }
    </style>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />

    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
</head>

<body>

<!--Меню сайта-->
    <nav class="navbar navbar-inverse">
        <div class="container">
            <ul class="nav navbar-nav">
                <li><a href="/">
                        <span class="glyphicon glyphicon-home"></span>
                        Головна
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
            //Если пользователь авторизирован отображать его имя и выход из учетной записи
                if(isset($_SESSION['user']))
                    echo '<li><a href="#">
                            <span class="glyphicon glyphicon-user"></span>
                            '.unserialize($_SESSION['user'])->name.'</a></li>
                            <li><a href="/logout">
                            <span class="glyphicon glyphicon-log-out"></span>
                            Вийти</a></li>';
            //Иначи отображать регистрацию и вход в учетную запись
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

<!--Контент страницы-->
<div class="container-fluid">
    <?php
    if (isset($content))
        echo $content;
    ?>
</div>

</body>
</html>
