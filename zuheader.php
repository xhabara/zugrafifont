<?php
/**
 *
 * @category  zuheader - set header request pages
 * @package   ZUGRAFI - application custom font
 * @author    Rully Shabara <rullyshabara@gmail.com>
 * @copyright Copyright (c) 2017
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   3.3
 *
 */

class zuheader extends zusession {

  private $pet   = "KHAWAGAKA";   # organisation 

  private $name  = "Fredi.work";   # admin webs

  private $add_name  = "www.fredi.work";   # address admin webs

  private $email_name  = "priarumahtangga@gmail.com";   # address admin webs

  private $owner = "Rully Shabara";   # owner webs

  private $add_owner = "www.rullyshabara.com";   # address owner webs

  private $email_owner = "rullyshabara@gmail.com";   # address owner webs

  private $logo  = "logo_pages.png";     # image logo in public

  private $ico   = "logo_tabs.ico";   # image ico in tab browser

  private $release;   # date last modified

/*   
 *
 * pet  
 *
 * show name organisation
 * @param default
 * @return string
 *
 */

 public function pet()
 {

  //$this->pet = $pets;

   return $this->pet;
 
 }

/*   
 *
 * admin  
 *
 * show name admin webpage
 * @param default
 * @return string
 *
 */

 public function admin()
 {

   $this->name;

   return $this->name;
 
 }

/*   
 *
 * owner  
 *
 * show the owner webpage 
 * @param default
 * @return string
 *
 */

 public function owner()
 {

   $this->owner;

   return $this->owner;
 
  }

/*   
 *
 * forico  
 *
 * show the image ico in tab browser 
 * @param default
 * @return string
 *
 */

 public function forIco()
 {

   $this->ico;

   return $this->ico;
 
  }

/*   
 *
 * forLogo  
 *
 * show the image logo in public 
 * @param default
 * @return string
 *
 */

 public function forLogo()
 {

   $this->logo;

   return $this->logo;
 
  }

/*   
 *
 * OneRelease  
 *
 * show release first webpage on public 
 * @param default
 * @return string
 *
 */

 public function OneRelease()
 {

   $this->release ="Date: ". date("d/m/Y");

   return $this->release;
 
  }

/*   
 *
 * dirme  
 *
 * show directory name
 * @param default
 * @return string
 *
 */

 public static function dirme()
 {

   $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

   return $uri;

 }

/*   
 *
 * URL  
 *
 * show url webpage
 * @param default
 * @return string
 *
 */

 public static function URL()
 {

   return self::getRequestScheme() . '://' . $_SERVER['HTTP_HOST']; #--> native online mode

   #return self::getRequestScheme() . '://' . $_SERVER['HTTP_HOST'] . "/zugrafi.com" ; //localhost #--> offline mode

 }

/*   
 *
 * getRequestUrl  
 *
 * native url webpage
 * @param default
 * @return string
 *
 */
 
 public static function getRequestUrl()
 {

   return self::getRequestScheme() . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

 }

/*   
 *
 * getRequestScheme  
 *
 * method ssl 
 * @param default
 * @return string
 *
 */
  
 public static function getRequestScheme()
 {

   return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

 }

/*   
 *
 * set_headers_html  
 *
 * set header text/html
 *
 */
 
 public function set_headers_html() 
 {
   
   header("Content-type:text/html"); 

 }

/*   
 *
 * set_headers_iso88591
 *
 * set header text/html
 *
 */

 public function set_headers_iso88591()
 {

   # North America, Western Europe, Latin America, the Caribbean, Canada, Africa 
   header("Content-type: text/html; charset=iso-8859-1"); 

  }

/*   
 *
 * set_headers_iso88592
 *
 * set header text/html
 *
 */

 public function set_headers_iso88592()
 {

   # Eastern Europe
   header("Content-type: text/html; charset=iso-8859-2"); 

 }

/*   
 *
 * set_headers_iso88593
 *
 * set header text/html
 *
 */

