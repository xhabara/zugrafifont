<?php
/**
 *
 * @category  zufunction - custom all function
 * @package   ZUGRAFI - application custom font
 * @author    Rully Shabara <rullyshabara@gmail.com>
 * @copyright Copyright (c) 2017
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   3.3
 *
 */
 
class zufunction extends zuheader {

  /**
   * Whether to use proxy addresses or not.
   *
   * As default this setting is disabled - IP address is mostly needed to increase
   * security. HTTP_* are not reliable since can easily be spoofed. It can be enabled
   * just for more flexibility, but if user uses proxy to connect to trusted services
   * it's his/her own risk, only reliable field for IP address is $_SERVER['REMOTE_ADDR'].
   *
   * @var bool
   */
  protected $useProxy = false;

  /**
   * List of trusted proxy IP addresses
   *
   * @var array
   */
  protected $trustedProxies = array();

  /**
   * HTTP header to introspect for proxies
   *
   * @var string
   */
  protected $proxyHeader = 'HTTP_X_FORWARDED_FOR';

  // [...]

  /**
   * Returns client IP address.
   *
   * @return string IP address.
   */
  public function getIpAddress(){
      $ip = $this->getIpAddressFromProxy();
      if ($ip) {
          return $ip;
      }

      // direct IP address
      if (isset($_SERVER['REMOTE_ADDR'])) {
          return $_SERVER['REMOTE_ADDR'];
      }

      return '';
  }

  /**
   * Attempt to get the IP address for a proxied client
   *
   * @see http://tools.ietf.org/html/draft-ietf-appsawg-http-forwarded-10#section-5.2
   * @return false|string
   */
  protected function getIpAddressFromProxy(){
      if (!$this->useProxy
          || (isset($_SERVER['REMOTE_ADDR']) && !in_array($_SERVER['REMOTE_ADDR'], $this->trustedProxies))
      ) {
          return false;
      }

      $header = $this->proxyHeader;
      if (!isset($_SERVER[$header]) || empty($_SERVER[$header])) {
          return false;
      }

      // Extract IPs
      $ips = explode(',', $_SERVER[$header]);
      // trim, so we can compare against trusted proxies properly
      $ips = array_map('trim', $ips);
      // remove trusted proxy IPs
      $ips = array_diff($ips, $this->trustedProxies);

      // Any left?
      if (empty($ips)) {
          return false;
      }

      // Since we've removed any known, trusted proxy servers, the right-most
      // address represents the first IP we do not know about -- i.e., we do
      // not know if it is a proxy server, or a client. As such, we treat it
      // as the originating IP.
      // @see http://en.wikipedia.org/wiki/X-Forwarded-For
      $ip = array_pop($ips);
      return $ip;
  }

/*   
 *
 * getBrowser  
 *
 * get client browser
 * @param default
 * @return string
 *
 */

 protected function getBrowser(){

  $browser = $_SERVER['HTTP_USER_AGENT'];

  return $browser;

 }

/*   
 *
 * showBrowser  
 *
 * show client browser
 * @param default
 * @return string
 *
 */

 public function showBrowser(){

  return self::getBrowser();

 }

/*   
 *
 * show_memory  
 *
 * show the memory cache
 * @param default
 * @return array
 *
 */

 public function show_memory(){

  $time = microtime(TRUE);

  $mem = memory_get_usage();

   #[the code you want to measure here]

  $show = array( 'memory' => (memory_get_usage() - $mem) / (1024 * 1024), # use print_r to see

                 'seconds' => microtime(TRUE) - $time );

  return $show;

 }

/*   
 *
 * get_dir_size  
 *
 * show the size directory
 * @param $directory $directory
 * @return string
 *
 */

 public function get_dir_size($directory){

    $size = 0;

    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file) {

        $size += $file->getSize();
    }

    return $size;
 }

/*   
 *
 * foldersize
 *
 * Get the directory size
 * @param directory $directory
 * @return integer
 *
 */

 public function folderSize ($dir){

    $size = 0;

    foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {

        $size += is_file($each) ? filesize($each) : folderSize($each);

    }

    return $size;

 }

/*   
 *
 * show_php_info  
 *
 * show the memory cache
 * @param default
 * @return file phpinfo
 *
 */

 public function show_php_info(){

  #see info all feature php

  $phpo = phpinfo();

  return $phpo;

 }

/*
 * Formats filesize in human readable way.
 *
 * @param file $file
 * @return string Formatted Filesize, e.g. "113.24 MB".
 */

 public function filesize_formatted($bytes){

    //$bytes = filesize($file);

    if ($bytes >= 1073741824) {
 
       return number_format($bytes / 1073741824, 2) . ' GB';

    } elseif ($bytes >= 1048576) {

        return number_format($bytes / 1048576, 2) . ' MB';

    } elseif ($bytes >= 1024) {

        return number_format($bytes / 1024, 2) . ' KB';

    } elseif ($bytes > 1) {

        return $bytes . ' bytes';

    } elseif ($bytes == 1) {

        return '1 byte';

    } else {

        return '0 bytes';

    }

 }

/*   
 *
 * get_int  
 *
 * filter string
 * @param $string
 * @return int
 *
 */

 public function get_int($name){

  $names = trim($name);
 
  $nm = preg_replace("/[^0-9 ]/", "", $names);

  return $nm;

 }

/*   
 *
 * zuhash  
 *
 * get random hash 
 * @param string or varchar
 * @return int
 *
 */

 public static function zuhash($word){

  $zuhash = md5("&^%#^~><#$%$^%$^". $word ."^");

  return $zuhash;

 }


