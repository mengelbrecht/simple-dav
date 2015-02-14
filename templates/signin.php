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
        <input type="hidden" name="csrf" id="form-csrf" value="<?= $values[SimpleDAV\CSRFToken::ID] ?>"/>
        <h2 class="form-signin-heading">Please sign in</h2>
        <div class="form-group">
            <input type="text" name="username" id=username" class="form-control" placeholder="Username" value="<?= SimpleDAV\Utils::escape($values['username']) ?>" required <?= isset($error) ? "" : "autofocus"?>>
        </div>
        <div class="form-group <?= isset($error) ? "has-error has-feedback" : ""?>">
            <input class="form-control <?= isset($error) ? 'input-padding-right' : '' ?>" name="password" type="password" placeholder="Password" value="<?= isset($error) ? "" : SimpleDAV\Utils::escape($values['password']) ?>" required  <?= isset($error) ? "autofocus" : "" ?>>
<?php if (isset($error)): ?>
            <span class="fa fa-exclamation-circle form-control-feedback input-suffix" aria-hidden="true"></span>
<?php endif ?>
        </div>
        <div class="form-group">
            <div class="checkbox"><label><input type="checkbox" value="remember-me"> Remember me</label></div>
        </div>
        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block" type="submit"><i class="fa fa-sign-in"></i> Sign in</button>
        </div>
<?php if (isset($error)): ?>
        <div class="form-group">
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?= SimpleDAV\Utils::escape($error) ?></div>
        </div>
<?php endif ?>
    </form>
</div>
</body>
</html>
