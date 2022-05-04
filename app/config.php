<?php

ini_set('error_log', 'data/icehrm.log');

define('APP_NAME', 'XHRM');
define('FB_URL', 'XHRM');
define('TWITTER_URL', 'XHRM');

define('CLIENT_NAME', 'app');
define('APP_BASE_PATH', 'C:/xampp/htdocs/rokel_hrm/core/');
define('CLIENT_BASE_PATH', 'C:/xampp/htdocs/rokel_hrm/app/');
define('BASE_URL','http://localhost/rokel_hrm/web/');
define('CLIENT_BASE_URL','http://localhost/rokel_hrm/app/');

define('APP_DB', 'hrmdata');
define('APP_USERNAME', 'root');
define('APP_PASSWORD', '');
define('APP_HOST', 'localhost');

define('APP_CON_STR', 'mysqli://'.APP_USERNAME.':'.APP_PASSWORD.'@'.APP_HOST.'/'.APP_DB);

//file upload
define('FILE_TYPES', 'jpg,png,jpeg');
define('MAX_FILE_SIZE_KB', 10 * 1024);
 