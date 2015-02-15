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
<?php foreach ($calendars as $calendar): ?>
    <li class="list-group-item">
        <div class="row">
            <div class="col-md-5"><?= SimpleDAV\Utils::escape($calendar['name']) ?></div>
            <div class="col-md-5">Events <span class="badge"><?= $calendar['count'] ?></span></div>
            <div class="col-md-2"><a href="?action=confirm-delete-calendar&calendar_id=<?= $calendar['id'] ?>"><i class="fa fa-trash-o fa-lg"></i> Delete</a></div>
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
<?php foreach ($addressBooks as $addressBook): ?>
    <li class="list-group-item">
        <div class="row">
            <div class="col-md-5"><?= SimpleDAV\Utils::escape($addressBook['name']) ?></div>
            <div class="col-md-5">Cards <span class="badge"><?= $addressBook['count'] ?></span></div>
            <div class="col-md-2"><a href="#"><i class="fa fa-trash-o fa-lg"></i> Delete</a></div>
        </div>
    </li>
<?php endforeach ?>
<?php endif ?>
</ul>
