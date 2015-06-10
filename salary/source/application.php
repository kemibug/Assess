<?php
error_reporting(E_ALL);

$mtime = explode(' ',microtime());
$starttime = $mtime[1] + $mtime[0];

session_start();
header('Content-Type:text/html;charset=GB2312');

define('IN_UF',true);

unset($GLOBALS);

$_GET     = daddslashes($_GET,1,true);
$_POST    = daddslashes($_POST,1,true);
$_COOKIE  = daddslashes($_COOKIE,1,true);
$_SERVER  = daddslashes($_SERVER);
$_FILES   = daddslashes($_FILES);
$_REQUEST = daddslashes($_REQUEST,1,true);

$m = getgpc('m');
$a = getgpc('a');

define('APP',dirname(__FILE__));

require_once dirname(__FILE__).'/config.php';
require_once dirname(__FILE__).'/function.php';
require_once dirname(__FILE__).'/adodb/adodb.inc.php';
$db = NewADOConnection($cfg['DB_TYPE'].'://'.$cfg['DB_USER'].':'.$cfg['DB_PWD'].'@'.$cfg['DB_HOST'].':'.$cfg['DB_PORT'].'/'.$cfg['DB_NAME']);
mysql_query("set names 'gbk'");

function daddslashes($string,$force=0,$strip=false){
    if(!get_magic_quotes_gpc() || $force){
        if(is_array($string)){
            foreach($string as $key => $val) {
                $string[$key] = daddslashes($val,$force,$strip);
            }
        }else{
            $string = addslashes($strip ? stripslashes($string) : $string);
        }
    }
    return $string;
}

function getgpc($k,$t='R'){
    switch($t){
        case 'P': $var = &$_POST; break;
        case 'G': $var = &$_GET; break;
        case 'C': $var = &$_COOKIE; break;
        case 'R': $var = &$_REQUEST; break;
    }
    return isset($var[$k]) ? (is_array($var[$k]) ? $var[$k] : trim($var[$k])) : null;
}
?>