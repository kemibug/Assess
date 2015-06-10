<?php
defined('IN_UF') or exit('Access Denied');

$jump_url = "./";

if($_SESSION[DB_PREFIX.'fromoa'] == true){
    $jump_url .= "?fromoa=true";
}

session_unset(); 
session_destroy();

halt2("",$jump_url,1);
?>