 public function set_headers_iso88593()
 {

   # SE Europe, Esperanto, miscellaneous others
   header("Content-type: text/html; charset=iso-8859-3"); 

 }

/*   
 *
 * set_headers_iso88594
 *
 * set header text/html
 *
 */

 public function set_headers_iso88594()
 {

   # Scandinavia/Baltics (and others not in ISO-8859-1)
   header("Content-type: text/html; charset=iso-8859-4"); 

 }

/*   
 *
 * set_headers_iso88595
 *
 * set header text/html
 *
 */

 public function set_headers_iso88595()
 {

   # The languages that are using a Cyrillic alphabet such as Bulgarian, Belarusian, Russian and Macedonian
   header("Content-type: text/html; charset=iso-8859-5"); 

 }

/*   
 *
 * set_headers_iso88596
 *
 * set header text/html
 *
 */

 public function set_headers_iso88596()
 {

   # The languages that are using the Arabic alphabet
   header("Content-type: text/html; charset=iso-8859-6"); 

 }

/*   
 *
 * set_headers_iso88597
 *
 * set header text/html
 *
 */

 public function set_headers_iso88597()
 {

   # The modern Greek language as well as mathematical symbols derived from the Greek
   header("Content-type: text/html; charset=iso-8859-7"); 

  }

/*   
 *
 * set_headers_iso88598
 *
 * set header text/html
 *
 */

 public function set_headers_iso88598()
 {

   # The languages that are using the Hebrew alphabet
   header("Content-type: text/html; charset=iso-8859-8"); 

 }

/*   
 *
 * set_headers_iso88599
 *
 * set header text/html
 *
 */

 public function set_headers_iso88599()
 {

   # The Turkish language. Same as ISO-8859-1 except Turkish characters replace Icelandic ones
   header("Content-type: text/html; charset=iso-8859-9"); 

 }

/*   
 *
 * set_headers_iso885910
 *
 * set header text/html
 *
 */

 public function set_headers_iso885910()
 {

   # The Nordic languages
   header("Content-type: text/html; charset=iso-8859-10"); 

 }

/*   
 *
 * set_headers_iso885915
 *
 * set header text/html
 *
 */

 public function set_headers_iso885915()
 {

   # Similar to ISO 8859-1 but replaces some less common symbols with the euro sign and some other missing characters
   header("Content-type: text/html; charset=iso-8859-15"); 

 }

/*   
 *
 * set_headers_iso2022jp
 *
 * set header text/html
 *
 */

 public function set_headers_iso2022jp()
 {

   # The Japanese language
   header("Content-type: text/html; charset=iso-2022-JP"); 

 }

/*   
 *
 * set_headers_iso2022jp2
 *
 * set header text/html
 *
 */

 public function set_headers_iso2022jp2()
 {

   # The Japanese language
   header("Content-type: text/html; charset=iso-2022-JP-2"); 

 }

/*   
 *
 * set_headers_iso2022kr
 *
 * set header text/html
 *
 */

 public function set_headers_iso2022kr()
 {

   # The Korean language
   header("Content-type: text/html; charset=iso-2022-KR"); 

 }

/*   
 *
 * set_headers_pdf
 *
 * set header file pdf 
 *
 */

 public function set_headers_pdf($name)
 {

   # header('Content-Disposition: attachment; filename="example.pdf"')
   return header('Content-Disposition: attachment; filename="'.$name.'.pdf"');

 }

/*   
 *
 * set_headers_javascript
 *
 * set header javascript
 *
 */

 public function set_headers_javascript()
 {
   
   header("Content-type:text/javascript"); 

 }
 
/*   
 *
 * set_headers_plain
 *
 * set header plain
 *
 */

 public function set_headers_plain()
 {
   
   header("Content-type:text/plain"); 

 }
 
/*   
 *
 * set_headers_json
 *
 * set header app/json
 *
 */
 
 public function set_headers_json()
 {

   header("Content-Type: application/json; charset=UTF-8");

 } 

/*   
 *
 * set_headers_appOctet
 *
 * set header octet-stream
 *
 */

