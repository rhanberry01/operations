<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'root';
// $db['default']['password'] = 'p@ssw0rd';
$db['default']['password'] = '';
$db['default']['database'] = 'asset_management'; //apm
//$db['default']['database'] = 'central_db'; //apm
// $db['default']['database'] = 'bon_live';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;


$db['orange']['hostname'] = '192.168.0.91';
$db['orange']['username'] = 'root';
// $db['default']['password'] = 'p@ssw0rd';
$db['orange']['password'] = 'srsnova';
$db['orange']['database'] = 'orange'; //apm
//$db['default']['database'] = 'central_db'; //apm
// $db['default']['database'] = 'bon_live';
$db['orange']['dbdriver'] = 'mysql';
$db['orange']['dbprefix'] = '';
$db['orange']['pconnect'] = TRUE;
$db['orange']['db_debug'] = TRUE;
$db['orange']['cache_on'] = FALSE;
$db['orange']['cachedir'] = '';
$db['orange']['char_set'] = 'utf8';
$db['orange']['dbcollat'] = 'utf8_general_ci';
$db['orange']['swap_pre'] = '';
$db['orange']['autoinit'] = TRUE;
$db['orange']['stricton'] = FALSE;


$db['srs_aria_nova']['hostname'] = 'localhost'; 
$db['srs_aria_nova']['username'] = 'root'; 
$db['srs_aria_nova']['password'] = '';
$db['srs_aria_nova']['database'] = 'srs_aria_nova';
$db['srs_aria_nova']['dbdriver'] = 'mysql';
$db['srs_aria_nova']['dbprefix'] = '';
$db['srs_aria_nova']['pconnect'] = FALSE;
$db['srs_aria_nova']['db_debug'] = false;
$db['srs_aria_nova']['cache_on'] = FALSE;
$db['srs_aria_nova']['cachedir'] = '';
$db['srs_aria_nova']['char_set'] = 'utf8';
$db['srs_aria_nova']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_nova']['swap_pre'] = '';
$db['srs_aria_nova']['autoinit'] = TRUE;
$db['srs_aria_nova']['stricton'] = FALSE;



$db['srs_aria_retail']['hostname'] = 'localhost'; 
$db['srs_aria_retail']['username'] = 'root'; 
$db['srs_aria_retail']['password'] = '';
$db['srs_aria_retail']['database'] = 'srs_aria_retail';
$db['srs_aria_retail']['dbdriver'] = 'mysql';
$db['srs_aria_retail']['dbprefix'] = '';
$db['srs_aria_retail']['pconnect'] = FALSE;
$db['srs_aria_retail']['db_debug'] = false;
$db['srs_aria_retail']['cache_on'] = FALSE;
$db['srs_aria_retail']['cachedir'] = '';
$db['srs_aria_retail']['char_set'] = 'utf8';
$db['srs_aria_retail']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_retail']['swap_pre'] = '';
$db['srs_aria_retail']['autoinit'] = TRUE;
$db['srs_aria_retail']['stricton'] = FALSE;




$db['srs_aria_antipolo_quezon']['hostname'] = 'localhost'; 
$db['srs_aria_antipolo_quezon']['username'] = 'root'; 
$db['srs_aria_antipolo_quezon']['password'] = '';
$db['srs_aria_antipolo_quezon']['database'] = 'srs_aria_antipolo_quezon';
$db['srs_aria_antipolo_quezon']['dbdriver'] = 'mysql';
$db['srs_aria_antipolo_quezon']['dbprefix'] = '';
$db['srs_aria_antipolo_quezon']['pconnect'] = FALSE;
$db['srs_aria_antipolo_quezon']['db_debug'] = false;
$db['srs_aria_antipolo_quezon']['cache_on'] = FALSE;
$db['srs_aria_antipolo_quezon']['cachedir'] = '';
$db['srs_aria_antipolo_quezon']['char_set'] = 'utf8';
$db['srs_aria_antipolo_quezon']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_antipolo_quezon']['swap_pre'] = '';
$db['srs_aria_antipolo_quezon']['autoinit'] = TRUE;
$db['srs_aria_antipolo_quezon']['stricton'] = FALSE;



