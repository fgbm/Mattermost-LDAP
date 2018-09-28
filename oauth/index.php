<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <link rel="icon" href="favicon.ico">

    <title>Авторизация в чате Полимедики</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
          integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="https://maxcdn.bootstrapcdn.com/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries --><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>

<body>

<div class="container">

    <form class="form-signin" action="connection.php" method="post">
        <h2 class="form-signin-heading">Вход в чат Полимедики</h2>
        <label for="inputUser" class="sr-only">Email address</label>
        <input type="text" name="user" id="inputUser" class="form-control" placeholder="Имя пользователя в домене"
               required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" autocomplete="new-password" id="inputPassword" class="form-control"
               placeholder="Пароль" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
    </form>

</div> <!-- /container -->

<script>
    document.getElementById("inputUser").setCustomValidity("Введите свой логин (тот же что и при включении компьютера)");
</script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->

<script src="https://maxcdn.bootstrapcdn.com/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
