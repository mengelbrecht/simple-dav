SimpleDAV
=========

SimpleDAV is a simplistic WebDAV, CalDAV and CardDAV server using [SabreDAV](https://github.com/fruux/sabre-dav).
It is easy to setup and has almost no dependencies. For authentication it uses an IMAP server (for now).

Requirements
------------
* PHP >= 5.5
* SQLite
* [Composer](https://getcomposer.org/)
* IMAP server for authentication (this requirement will be dropped in a later version)

Installation
------------

1. `git clone https://github.com/mgee/simple-dav.git`
2. `cd simple-dav`
3. `composer install`

Configuration & Usage
---------------------

1. Open the `config.php` file and adjust the address of the IMAP server if necessary (e.g. enable certificate checking).

2. Open `https://your-domain-here/simple-dav/server.php/` in your browser (adjust the URL for your server).

3. Authenticate using your username and password for the IMAP server.
SimpleDAV automatically creates a user with the provided username if the authentication succeeded.
The created user also has a default address book and calendar already.

4. Setup your clients to use the CalDAV and CardDAV server by specifying the URL `https://your-domain-here/simple-dav/server.php/`.
Alternatively, if you have configured service discovery (see next section) you can just use `https://your-domain-here` as URL.

Service Discovery
-----------------

To enable automatic discovery of the CalDAV and CardDAV service by clients you can use *Well-known* redirects.
Assuming that you have cloned SimpleDAV to your document root of your webserver and are running Apache, put these lines in the `.htaccess` file of your document root:
```
Redirect /.well-known/carddav /simple-dav/server.php/
Redirect /.well-known/caldav /simple-dav/server.php/
```

Another useful redirect is the shortcut to the `server.php`:
```
RedirectMatch ^/simple-dav/?$ /simple-dav/server.php/
```

License
-------

Released under the [MIT License](LICENSE)