$db['srs_aria_antipolo_manalo']['hostname'] = 'localhost'; 
$db['srs_aria_antipolo_manalo']['username'] = 'root'; 
$db['srs_aria_antipolo_manalo']['password'] = '';
$db['srs_aria_antipolo_manalo']['database'] = 'srs_aria_antipolo_manalo';
$db['srs_aria_antipolo_manalo']['dbdriver'] = 'mysql';
$db['srs_aria_antipolo_manalo']['dbprefix'] = '';
$db['srs_aria_antipolo_manalo']['pconnect'] = FALSE;
$db['srs_aria_antipolo_manalo']['db_debug'] = false;
$db['srs_aria_antipolo_manalo']['cache_on'] = FALSE;
$db['srs_aria_antipolo_manalo']['cachedir'] = '';
$db['srs_aria_antipolo_manalo']['char_set'] = 'utf8';
$db['srs_aria_antipolo_manalo']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_antipolo_manalo']['swap_pre'] = '';
$db['srs_aria_antipolo_manalo']['autoinit'] = TRUE;
$db['srs_aria_antipolo_manalo']['stricton'] = FALSE;




$db['srs_aria_cainta']['hostname'] = 'localhost'; 
$db['srs_aria_cainta']['username'] = 'root'; 
$db['srs_aria_cainta']['password'] = '';
$db['srs_aria_cainta']['database'] = 'srs_aria_cainta';
$db['srs_aria_cainta']['dbdriver'] = 'mysql';
$db['srs_aria_cainta']['dbprefix'] = '';
$db['srs_aria_cainta']['pconnect'] = FALSE;
$db['srs_aria_cainta']['db_debug'] = false;
$db['srs_aria_cainta']['cache_on'] = FALSE;
$db['srs_aria_cainta']['cachedir'] = '';
$db['srs_aria_cainta']['char_set'] = 'utf8';
$db['srs_aria_cainta']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_cainta']['swap_pre'] = '';
$db['srs_aria_cainta']['autoinit'] = TRUE;
$db['srs_aria_cainta']['stricton'] = FALSE;


$db['srs_aria_camarin']['hostname'] = 'localhost'; 
$db['srs_aria_camarin']['username'] = 'root'; 
$db['srs_aria_camarin']['password'] = '';
$db['srs_aria_camarin']['database'] = 'srs_aria_camarin';
$db['srs_aria_camarin']['dbdriver'] = 'mysql';
$db['srs_aria_camarin']['dbprefix'] = '';
$db['srs_aria_camarin']['pconnect'] = FALSE;
$db['srs_aria_camarin']['db_debug'] = false;
$db['srs_aria_camarin']['cache_on'] = FALSE;
$db['srs_aria_camarin']['cachedir'] = '';
$db['srs_aria_camarin']['char_set'] = 'utf8';
$db['srs_aria_camarin']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_camarin']['swap_pre'] = '';
$db['srs_aria_camarin']['autoinit'] = TRUE;
$db['srs_aria_camarin']['stricton'] = FALSE;


$db['srs_aria_blum']['hostname'] = 'localhost'; 
$db['srs_aria_blum']['username'] = 'root'; 
$db['srs_aria_blum']['password'] = '';
$db['srs_aria_blum']['database'] = 'srs_aria_blum';
$db['srs_aria_blum']['dbdriver'] = 'mysql';
$db['srs_aria_blum']['dbprefix'] = '';
$db['srs_aria_blum']['pconnect'] = FALSE;
$db['srs_aria_blum']['db_debug'] = false;
$db['srs_aria_blum']['cache_on'] = FALSE;
$db['srs_aria_blum']['cachedir'] = '';
$db['srs_aria_blum']['char_set'] = 'utf8';
$db['srs_aria_blum']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_blum']['swap_pre'] = '';
$db['srs_aria_blum']['autoinit'] = TRUE;
$db['srs_aria_blum']['stricton'] = FALSE;


