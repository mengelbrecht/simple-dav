<ul class="list-group">
    <li class="list-group-item active">
        <i class="fa fa-calendar"></i> Calendars
    </li>
    <li class="list-group-item">
        <a href="?action=addcalendar"><i class="fa fa-plus"></i> Create...</a>
    </li>
<?php if (empty($addressBooks)): ?>
    <li class="list-group-item"><i>No address books</i></li>
<?php else: ?>
<?php foreach ($calendars as $name => $count): ?>
    <li class="list-group-item">
        <div class="row">
            <div class="col-md-5"><?= SimpleDAV\Utils::escape($name) ?></div>
            <div class="col-md-5">Events <span class="badge"><?= $count ?></span></div>
            <div class="col-md-2"><a href="#"><i class="fa fa-trash-o fa-lg"></i> Delete</a></div>
        </div>
    </li>
<?php endforeach ?>
<?php endif ?>
</ul>
<ul class="list-group">
    <li class="list-group-item active">
        <i class="fa fa-book"></i> Address Books
    </li>
    <li class="list-group-item">
        <a href="?action=addaddressbook"><i class="fa fa-plus"></i> Create...</a>
    </li>
<?php if (empty($addressBooks)): ?>
    <li class="list-group-item"><i>No address books</i></li>
<?php else: ?>
<?php foreach ($addressBooks as $name => $count): ?>
    <li class="list-group-item">
        <div class="row">
            <div class="col-md-5"><?= SimpleDAV\Utils::escape($name) ?></div>
            <div class="col-md-5">Cards <span class="badge"><?= $count ?></span></div>
            <div class="col-md-2"><a href="#"><i class="fa fa-trash-o fa-lg"></i> Delete</a></div>
        </div>
    </li>
<?php endforeach ?>
<?php endif ?>
</ul>
