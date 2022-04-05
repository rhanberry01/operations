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

$db['default']['hostname'] = '192.168.0.89';
$db['default']['username'] = 'root';
$db['default']['password'] = 'srsnova';
$db['default']['database'] = 'operations';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = FALSE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;


$db['orange']['hostname'] = '192.168.0.43';
$db['orange']['username'] = 'root';
$db['orange']['password'] = 'srsnova';
$db['orange']['database'] = 'orange'; 
$db['orange']['dbdriver'] = 'mysql';
$db['orange']['dbprefix'] = '';
$db['orange']['pconnect'] = FALSE;
$db['orange']['db_debug'] = TRUE;
$db['orange']['cache_on'] = FALSE;
$db['orange']['cachedir'] = '';
$db['orange']['char_set'] = 'utf8';
$db['orange']['dbcollat'] = 'utf8_general_ci';
$db['orange']['swap_pre'] = '';
$db['orange']['autoinit'] = TRUE;
$db['orange']['stricton'] = FALSE;

$db['srs_aria_nova']['hostname'] = '192.168.0.91'; 
$db['srs_aria_nova']['username'] = 'root'; 
$db['srs_aria_nova']['password'] = 'srsnova';
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

$db['srs_aria_nova']['hostname'] = '192.168.0.91'; 
$db['srs_aria_nova']['username'] = 'root'; 
$db['srs_aria_nova']['password'] = 'srsnova';
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

$db['srs_aria_deparo']['hostname'] = '192.168.0.91'; 
$db['srs_aria_deparo']['username'] = 'root'; 
$db['srs_aria_deparo']['password'] = 'srsnova';
$db['srs_aria_deparo']['database'] = 'srs_aria_deparo';
$db['srs_aria_deparo']['dbdriver'] = 'mysql';
$db['srs_aria_deparo']['dbprefix'] = '';
$db['srs_aria_deparo']['pconnect'] = FALSE;
$db['srs_aria_deparo']['db_debug'] = false;
$db['srs_aria_deparo']['cache_on'] = FALSE;
$db['srs_aria_deparo']['cachedir'] = '';
$db['srs_aria_deparo']['char_set'] = 'utf8';
$db['srs_aria_deparo']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_deparo']['swap_pre'] = '';
$db['srs_aria_deparo']['autoinit'] = TRUE;
$db['srs_aria_deparo']['stricton'] = FALSE;


$db['srs_aria_benguet']['hostname'] = '192.168.0.91'; 
$db['srs_aria_benguet']['username'] = 'root'; 
$db['srs_aria_benguet']['password'] = 'srsnova';
$db['srs_aria_benguet']['database'] = 'srs_aria_benguet';
$db['srs_aria_benguet']['dbdriver'] = 'mysql';
$db['srs_aria_benguet']['dbprefix'] = '';
$db['srs_aria_benguet']['pconnect'] = FALSE;
$db['srs_aria_benguet']['db_debug'] = false;
$db['srs_aria_benguet']['cache_on'] = FALSE;
$db['srs_aria_benguet']['cachedir'] = '';
$db['srs_aria_benguet']['char_set'] = 'utf8';
$db['srs_aria_benguet']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_benguet']['swap_pre'] = '';
$db['srs_aria_benguet']['autoinit'] = TRUE;
$db['srs_aria_benguet']['stricton'] = FALSE;


$db['srs_aria_tala']['hostname'] = '192.168.0.91'; 
$db['srs_aria_tala']['username'] = 'root'; 
$db['srs_aria_tala']['password'] = 'srsnova';
$db['srs_aria_tala']['database'] = 'srs_aria_tala';
$db['srs_aria_tala']['dbdriver'] = 'mysql';
$db['srs_aria_tala']['dbprefix'] = '';
$db['srs_aria_tala']['pconnect'] = FALSE;
$db['srs_aria_tala']['db_debug'] = false;
$db['srs_aria_tala']['cache_on'] = FALSE;
$db['srs_aria_tala']['cachedir'] = '';
$db['srs_aria_tala']['char_set'] = 'utf8';
$db['srs_aria_tala']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_tala']['swap_pre'] = '';
$db['srs_aria_tala']['autoinit'] = TRUE;
$db['srs_aria_tala']['stricton'] = FALSE;

$db['srs_aria_sanana']['hostname'] = '192.168.0.91'; 
$db['srs_aria_sanana']['username'] = 'root'; 
$db['srs_aria_sanana']['password'] = 'srsnova';
$db['srs_aria_sanana']['database'] = 'srs_aria_sanana';
$db['srs_aria_sanana']['dbdriver'] = 'mysql';
$db['srs_aria_sanana']['dbprefix'] = '';
$db['srs_aria_sanana']['pconnect'] = FALSE;
$db['srs_aria_sanana']['db_debug'] = false;
$db['srs_aria_sanana']['cache_on'] = FALSE;
$db['srs_aria_sanana']['cachedir'] = '';
$db['srs_aria_sanana']['char_set'] = 'utf8';
$db['srs_aria_sanana']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_sanana']['swap_pre'] = '';
$db['srs_aria_sanana']['autoinit'] = TRUE;
$db['srs_aria_sanana']['stricton'] = FALSE;

$db['srs_aria_agora']['hostname'] = '192.168.0.91'; 
$db['srs_aria_agora']['username'] = 'root'; 
$db['srs_aria_agora']['password'] = 'srsnova';
$db['srs_aria_agora']['database'] = 'srs_aria_agora';
$db['srs_aria_agora']['dbdriver'] = 'mysql';
$db['srs_aria_agora']['dbprefix'] = '';
$db['srs_aria_agora']['pconnect'] = FALSE;
$db['srs_aria_agora']['db_debug'] = false;
$db['srs_aria_agora']['cache_on'] = FALSE;
$db['srs_aria_agora']['cachedir'] = '';
$db['srs_aria_agora']['char_set'] = 'utf8';
$db['srs_aria_agora']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_agora']['swap_pre'] = '';
$db['srs_aria_agora']['autoinit'] = TRUE;
$db['srs_aria_agora']['stricton'] = FALSE;

$db['srs_aria_llano']['hostname'] = '192.168.0.91'; 
$db['srs_aria_llano']['username'] = 'root'; 
$db['srs_aria_llano']['password'] = 'srsnova';
$db['srs_aria_llano']['database'] = 'srs_aria_llano';
$db['srs_aria_llano']['dbdriver'] = 'mysql';
$db['srs_aria_llano']['dbprefix'] = '';
$db['srs_aria_llano']['pconnect'] = FALSE;
$db['srs_aria_llano']['db_debug'] = false;
$db['srs_aria_llano']['cache_on'] = FALSE;
$db['srs_aria_llano']['cachedir'] = '';
$db['srs_aria_llano']['char_set'] = 'utf8';
$db['srs_aria_llano']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_llano']['swap_pre'] = '';
$db['srs_aria_llano']['autoinit'] = TRUE;
$db['srs_aria_llano']['stricton'] = FALSE;


$db['srs_aria_batasan']['hostname'] = '192.168.0.91'; 
$db['srs_aria_batasan']['username'] = 'root'; 
$db['srs_aria_batasan']['password'] = 'srsnova';
$db['srs_aria_batasan']['database'] = 'srs_aria_batasan';
$db['srs_aria_batasan']['dbdriver'] = 'mysql';
$db['srs_aria_batasan']['dbprefix'] = '';
$db['srs_aria_batasan']['pconnect'] = FALSE;
$db['srs_aria_batasan']['db_debug'] = false;
$db['srs_aria_batasan']['cache_on'] = FALSE;
$db['srs_aria_batasan']['cachedir'] = '';
$db['srs_aria_batasan']['char_set'] = 'utf8';
$db['srs_aria_batasan']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_batasan']['swap_pre'] = '';
$db['srs_aria_batasan']['autoinit'] = TRUE;
$db['srs_aria_batasan']['stricton'] = FALSE;





$db['srs_aria_comembo']['hostname'] = '192.168.0.91'; 
$db['srs_aria_comembo']['username'] = 'root'; 
$db['srs_aria_comembo']['password'] = 'srsnova';
$db['srs_aria_comembo']['database'] = 'srs_aria_comembo';
$db['srs_aria_comembo']['dbdriver'] = 'mysql';
$db['srs_aria_comembo']['dbprefix'] = '';
$db['srs_aria_comembo']['pconnect'] = FALSE;
$db['srs_aria_comembo']['db_debug'] = false;
$db['srs_aria_comembo']['cache_on'] = FALSE;
$db['srs_aria_comembo']['cachedir'] = '';
$db['srs_aria_comembo']['char_set'] = 'utf8';
$db['srs_aria_comembo']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_comembo']['swap_pre'] = '';
$db['srs_aria_comembo']['autoinit'] = TRUE;
$db['srs_aria_comembo']['stricton'] = FALSE;


