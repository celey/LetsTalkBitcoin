###INSTALLATION OF TOKENLY CMS: LTB EDITION

Follow the below steps to set up the LTBN platform.

0) Set up linux web server using Ubuntu/Debian + NGINX + MySQL + PHP 5.6
	- Install the following PHP extensions: php5-json, php5-gd, php5-curl, php5-mysql, php5-mcrypt, php5-intl, php5-imagick, php5-gmp, php5-bcmath
	- Install `Composer` package manager for PHP
	- Recommended 8GB of RAM or more for system resources.

1) Upload the contents of the `www` folder to the location of your web root. Web root path should look like `/var/www/letstalkbitcoin/www`
	- make sure `letstalkbitcoin/www/files` and `letstalkbitcoin/www/resources/files` both have writeable permissions

2) Run CLI command `composer install` inside the letstalkbitcoin folder.

3) Create a mysql database called `ltb` and import ltb.sql into it.

4) Update config variables in `letstalkbitcoin/conf/config.php`
	- Many of the values and API keys here can be left as-is, some of them are also not in use anymore.
	- Make sure SITE_BASE and SITE_PATH is correct
	- Make sure MYSQL_DB credentials are correct
	- change the default CONTACT_EMAIL
	- Replace CAPTCHA_PUB/PRIV with your own Google ReCaptcha keys
	- replace MANDRILL_API_KEY with your own (Mailchimp/Mandrill API)
	- setup your own BLOCKTRAIL_KEY/SECRET at https://www.blocktrail.com/api
	
Note: Do not change Disqus API information... doing so may cause all comment threads on all blog posts to disappear.
Note 2: Do not change the Tokenpass API info either, so that everyones accounts continue to work properly.


5) Configure NGINX web server. See the `nginx/nginx.conf` and `nginx/sites-available/default` files for examples.

6) Temporary disable/comment out the HTTPS redirect in `letstalkbitcoin/conf/config.php` (near the bottom).

7) Set up a dummy domain name or subdomain for testing if platform is working
	- Requires a manual update to the `url` field in the `sites` table in the MySQL database
		- UPDATE sites SET domain = 'test.letstalkbitcoin.com', url = 'http://test.letstalkbitcoin.com' WHERE domain = 'letstalkbitcoin.com';

8) Visit test subdomain and make sure front page + other pages all load properly

9) When all seems to be working fine, contact Nick to coordinate final migration (most up-to-date DB + switch DNS records)

10) Prior to migration, make sure to update DB and nginx settings to the proper domain. 

11) After the migration is complete, install `Let's Encrypt!` and run ./letsencrypto-auto to generate a free 3-month SSL certificate. Re-enable the HTTPS redirect in conf/config.php afterwards
	
	


	
