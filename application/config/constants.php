<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */

/*
 * User roles
 */
define('ROLE_GUEST', 'guest');
define('ROLE_USER', 'user');
define('ROLE_ENTREPRENEUR', 'entrepreneur');
define('ROLE_PROVIDER', 'provider');
define('ROLE_ADMIN', 'admin');
define('ROLE_ROOT', 'root');
define('ROLE_CRON', 'cron');

/*
 * Resources
 */
define('RESOURCE_GUEST', 'r_guest');
define('RESOURCE_USER', 'r_user');
define('RESOURCE_ENTREPRENEUR', 'r_entrepreneur');
define('RESOURCE_SUPPLIER', 'r_supplier');
define('RESOURCE_ADMIN', 'r_admin');
define('RESOURCE_ROOT', 'r_root');

define('RESOURCE_NOTIFICATION', 'r_notification');

/*
 * Grants for resources
 */
define('GRANT_READ', 'r');
define('GRANT_WRITE', 'w');
define('GRANT_EXECUTE', 'x');

/* Define how long the maximum amount of time the session can be inactive. */
define("MAX_IDLE_TIME", 3);

/* Define how long the user can be inactive. 30 sec */
define("MAX_USER_INACTIVE_TIME", 30);

define("VIEW", 1);
define("EDIT", 2);
define("DELETE", 3);

define('TMP_FOLDER', "files/tmp/");

define('GROUP_LOGO_FOLDER', "files/group/logo/");
define('CATEGORY_LOGO_FOLDER', "files/category/logo/");

// ban types
define("EMAIL", 1);
define("USERNAME", 2);

// user status
define("NOT_ACTIVE_USER", 0);
define("ACTIVE_USER", 1);

// email notification
define("NOTIFICATION_NOT_SENT", 0);
define("NOTIFICATION_SENT", 1);

// notification types
define("QUOTE_REQUEST", "quote_request");
define("QUOTE", "quote");
define("INVOICE", "invoice");
define("INVOICE_REMINDER", "invoice_reminder");

// invoice statuses
define("CANCELED", "Canceled");
define("DISPUTE", "Dispute");
define("PAID", "Paid");
define("ESCROW", "Escrow");
define("OVERDUE", "Overdue");
define("INVOICE_SENT", "Invoice Sent");
define("INVOICE_DUE", "Invoice Due");
