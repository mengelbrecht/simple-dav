<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">
    <title>Overview</title>
    <link href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/flatly/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/overview.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">SimpleDAV</a>
        </div>
        <div class="navbar-collapse collapse navbar-inverse-collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li class="active"><a href="?action=overview"><i class="fa fa-user"></i> Overview</a></li>
                <li><a href="?action=users"><i class="fa fa-users"></i> Manage Users</a></li>
                <li><a href="?action=statistics"><i class="fa fa-bar-chart"></i> Statistics</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="?action=logout"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h3>User: <?= SimpleDAV\Utils::escape($values['username']) ?></h3>
</div>
</body>
</html>