$db['srs_aria_retail']['hostname'] = '192.168.0.91'; 
$db['srs_aria_retail']['username'] = 'root'; 
$db['srs_aria_retail']['password'] = 'srsnova';
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




$db['srs_aria_antipolo_quezon']['hostname'] = '192.168.0.91'; 
$db['srs_aria_antipolo_quezon']['username'] = 'root'; 
$db['srs_aria_antipolo_quezon']['password'] = 'srsnova';
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



$db['srs_aria_antipolo_manalo']['hostname'] = '192.168.0.91'; 
$db['srs_aria_antipolo_manalo']['username'] = 'root'; 
$db['srs_aria_antipolo_manalo']['password'] = 'srsnova';
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




$db['srs_aria_cainta']['hostname'] = '192.168.0.91'; 
$db['srs_aria_cainta']['username'] = 'root'; 
$db['srs_aria_cainta']['password'] = 'srsnova';
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



$db['srs_aria_cainta_san_juan']['hostname'] = '192.168.0.91'; 
$db['srs_aria_cainta_san_juan']['username'] = 'root'; 
$db['srs_aria_cainta_san_juan']['password'] = 'srsnova';
$db['srs_aria_cainta_san_juan']['database'] = 'srs_aria_cainta_san_juan';
$db['srs_aria_cainta_san_juan']['dbdriver'] = 'mysql';
$db['srs_aria_cainta_san_juan']['dbprefix'] = '';
$db['srs_aria_cainta_san_juan']['pconnect'] = FALSE;
$db['srs_aria_cainta_san_juan']['db_debug'] = false;
$db['srs_aria_cainta_san_juan']['cache_on'] = FALSE;
$db['srs_aria_cainta_san_juan']['cachedir'] = '';
$db['srs_aria_cainta_san_juan']['char_set'] = 'utf8';
$db['srs_aria_cainta_san_juan']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_cainta_san_juan']['swap_pre'] = '';
$db['srs_aria_cainta_san_juan']['autoinit'] = TRUE;
$db['srs_aria_cainta_san_juan']['stricton'] = FALSE;


$db['srs_aria_camarin']['hostname'] = '192.168.0.91'; 
$db['srs_aria_camarin']['username'] = 'root'; 
$db['srs_aria_camarin']['password'] = 'srsnova';
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


$db['srs_aria_blum']['hostname'] = '192.168.0.91'; 
$db['srs_aria_blum']['username'] = 'root'; 
$db['srs_aria_blum']['password'] = 'srsnova';
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


$db['srs_aria_malabon']['hostname'] = '192.168.0.91'; 
$db['srs_aria_malabon']['username'] = 'root'; 
$db['srs_aria_malabon']['password'] = 'srsnova';
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


$db['srs_aria_navotas']['hostname'] = '192.168.0.91'; 
$db['srs_aria_navotas']['username'] = 'root'; 
$db['srs_aria_navotas']['password'] = 'srsnova';
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


$db['srs_aria_imus']['hostname'] = '192.168.0.91'; 
$db['srs_aria_imus']['username'] = 'root'; 
$db['srs_aria_imus']['password'] = 'srsnova';
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


$db['srs_aria_gala']['hostname'] = '192.168.0.91'; 
$db['srs_aria_gala']['username'] = 'root'; 
$db['srs_aria_gala']['password'] = 'srsnova';
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


$db['srs_aria_tondo']['hostname'] = '192.168.0.91'; 
$db['srs_aria_tondo']['username'] = 'root'; 
$db['srs_aria_tondo']['password'] = 'srsnova';
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


$db['srs_aria_alaminos']['hostname'] = '192.168.0.91'; 
$db['srs_aria_alaminos']['username'] = 'root'; 
$db['srs_aria_alaminos']['password'] = 'srsnova';
$db['srs_aria_alaminos']['database'] = 'srs_aria_alaminos';
$db['srs_aria_alaminos']['dbdriver'] = 'mysql';
$db['srs_aria_alaminos']['dbprefix'] = '';
$db['srs_aria_alaminos']['pconnect'] = FALSE;
$db['srs_aria_alaminos']['db_debug'] = false;
$db['srs_aria_alaminos']['cache_on'] = FALSE;
$db['srs_aria_alaminos']['cachedir'] = '';
$db['srs_aria_alaminos']['char_set'] = 'utf8';
$db['srs_aria_alaminos']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_alaminos']['swap_pre'] = '';
$db['srs_aria_alaminos']['autoinit'] = TRUE;
$db['srs_aria_alaminos']['stricton'] = FALSE;



$db['srs_aria_valenzuela']['hostname'] = '192.168.0.91'; 
$db['srs_aria_valenzuela']['username'] = 'root'; 
$db['srs_aria_valenzuela']['password'] = 'srsnova';
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


$db['srs_aria_b_silang']['hostname'] = '192.168.0.91'; 
$db['srs_aria_b_silang']['username'] = 'root'; 
$db['srs_aria_b_silang']['password'] = 'srsnova';
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


$db['srs_aria_malabon_rest']['hostname'] = '192.168.0.91'; 
$db['srs_aria_malabon_rest']['username'] = 'root'; 
$db['srs_aria_malabon_rest']['password'] = 'srsnova';
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

$db['srs_aria_san_pedro']['hostname'] = '192.168.0.91'; 
$db['srs_aria_san_pedro']['username'] = 'root'; 
$db['srs_aria_san_pedro']['password'] = 'srsnova';
$db['srs_aria_san_pedro']['database'] = 'srs_aria_san_pedro';
$db['srs_aria_san_pedro']['dbdriver'] = 'mysql';
$db['srs_aria_san_pedro']['dbprefix'] = '';
$db['srs_aria_san_pedro']['pconnect'] = FALSE;
$db['srs_aria_san_pedro']['db_debug'] = false;
$db['srs_aria_san_pedro']['cache_on'] = FALSE;
$db['srs_aria_san_pedro']['cachedir'] = '';
$db['srs_aria_san_pedro']['char_set'] = 'utf8';
$db['srs_aria_san_pedro']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_san_pedro']['swap_pre'] = '';
$db['srs_aria_san_pedro']['autoinit'] = TRUE;
$db['srs_aria_san_pedro']['stricton'] = FALSE;

$db['srs_aria_punturin_val']['hostname'] = '192.168.0.91'; 
$db['srs_aria_punturin_val']['username'] = 'root'; 
$db['srs_aria_punturin_val']['password'] = 'srsnova';
$db['srs_aria_punturin_val']['database'] = 'srs_aria_punturin_val';
$db['srs_aria_punturin_val']['dbdriver'] = 'mysql';
$db['srs_aria_punturin_val']['dbprefix'] = '';
$db['srs_aria_punturin_val']['pconnect'] = FALSE;
$db['srs_aria_punturin_val']['db_debug'] = false;
$db['srs_aria_punturin_val']['cache_on'] = FALSE;
$db['srs_aria_punturin_val']['cachedir'] = '';
$db['srs_aria_punturin_val']['char_set'] = 'utf8';
$db['srs_aria_punturin_val']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_punturin_val']['swap_pre'] = '';
$db['srs_aria_punturin_val']['autoinit'] = TRUE;
$db['srs_aria_punturin_val']['stricton'] = FALSE;

$db['srs_aria_talon_uno']['hostname'] = '192.168.0.91'; 
$db['srs_aria_talon_uno']['username'] = 'root'; 
$db['srs_aria_talon_uno']['password'] = 'srsnova';
$db['srs_aria_talon_uno']['database'] = 'srs_aria_talon_uno';
$db['srs_aria_talon_uno']['dbdriver'] = 'mysql';
$db['srs_aria_talon_uno']['dbprefix'] = '';
$db['srs_aria_talon_uno']['pconnect'] = FALSE;
$db['srs_aria_talon_uno']['db_debug'] = false;
$db['srs_aria_talon_uno']['cache_on'] = FALSE;
$db['srs_aria_talon_uno']['cachedir'] = '';
$db['srs_aria_talon_uno']['char_set'] = 'utf8';
$db['srs_aria_talon_uno']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_talon_uno']['swap_pre'] = '';
$db['srs_aria_talon_uno']['autoinit'] = TRUE;
$db['srs_aria_talon_uno']['stricton'] = FALSE;

