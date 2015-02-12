<form class="form-horizontal" method="post" action="?action=add-user" autocomplete="off">
    <div class="form-group">
        <label for="inputUsername" class="col-sm-3 control-label">Username</label>
        <div class="col-sm-9">
            <input type="text" name="username" class="form-control" id="inputUsername" placeholder="Username" required autofocus>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail" class="col-sm-3 control-label">Email address</label>
        <div class="col-sm-9">
            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="E-Mail">
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword" class="col-sm-3 control-label">Password</label>
        <div class="col-sm-9">
            <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            <button type="submit" class="btn btn-success btn-sm">Create</button>
        </div>
        <div class="col-sm-offset-1 col-sm-5">
            <a href="?action=users" class="btn btn-danger btn-sm">Cancel</a>
        </div>
    </div>
</form>