$db['srs_aria_malabon']['hostname'] = 'localhost'; 
$db['srs_aria_malabon']['username'] = 'root'; 
$db['srs_aria_malabon']['password'] = '';
$db['srs_aria_malabon']['database'] = 'srs_aria_malabon';
$db['srs_aria_malabon']['dbdriver'] = 'mysql';
$db['srs_aria_malabon']['dbprefix'] = '';
$db['srs_aria_malabon']['pconnect'] = FALSE;
$db['srs_aria_malabon']['db_debug'] = false;
$db['srs_aria_malabon']['cache_on'] = FALSE;
$db['srs_aria_malabon']['cachedir'] = '';
$db['srs_aria_malabon']['char_set'] = 'utf8';
$db['srs_aria_malabon']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_malabon']['swap_pre'] = '';
$db['srs_aria_malabon']['autoinit'] = TRUE;
$db['srs_aria_malabon']['stricton'] = FALSE;


$db['srs_aria_navotas']['hostname'] = 'localhost'; 
$db['srs_aria_navotas']['username'] = 'root'; 
$db['srs_aria_navotas']['password'] = '';
$db['srs_aria_navotas']['database'] = 'srs_aria_navotas';
$db['srs_aria_navotas']['dbdriver'] = 'mysql';
$db['srs_aria_navotas']['dbprefix'] = '';
$db['srs_aria_navotas']['pconnect'] = FALSE;
$db['srs_aria_navotas']['db_debug'] = false;
$db['srs_aria_navotas']['cache_on'] = FALSE;
$db['srs_aria_navotas']['cachedir'] = '';
$db['srs_aria_navotas']['char_set'] = 'utf8';
$db['srs_aria_navotas']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_navotas']['swap_pre'] = '';
$db['srs_aria_navotas']['autoinit'] = TRUE;
$db['srs_aria_navotas']['stricton'] = FALSE;


$db['srs_aria_imus']['hostname'] = 'localhost'; 
$db['srs_aria_imus']['username'] = 'root'; 
$db['srs_aria_imus']['password'] = '';
$db['srs_aria_imus']['database'] = 'srs_aria_imus';
$db['srs_aria_imus']['dbdriver'] = 'mysql';
$db['srs_aria_imus']['dbprefix'] = '';
$db['srs_aria_imus']['pconnect'] = FALSE;
$db['srs_aria_imus']['db_debug'] = false;
$db['srs_aria_imus']['cache_on'] = FALSE;
$db['srs_aria_imus']['cachedir'] = '';
$db['srs_aria_imus']['char_set'] = 'utf8';
$db['srs_aria_imus']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_imus']['swap_pre'] = '';
$db['srs_aria_imus']['autoinit'] = TRUE;
$db['srs_aria_imus']['stricton'] = FALSE;


$db['srs_aria_gala']['hostname'] = 'localhost'; 
$db['srs_aria_gala']['username'] = 'root'; 
$db['srs_aria_gala']['password'] = '';
$db['srs_aria_gala']['database'] = 'srs_aria_gala';
$db['srs_aria_gala']['dbdriver'] = 'mysql';
$db['srs_aria_gala']['dbprefix'] = '';
$db['srs_aria_gala']['pconnect'] = FALSE;
$db['srs_aria_gala']['db_debug'] = false;
$db['srs_aria_gala']['cache_on'] = FALSE;
$db['srs_aria_gala']['cachedir'] = '';
$db['srs_aria_gala']['char_set'] = 'utf8';
$db['srs_aria_gala']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_gala']['swap_pre'] = '';
$db['srs_aria_gala']['autoinit'] = TRUE;
$db['srs_aria_gala']['stricton'] = FALSE;