/*   
 *
 * get_string  
 *
 * filter string
 * @param $string
 * @return string
 *
 */

 public function get_string($name)
 {

  $names = trim($name);
 
  $nm = preg_replace("/[^A-Za-z0-9 .]/", "", $names); 

  return substr($nm,0,100);

 }
/*   
 *
 * get string for request all words  
 *
 * filter string
 * @param $string
 * @return string
 *
 */

 public function get_string_for_words($name){

  $names = trim(htmlentities($name));

  $nm = preg_replace("/[^A-Za-z0-9 +&-_>.,?!]/", "", $names); 

  $nmOne  = str_replace( array(";","&","<",">"),
                         array("","&amp;","&lt;","&gt;"),
                         $nm);
  return $nmOne;

 }

/*   
 *
 * AHR string to &gt; &gt; or >>   
 *
 * filter string
 * @param $string
 * @return string
 *
 */

 public function string_to_gt($name){

  $nmOne  = str_replace( array("AHR","AHL","SY","KH","NY","NG"),
                         array("","","s","k","n","g"),
                         $name);
  return $nmOne;

 }

/*   
 *
 * get AHR or AHL   
 *
 * filter string
 * @param $string
 * @return string
 *
 */

 public function get_char($name){

  $char = '';

  $nmAHR  = strpos($name,'AHR');

  $nmAHL  = strpos($name,'AHL');

   if ($nmAHR == 1){
   
     return $char = 1;

   } 

   if ($nmAHL == 1){
   
     return $char = 2;

   } 

   else {
    
    $char = 3;
  
   }

  return $nmOne = $char;

 }

/*   
 *
 * get pola word   
 *
 * filter string
 * @param $string
 * @return string
 *
 */


 public function get_pola($name){

  $nmOne  = str_replace( array("A","I","U","E","O","Z","P","J","G","C","R","K","g","M","T","n","H","S","L","s","D","W","B","N","k","F","Y"),
                         array("2","3","4","5","6","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1"),
                         $name);
  return $nmOne;

 }

/*   
 *
 * get only space   
 *
 * filter string
 * @param $string
 * @return string
 *
 */

 public function get_only_space($name){

  $nmOne  = str_replace( array(//"AAA","AAI","AAU","AAE","AAO",
                               "AA","AI","AU","AE","AO",
                               "IA","II","IU","IE","IO",
                               "UA","UI","UU","UE","UO",
                               "OA","OI","OU","OE","OO",
                               "EA","EI","EU","EE","EO"),
                         array(//"   ","   ","   ","   ","   ",
                               "","","","","",
                               "","","","","",
                               "","","","","",
                               "","","","","",
                               "","","","",""),
                         $name);

  #return  self::get_only_alpha($name);

  return self::get_only_alpha($nmOne);

 }

/*   
 *
 * get only alphabet   
 *
 * filter string
 * @param $string
 * @return string
 *
 */

 public function get_only_alpha($name){

  $nmOne  = str_replace( array("A","I","U","E","O"),
                         array("","","","",""),
                         $name);
  /*
  $nmTwo  = str_replace( array("  ","   "),
                         array(" ","  "),
                         $nmOne);
  */
  return $nmOne;

 }

/*   
 *
 * open kurawal   
 *
 * filter string
 * @param $string
 * @return string
 *
 */

 public function open_kurawal($name){

  $nmOne  = str_replace( array("}","{"),
                         array("",""),
                         $name);
  return $nmOne;

 }

/*   
 *
 * give kurawal   
 *
 * giving kurawal to string
 * @param $string
 * @return string
 *
 */

 public function give_kurawal($name){

  return "{".$name."}";

 }

/*   
 *
 * email_filter  
 *
 * filter string
 * @param $string
 * @return string
 *
 */

 public function email_filter($str){

  $use = preg_replace("/[^A-Za-z0-9 _.@]/", "", $str);

  return self::give_kurawal($use);

 }

/*   
 *
 * open_time  
 *
 * filter string
 * @param $string
 * @return string
 *
 */

 public static function open_time($sh) {

  $mnt = substr($sh,11,8);

  return $mnt;

 }

/*   
 *
 * open_simple_date  
 *
 * filter string
 * @param $string
 * @return string
 *
 */

 public static function open_simple_date($sh) {
  
  $set = "";
  
  $th  = substr($sh,0,4);

  $bln = substr($sh,5,2);

  $tgl = substr($sh,8,2);

  $set .= $tgl. "/";  

  $set .= $bln. "/";  

  $set .= $th;  

  return $set;

 }

/*   
 *
 * open_date  
 *
 * filter string
 * @param $string
 * @return string
 *
 */

 public static function open_date($sh) {
  
  $set = "";
  
  $th  = substr($sh,0,4);

  $bln = substr($sh,5,2);

  $bl = self::open_mount($bln);

  $tgl = substr($sh,8,2);

  $set .= $tgl. " ";  

  $set .= $bl. " ";  

  $set .= $th;  

  return $set;

 }

/*   
 *
 * open_mount  
 *
 * get mount id-lang 
 * @param $string
 * @return string
 *
 */

 public static function open_mount($sh)
 {
   switch($sh){

   case "01":
   return "januari";
   break;

   case "02":
   return "Februari";
   break;

   case "03":
   return "Maret";
   break;

   case "04":
   return "April";
   break;

   case "05":
   return "Mei";
   break;

   case "06":
   return "juni";
   break;
 
   case "07":
   return "juli";
   break;

   case "08":
   return "Agustus";
   break;

   case "09":
   return "September";
   break;

   case "10":
   return "Oktober";
   break;

   case "11":
   return "November";
   break;

   case "12":
   return "Desember";
   break;
 
   }

 }

} 