$db['srs_aria_pateros']['hostname'] = '192.168.0.91'; 
$db['srs_aria_pateros']['username'] = 'root'; 
$db['srs_aria_pateros']['password'] = 'srsnova';
$db['srs_aria_pateros']['database'] = 'srs_aria_pateros';
$db['srs_aria_pateros']['dbdriver'] = 'mysql';
$db['srs_aria_pateros']['dbprefix'] = '';
$db['srs_aria_pateros']['pconnect'] = FALSE;
$db['srs_aria_pateros']['db_debug'] = false;
$db['srs_aria_pateros']['cache_on'] = FALSE;
$db['srs_aria_pateros']['cachedir'] = '';
$db['srs_aria_pateros']['char_set'] = 'utf8';
$db['srs_aria_pateros']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_pateros']['swap_pre'] = '';
$db['srs_aria_pateros']['autoinit'] = TRUE;
$db['srs_aria_pateros']['stricton'] = FALSE;

$db['srs_aria_bagumbong']['hostname'] = '192.168.0.91'; 
$db['srs_aria_bagumbong']['username'] = 'root'; 
$db['srs_aria_bagumbong']['password'] = 'srsnova';
$db['srs_aria_bagumbong']['database'] = 'srs_aria_bagumbong';
$db['srs_aria_bagumbong']['dbdriver'] = 'mysql';
$db['srs_aria_bagumbong']['dbprefix'] = '';
$db['srs_aria_bagumbong']['pconnect'] = FALSE;
$db['srs_aria_bagumbong']['db_debug'] = false;
$db['srs_aria_bagumbong']['cache_on'] = FALSE;
$db['srs_aria_bagumbong']['cachedir'] = '';
$db['srs_aria_bagumbong']['char_set'] = 'utf8';
$db['srs_aria_bagumbong']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_bagumbong']['swap_pre'] = '';
$db['srs_aria_bagumbong']['autoinit'] = TRUE;
$db['srs_aria_bagumbong']['stricton'] = FALSE;



$db['srs_aria_molino']['hostname'] = '192.168.0.91'; 
$db['srs_aria_molino']['username'] = 'root'; 
$db['srs_aria_molino']['password'] = 'srsnova';
$db['srs_aria_molino']['database'] = 'srs_aria_molino';
$db['srs_aria_molino']['dbdriver'] = 'mysql';
$db['srs_aria_molino']['dbprefix'] = '';
$db['srs_aria_molino']['pconnect'] = FALSE;
$db['srs_aria_molino']['db_debug'] = false;
$db['srs_aria_molino']['cache_on'] = FALSE;
$db['srs_aria_molino']['cachedir'] = '';
$db['srs_aria_molino']['char_set'] = 'utf8';
$db['srs_aria_molino']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_molino']['swap_pre'] = '';
$db['srs_aria_molino']['autoinit'] = TRUE;
$db['srs_aria_molino']['stricton'] = FALSE;

$db['srs_aria_graceville']['hostname'] = '192.168.0.91'; 
$db['srs_aria_graceville']['username'] = 'root'; 
$db['srs_aria_graceville']['password'] = 'srsnova';
$db['srs_aria_graceville']['database'] = 'srs_aria_graceville';
$db['srs_aria_graceville']['dbdriver'] = 'mysql';
$db['srs_aria_graceville']['dbprefix'] = '';
$db['srs_aria_graceville']['pconnect'] = FALSE;
$db['srs_aria_graceville']['db_debug'] = false;
$db['srs_aria_graceville']['cache_on'] = FALSE;
$db['srs_aria_graceville']['cachedir'] = '';
$db['srs_aria_graceville']['char_set'] = 'utf8';
$db['srs_aria_graceville']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_graceville']['swap_pre'] = '';
$db['srs_aria_graceville']['autoinit'] = TRUE;
$db['srs_aria_graceville']['stricton'] = FALSE;

$db['srs_aria_montalban']['hostname'] = '192.168.0.91'; 
$db['srs_aria_montalban']['username'] = 'root'; 
$db['srs_aria_montalban']['password'] = 'srsnova';
$db['srs_aria_montalban']['database'] = 'srs_aria_montalban';
$db['srs_aria_montalban']['dbdriver'] = 'mysql';
$db['srs_aria_montalban']['dbprefix'] = '';
$db['srs_aria_montalban']['pconnect'] = FALSE;
$db['srs_aria_montalban']['db_debug'] = false;
$db['srs_aria_montalban']['cache_on'] = FALSE;
$db['srs_aria_montalban']['cachedir'] = '';
$db['srs_aria_montalban']['char_set'] = 'utf8';
$db['srs_aria_montalban']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_montalban']['swap_pre'] = '';
$db['srs_aria_montalban']['autoinit'] = TRUE;
$db['srs_aria_montalban']['stricton'] = FALSE;


$db['srs_aria_manggahan']['hostname'] = '192.168.0.91'; 
$db['srs_aria_manggahan']['username'] = 'root'; 
$db['srs_aria_manggahan']['password'] = 'srsnova';
$db['srs_aria_manggahan']['database'] = 'srs_aria_manggahan';
$db['srs_aria_manggahan']['dbdriver'] = 'mysql';
$db['srs_aria_manggahan']['dbprefix'] = '';
$db['srs_aria_manggahan']['pconnect'] = FALSE;
$db['srs_aria_manggahan']['db_debug'] = false;
$db['srs_aria_manggahan']['cache_on'] = FALSE;
$db['srs_aria_manggahan']['cachedir'] = '';
$db['srs_aria_manggahan']['char_set'] = 'utf8';
$db['srs_aria_manggahan']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_manggahan']['swap_pre'] = '';
$db['srs_aria_manggahan']['autoinit'] = TRUE;
$db['srs_aria_manggahan']['stricton'] = FALSE;

$db['srs_aria_s_palay']['hostname'] = '192.168.0.91'; 
$db['srs_aria_s_palay']['username'] = 'root'; 
$db['srs_aria_s_palay']['password'] = 'srsnova';
$db['srs_aria_s_palay']['database'] = 'srs_aria_s_palay';
$db['srs_aria_s_palay']['dbdriver'] = 'mysql';
$db['srs_aria_s_palay']['dbprefix'] = '';
$db['srs_aria_s_palay']['pconnect'] = FALSE;
$db['srs_aria_s_palay']['db_debug'] = false;
$db['srs_aria_s_palay']['cache_on'] = FALSE;
$db['srs_aria_s_palay']['cachedir'] = '';
$db['srs_aria_s_palay']['char_set'] = 'utf8';
$db['srs_aria_s_palay']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_s_palay']['swap_pre'] = '';
$db['srs_aria_s_palay']['autoinit'] = TRUE;
$db['srs_aria_s_palay']['stricton'] = FALSE;


$db['srs_aria_san_isidro']['hostname'] = '192.168.0.91'; 
$db['srs_aria_san_isidro']['username'] = 'root'; 
$db['srs_aria_san_isidro']['password'] = 'srsnova';
$db['srs_aria_san_isidro']['database'] = 'srs_aria_san_isidro';
$db['srs_aria_san_isidro']['dbdriver'] = 'mysql';
$db['srs_aria_san_isidro']['dbprefix'] = '';
$db['srs_aria_san_isidro']['pconnect'] = FALSE;
$db['srs_aria_san_isidro']['db_debug'] = false;
$db['srs_aria_san_isidro']['cache_on'] = FALSE;
$db['srs_aria_san_isidro']['cachedir'] = '';
$db['srs_aria_san_isidro']['char_set'] = 'utf8';
$db['srs_aria_san_isidro']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_san_isidro']['swap_pre'] = '';
$db['srs_aria_san_isidro']['autoinit'] = TRUE;
$db['srs_aria_san_isidro']['stricton'] = FALSE;



$db['srs_aria_sta_rosa']['hostname'] = '192.168.0.91'; 
$db['srs_aria_sta_rosa']['username'] = 'root'; 
$db['srs_aria_sta_rosa']['password'] = 'srsnova';
$db['srs_aria_sta_rosa']['database'] = 'srs_aria_sta_rosa';
$db['srs_aria_sta_rosa']['dbdriver'] = 'mysql';
$db['srs_aria_sta_rosa']['dbprefix'] = '';
$db['srs_aria_sta_rosa']['pconnect'] = FALSE;
$db['srs_aria_sta_rosa']['db_debug'] = false;
$db['srs_aria_sta_rosa']['cache_on'] = FALSE;
$db['srs_aria_sta_rosa']['cachedir'] = '';
$db['srs_aria_sta_rosa']['char_set'] = 'utf8';
$db['srs_aria_sta_rosa']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_sta_rosa']['swap_pre'] = '';
$db['srs_aria_sta_rosa']['autoinit'] = TRUE;
$db['srs_aria_sta_rosa']['stricton'] = FALSE;



