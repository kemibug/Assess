<?php
defined('IN_UF') or exit('Access Denied');

$page_title = $_REQUEST['title'];

$attach = base64_decode($_REQUEST['attach']);

include(Template("help"));
?>