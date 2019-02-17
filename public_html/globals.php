<?php

require_once("server_url.php");
/////// Global variables ////////////////////

$public_path = dirname( __DIR__,1);
$project_path = dirname($public_path, 1)."/Blogg-Prosjekt";
$protocol = 'http://';
$server_url = $protocol . $srv_path;

$doc_root = $protocol . $srv_path;
$template_path = $public_path . "/public_html/template";
$project_title = 'ITE1805 - 2017';


$twigdata = array();
$twigdata['server_url'] = $GLOBALS['server_url'] . $GLOBALS['user_dir'];
$twigdata['assets_dir'] = $GLOBALS['server_url'] . $GLOBALS['user_dir'] . $GLOBALS['prj_dir'] . '/assets';
$twigdata['action_dir']= $GLOBALS['user_dir'] . $GLOBALS['prj_dir'] . '/controller';
$twigdata['template_dir']= $GLOBALS['user_dir'] . $GLOBALS['prj_dir'] . '/template';
$twigdata['image_dir'] = $GLOBALS['server_url'] . $GLOBALS['user_dir'] . $GLOBALS['prj_dir'] . '/uploaded-imgs';
$twigdata['isPrivate'] = false;