$db['srs_aria_marilao']['hostname'] = '192.168.0.91'; 
$db['srs_aria_marilao']['username'] = 'root'; 
$db['srs_aria_marilao']['password'] = 'srsnova';
$db['srs_aria_marilao']['database'] = 'srs_aria_marilao';
$db['srs_aria_marilao']['dbdriver'] = 'mysql';
$db['srs_aria_marilao']['dbprefix'] = '';
$db['srs_aria_marilao']['pconnect'] = FALSE;
$db['srs_aria_marilao']['db_debug'] = false;
$db['srs_aria_marilao']['cache_on'] = FALSE;
$db['srs_aria_marilao']['cachedir'] = '';
$db['srs_aria_marilao']['char_set'] = 'utf8';
$db['srs_aria_marilao']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_marilao']['swap_pre'] = '';
$db['srs_aria_marilao']['autoinit'] = TRUE;
$db['srs_aria_marilao']['stricton'] = FALSE;


$db['srs_aria_b_silang_2']['hostname'] = '192.168.0.91'; 
$db['srs_aria_b_silang_2']['username'] = 'root'; 
$db['srs_aria_b_silang_2']['password'] = 'srsnova';
$db['srs_aria_b_silang_2']['database'] = 'srs_aria_b_silang_2';
$db['srs_aria_b_silang_2']['dbdriver'] = 'mysql';
$db['srs_aria_b_silang_2']['dbprefix'] = '';
$db['srs_aria_b_silang_2']['pconnect'] = FALSE;
$db['srs_aria_b_silang_2']['db_debug'] = false;
$db['srs_aria_b_silang_2']['cache_on'] = FALSE;
$db['srs_aria_b_silang_2']['cachedir'] = '';
$db['srs_aria_b_silang_2']['char_set'] = 'utf8';
$db['srs_aria_b_silang_2']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_b_silang_2']['swap_pre'] = '';
$db['srs_aria_b_silang_2']['autoinit'] = TRUE;
$db['srs_aria_b_silang_2']['stricton'] = FALSE;



$db['srs_aria_tanza']['hostname'] = '192.168.0.91'; 
$db['srs_aria_tanza']['username'] = 'root'; 
$db['srs_aria_tanza']['password'] = 'srsnova';
$db['srs_aria_tanza']['database'] = 'srs_aria_tanza';
$db['srs_aria_tanza']['dbdriver'] = 'mysql';
$db['srs_aria_tanza']['dbprefix'] = '';
$db['srs_aria_tanza']['pconnect'] = FALSE;
$db['srs_aria_tanza']['db_debug'] = false;
$db['srs_aria_tanza']['cache_on'] = FALSE;
$db['srs_aria_tanza']['cachedir'] = '';
$db['srs_aria_tanza']['char_set'] = 'utf8';
$db['srs_aria_tanza']['dbcollat'] = 'utf8_general_ci';
$db['srs_aria_tanza']['swap_pre'] = '';
$db['srs_aria_tanza']['autoinit'] = TRUE;
$db['srs_aria_tanza']['stricton'] = FALSE;












$db['operation']['hostname'] = "192.168.0.179";
$db['operation']['username'] = 'markuser';
$db['operation']['password'] = 'tseug';
$db['operation']['database'] = 'srspos';
//$db['operation']['dbdriver'] = 'sqlsrv';
$db['operation']['dbdriver'] = 'mssql';
$db['operation']['dbprefix'] = '';
$db['operation']['pconnect'] = TRUE;
$db['operation']['db_debug'] = FALSE;
$db['operation']['cache_on'] = FALSE;
$db['operation']['cachedir'] = '';
$db['operation']['char_set'] = 'utf8';
$db['operation']['dbcollat'] = 'utf8_general_ci';
$db['operation']['swap_pre'] = '';
$db['operation']['autoinit'] = TRUE;
$db['operation']['stricton'] = FALSE; 

$db['smart']['hostname'] = "192.168.0.203";
$db['smart']['username'] = 'markuser';
$db['smart']['password'] = 'tseug';
$db['smart']['database'] = 'SMARTELP';
//$db['smart']['dbdriver'] = 'sqlsrv';
$db['smart']['dbdriver'] = 'mssql';
$db['smart']['dbprefix'] = '';
$db['smart']['pconnect'] = TRUE;
$db['smart']['db_debug'] = FALSE;
$db['smart']['cache_on'] = FALSE;
$db['smart']['cachedir'] = '';
$db['smart']['char_set'] = 'utf8';
$db['smart']['dbcollat'] = 'utf8_general_ci';
$db['smart']['swap_pre'] = '';
$db['smart']['autoinit'] = TRUE;
$db['smart']['stricton'] = FALSE; 


$db['smartmy']['hostname'] = '192.168.0.203'; 
$db['smartmy']['username'] = 'root'; 
$db['smartmy']['password'] = 'srsnova';
$db['smartmy']['database'] = 'smartelp';
$db['smartmy']['dbdriver'] = 'mysql';
$db['smartmy']['dbprefix'] = '';
$db['smartmy']['pconnect'] = FALSE;
$db['smartmy']['db_debug'] = true;
$db['smartmy']['cache_on'] = FALSE;
$db['smartmy']['cachedir'] = '';
$db['smartmy']['char_set'] = 'utf8';
$db['smartmy']['dbcollat'] = 'utf8_general_ci';
$db['smartmy']['swap_pre'] = '';
$db['smartmy']['autoinit'] = TRUE;
$db['smartmy']['stricton'] = FALSE;



$db['TNOV']['hostname'] = "192.168.0.179";
$db['TNOV']['username'] = 'markuser';
$db['TNOV']['password'] = 'tseug';
$db['TNOV']['database'] = 'srspos';
//$db['TNOV']['dbdriver'] = 'sqlsrv';
$db['TNOV']['dbdriver'] = 'mssql';
$db['TNOV']['dbprefix'] = '';
$db['TNOV']['pconnect'] = TRUE;
$db['TNOV']['db_debug'] = FALSE;
$db['TNOV']['cache_on'] = FALSE;
$db['TNOV']['cachedir'] = '';
$db['TNOV']['char_set'] = 'utf8';
$db['TNOV']['dbcollat'] = 'utf8_general_ci';
$db['TNOV']['swap_pre'] = '';
$db['TNOV']['autoinit'] = TRUE;
$db['TNOV']['stricton'] = FALSE; 


$db['TAQU']['hostname'] = "192.168.110.100";
$db['TAQU']['username'] = 'markuser';
$db['TAQU']['password'] = 'tseug';
$db['TAQU']['database'] = 'SRSANT1GF';
//$db['TAQU']['dbdriver'] = 'sqlsrv';
$db['TAQU']['dbdriver'] = 'mssql';
$db['TAQU']['dbprefix'] = '';
$db['TAQU']['pconnect'] = TRUE;
$db['TAQU']['db_debug'] = FALSE;
$db['TAQU']['cache_on'] = FALSE;
$db['TAQU']['cachedir'] = '';
$db['TAQU']['char_set'] = 'utf8';
$db['TAQU']['dbcollat'] = 'utf8_general_ci';
$db['TAQU']['swap_pre'] = '';
$db['TAQU']['autoinit'] = TRUE;
$db['TAQU']['stricton'] = FALSE;


$db['TAMA']['hostname'] = "192.168.111.100";
$db['TAMA']['username'] = 'markuser';
$db['TAMA']['password'] = 'tseug';
$db['TAMA']['database'] = 'srsmant2em';
//$db['TAMA']['dbdriver'] = 'sqlsrv';
$db['TAMA']['dbdriver'] = 'mssql';
$db['TAMA']['dbprefix'] = '';
$db['TAMA']['pconnect'] = TRUE;
$db['TAMA']['db_debug'] = TRUE;
$db['TAMA']['cache_on'] = FALSE;
$db['TAMA']['cachedir'] = '';
$db['TAMA']['char_set'] = 'utf8';
$db['TAMA']['dbcollat'] = 'utf8_general_ci';
$db['TAMA']['swap_pre'] = '';
$db['TAMA']['autoinit'] = TRUE;
$db['TAMA']['stricton'] = FALSE;

