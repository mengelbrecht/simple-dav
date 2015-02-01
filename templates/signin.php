<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../favicon.ico">
    <link href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/flatly/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/signin.css" rel="stylesheet">
    <title>Sign in</title>
</head>
<body>
<div class="container">
    <form class="form-signin" method="post" action="?action=login">
        <input type="hidden" name="csrf" id="form-csrf" value="<?= $values['csrf'] ?>"/>

        <h2 class="form-signin-heading">Please sign in</h2>
<?php if (isset($error)): ?>
        <div class="form-group has-error">
<?php endif ?>
        <label for="inputEmail" class="sr-only">Username</label>
        <input type="text" name="username" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
<?php if (isset($error)): ?>
        </div>
<?php endif ?>
        <div class="checkbox"><label><input type="checkbox" value="remember-me"> Remember me</label></div>
        <button class="btn btn-lg btn-primary btn-block" type="submit"><i class="fa fa-sign-in"></i> Sign in</button>
<?php if (isset($error)): ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?= SimpleDAV\Utils::escape($error) ?></div>
<?php endif ?>
    </form>
</div>
</body>
</html>
