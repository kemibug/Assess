<?php
defined('IN_UF') or exit('Access Denied');

$main_url = '?m=main';

if(isset($_GET['login_ref']) && $_GET['login_ref'] != ''){
    $main_url = $_GET['login_ref'];
}

include(Template("frame"));
?>