$db['srs_aria_tondo']['hostname'] = 'localhost'; 
$db['srs_aria_tondo']['username'] = 'root'; 
$db['srs_aria_tondo']['password'] = '';
$db['srs_aria_tondo']['database'] = 'srs_aria_tondo';
$db['srs_aria_tondo']['dbdriver'] = 'mysql';
$db['srs_aria_tondo']['dbprefix'] = '';
$db['srs_aria_tondo']['pconnect'] = FALSE;
$db['srs_aria_tondo']['db_debug'] = false;
$db['srs_aria_tondo']['cache_on'] = FALSE;
$db['srs_aria_tondo']['cachedir'] = '';
$db['srs_aria_tondo']['char_set'] = 'utf8';
$db['srs_aria_tondo']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_tondo']['swap_pre'] = '';
$db['srs_aria_tondo']['autoinit'] = TRUE;
$db['srs_aria_tondo']['stricton'] = FALSE;


$db['srs_aria_valenzuela']['hostname'] = 'localhost'; 
$db['srs_aria_valenzuela']['username'] = 'root'; 
$db['srs_aria_valenzuela']['password'] = '';
$db['srs_aria_valenzuela']['database'] = 'srs_aria_valenzuela';
$db['srs_aria_valenzuela']['dbdriver'] = 'mysql';
$db['srs_aria_valenzuela']['dbprefix'] = '';
$db['srs_aria_valenzuela']['pconnect'] = FALSE;
$db['srs_aria_valenzuela']['db_debug'] = false;
$db['srs_aria_valenzuela']['cache_on'] = FALSE;
$db['srs_aria_valenzuela']['cachedir'] = '';
$db['srs_aria_valenzuela']['char_set'] = 'utf8';
$db['srs_aria_valenzuela']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_valenzuela']['swap_pre'] = '';
$db['srs_aria_valenzuela']['autoinit'] = TRUE;
$db['srs_aria_valenzuela']['stricton'] = FALSE;


$db['srs_aria_b_silang']['hostname'] = 'localhost'; 
$db['srs_aria_b_silang']['username'] = 'root'; 
$db['srs_aria_b_silang']['password'] = '';
$db['srs_aria_b_silang']['database'] = 'srs_aria_b_silang';
$db['srs_aria_b_silang']['dbdriver'] = 'mysql';
$db['srs_aria_b_silang']['dbprefix'] = '';
$db['srs_aria_b_silang']['pconnect'] = FALSE;
$db['srs_aria_b_silang']['db_debug'] = false;
$db['srs_aria_b_silang']['cache_on'] = FALSE;
$db['srs_aria_b_silang']['cachedir'] = '';
$db['srs_aria_b_silang']['char_set'] = 'utf8';
$db['srs_aria_b_silang']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_b_silang']['swap_pre'] = '';
$db['srs_aria_b_silang']['autoinit'] = TRUE;
$db['srs_aria_b_silang']['stricton'] = FALSE;


$db['srs_aria_malabon_rest']['hostname'] = 'localhost'; 
$db['srs_aria_malabon_rest']['username'] = 'root'; 
$db['srs_aria_malabon_rest']['password'] = '';
$db['srs_aria_malabon_rest']['database'] = 'srs_aria_malabon_rest';
$db['srs_aria_malabon_rest']['dbdriver'] = 'mysql';
$db['srs_aria_malabon_rest']['dbprefix'] = '';
$db['srs_aria_malabon_rest']['pconnect'] = FALSE;
$db['srs_aria_malabon_rest']['db_debug'] = false;
$db['srs_aria_malabon_rest']['cache_on'] = FALSE;
$db['srs_aria_malabon_rest']['cachedir'] = '';
$db['srs_aria_malabon_rest']['char_set'] = 'utf8';
$db['srs_aria_malabon_rest']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_malabon_rest']['swap_pre'] = '';
$db['srs_aria_malabon_rest']['autoinit'] = TRUE;
$db['srs_aria_malabon_rest']['stricton'] = FALSE;


