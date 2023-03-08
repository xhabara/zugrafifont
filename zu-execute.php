<?php
/**
 *
 * @category  zu-execute - execute all request public
 * @package   ZUGRAFI - application custom font
 * @author    Rully Shabara <rullyshabara@gmail.com>
 * @copyright Copyright (c) 2017
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   3.3
 *
 */

require_once( DEVPATH . ZUEXEC . ZULIB . '.php' );

 $report_ini  = new zusession();

 $report_ini->report_set_ini();

 $visual = new zuvisual();
 



# $visual->showPublic();

 if(isset($_SESSION['usr-welcome']) && isset($_SESSION['zu-usr']) && is_array($_SESSION['zu-usr'])) {

   $visual->loading_login();

 } 

 if(isset($_SESSION['zu-usr']) && is_array($_SESSION['zu-usr']) && base64_decode($_SESSION['zu-welcome']) == "welcome-to-admin" ) {

   #$icheck->checkSessionUser( $_SESSION['jm-usr']['tbl'],$_SESSION['jm-usr']['id'],'jm-usr','id' );

   	$visual->showAdmin();

 }

  else {

   if( !isset($_GET) ) { $_GET = null; }

    foreach ($_GET as $var => $val) 

   if( !isset($var) ) { $var = null; }

   //switch($var ?? ''){
   switch($var){
   case "zu-login":
    $visual->showLogin();
   break;

   case null:
    $visual->showPublic();
   break;
   
   default:
    $visual->showPublic();
   break;

  } 

} 

