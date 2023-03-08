<?php
/**
 *
 * @category  zuload - definition variable constant
 * @package   ZUGRAFI - application custom font
 * @author    Rully Shabara <rullyshabara@gmail.com>
 * @copyright Copyright (c) 2017
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   3.3
 *
 */

@define( 'DEVPATH', dirname(__FILE__) . '/' );

/** if https use port 443 */
define( 'ZUPORT' , '443' ); 

/** MySQL name database */
define( 'ZUNAME', 'khawagak_a' );

/** MySQL database username */
define( 'ZUSER', 'khawagak_user' ); # if localhost change root & the native is japromik_jm

/** MySQL database password */
define( 'ZUPASS', 'walahwalah' );  # if localhost change root & the native is bismillah123456789

/** MySQL hostname */
define( 'ZUHOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'ZUCHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'ZUCOLLATE', '' );

define( 'ZU_DEBUG', false );

class zu_quest {

  public function get_protocol() {

   $protocol = $_SERVER['SERVER_PROTOCOL'];

   if ( ! in_array( $protocol, array( 'HTTP/1.1', 'HTTP/2', 'HTTP/2.0' ) ) ) {

    $protocol = 'HTTP/1.0';

   }

   return $protocol;

  }

}