 public function set_headers_appOctet()
 {
 
   header("Content-type: application/octet-stream");  

 }

/*   
 *
 * set_headers_appPdf
 *
 * set header pdf
 *
 */

 public function set_headers_appPdf()
 {
 
   # add here more headers for diff. extensions
   header("Content-type: application/pdf"); 

 }

/*   
 *
 * set_headers_cLength
 *
 * set content length
 *
 */

 public function set_headers_cLength($fsize)
 {
   
   header("Content-length: $fsize"); 

 }

/*   
 *
 * set_headers_xml
 *
 * set header xml
 *
 */
 
 public function set_headers_xml() 
 {
   
   header("Content-type:text/xml"); 

 }

/*   
 *
 * set_headers_origin
 *
 * set access control
 *
 */

 public function set_headers_origin($key)
 {
   
   # "*" or http://foo.example 
   header("Access-Control-Allow-Origin: $key");

 }

/*   
 *
 * set_headers_appXml
 *
 * content app xml
 *
 */

 public function set_headers_appXml()
 {
   
   header("Content-type:application/xml"); 

 }

/*   
 *
 * set_headers_css
 *
 * content css
 *
 */
 
 public function set_headers_css()
 {
   
   header("Content-type:text/css"); 

 }

/*   
 *
 * set_headers_close
 *
 * set connection close
 *
 */
 
 public function set_headers_close()
 {
   
   header("Connection:close"); 

 }

/*   
 *
 * set_headers_pragma
 *
 * set pragma
 *
 */
 
 public function set_headers_pragma()
 {
   
   header("pragma: no-cache"); 

 }

/*   
 *
 * headerEtag
 *
 * set E-tag
 *
 */

 public function headerEtag($key)
 {

   # 46737687645987678963
   return header("E-tag: $key");

 }

/*   
 *
 * headerVary
 *
 * content css
 *
 */
 
 public function headerVary($key)
 {

   # Vary: User-Agent, Accept 
   return header("Vary: $key");

 }

/*   
 *
 * headerCache
 *
 * set cache-control
 *
 */

 public function headerCache($key)
 {

   # no-store, no-cache, must-revalidate, post-check=0, pre-check=0
   # header('Cache-Control: no-cache, must-revalidate');
   return header("Cache-Control: $key");

 }

/*   
 *
 * headerTrans
 *
 * set Transfer-Encoding
 *
 */
 
 public function headerTrans($key)
 {

   # gzip,deflate,chunked
   return header("Transfer-Encoding: $key");

 }

/*   
 *
 * headerRefresh
 *
 * set header refresh
 *
 */

 public function headerRefresh($time,$url)
 {

   # header('Refresh:10; url=http://www.google.com')
   return header('Refresh:'.$time.'; url='.$url.'');

 }

/*   
 *
 * headerLocation
 *
 * set header-location
 *
 */

 public function headerLocation($url)
 {

   # header('Location: http://www.google.com')
   # exit;
   return header('Location: '.$url.'');

 }

/*   
 *
 * headerTrans
 *
 * set X-Content-Type-Options
 *
 */

 public function no_sniff()
 {

  @header('X-Content-Type-Options: nosniff');

 }

/*   
 *
 * Frame_option
 *
 * set X-Frame-option
 *
 */

 public function frame_option()
 {

  @header('X-Frame-Options: SAMEORIGIN');

 }
 
}

#=============================#
/** set for new headers */
$set_headers = new zuheader();

/** name organisation */
define('PETS' , $set_headers->pet() );

/** admin */
define('ADMINS' , $set_headers->admin() );

/** owner */
define('OWNERS' , $set_headers->owner() );

/** constant for new URL */
define('URL' , $set_headers->URL() );

/** constant for ico image */
define('ICO' , $set_headers->forIco() );

/** constant for logo image */
define('LOGO' , $set_headers->forLogo() );

/** constant for first release */
define('RELEASE' , $set_headers->OneRelease() );

