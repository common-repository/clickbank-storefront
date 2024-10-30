<?php

$GLOBALS['cs_plugin_version'] = '1.7';

require_once 'functions.inc.php';


if (!session_id()) session_start();

if (isset($_GET['sortby'])) $_SESSION['cs_sortby'] = $_GET['sortby'];
if (isset($_GET['switch_view'])) $_SESSION['cs_switch_view'] = $_GET['switch_view'];

$output = cs_show($_GET['section'], $_GET['user_id'], $_GET['criteria'], $_GET['page'],$_GET['cs_mcat'],$_GET['cs_scat']);
//echo $_GET['section'].$_GET['criteria'];
echo $output['output'];

?>