// MAIN SERVER-RHAN
// $db['central_db_default']['hostname'] = 'localhost'; 
// $db['central_db_default']['username'] = 'root'; 
// $db['central_db_default']['password'] = '';
// $db['central_db_default']['database'] = 'central_db_default_mms';
// $db['central_db_default']['dbdriver'] = 'mysql';
// $db['central_db_default']['dbprefix'] = '';
// $db['central_db_default']['pconnect'] = FALSE;
// $db['central_db_default']['db_debug'] = false;
// $db['central_db_default']['cache_on'] = FALSE;
// $db['central_db_default']['cachedir'] = '';
// $db['central_db_default']['char_set'] = 'utf8';
// $db['central_db_default']['dbcollat'] = 'utf8_general_ci';
// $db['central_db_default']['swap_pre'] = '';
// $db['central_db_default']['autoinit'] = TRUE;
// $db['central_db_default']['stricton'] = FALSE;

// ma'am allyn
// cental_db_imu 
// $db['srs_imu']['hostname'] = '192.168.0.141'; 
// $db['srs_imu']['username'] = 'root';
// $db['srs_imu']['password'] = '';
// $db['srs_imu']['database'] = 'central_db_imu_mms';
// $db['srs_imu']['dbdriver'] = 'mysql';
// $db['srs_imu']['dbprefix'] = '';
// $db['srs_imu']['pconnect'] = FALSE;
// $db['srs_imu']['db_debug'] = false;
// $db['srs_imu']['cache_on'] = FALSE;
// $db['srs_imu']['cachedir'] = '';
// $db['srs_imu']['char_set'] = 'utf8';
// $db['srs_imu']['dbcollat'] = 'utf8_general_ci';
// $db['srs_imu']['swap_pre'] = '';
// $db['srs_imu']['autoinit'] = TRUE;
// $db['srs_imu']['stricton'] = FALSE;

// cental_db_a1
// $db['srs_a1']['hostname'] = '192.168.0.141'; 
// $db['srs_a1']['username'] = 'root';
// $db['srs_a1']['password'] = '';
// $db['srs_a1']['database'] = 'central_db_a1_mms';
// $db['srs_a1']['dbdriver'] = 'mysql';
// $db['srs_a1']['dbprefix'] = '';
// $db['srs_a1']['pconnect'] = FALSE;
// $db['srs_a1']['db_debug'] = false;
// $db['srs_a1']['cache_on'] = FALSE;
// $db['srs_a1']['cachedir'] = '';
// $db['srs_a1']['char_set'] = 'utf8';
// $db['srs_a1']['dbcollat'] = 'utf8_general_ci';
// $db['srs_a1']['swap_pre'] = '';
// $db['srs_a1']['autoinit'] = TRUE;
// $db['srs_a1']['stricton'] = FALSE;

// cental_db_a2
// $db['srs_a2']['hostname'] = '192.168.0.141'; 
// $db['srs_a2']['username'] = 'root';
// $db['srs_a2']['password'] = '';
// $db['srs_a2']['database'] = 'central_db_a2_mms';
// $db['srs_a2']['dbdriver'] = 'mysql';
// $db['srs_a2']['dbprefix'] = '';
// $db['srs_a2']['pconnect'] = FALSE;
// $db['srs_a2']['db_debug'] = false;
// $db['srs_a2']['cache_on'] = FALSE;
// $db['srs_a2']['cachedir'] = '';
// $db['srs_a2']['char_set'] = 'utf8';
// $db['srs_a2']['dbcollat'] = 'utf8_general_ci';
// $db['srs_a2']['swap_pre'] = '';
// $db['srs_a2']['autoinit'] = TRUE;
// $db['srs_a2']['stricton'] = FALSE;

// cental_db_cai
// $db['srs_cai']['hostname'] = '192.168.0.141'; 
// $db['srs_cai']['username'] = 'root';
// $db['srs_cai']['password'] = '';
// $db['srs_cai']['database'] = 'central_db_cai_mms';
// $db['srs_cai']['dbdriver'] = 'mysql';
// $db['srs_cai']['dbprefix'] = '';
// $db['srs_cai']['pconnect'] = FALSE;
// $db['srs_cai']['db_debug'] = false;
// $db['srs_cai']['cache_on'] = FALSE;
// $db['srs_cai']['cachedir'] = '';
// $db['srs_cai']['char_set'] = 'utf8';
// $db['srs_cai']['dbcollat'] = 'utf8_general_ci';
// $db['srs_cai']['swap_pre'] = '';
// $db['srs_cai']['autoinit'] = TRUE;
// $db['srs_cai']['stricton'] = FALSE;