$db['TCAI']['hostname'] = "192.168.112.100";
$db['TCAI']['username'] = 'markuser';
$db['TCAI']['password'] = 'tseug';
$db['TCAI']['database'] = 'SRSMCAINTA';
//$db['TCAI']['dbdriver'] = 'sqlsrv';
$db['TCAI']['dbdriver'] = 'mssql';
$db['TCAI']['dbprefix'] = '';
$db['TCAI']['pconnect'] = TRUE;
$db['TCAI']['db_debug'] = FALSE;
$db['TCAI']['cache_on'] = FALSE;
$db['TCAI']['cachedir'] = '';
$db['TCAI']['char_set'] = 'utf8';
$db['TCAI']['dbcollat'] = 'utf8_general_ci';
$db['TCAI']['swap_pre'] = '';
$db['TCAI']['autoinit'] = TRUE;
$db['TCAI']['stricton'] = FALSE;


$db['TCAM']['hostname'] = "192.168.6.100";
$db['TCAM']['username'] = 'markuser';
$db['TCAM']['password'] = 'tseug';
$db['TCAM']['database'] = 'srcama';
//$db['TCAM']['dbdriver'] = 'sqlsrv';
$db['TCAM']['dbdriver'] = 'mssql';
$db['TCAM']['dbprefix'] = '';
$db['TCAM']['pconnect'] = TRUE;
$db['TCAM']['db_debug'] = FALSE;
$db['TCAM']['cache_on'] = FALSE;
$db['TCAM']['cachedir'] = '';
$db['TCAM']['char_set'] = 'utf8';
$db['TCAM']['dbcollat'] = 'utf8_general_ci';
$db['TCAM']['swap_pre'] = '';
$db['TCAM']['autoinit'] = TRUE;
$db['TCAM']['stricton'] = FALSE;

$db['TCA2']['hostname'] = "192.168.118.100";
$db['TCA2']['username'] = 'markuser';
$db['TCA2']['password'] = 'tseug';
$db['TCA2']['database'] = 'SRSCAINTA2';
//$db['TCA2']['dbdriver'] = 'sqlsrv';
$db['TCA2']['dbdriver'] = 'mssql';
$db['TCA2']['dbprefix'] = '';
$db['TCA2']['pconnect'] = TRUE;
$db['TCA2']['db_debug'] = FALSE;
$db['TCA2']['cache_on'] = FALSE;
$db['TCA2']['cachedir'] = '';
$db['TCA2']['char_set'] = 'utf8';
$db['TCA2']['dbcollat'] = 'utf8_general_ci';
$db['TCA2']['swap_pre'] = '';
$db['TCA2']['autoinit'] = TRUE;
$db['TCA2']['stricton'] = FALSE;

$db['TMAL']['hostname'] = "192.168.101.100";
$db['TMAL']['username'] = 'markuser';
$db['TMAL']['password'] = 'tseug';
$db['TMAL']['database'] = 'srpos';
//$db['TMAL']['dbdriver'] = 'sqlsrv';
$db['TMAL']['dbdriver'] = 'mssql';
$db['TMAL']['dbprefix'] = '';
$db['TMAL']['pconnect'] = TRUE;
$db['TMAL']['db_debug'] = FALSE;
$db['TMAL']['cache_on'] = FALSE;
$db['TMAL']['cachedir'] = '';
$db['TMAL']['char_set'] = 'utf8';
$db['TMAL']['dbcollat'] = 'utf8_general_ci';
$db['TMAL']['swap_pre'] = '';
$db['TMAL']['autoinit'] = TRUE;
$db['TMAL']['stricton'] = FALSE;

$db['TNAV']['hostname'] = "192.168.107.100";
$db['TNAV']['username'] = 'markuser';
$db['TNAV']['password'] = 'tseug';
$db['TNAV']['database'] = 'srnav';
//$db['TNAV']['dbdriver'] = 'sqlsrv';
$db['TNAV']['dbdriver'] = 'mssql';
$db['TNAV']['dbprefix'] = '';
$db['TNAV']['pconnect'] = TRUE;
$db['TNAV']['db_debug'] = FALSE;
$db['TNAV']['cache_on'] = FALSE;
$db['TNAV']['cachedir'] = '';
$db['TNAV']['char_set'] = 'utf8';
$db['TNAV']['dbcollat'] = 'utf8_general_ci';
$db['TNAV']['swap_pre'] = '';
$db['TNAV']['autoinit'] = TRUE;
$db['TNAV']['stricton'] = FALSE;

$db['TIMU']['hostname'] = "192.168.108.100";
$db['TIMU']['username'] = 'markuser';
$db['TIMU']['password'] = 'tseug';
$db['TIMU']['database'] = 'srimu';
//$db['TIMU']['dbdriver'] = 'sqlsrv';
$db['TIMU']['dbdriver'] = 'mssql';
$db['TIMU']['dbprefix'] = '';
$db['TIMU']['pconnect'] = TRUE;
$db['TIMU']['db_debug'] = FALSE;
$db['TIMU']['cache_on'] = FALSE;
$db['TIMU']['cachedir'] = '';
$db['TIMU']['char_set'] = 'utf8';
$db['TIMU']['dbcollat'] = 'utf8_general_ci';
$db['TIMU']['swap_pre'] = '';
$db['TIMU']['autoinit'] = TRUE;
$db['TIMU']['stricton'] = FALSE;

$db['TGAG']['hostname'] = "192.168.5.6";
$db['TGAG']['username'] = 'markuser';
$db['TGAG']['password'] = 'tseug';
$db['TGAG']['database'] = 'srgala';
//$db['TGAG']['dbdriver'] = 'sqlsrv';
$db['TGAG']['dbdriver'] = 'mssql';
$db['TGAG']['dbprefix'] = '';
$db['TGAG']['pconnect'] = TRUE;
$db['TGAG']['db_debug'] = FALSE;
$db['TGAG']['cache_on'] = FALSE;
$db['TGAG']['cachedir'] = '';
$db['TGAG']['char_set'] = 'utf8';
$db['TGAG']['dbcollat'] = 'utf8_general_ci';
$db['TGAG']['swap_pre'] = '';
$db['TGAG']['autoinit'] = TRUE;
$db['TGAG']['stricton'] = FALSE;

$db['TTON']['hostname'] = "192.168.103.100";
$db['TTON']['username'] = 'markuser';
$db['TTON']['password'] = 'tseug';
$db['TTON']['database'] = 'srpos';
//$db['TTON']['dbdriver'] = 'sqlsrv';
$db['TTON']['dbdriver'] = 'mssql';
$db['TTON']['dbprefix'] = '';
$db['TTON']['pconnect'] = TRUE;
$db['TTON']['db_debug'] = FALSE;
$db['TTON']['cache_on'] = FALSE;
$db['TTON']['cachedir'] = '';
$db['TTON']['char_set'] = 'utf8';
$db['TTON']['dbcollat'] = 'utf8_general_ci';
$db['TTON']['swap_pre'] = '';
$db['TTON']['autoinit'] = TRUE;
$db['TTON']['stricton'] = FALSE;

$db['TVAL']['hostname'] = "192.168.114.100";
$db['TVAL']['username'] = 'markuser';
$db['TVAL']['password'] = 'tseug';
$db['TVAL']['database'] = 'srsval';
//$db['TVAL']['dbdriver'] = 'sqlsrv';
$db['TVAL']['dbdriver'] = 'mssql';
$db['TVAL']['dbprefix'] = '';
$db['TVAL']['pconnect'] = TRUE;
$db['TVAL']['db_debug'] = FALSE;
$db['TVAL']['cache_on'] = FALSE;
$db['TVAL']['cachedir'] = '';
$db['TVAL']['char_set'] = 'utf8';
$db['TVAL']['dbcollat'] = 'utf8_general_ci';
$db['TVAL']['swap_pre'] = '';
$db['TVAL']['autoinit'] = TRUE;
$db['TVAL']['stricton'] = FALSE;

$db['TBAG']['hostname'] = "192.168.13.100";
$db['TBAG']['username'] = 'markuser';
$db['TBAG']['password'] = 'tseug';
$db['TBAG']['database'] = 'SRSBSL';
//$db['TBAG']['dbdriver'] = 'sqlsrv';
$db['TBAG']['dbdriver'] = 'mssql';
$db['TBAG']['dbprefix'] = '';
$db['TBAG']['pconnect'] = TRUE;
$db['TBAG']['db_debug'] = FALSE;
$db['TBAG']['cache_on'] = FALSE;
$db['TBAG']['cachedir'] = '';
$db['TBAG']['char_set'] = 'utf8';
$db['TBAG']['dbcollat'] = 'utf8_general_ci';
$db['TBAG']['swap_pre'] = '';
$db['TBAG']['autoinit'] = TRUE;
$db['TBAG']['stricton'] = FALSE;

