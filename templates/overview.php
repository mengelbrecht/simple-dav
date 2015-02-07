<ul class="list-group">
    <li class="list-group-item active">
        Calendars
    </li>
<?php foreach ($calendars as $name => $count): ?>
    <li class="list-group-item">
        <?= SimpleDAV\Utils::escape($name) ?><span class="badge"><?= $count ?></span>
    </li>
<?php endforeach ?>
</ul>

<ul class="list-group">
    <li class="list-group-item active">
        Address Books
    </li>
<?php foreach ($addressBooks as $name => $count): ?>
    <li class="list-group-item">
        <?= SimpleDAV\Utils::escape($name) ?><span class="badge"><?= $count ?></span>
    </li>
<?php endforeach ?>
</ul>
