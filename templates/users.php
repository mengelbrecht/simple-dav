<ul class="list-group">
    <li class="list-group-item active">
        <i class="fa fa-users"></i> Users
    </li>
    <li class="list-group-item">
        <a href="?action=add-user"><i class="fa fa-user-plus"></i> Create...</a>
    </li>
<?php foreach ($users as $user): ?>
    <li class="list-group-item">
        <div class="row">
            <div class="col-md-5"><?= \SimpleDAV\Utils::escape($user['username']) ?></div>
            <div class="col-md-3">
<?php if ($user['role'] == \SimpleDAV\Model\Role::ADMIN): ?>
                <span class="label label-success">admin</span>
<?php elseif ($user['role'] == \SimpleDAV\Model\Role::REGULAR): ?>
                <span class="label label-warning">regular</span>
<?php endif ?>
            </div>
            <div class="col-md-2"><a href="#"><i class="fa fa-pencil fa-fw"></i> Edit</a></div>
<?php if ($user['username'] !== $username): ?>
            <div class="col-md-2"><a href="?action=confirm-delete-user&user_id=<?= \SimpleDAV\Utils::escape($user['id']) ?>"><i class="fa fa-trash-o fa-lg"></i> Delete</a></div>
<?php endif ?>
        </div>
    </li>
<?php endforeach ?>
</ul>
