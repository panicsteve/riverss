# riverss
RSS aggregator

It looks like this: http://stevenf.com/riverss/

## Quickstart

Sorry, getting this running is not very user friendly at this time.

1. Create a MySQL database using schema.sql.  Remember to grant a user at least select/update/insert privileges.
2. Edit application/config/config.php and set base_url and adjust date_default_timezone_set() appropriately for you.
3. Edit application/config/database.php and set correct database host, username, password, etc, for your database server.
4. Create a folder called cache at the root of the project (next to index.php) and make it writable by the web server.
5. Manually add some feed titles/URLs to the table called feeds. (sorry, no GUI for this)
6. Init feeds by hitting [yourserver]/riverss/index.php/feeds/update
7. Set up a cron job or something to hit that URL periodically to update feeds.

## Acknowledgements

- Uses SimplePie for RSS parsing.
- Uses CodeIgniter for MVC framework.