$db['TCOM']['hostname'] = "192.168.117.100";
$db['TCOM']['username'] = 'markuser';
$db['TCOM']['password'] = 'tseug';
$db['TCOM']['database'] = 'skum';
//$db['TCOM']['dbdriver'] = 'sqlsrv';
$db['TCOM']['dbdriver'] = 'mssql';
$db['TCOM']['dbprefix'] = '';
$db['TCOM']['pconnect'] = TRUE;
$db['TCOM']['db_debug'] = FALSE;
$db['TCOM']['cache_on'] = FALSE;
$db['TCOM']['cachedir'] = '';
$db['TCOM']['char_set'] = 'utf8';
$db['TCOM']['dbcollat'] = 'utf8_general_ci';
$db['TCOM']['swap_pre'] = '';
$db['TCOM']['autoinit'] = TRUE;
$db['TCOM']['stricton'] = FALSE;
	
$db['TSAN']['hostname'] = "192.168.119.100";
$db['TSAN']['username'] = 'markuser';
$db['TSAN']['password'] = 'tseug';
$db['TSAN']['database'] = 'srspedro';
//$db['TSAN']['dbdriver'] = 'sqlsrv';
$db['TSAN']['dbdriver'] = 'mssql';
$db['TSAN']['dbprefix'] = '';
$db['TSAN']['pconnect'] = TRUE;
$db['TSAN']['db_debug'] = FALSE;
$db['TSAN']['cache_on'] = FALSE;
$db['TSAN']['cachedir'] = '';
$db['TSAN']['char_set'] = 'utf8';
$db['TSAN']['dbcollat'] = 'utf8_general_ci';
$db['TSAN']['swap_pre'] = '';
$db['TSAN']['autoinit'] = TRUE;
$db['TSAN']['stricton'] = FALSE;

$db['TALA']['hostname'] = "192.168.20.100";
$db['TALA']['username'] = 'markuser';
$db['TALA']['password'] = 'tseug';
$db['TALA']['database'] = 'SRSALAM';
//$db['TALA']['dbdriver'] = 'sqlsrv';
$db['TALA']['dbdriver'] = 'mssql';
$db['TALA']['dbprefix'] = '';
$db['TALA']['pconnect'] = TRUE;
$db['TALA']['db_debug'] = FALSE;
$db['TALA']['cache_on'] = FALSE;
$db['TALA']['cachedir'] = '';
$db['TALA']['char_set'] = 'utf8';
$db['TALA']['dbcollat'] = 'utf8_general_ci';
$db['TALA']['swap_pre'] = '';
$db['TALA']['autoinit'] = TRUE;
$db['TALA']['stricton'] = FALSE;

$db['TPUN']['hostname'] = "192.168.15.100";
$db['TPUN']['username'] = 'markuser';
$db['TPUN']['password'] = 'tseug';
$db['TPUN']['database'] = 'SRSPUN';
//$db['TPUN']['dbdriver'] = 'sqlsrv';
$db['TPUN']['dbdriver'] = 'mssql';
$db['TPUN']['dbprefix'] = '';
$db['TPUN']['pconnect'] = TRUE;
$db['TPUN']['db_debug'] = FALSE;
$db['TPUN']['cache_on'] = FALSE;
$db['TPUN']['cachedir'] = '';
$db['TPUN']['char_set'] = 'utf8';
$db['TPUN']['dbcollat'] = 'utf8_general_ci';
$db['TPUN']['swap_pre'] = '';
$db['TPUN']['autoinit'] = TRUE;
$db['TPUN']['stricton'] = FALSE;

$db['TLAP']['hostname'] = "192.168.132.100";
$db['TLAP']['username'] = 'markuser';
$db['TLAP']['password'] = 'tseug';
$db['TLAP']['database'] = 'srspinas';
//$db['TLAP']['dbdriver'] = 'sqlsrv';
$db['TLAP']['dbdriver'] = 'mssql';
$db['TLAP']['dbprefix'] = '';
$db['TLAP']['pconnect'] = TRUE;
$db['TLAP']['db_debug'] = FALSE;
$db['TLAP']['cache_on'] = FALSE;
$db['TLAP']['cachedir'] = '';
$db['TLAP']['char_set'] = 'utf8';
$db['TLAP']['dbcollat'] = 'utf8_general_ci';
$db['TLAP']['swap_pre'] = '';
$db['TLAP']['autoinit'] = TRUE;
$db['TLAP']['stricton'] = FALSE;

$db['TPAT']['hostname'] = "192.168.116.100";
$db['TPAT']['username'] = 'markuser';
$db['TPAT']['password'] = 'tseug';
$db['TPAT']['database'] = 'SRSPAT';
//$db['TPAT']['dbdriver'] = 'sqlsrv';
$db['TPAT']['dbdriver'] = 'mssql';
$db['TPAT']['dbprefix'] = '';
$db['TPAT']['pconnect'] = TRUE;
$db['TPAT']['db_debug'] = FALSE;
$db['TPAT']['cache_on'] = FALSE;
$db['TPAT']['cachedir'] = '';
$db['TPAT']['char_set'] = 'utf8';
$db['TPAT']['dbcollat'] = 'utf8_general_ci';
$db['TPAT']['swap_pre'] = '';
$db['TPAT']['autoinit'] = TRUE;
$db['TPAT']['stricton'] = FALSE;

$db['TBGB']['hostname'] = "192.168.21.100";
$db['TBGB']['username'] = 'markuser';
$db['TBGB']['password'] = 'tseug';
$db['TBGB']['database'] = 'SRSBAG';
//$db['TBGB']['dbdriver'] = 'sqlsrv';
$db['TBGB']['dbdriver'] = 'mssql';
$db['TBGB']['dbprefix'] = '';
$db['TBGB']['pconnect'] = TRUE;
$db['TBGB']['db_debug'] = FALSE;
$db['TBGB']['cache_on'] = FALSE;
$db['TBGB']['cachedir'] = '';
$db['TBGB']['char_set'] = 'utf8';
$db['TBGB']['dbcollat'] = 'utf8_general_ci';
$db['TBGB']['swap_pre'] = '';
$db['TBGB']['autoinit'] = TRUE;
$db['TBGB']['stricton'] = FALSE;



$db['TMOL']['hostname'] = "192.168.22.100";
$db['TMOL']['username'] = 'markuser';
$db['TMOL']['password'] = 'tseug';
$db['TMOL']['database'] = 'SRSMOL';
//$db['TMOL']['dbdriver'] = 'sqlsrv';
$db['TMOL']['dbdriver'] = 'mssql';
$db['TMOL']['dbprefix'] = '';
$db['TMOL']['pconnect'] = TRUE;
$db['TMOL']['db_debug'] = FALSE;
$db['TMOL']['cache_on'] = FALSE;
$db['TMOL']['cachedir'] = '';
$db['TMOL']['char_set'] = 'utf8';
$db['TMOL']['dbcollat'] = 'utf8_general_ci';
$db['TMOL']['swap_pre'] = '';
$db['TMOL']['autoinit'] = TRUE;
$db['TMOL']['stricton'] = FALSE;

$db['TGVL']['hostname'] = "192.168.102.100";
$db['TGVL']['username'] = 'markuser';
$db['TGVL']['password'] = 'tseug';
$db['TGVL']['database'] = 'SRSMUZ';
//$db['TGVL']['dbdriver'] = 'sqlsrv';
$db['TGVL']['dbdriver'] = 'mssql';
$db['TGVL']['dbprefix'] = '';
$db['TGVL']['pconnect'] = TRUE;
$db['TGVL']['db_debug'] = FALSE;
$db['TGVL']['cache_on'] = FALSE;
$db['TGVL']['cachedir'] = '';
$db['TGVL']['char_set'] = 'utf8';
$db['TGVL']['dbcollat'] = 'utf8_general_ci';
$db['TGVL']['swap_pre'] = '';
$db['TGVL']['autoinit'] = TRUE;
$db['TGVL']['stricton'] = FALSE;


