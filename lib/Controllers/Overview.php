<?php

namespace SimpleDAV\Controllers;

use PicoFarad\Request;
use PicoFarad\Response;
use PicoFarad\Router;
use PicoFarad\Session;
use PicoFarad\Template;
use SimpleDAV\Model\User;

Router\get_action('overview', function () {
    Response\html(Template\layout('overview', [
        'page' => 'overview',
        'username' => User::loggedIn(),
        'isAdmin' => User::isAdmin(),
        'calendars' => User::getCalendars(),
        'addressBooks' => User::getAddressBooks()
    ]));
});

Router\get_action('confirm-delete-calendar', function () {
    $calendarID = Request\int_param('calendar_id');
    $calendar = User::getCalendarForID($calendarID);

    if (!isset($calendar)) {
        Session\flash_error('Calendar does not exist.');
        Response\redirect('?action=overview');
    }

    Response\html(Template\layout('confirm-delete-calendar', [
        'page' => 'overview',
        'username' => User::loggedIn(),
        'isAdmin' => User::isAdmin(),
        'calendar' => $calendar,
        'calendarID' => $calendarID
    ]));
});

Router\get_action('delete-calendar', function () {

    $calendarID = Request\int_param('calendar_id');

    if (User::deleteCalendarByIDs(User::principalUri(), [$calendarID])) {
        Session\flash('Calendar deleted successfully.');
    } else {
        Session\flash_error('Unable to delete calendar.');
    }

    Response\redirect('?action=overview');
});
