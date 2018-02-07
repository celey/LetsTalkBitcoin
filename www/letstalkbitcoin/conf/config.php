<?php
date_default_timezone_set('America/Los_Angeles');
define('SITE_BASE', '/var/www/letstalkbitcoin');
define('SITE_PATH', SITE_BASE.'/www');
define('FRAMEWORK_PATH', SITE_BASE.'/slick');
define('SITE_NAME', 'Lets Talk Bitcoin!');
define('SITE_DOMAIN', 'letstalkbitcoin.com');

 
define('MYSQL_DB', 'ltb');
define('MYSQL_USER', 'ltb');
define('MYSQL_PASS', '');
define('MYSQL_HOST', 'db.letstalkbitcoin.com');


define('CONTACT_EMAIL', 'nrathman@ironcladtech.ca');

define('DATE_FORMAT', 'F j\, Y \a\t g:i A');

define('SYSTEM_NAME', 'LTB Network');


define('CAPTCHA_PUB', '6LcnOwETAAAAADUdL-S250KsVXGOMfLoLGXuRQ8S');
define('CAPTCHA_PRIV', '6LcnOwETAAAAAJH2VIYGjDA7O_23p5eUI8bcy5xr');


define('SOUNDCLOUD_ID', '7801c7a5dcce2c1f33d66c82d867f1d6');
define('SOUNDCLOUD_SECRET', 'c5bb2bf2b990a535ed54aec3b1d90d47');

define('DISQUS_PUBLIC', 'VMQtTKcaEToKzKoeEpNkAAEpFDe5xSTKD49VmYbGQBNJCk7Ll3Srm7LRN9heYR7y');
define('DISQUS_SECRET', 'gxInIyeIkbHymWMhus5blc6Qde4VxsAqvOjdojYOyJZRNCX2Eo75GcG1v7fBfAhF');
define('DISQUS_DEFAULT_FORUM', 'letstalkbitcoin');
define('DISQUS_ADMIN', '2844110a495b4111b4ef88288acb4cd5');

define('XCP_USER', 'counterltb');
define('XCP_PASS', 'sdJc3jc8sj3fka2lLLLjsjcfuf3ma9021l');
define('XCP_IP', '72.14.189.161:4000');
define('XCP_CONNECT', 'http://'.XCP_USER.':'.XCP_PASS.'@'.XCP_IP.'/api/');
define('XCP_WALLET', '');
define('XCP_PREFIX', 'XCP_');
define('SATOSHI_MOD', 100000000);
define('XCP_BASE_FEE', 10000); //satoshis
define('XCP_FEE_MOD', (10860 * 2)); //extra satoshis for the xcp escrow transactions


define('BTC_USER', 'ltbrpc');
define('BTC_PASS', '2qwb2qE6Wx2aFPACwT5CttY6eSqSAaBJZSwAk9hDWsnx');
define('BTC_IP', '72.14.189.161:8332');
define('BTC_CONNECT', 'http://'.BTC_USER.':'.BTC_PASS.'@'.BTC_IP.'/');

define('PRIMARY_TOKEN_FIELD', 12); //fieldId for main token profile field (LTBcoin address)

define('ENCRYPT_KEY', 'Akjdj2jci2jf84gg57HWn3nfsk*aj2!54gajf239JAa1qrPPOwfoooasdj2wjjjjjj!34');

define('STOPFORUMSPAM_KEY', 'bn9ijx4uv8rqts');
define('STOPFORUMSPAM_API', 'http://api.stopforumspam.org/api');

define('XCP_FUEL_ACCOUNT', 'XCP_DUST_FUEL');
define('XCP_DEFAULT_FUEL', 0.0001);

define('TOKENSLOT_URL', 'http://slots.dev02.tokenly.co/api/v1/');
define('TOKENSLOT_KEY', '');

define('DEFAULT_MAIL_DRIVER', 'mandrill');
define('MANDRILL_API_KEY', 'wpUPbeDE1KaaiWRMxFT41w');

define('ENABLE_TOKEN_BALANCE_CHECK', true);

define('BLOCKTRAIL_KEY', '08ee7f4a48884bea7ff5e7899984f1dd835553d2');
define('BLOCKTRAIL_SECRET', '0ccb5921ed20bcc3db644468c281b03cd52cae02');
define('BLOCKTRAIL_TESTNET', false);

define('TOKENPASS_CLIENT', 'IaI2eoiRlwRk9N3It8B4vncnAeKYF0zD');
define('TOKENPASS_SECRET', 'KUmuA5AzYvJpUUDsmtk5AhWRRgs32RclxqK473NS');
define('TOKENPASS_URL', 'https://tokenpass.tokenly.com');
define('TOKENLY_ACCOUNTS_CLIENT_ID', TOKENPASS_CLIENT);
define('TOKENLY_ACCOUNTS_PROVIDER_HOST', TOKENPASS_URL);
define('TOKENPASS_PROVIDER_HOST', TOKENPASS_URL);
define('TOKENPASS_CLIENT_ID', TOKENPASS_CLIENT);
define('TOKENPASS_CLIENT_SECRET', TOKENPASS_SECRET);

if(isset($_SERVER['HTTP_HOST']) AND substr($_SERVER['HTTP_HOST'],0,4) == 'www.'){
	header('Location: http://'.str_replace('www.', '', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
	die();
}
if (isset($_SERVER['REMOTE_ADDR']) AND !isset($_SERVER['HTTPS']) AND !isset($noForceSSL) AND ($_SERVER['HTTP_HOST'] == 'letstalkbitcoin.com' OR $_SERVER['HTTP_HOST'] == 'tokenly.com')) {
    header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    die();
}