$db['TMON']['hostname'] = "192.168.23.100";
$db['TMON']['username'] = 'markuser';
$db['TMON']['password'] = 'tseug';
$db['TMON']['database'] = 'SRSMONTB';
//$db['TMON']['dbdriver'] = 'sqlsrv';
$db['TMON']['dbdriver'] = 'mssql';
$db['TMON']['dbprefix'] = '';
$db['TMON']['pconnect'] = TRUE;
$db['TMON']['db_debug'] = FALSE;
$db['TMON']['cache_on'] = FALSE;
$db['TMON']['cachedir'] = '';
$db['TMON']['char_set'] = 'utf8';
$db['TMON']['dbcollat'] = 'utf8_general_ci';
$db['TMON']['swap_pre'] = '';
$db['TMON']['autoinit'] = TRUE;
$db['TMON']['stricton'] = FALSE;

$db['TMANG']['hostname'] = "192.168.124.100";
$db['TMANG']['username'] = 'markuser';
$db['TMANG']['password'] = 'tseug';
$db['TMANG']['database'] = 'SRSBMANGA';
//$db['TMANG']['dbdriver'] = 'sqlsrv';
$db['TMANG']['dbdriver'] = 'mssql';
$db['TMANG']['dbprefix'] = '';
$db['TMANG']['pconnect'] = TRUE;
$db['TMANG']['db_debug'] = FALSE;
$db['TMANG']['cache_on'] = FALSE;
$db['TMANG']['cachedir'] = '';
$db['TMANG']['char_set'] = 'utf8';
$db['TMANG']['dbcollat'] = 'utf8_general_ci';
$db['TMANG']['swap_pre'] = '';
$db['TMANG']['autoinit'] = TRUE;
$db['TMANG']['stricton'] = FALSE;


$db['TSAP']['hostname'] = "192.168.5.30";
$db['TSAP']['username'] = 'markuser';
$db['TSAP']['password'] = 'tseug';
$db['TSAP']['database'] = 'SBPALAY';
//$db['TSAP']['dbdriver'] = 'sqlsrv';
$db['TSAP']['dbdriver'] = 'mssql';
$db['TSAP']['dbprefix'] = '';
$db['TSAP']['pconnect'] = TRUE;
$db['TSAP']['db_debug'] = FALSE;
$db['TSAP']['cache_on'] = FALSE;
$db['TSAP']['cachedir'] = '';
$db['TSAP']['char_set'] = 'utf8';
$db['TSAP']['dbcollat'] = 'utf8_general_ci';
$db['TSAP']['swap_pre'] = '';
$db['TSAP']['autoinit'] = TRUE;
$db['TSAP']['stricton'] = FALSE;


$db['TSIS']['hostname'] = "192.168.5.5";
$db['TSIS']['username'] = 'markuser';
$db['TSIS']['password'] = 'tseug';
$db['TSIS']['database'] = 'SBISIDRO';
//$db['TSIS']['dbdriver'] = 'sqlsrv';
$db['TSIS']['dbdriver'] = 'mssql';
$db['TSIS']['dbprefix'] = '';
$db['TSIS']['pconnect'] = TRUE;
$db['TSIS']['db_debug'] = FALSE;
$db['TSIS']['cache_on'] = FALSE;
$db['TSIS']['cachedir'] = '';
$db['TSIS']['char_set'] = 'utf8';
$db['TSIS']['dbcollat'] = 'utf8_general_ci';
$db['TSIS']['swap_pre'] = '';
$db['TSIS']['autoinit'] = TRUE;
$db['TSIS']['stricton'] = FALSE;


$db['TANA']['hostname'] = "192.168.127.100";
$db['TANA']['username'] = 'markuser';
$db['TANA']['password'] = 'tseug';
$db['TANA']['database'] = 'SBAGORA';
//$db['TANA']['dbdriver'] = 'sqlsrv';
$db['TANA']['dbdriver'] = 'mssql';
$db['TANA']['dbprefix'] = '';
$db['TANA']['pconnect'] = TRUE;
$db['TANA']['db_debug'] = FALSE;
$db['TANA']['cache_on'] = FALSE;
$db['TANA']['cachedir'] = '';
$db['TANA']['char_set'] = 'utf8';
$db['TANA']['dbcollat'] = 'utf8_general_ci';
$db['TANA']['swap_pre'] = '';
$db['TANA']['autoinit'] = TRUE;
$db['TANA']['stricton'] = FALSE;



$db['TBAG2']['hostname'] = "192.168.130.100";
$db['TBAG2']['username'] = 'markuser';
$db['TBAG2']['password'] = 'tseug';
$db['TBAG2']['database'] = 'SRSBSL2';
//$db['TBAG2']['dbdriver'] = 'sqlsrv';
$db['TBAG2']['dbdriver'] = 'mssql';
$db['TBAG2']['dbprefix'] = '';
$db['TBAG2']['pconnect'] = TRUE;
$db['TBAG2']['db_debug'] = FALSE;
$db['TBAG2']['cache_on'] = FALSE;
$db['TBAG2']['cachedir'] = '';
$db['TBAG2']['char_set'] = 'utf8';
$db['TBAG2']['dbcollat'] = 'utf8_general_ci';
$db['TBAG2']['swap_pre'] = '';
$db['TBAG2']['autoinit'] = TRUE;
$db['TBAG2']['stricton'] = FALSE;


$db['TMAR']['hostname'] = "192.168.128.100";
$db['TMAR']['username'] = 'markuser';
$db['TMAR']['password'] = 'tseug';
$db['TMAR']['database'] = 'SBMARILAO';
//$db['TMAR']['dbdriver'] = 'sqlsrv';
$db['TMAR']['dbdriver'] = 'mssql';
$db['TMAR']['dbprefix'] = '';
$db['TMAR']['pconnect'] = TRUE;
$db['TMAR']['db_debug'] = FALSE;
$db['TMAR']['cache_on'] = FALSE;
$db['TMAR']['cachedir'] = '';
$db['TMAR']['char_set'] = 'utf8';
$db['TMAR']['dbcollat'] = 'utf8_general_ci';
$db['TMAR']['swap_pre'] = '';
$db['TMAR']['autoinit'] = TRUE;
$db['TMAR']['stricton'] = FALSE;

$db['TMAR2']['hostname'] = "192.168.129.100";
$db['TMAR2']['username'] = 'markuser';
$db['TMAR2']['password'] = 'tseug';
$db['TMAR2']['database'] = 'SBMARILAO2';
//$db['TMAR2']['dbdriver'] = 'sqlsrv';
$db['TMAR2']['dbdriver'] = 'mssql';
$db['TMAR2']['dbprefix'] = '';
$db['TMAR2']['pconnect'] = TRUE;
$db['TMAR2']['db_debug'] = FALSE;
$db['TMAR2']['cache_on'] = FALSE;
$db['TMAR2']['cachedir'] = '';
$db['TMAR2']['char_set'] = 'utf8';
$db['TMAR2']['dbcollat'] = 'utf8_general_ci';
$db['TMAR2']['swap_pre'] = '';
$db['TMAR2']['autoinit'] = TRUE;
$db['TMAR2']['stricton'] = FALSE;




$db['TTNZA']['hostname'] = "192.168.5.29";
$db['TTNZA']['username'] = 'markuser';
$db['TTNZA']['password'] = 'tseug';
$db['TTNZA']['database'] = 'SBTANZA';
//$db['TTNZA']['dbdriver'] = 'sqlsrv';
$db['TTNZA']['dbdriver'] = 'mssql';
$db['TTNZA']['dbprefix'] = '';
$db['TTNZA']['pconnect'] = TRUE;
$db['TTNZA']['db_debug'] = TRUE;
$db['TTNZA']['cache_on'] = FALSE;
$db['TTNZA']['cachedir'] = '';
$db['TTNZA']['char_set'] = 'utf8';
$db['TTNZA']['dbcollat'] = 'utf8_general_ci';
$db['TTNZA']['swap_pre'] = '';
$db['TTNZA']['autoinit'] = TRUE;
$db['TTNZA']['stricton'] = FALSE;


$db['TBENG']['hostname'] = "192.168.5.31";
$db['TBENG']['username'] = 'markuser';
$db['TBENG']['password'] = 'tseug';
$db['TBENG']['database'] = 'SBBENGUET';
//$db['TBENG']['dbdriver'] = 'sqlsrv';
$db['TBENG']['dbdriver'] = 'mssql';
$db['TBENG']['dbprefix'] = '';
$db['TBENG']['pconnect'] = TRUE;
$db['TBENG']['db_debug'] = TRUE;
$db['TBENG']['cache_on'] = FALSE;
$db['TBENG']['cachedir'] = '';
$db['TBENG']['char_set'] = 'utf8';
$db['TBENG']['dbcollat'] = 'utf8_general_ci';
$db['TBENG']['swap_pre'] = '';
$db['TBENG']['autoinit'] = TRUE;
$db['TBENG']['stricton'] = FALSE;