// cental_db_nova
// $db['srs_nova']['hostname'] = '192.168.0.141'; 
// $db['srs_nova']['username'] = 'root';
// $db['srs_nova']['password'] = '';
// $db['srs_nova']['database'] = 'central_db_nova_mms';
// $db['srs_nova']['dbdriver'] = 'mysql';
// $db['srs_nova']['dbprefix'] = '';
// $db['srs_nova']['pconnect'] = FALSE;
// $db['srs_nova']['db_debug'] = false;
// $db['srs_nova']['cache_on'] = FALSE;
// $db['srs_nova']['cachedir'] = '';
// $db['srs_nova']['char_set'] = 'utf8';
// $db['srs_nova']['dbcollat'] = 'utf8_general_ci';
// $db['srs_nova']['swap_pre'] = '';
// $db['srs_nova']['autoinit'] = TRUE;
// $db['srs_nova']['stricton'] = FALSE;


// rhan connection 

// cental_db_tondo
// $db['srs_tondo']['hostname'] = 'localhost'; 
// $db['srs_tondo']['username'] = 'root';
// $db['srs_tondo']['password'] = '';
// $db['srs_tondo']['database'] = 'central_db_tondo_mms';
// $db['srs_tondo']['dbdriver'] = 'mysql';
// $db['srs_tondo']['dbprefix'] = '';
// $db['srs_tondo']['pconnect'] = FALSE;
// $db['srs_tondo']['db_debug'] = false;
// $db['srs_tondo']['cache_on'] = FALSE;
// $db['srs_tondo']['cachedir'] = '';
// $db['srs_tondo']['char_set'] = 'utf8';
// $db['srs_tondo']['dbcollat'] = 'utf8_general_ci';
// $db['srs_tondo']['swap_pre'] = '';
// $db['srs_tondo']['autoinit'] = TRUE;
// $db['srs_tondo']['stricton'] = FALSE;

// cental_db_val
// $db['srs_val']['hostname'] = 'localhost'; 
// $db['srs_val']['username'] = 'root';
// $db['srs_val']['password'] = '';
// $db['srs_val']['database'] = 'central_db_val_mms';
// $db['srs_val']['dbdriver'] = 'mysql';
// $db['srs_val']['dbprefix'] = '';
// $db['srs_val']['pconnect'] = FALSE;
// $db['srs_val']['db_debug'] = false;
// $db['srs_val']['cache_on'] = FALSE;
// $db['srs_val']['cachedir'] = '';
// $db['srs_val']['char_set'] = 'utf8';
// $db['srs_val']['dbcollat'] = 'utf8_general_ci';
// $db['srs_val']['swap_pre'] = '';
// $db['srs_val']['autoinit'] = TRUE;
// $db['srs_val']['stricton'] = FALSE;

// cental_db_pun
// $db['srs_pun']['hostname'] = 'localhost'; 
// $db['srs_pun']['username'] = 'root';
// $db['srs_pun']['password'] = '';
// $db['srs_pun']['database'] = 'central_db_pun_mms';
// $db['srs_pun']['dbdriver'] = 'mysql';
// $db['srs_pun']['dbprefix'] = '';
// $db['srs_pun']['pconnect'] = FALSE;
// $db['srs_pun']['db_debug'] = false;
// $db['srs_pun']['cache_on'] = FALSE;
// $db['srs_pun']['cachedir'] = '';
// $db['srs_pun']['char_set'] = 'utf8';
// $db['srs_pun']['dbcollat'] = 'utf8_general_ci';
// $db['srs_pun']['swap_pre'] = '';
// $db['srs_pun']['autoinit'] = TRUE;
// $db['srs_pun']['stricton'] = FALSE;

