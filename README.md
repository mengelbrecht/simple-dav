SimpleDAV
=========

**Development of SimpleDAV was discontinued. Consider using [Baïkal](https://github.com/fruux/Baikal) instead.**

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

4. Setup your clients to use the CalDAV and CardDAV server.
If you cloned SimpleDAV into your document root specify the URL `https://your-domain-here/simple-dav/` as server.
Alternatively, if you have configured service discovery (see next section) you can just use `https://your-domain-here` as URL.

Service Discovery
-----------------

Service discovery enables clients to automatically find the URL of your server even if it is installed in a subfolder of your document root.
To enable automatic discovery of the CalDAV and CardDAV service by clients you can use *Well-known* redirects.
If you have installed SimpleDAV directly in your document root (e.g. maybe for a subdomain like `dav.your-domain-here`) Service Discovery is already configured
and you can skip this section.
If you have cloned SimpleDAV to your document root of your webserver and you are running Apache, put these lines in the `.htaccess` file of your document root:
```
Redirect /.well-known/carddav /simple-dav/server.php/
Redirect /.well-known/caldav /simple-dav/server.php/
```

License
-------

Released under the [MIT License](LICENSE)
