<?php
if(!defined('SIGN_IN_ELEMENT_MAPPING_FIELD_NAME')){define('SIGN_IN_ELEMENT_MAPPING_FIELD_NAME','employee');}

if(!defined('APP_NAME')){define('APP_NAME','ICE Hrm');}
if(!defined('FB_URL')){define('FB_URL', 'https://www.facebook.com/icehrm');};
if(!defined('TWITTER_URL')){define('TWITTER_URL', 'https://twitter.com/icehrmapp');};

if(!defined('HOME_LINK_ADMIN')){
    define('HOME_LINK_ADMIN', CLIENT_BASE_URL . "?g=admin&n=dashboard&m=admin_Admin");
}
if(!defined('HOME_LINK_OTHERS')){
    define('HOME_LINK_OTHERS', CLIENT_BASE_URL . "?g=modules&n=dashboard&m=module_Personal_Information");
}

//Version
// define('VERSION', '26.6.1.PRO');
// define('CACHE_VALUE', '26.6.1.PRO');
// define('VERSION_NUMBER', '2661');
// define('VERSION_DATE', '05/08/2019');

// if(!defined('CONTACT_EMAIL')){define('CONTACT_EMAIL','unionsg.com');}
// if(!defined('KEY_PREFIX')){define('KEY_PREFIX','IceHrm');}
// if(!defined('APP_SEC')){define('APP_SEC','dbcs234d2saaqw');}

// define('UI_SHOW_SWITCH_PROFILE', true);
// define('CRON_LOG', ini_get('error_log'));

// define('MEMCACHE_HOST', '127.0.0.1');
// define('MEMCACHE_PORT', '11211');

if(!defined('WK_HTML_PATH')){
    // define('WK_HTML_PATH', '/usr/bin/xvfb-run -- /usr/local/bin/wkhtmltopdf');

    define('WK_HTML_PATH', 'C:/Users/User/wkhtmltox/bin/wkhtmltopdf.exe');
    
    // setPageOptions(array('orientation' => 'landscape'));
}
define('ALL_CLIENT_BASE_PATH', '/vagrant/deployment/clients/');

define('LDAP_ENABLED', true);
define('RECRUITMENT_ENABLED', false);
define('APP_WEB_URL', 'https://hrm.com');