// cental_db_pun
// $db['srs_cam']['hostname'] = 'localhost'; 
// $db['srs_cam']['username'] = 'root';
// $db['srs_cam']['password'] = '';
// $db['srs_cam']['database'] = 'central_db_cam_mms';
// $db['srs_cam']['dbdriver'] = 'mysql';
// $db['srs_cam']['dbprefix'] = '';
// $db['srs_cam']['pconnect'] = FALSE;
// $db['srs_cam']['db_debug'] = false;
// $db['srs_cam']['cache_on'] = FALSE;
// $db['srs_cam']['cachedir'] = '';
// $db['srs_cam']['char_set'] = 'utf8';
// $db['srs_cam']['dbcollat'] = 'utf8_general_ci';
// $db['srs_cam']['swap_pre'] = '';
// $db['srs_cam']['autoinit'] = TRUE;
// $db['srs_cam']['stricton'] = FALSE;

// cental_db_pat
// $db['srs_pat']['hostname'] = 'localhost'; 
// $db['srs_pat']['username'] = 'root';
// $db['srs_pat']['password'] = '';
// $db['srs_pat']['database'] = 'central_db_pat_mms';
// $db['srs_pat']['dbdriver'] = 'mysql';
// $db['srs_pat']['dbprefix'] = '';
// $db['srs_pat']['pconnect'] = FALSE;
// $db['srs_pat']['db_debug'] = false;
// $db['srs_pat']['cache_on'] = FALSE;
// $db['srs_pat']['cachedir'] = '';
// $db['srs_pat']['char_set'] = 'utf8';
// $db['srs_pat']['dbcollat'] = 'utf8_general_ci';
// $db['srs_pat']['swap_pre'] = '';
// $db['srs_pat']['autoinit'] = TRUE;
// $db['srs_pat']['stricton'] = FALSE;

// adoneza 

// cental_db_malabon
// $db['srs_malabon']['hostname'] = '192.163.0.236'; 
// $db['srs_malabon']['username'] = 'root';
// $db['srs_malabon']['password'] = '';
// $db['srs_malabon']['database'] = 'central_db_malabon_mms';
// $db['srs_malabon']['dbdriver'] = 'mysql';
// $db['srs_malabon']['dbprefix'] = '';
// $db['srs_malabon']['pconnect'] = FALSE;
// $db['srs_malabon']['db_debug'] = false;
// $db['srs_malabon']['cache_on'] = FALSE;
// $db['srs_malabon']['cachedir'] = '';
// $db['srs_malabon']['char_set'] = 'utf8';
// $db['srs_malabon']['dbcollat'] = 'utf8_general_ci';
// $db['srs_malabon']['swap_pre'] = '';
// $db['srs_malabon']['autoinit'] = TRUE;
// $db['srs_malabon']['stricton'] = FALSE;

// cental_db_bs
// $db['srs_bs']['hostname'] = '192.168.0.236'; 
// $db['srs_bs']['username'] = 'root';
// $db['srs_bs']['password'] = '';
// $db['srs_bs']['database'] = 'central_db_bs_mms';
// $db['srs_bs']['dbdriver'] = 'mysql';
// $db['srs_bs']['pconnect'] = FALSE;
// $db['srs_bs']['db_debug'] = false;
// $db['srs_bs']['cache_on'] = FALSE;
// $db['srs_bs']['cachedir'] = '';
// $db['srs_bs']['char_set'] = 'utf8';
// $db['srs_bs']['dbcollat'] = 'utf8_general_ci';
// $db['srs_bs']['swap_pre'] = '';
// $db['srs_bs']['autoinit'] = TRUE;
// $db['srs_bs']['stricton'] = FALSE;

// cental_db_gag
// $db['srs_gag']['hostname'] = '192.168.0.236'; 
// $db['srs_gag']['username'] = 'root';
// $db['srs_gag']['password'] = '';
// $db['srs_gag']['database'] = 'central_db_gag_mms';
// $db['srs_gag']['dbdriver'] = 'mysql';
// $db['srs_gag']['pconnect'] = FALSE;
// $db['srs_gag']['db_debug'] = false;
// $db['srs_gag']['cache_on'] = FALSE;
// $db['srs_gag']['cachedir'] = '';
// $db['srs_gag']['char_set'] = 'utf8';
// $db['srs_gag']['dbcollat'] = 'utf8_general_ci';
// $db['srs_gag']['swap_pre'] = '';
// $db['srs_gag']['autoinit'] = TRUE;
// $db['srs_gag']['stricton'] = FALSE;

