# riverss
RSS aggregator

It looks like this: http://stevenf.com/riverss/

## Quickstart

Sorry, getting this running is not very user friendly at this time.

You can either use the setup assistant script, or configure manually.

### Setup assistant instructions

1. Make sure you have a MySQL database and user with at least select/update/insert privileges to that database.
1. Run `./setup` (requires Ruby)
1. Manually add some feed titles/URLs to the table called feeds. (sorry, no GUI for this)
1. Init feeds by hitting [yourserver]/riverss/index.php/feeds/update
1. Set up a cron job or something to hit that URL periodically to update feeds.

### Manual configuration instructions

1. Create a MySQL database using schema.sql.  Remember to grant a user at least select/update/insert privileges.
1. Edit application/config/config.php and set base_url and adjust date_default_timezone_set() appropriately for you.		 +1. Run `./setup`
1. Edit application/config/database.php and set correct database host, username, password, etc, for your database server.		 +1. Manually add some feed titles/URLs to the table called feeds. (sorry, no GUI for this)
1. Create a folder called cache at the root of the project (next to index.php) and make it writable by the web server.		 +1. Init feeds by hitting [yourserver]/riverss/index.php/feeds/update
1. Manually add some feed titles/URLs to the table called feeds. (sorry, no GUI for this)		 +1. Set up a cron job or something to hit that URL periodically to update feeds.
1. Init feeds by hitting [yourserver]/riverss/index.php/feeds/update		
1. Set up a cron job or something to hit that URL periodically to update feeds.



## Acknowledgements

- Uses SimplePie for RSS parsing.
- Uses CodeIgniter for MVC framework.

