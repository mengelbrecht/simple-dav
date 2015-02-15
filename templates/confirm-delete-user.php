<div class="alert alert-warning" role="alert">Do you really want to delete the user "<?= \SimpleDAV\Utils::escape($userToDelete) ?>"?</div>
<div class="row">
    <div class="col-sm-2">
        <a href="?action=delete-user&user_id=<?= $userID ?>" class="btn btn-danger btn-sm">Delete</a>
    </div>
    <div class="col-sm-2">
        <span class="pull-right">
            <a href="?action=users" class="btn btn-success btn-sm">Cancel</a>
        </span>
    </div>
</div>