// cental_db_nav
// $db['srs_nav']['hostname'] = '192.168.0.236'; 
// $db['srs_nav']['username'] = 'root';
// $db['srs_nav']['password'] = '';
// $db['srs_nav']['database'] = 'central_db_nav_mms';
// $db['srs_nav']['dbdriver'] = 'mysql';
// $db['srs_nav']['pconnect'] = FALSE;
// $db['srs_nav']['db_debug'] = false;
// $db['srs_nav']['cache_on'] = FALSE;
// $db['srs_nav']['cachedir'] = '';
// $db['srs_nav']['char_set'] = 'utf8';
// $db['srs_nav']['dbcollat'] = 'utf8_general_ci';
// $db['srs_nav']['swap_pre'] = '';
// $db['srs_nav']['autoinit'] = TRUE;
// $db['srs_nav']['stricton'] = FALSE;

// cental_db_mal1
// $db['srs_mal1']['hostname'] = '192.168.0.236'; 
// $db['srs_mal1']['username'] = 'root';
// $db['srs_mal1']['password'] = '';
// $db['srs_mal1']['database'] = 'central_db_mal1_mms';
// $db['srs_mal1']['dbdriver'] = 'mysql';
// $db['srs_mal1']['pconnect'] = FALSE;
// $db['srs_mal1']['db_debug'] = false;
// $db['srs_mal1']['cache_on'] = FALSE;
// $db['srs_mal1']['cachedir'] = '';
// $db['srs_mal1']['char_set'] = 'utf8';
// $db['srs_mal1']['dbcollat'] = 'utf8_general_ci';
// $db['srs_mal1']['swap_pre'] = '';
// $db['srs_mal1']['autoinit'] = TRUE;
// $db['srs_mal1']['stricton'] = FALSE;

//// other_connection 
// $db['srs_nova']['hostname'] = '192.168.0.236'; //ado
// $db['srs_nova']['username'] = 'root';
// $db['srs_nova']['password'] = '';
// $db['srs_nova']['database'] = 'central_db_';
// $db['srs_nova']['dbdriver'] = 'mysql';
// $db['srs_nova']['dbprefix'] = '';
// $db['srs_nova']['pconnect'] = FALSE;
// $db['srs_nova']['db_debug'] = false;
// $db['srs_nova']['cache_on'] = FALSE;
// $db['srs_nova']['cachedir'] = '';
// $db['srs_nova']['char_set'] = 'utf8';
// $db['srs_nova']['dbcollat'] = 'utf8_general_ci';
// $db['srs_nova']['swap_pre'] = '';
// $db['srs_nova']['autoinit'] = TRUE;
// $db['srs_nova']['stricton'] = FALSE;


// other_connection 
// $db['srs_tondo']['hostname'] = '192.168.0.141'; //ma'am allyn
// $db['srs_tondo']['username'] = 'root';
// $db['srs_tondo']['password'] = '';
// $db['srs_tondo']['database'] = 'central_db_';
// $db['srs_tondo']['dbdriver'] = 'mysql';
// $db['srs_tondo']['dbprefix'] = '';
// $db['srs_tondo']['pconnect'] = FALSE;
// $db['srs_tondo']['db_debug'] = false;
// $db['srs_tondo']['cache_on'] = FALSE;
// $db['srs_tondo']['cachedir'] = '';
// $db['srs_tondo']['char_set'] = 'utf8';
// $db['srs_tondo']['dbcollat'] = 'utf8_general_ci';
// $db['srs_tondo']['swap_pre'] = '';
// $db['srs_tondo']['autoinit'] = TRUE;
// $db['srs_tondo']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */