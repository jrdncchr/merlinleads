<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

define('CSS', 'resources/css/');
define('JS', 'resources/js/');
define('IMG', 'resources/images/');
define('FONT', 'resources/font-awesome/');
define('OTHERS', 'resources/others/');

define('DB_DATABASE', 'merlinle_mldb');
define('DB_USERNAME', 'merlinle_admin');
define('DB_PASSWORD', 'ml143');
define('DB_HOST', 'localhost');

/* API Integration
 */
define('FB_APP_ID', '995734017131931');
define('FB_SECRET_KEY', 'ddc7e43bde20c8bd37bb180cdbecc6cc');

define('LI_CLIENT_ID', '75d3bm3svzr0ar');
define('LI_SECRET_KEY', '6s4F3ExHzXlti54j');
define('LI_CALLBACK', 'http://127.0.0.1:80/merlinleads/linkedin/auth');

$stripe_keys = file(FCPATH . OTHERS . "stripe/ml_test.txt", FILE_IGNORE_NEW_LINES);
//$stripe_keys = file(FCPATH . OTHERS . "stripe/ml_live.txt", FILE_IGNORE_NEW_LINES);
define('STRIPE_PUBLISHABLE_KEY', $stripe_keys[0]);
define('STRIPE_SECRET_KEY', $stripe_keys[1]);

/* Others
 */
define('TIME_ADJUST', 8);


/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */