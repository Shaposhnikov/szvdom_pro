<?
define("DBPersistent", false);
/* define("BX_USE_MYSQLI", false); */
$DBType = "mysql";
$DBHost = "localhost";
$DBLogin = "szvdom";
$DBPassword = "Z8f5S9v8";
$DBName = "szvdom";
$DBDebug = false;
$DBDebugToFile = false;

define("MYSQL_TABLE_TYPE", "INNODB");

define("DELAY_DB_CONNECT", true);
define("CACHED_b_file", 3600);
define("CACHED_b_file_bucket_size", 10);
define("CACHED_b_lang", 3600);
define("CACHED_b_option", 3600);
define("CACHED_b_lang_domain", 3600);
define("CACHED_b_site_template", 3600);
define("CACHED_b_event", 3600);
define("CACHED_b_agent", 3660);
define("CACHED_menu", 3600);

define("BX_UTF", true);
define("BX_COMPOSITE_DEBUG", false);
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");
define("BX_FILE_PERMISSIONS", 0777);
define("BX_DIR_PERMISSIONS", 0777);
@umask(~BX_DIR_PERMISSIONS);
@ini_set("memory_limit", "512M");
define("BX_DISABLE_INDEX_PAGE", true);
date_default_timezone_set("Europe/Moscow");
?>
<?
$err_level = error_reporting(0);  
$conn = mysql_connect('params');  
error_reporting($err_level);
?>