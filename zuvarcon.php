<?php
/**
 *
 * @category  zuvarcon -loads request public  
 * @package   ZUGRAFI - application custom font
 * @author    Rully Shabara <rullyshabara@gmail.com>
 * @copyright Copyright (c) 2017
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   3.3
 *
 */

define( 'ZULIBS' , 'libs' . '/' );

if ( !isset($first_header) ) {

    $first_header = true;

    require_once( dirname( __FILE__ ) . '/zuload.php' );

    if ( class_exists('zu_quest') ){

       define( 'ZULIB' , 'zu-library' );

       require_once( DEVPATH . ZUEXEC . 'zu-execute.php' );

    }

}
 
