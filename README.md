SimpleDAV
=========

SimpleDAV is a simplistic WebDAV, CalDAV and CardDAV server using [SabreDAV](https://github.com/fruux/sabre-dav).
It is easy to setup and has almost no dependencies.

Requirements
------------
* PHP >= 5.5
* SQLite
* [Composer](https://getcomposer.org/)

Installation
------------

1. `git clone https://github.com/mgee/simple-dav.git`
2. `cd simple-dav`
3. `composer install`

Configuration & Usage
---------------------

1. Open `https://your-domain-here/simple-dav/` in your browser (adjust the URL for your server).

2. Login using the username *admin* and password *admin*.

3. Change the password of your account (and change the username if you want). 
*This part is not yet working. The username and password can only be changed manually using SQLite at the moment.*

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
