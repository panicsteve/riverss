# riverss
RSS aggregator

It looks like this: http://stevenf.com/riverss/

## Quickstart

Sorry, getting this running is not very user friendly at this time.

1. Make sure you know a MySQL user with at least select/update/insert privileges.
1. Run `./setup`
1. Manually add some feed titles/URLs to the table called feeds. (sorry, no GUI for this)
1. Init feeds by hitting [yourserver]/riverss/index.php/feeds/update
1. Set up a cron job or something to hit that URL periodically to update feeds.

## Acknowledgements

- Uses SimplePie for RSS parsing.
- Uses CodeIgniter for MVC framework.

