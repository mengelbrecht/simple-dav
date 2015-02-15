<div class="alert alert-warning" role="alert">Do you really want to delete the calendar "<?= \SimpleDAV\Utils::escape($calendar) ?>"?</div>
<div class="row">
    <div class="col-sm-2">
        <a href="?action=delete-calendar&calendar_id=<?= $calendarID ?>" class="btn btn-danger btn-sm">Delete</a>
    </div>
    <div class="col-sm-2">
        <span class="pull-right">
            <a href="?action=overview" class="btn btn-success btn-sm">Cancel</a>
        </span>
    </div>
</div>