$db['TCOMD']['hostname'] = "192.168.0.148";
$db['TCOMD']['username'] = 'markuser';
$db['TCOMD']['password'] = 'tseug';
$db['TCOMD']['database'] = 'COMDEPARO';
//$db['TCOMD']['dbdriver'] = 'sqlsrv';
$db['TCOMD']['dbdriver'] = 'mssql';
$db['TCOMD']['dbprefix'] = '';
$db['TCOMD']['pconnect'] = TRUE;
$db['TCOMD']['db_debug'] = TRUE;
$db['TCOMD']['cache_on'] = FALSE;
$db['TCOMD']['cachedir'] = '';
$db['TCOMD']['char_set'] = 'utf8';
$db['TCOMD']['dbcollat'] = 'utf8_general_ci';
$db['TCOMD']['swap_pre'] = '';
$db['TCOMD']['autoinit'] = TRUE;
$db['TCOMD']['stricton'] = FALSE;


$db['TCOMS']['hostname'] = "192.168.0.148";
$db['TCOMS']['username'] = 'markuser';
$db['TCOMS']['password'] = 'tseug';
$db['TCOMS']['database'] = 'COMSANANA';
//$db['TCOMS']['dbdriver'] = 'sqlsrv';
$db['TCOMS']['dbdriver'] = 'mssql';
$db['TCOMS']['dbprefix'] = '';
$db['TCOMS']['pconnect'] = TRUE;
$db['TCOMS']['db_debug'] = TRUE;
$db['TCOMS']['cache_on'] = FALSE;
$db['TCOMS']['cachedir'] = '';
$db['TCOMS']['char_set'] = 'utf8';
$db['TCOMS']['dbcollat'] = 'utf8_general_ci';
$db['TCOMS']['swap_pre'] = '';
$db['TCOMS']['autoinit'] = TRUE;
$db['TCOMS']['stricton'] = FALSE;


$db['TCOMT']['hostname'] = "192.168.0.148";
$db['TCOMT']['username'] = 'markuser';
$db['TCOMT']['password'] = 'tseug';
$db['TCOMT']['database'] = 'COMTALA';
//$db['TCOMT']['dbdriver'] = 'sqlsrv';
$db['TCOMT']['dbdriver'] = 'mssql';
$db['TCOMT']['dbprefix'] = '';
$db['TCOMT']['pconnect'] = TRUE;
$db['TCOMT']['db_debug'] = TRUE;
$db['TCOMT']['cache_on'] = FALSE;
$db['TCOMT']['cachedir'] = '';
$db['TCOMT']['char_set'] = 'utf8';
$db['TCOMT']['dbcollat'] = 'utf8_general_ci';
$db['TCOMT']['swap_pre'] = '';
$db['TCOMT']['autoinit'] = TRUE;
$db['TCOMT']['stricton'] = FALSE;


$db['TCOMT']['hostname'] = "192.168.0.148";
$db['TCOMT']['username'] = 'markuser';
$db['TCOMT']['password'] = 'tseug';
$db['TCOMT']['database'] = 'COMTALA';
//$db['TCOMT']['dbdriver'] = 'sqlsrv';
$db['TCOMT']['dbdriver'] = 'mssql';
$db['TCOMT']['dbprefix'] = '';
$db['TCOMT']['pconnect'] = TRUE;
$db['TCOMT']['db_debug'] = TRUE;
$db['TCOMT']['cache_on'] = FALSE;
$db['TCOMT']['cachedir'] = '';
$db['TCOMT']['char_set'] = 'utf8';
$db['TCOMT']['dbcollat'] = 'utf8_general_ci';
$db['TCOMT']['swap_pre'] = '';
$db['TCOMT']['autoinit'] = TRUE;
$db['TCOMT']['stricton'] = FALSE;


$db['TCOML']['hostname'] = "192.168.0.148";
$db['TCOML']['username'] = 'markuser';
$db['TCOML']['password'] = 'tseug';
$db['TCOML']['database'] = 'COMLLANO';
//$db['TCOML']['dbdriver'] = 'sqlsrv';
$db['TCOML']['dbdriver'] = 'mssql';
$db['TCOML']['dbprefix'] = '';
$db['TCOML']['pconnect'] = TRUE;
$db['TCOML']['db_debug'] = TRUE;
$db['TCOML']['cache_on'] = FALSE;
$db['TCOML']['cachedir'] = '';
$db['TCOML']['char_set'] = 'utf8';
$db['TCOML']['dbcollat'] = 'utf8_general_ci';
$db['TCOML']['swap_pre'] = '';
$db['TCOML']['autoinit'] = TRUE;
$db['TCOML']['stricton'] = FALSE;



$db['TSTAM']['hostname'] = "192.168.5.26";
$db['TSTAM']['username'] = 'markuser';
$db['TSTAM']['password'] = 'tseug';
$db['TSTAM']['database'] = 'SBSTAMARIA';
//$db['TSTAM']['dbdriver'] = 'sqlsrv';
$db['TSTAM']['dbdriver'] = 'mssql';
$db['TSTAM']['dbprefix'] = '';
$db['TSTAM']['pconnect'] = TRUE;
$db['TSTAM']['db_debug'] = TRUE;
$db['TSTAM']['cache_on'] = FALSE;
$db['TSTAM']['cachedir'] = '';
$db['TSTAM']['char_set'] = 'utf8';
$db['TSTAM']['dbcollat'] = 'utf8_general_ci';
$db['TSTAM']['swap_pre'] = '';
$db['TSTAM']['autoinit'] = TRUE;
$db['TSTAM']['stricton'] = FALSE;


$db['TBAT']['hostname'] = "192.168.0.148";
$db['TBAT']['username'] = 'markuser';
$db['TBAT']['password'] = 'tseug';
$db['TBAT']['database'] = 'COMBATASAN';
//$db['TBAT']['dbdriver'] = 'sqlsrv';
$db['TBAT']['dbdriver'] = 'mssql';
$db['TBAT']['dbprefix'] = '';
$db['TBAT']['pconnect'] = TRUE;
$db['TBAT']['db_debug'] = TRUE;
$db['TBAT']['cache_on'] = FALSE;
$db['TBAT']['cachedir'] = '';
$db['TBAT']['char_set'] = 'utf8';
$db['TBAT']['dbcollat'] = 'utf8_general_ci';
$db['TBAT']['swap_pre'] = '';
$db['TBAT']['autoinit'] = TRUE;
$db['TBAT']['stricton'] = FALSE;






// LAWRENZE
$db['newdatacenter']['hostname'] = '192.168.0.91'; 
$db['newdatacenter']['username'] = 'root'; 
$db['newdatacenter']['password'] = 'srsnova';
$db['newdatacenter']['database'] = 'new_datacenter';
$db['newdatacenter']['dbdriver'] = 'mysql';
$db['newdatacenter']['dbprefix'] = '';
$db['newdatacenter']['pconnect'] = FALSE;
$db['newdatacenter']['db_debug'] = false;
$db['newdatacenter']['cache_on'] = FALSE;
$db['newdatacenter']['cachedir'] = '';
$db['newdatacenter']['char_set'] = 'utf8';
$db['newdatacenter']['dbcollat'] = 'utf8_general_ci';
$db['newdatacenter']['swap_pre'] = '';
$db['newdatacenter']['autoinit'] = TRUE;
$db['newdatacenter']['stricton'] = FALSE;
// ./LAWRENZE

//VAN
$db['mynova']['hostname'] = '192.168.0.179'; 
$db['mynova']['username'] = 'root'; 
$db['mynova']['password'] = 'srsnova';
$db['mynova']['database'] = 'srspos';
$db['mynova']['dbdriver'] = 'mysql';
$db['mynova']['dbprefix'] = '';
$db['mynova']['pconnect'] = FALSE;
$db['mynova']['db_debug'] = false;
$db['mynova']['cache_on'] = FALSE;
$db['mynova']['cachedir'] = '';
$db['mynova']['char_set'] = 'utf8';
$db['mynova']['dbcollat'] = 'utf8_general_ci';
$db['mynova']['swap_pre'] = '';
$db['mynova']['autoinit'] = TRUE;
$db['mynova']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */