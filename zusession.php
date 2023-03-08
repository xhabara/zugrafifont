<?php
/**
 *
 * @category  zusession - set first session
 * @package   ZUGRAFI - application custom font
 * @author    Rully Shabara <rullyshabara@gmail.com>
 * @copyright Copyright (c) 2017
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   3.3
 *
 */

class zusession
{

/*   
 *
 * startName  
 *
 * set new name session
 * @return session_start 
 *
 */

 private function startName()
 {

   return session_name("zu-id");

 }

/*   
 *
 * startSession  
 *
 * set new session
 * @return session_start 
 *
 */

 public function startSession()
 {

   self::startName();

   session_start();

 }

/*   
 *
 * hideXpowered  
 *
 * set new session
 * @return session_start 
 *
 */

 public static function hideXpowered()
 {

   if (function_exists('header_remove')) {

    header_remove('X-Powered-By'); // PHP 5.3+

    } else 
      {

        @ini_set('expose_php', 'off');

       }
 }

/*   
 *
 * hideXEpire  
 *
 * set header expire 
 *
 */

 public static function headerExpire($give)
 {

    // header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
    // 60 * 60 * 24 * 365 is 1 year

    $offset = $give;

    $ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";

    $show =  header($ExpStr); 

    return $show;

 }

/*   
 *
 * report_set_ini  
 *
 *
 */

 public function report_set_ini()
 {

    #If you don't have access to the server's error log, your task become more complicated.
    #There are several ways to get in touch with error messages.

    #To display error messages on screen you can add these lines to the code
    #ini_set('display_errors',1);
    #error_reporting(E_ALL);

    #or to make custom error logfile
    //ini_set('log_errors',1);
    #ini_set('error_log','/absolute/path/tp/log_file');

    $dier = str_replace("/exec/libs","",dirname( __FILE__ ));

    # echo $dier."/report_log/error_log"; #check it

    ini_set('log_errors',1);

    ini_set('error_log',$dier."/report_log/error_log");

 }

/*   
 *
 * iset_ini  
 *
 *
 */

 public function set_ini()
 {

    return ini_set('display_errors', 'Off'); 

 }

/*   
 *
 * set_report  
 *
 *
 */

 private function set_report()
 {

    self::set_ini();

    error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );
   
    return error_reporting(E_ALL);

 }

 
}

#=============================#
/** set new zusession */
$set_session = new zusession();

/** start session */
$set_session->startSession();

/** hide name machine server */
$set_session->hideXpowered();

