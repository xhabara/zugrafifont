<?php
/**
 *
 * @category  zudatabase - call database
 * @package   ZUGRAFI - application custom font
 * @author    Rully Shabara <rullyshabara@gmail.com>
 * @copyright Copyright (c) 2017
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   3.3
 *
 */

class zudatabase extends zufunction {

 private $host    = ZUHOST;

 private $user    = ZUSER;

 private $pass    = ZUPASS;

 private $dbase   = ZUNAME;

 private $empty   = "empty";

 private $false   = null;

 private $true    = 1;

 private $port    = ZUPORT;

 private $charset = "utf-8";

 private $show;

 private $disconnect;

 var $sid =array();

/**
  *
  * Fungsi __CONTRUCT 
  *
  * Digunakan untuk mengatur konfigurasi koneksi ke database.
  * @param host  : masukan nama host.
  * @param dbname: masukan nama database.
  * @param user  : masukan nama user.
  * @param pass  : masukan password koneksi ke database.
  *
  */

 public function __CONSTRUCT(){

  //mb_internal_encoding( 'UTF-8' );

  //mb_regex_encoding( 'UTF-8' );

  //mysqli_report( MYSQLI_REPORT_STRICT ); 

  try
  { 

    $pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->dbase.'', ''.$this->user.'', ''.$this->pass.'');

    return $pdo;

  }

  catch(PDOException $e)
  { 

    return print $sql ."<br>". $e->getMessage();

    #SQLSTATE[HY000] [1045]  -> error about connection 
    #SQLSTATE[HY000] [2002]  -> error connection host

  }  

 }

/**
  *
  * checked_login
  *
  * handle request to database from login page in function respond_login.
  * @param $table: name table. 
  * @param $where: variables conditional. 
  * @param $value: value variables. 
  * @param $param: set new session. 
  * @param $auth : set key value for checked. 
  *
  */

 public function checked_login($table=null, $where=null, $value=null, $param=null, $auth=null){

    $db   = self::__CONSTRUCT();

    $conn = self::__CONSTRUCT();

    try
    {

      // set the PDO error mode to exception

      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $adn = $db->prepare("SELECT * FROM $table WHERE $where");

      $adn->execute($value);

      $row = $adn->fetch(PDO::FETCH_ASSOC);
 
      if(empty($row[$param]))
      {

        echo "<div class='text-large text-danger'><i class='fa fa-warning text-red'></i> &nbsp; Wrong Email or Password.</div>";

        exit;

      } else
        {
 
         // set mode session
 
         $_SESSION['zu-usr'] = $row; $_SESSION['usr-welcome'] = $auth;
 
          try
          {
      
            // set the PDO error mode to exception

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE  $table SET user_last_login = NOW() WHERE id=".$row['id'];

            // Prepare statement

            $stmt = $conn->prepare($sql);

            // execute the query

            $stmt->execute();

            // echo a message to say the UPDATE success

            $stmt->rowCount();

            //print $report;
            echo "<div class='text-large text-success'><i class='fa fa-check text-success'></i>&nbsp; Please wait... <img src='". URL ."/dist/img/process.gif' alt='...'></div>";

          } catch(PDOException $e)
            {

             #echo $sql . "<br>" . $e->getMessage();
        echo "<div class='text-large text-danger'><i class='fa fa-warning text-red'></i> &nbsp; Wrong Email or Password.</div>";

            }

          $conn = null;

        }

    } 

    catch(PDOException $e)
    {

      echo $sql . "<br>" . $e->getMessage();

    }

    $db = null;

 }

/**
  *
  * connectMysqli
  *
  * Digunakan u/ menghubungkan ke database dengan method mysqli.
  * @param DHOST : nilai sudah ditentukan dengan define.
  * @param DUSER : nilai sudah ditentukan dengan define.
  * @param DPASS : nilai sudah ditentukan dengan define.
  * @param DNAME : nilai sudah ditentukan dengan define.
  *
  */

 public function connectMysqli(){

  $conn = new mysqli( ZUHOST, ZUSER, ZUPASS, ZUNAME);

  // Check connection

  if ($conn->connect_error) {

    return die("Connection failed: " . $conn->connect_error);

  } else {

    return $conn;

    }

 }

/**
  *
  * Fungsi insertOneRows 
  *
  * Digunakan untuk menambahkan record baru/data baru pada sebuah tabel.
  * perlu diingat:
  * -> untuk auto_increment id harus dikosongkan atau tidak perlu ditulis dalam sebuah variabel. 
  * -> untuk format date(format tanggal sekarang secara otomatis) silahkan menuliskan NOW() dan tidak perlu diberikan tanda kutip apapun, serta harus dilampirkan boleh memberikan nilai null tanpa tanda kutip. 
  * @param $table : masukan nama tabel yang ingin diberikan nilai baru/data baru.
  * @param $var   : masukan variabel yang diinginkan dengan cara array, contoh: $str=array("name_user","alamat_user","avatar_user").
  * @param $value : masukan nilai yang ingin di masukan.
  *
  */

  public function insertOneRows($table=null,$var=null,$value=null)
  {

    $conn = self::__CONSTRUCT();

    try
    {

      // set the PDO error mode to exception

      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "INSERT INTO $table $var VALUES $value";

      // use exec() because no results are returned

      $conn->exec($sql);

      return " successfully";

    }

    catch(PDOException $e)
    {

      echo $sql . "<br>" . $e->getMessage();

    }

    $conn = null;

  }

/**
  *
  * viewCount
  *
  * Digunakan u/ menampilkan jumlah isi table.
  * @param tb : masukan nama table yang dipilih.
  *
  */

 public function viewCount($tb){

   try {

    $con = self::__CONSTRUCT();

    $sql = "SELECT count(*) FROM $tb";

    $result = $con->query($sql);

    $count = $result->fetchColumn(0);

    $con = null;
 
    } catch(PDOException $e) {
  
       return '<div class="alert alert-danger">'.$e->getMessage().'</div>';

       exit;

      }

    return $count;

 }

/**
  *
  * show_all_words
  *
  * Digunakan u/ menampilkan semua pesan yang dikirim user.
  * @param sendmes : nilai url halaman yang ditentukan.
  * @param vars    : varible yang ingin ditampilkan.
  * @param table   : table yang ingin ditampilkan.
  *
  */

 public function show_all_words($vars,$table,$startPage){

   $res = '';

   $conn = self::connectMysqli();

   $sql = "SELECT $vars FROM $table";

   $result = $conn->query($sql);

   if ($result->num_rows > 0) {

  if(!isset($startPage)){

     $number = 1;

   } else {

     $number = $startPage + 1;
    
     }

      $res .=<<<_show_words
[
_show_words;

    while($row = $result->fetch_assoc()) {

      $id_words  = $row['id_words'];
  
      $key_words = date('dmy').$row['id_words'];

      $kata_id   = ucfirst($row['kata_id']);

      $huruf_zu  = $row['huruf_zu'];

      $ket_zu    = $row['ket_zu'];
 
      $time      = zufunction::open_time($row['date_zu']);

      $date      = zufunction::open_simple_date($row['date_zu']);

      $res .=<<<_show_words
{"number":"$number","id_words":"$id_words","key_words":"$key_words","kata_id":"$kata_id","huruf_zu":"$huruf_zu","ket_zu":"$ket_zu","dates":"$date","times":"$time"},
_show_words;
$number ++;
    }

      $res .=<<<_show_words
]
_show_words;

   } else {

      $res .= '';

     }

   $jsonData = preg_replace("/,(?!.*,)/", "", $res);

   return $jsonData; 

   $conn->close();
   
  }

/**
  *
  * show_all_request_words
  *
  * Digunakan u/ menampilkan semua pesan yang dikirim user pd control admin.
  * @param sendmes : nilai url halaman yang ditentukan.
  * @param vars    : varible yang ingin ditampilkan.
  * @param table   : table yang ingin ditampilkan.
  *
  */

 public function show_all_request_words($vars,$table,$startPage){

   $res = '';

   $conn = self::connectMysqli();

   $sql = "SELECT $vars FROM $table";

   $result = $conn->query($sql);

   if ($result->num_rows > 0) {

  if(!isset($startPage)){

     $number = 1;

   } else {

     $number = $startPage + 1;
 
     }

      $res .=<<<_show_words
[
_show_words;

    while($row = $result->fetch_assoc()) {

      $id_reqwords      = $row['id_reqwords'];
  
      $ip_reqwords      = $row['ip_reqwords'];

      $browser_reqwords = ucfirst($row['browser_reqwords']);

      $content_reqwords = $row['content_reqwords'];

      $ket_reqwords     = $row['ket_reqwords'];

      $time_reqwords    = zufunction::open_time($row['time_reqwords']);

      $date_reqwords    = zufunction::open_simple_date($row['time_reqwords']);

      $key_reqwords     = "deck".$row['id_reqwords'];

      $res .=<<<_show_words
{"keyzx":"$key_reqwords","number":"$number","id":"$id_reqwords","ip":"$ip_reqwords","brow":"$browser_reqwords","content":"$content_reqwords","ket":"$ket_reqwords","time":"$time_reqwords","date":"$date_reqwords"},
_show_words;
$number ++;
    }

      $res .=<<<_show_words
]
_show_words;

   } else {

      $res .= '';

     }

   $jsonData = preg_replace("/,(?!.*,)/", "", $res);

   return $jsonData; 

   $conn->close();
   
  }

/**
  *
  * show_notify_request_words
  *
  * Digunakan u/ menampilkan semua pesan yang dikirim user pd control admin.
  * @param sendmes : nilai url halaman yang ditentukan.
  * @param vars    : varible yang ingin ditampilkan.
  * @param table   : table yang ingin ditampilkan.
  *
  */

 public function show_notify_request_words($vars,$table){

   $res = '';

   $conn = self::connectMysqli();

   $sql = "SELECT $vars FROM $table";

   $result = $conn->query($sql);

   if ($result->num_rows > 0) {

  if(!isset($startPage)){

     $number = 1;

   } else {

     $number = $startPage + 1;
 
     }

      $res .=<<<_show_words
[
_show_words;

    while($row = $result->fetch_assoc()) {

      $id_reqwords      = $row['id_reqwords'];
  
      $ip_reqwords      = $row['ip_reqwords'];

      $browser_reqwords = ucfirst($row['browser_reqwords']);

      $content_reqwords = $row['content_reqwords'];

      $ket_reqwords     = $row['ket_reqwords'];

      $time_reqwords    = zufunction::open_time($row['time_reqwords']);

      $date_reqwords    = zufunction::open_simple_date($row['time_reqwords']);

      $res .=<<<_show_words
{"number":"$number","id":"$id_reqwords","ip":"$ip_reqwords","brow":"$browser_reqwords","content":"$content_reqwords","ket":"$ket_reqwords","time":"$time_reqwords","date":"$date_reqwords"},
_show_words;
$number ++;
    }

      $res .=<<<_show_words
]
_show_words;

   } else {

      $res .= '';

     }

   $jsonData = preg_replace("/,(?!.*,)/", "", $res);

   return $jsonData; 

   $conn->close();
   
  }

/**
  *
  * show_request_words 
  *
  * Digunakan u/ menampilkan semua pesan yang dikirim user.
  * @param sendmes : nilai url halaman yang ditentukan.
  * @param vars    : variable yang ingin ditampilkan.
  * @param table   : table yang ingin ditampilkan.
  *
  */

 public function clearEndStr($str,$int){

   return substr_replace($str,"",$int);
 
 }

 public function colorFont($new,$old){

  $nmOne  = str_replace( array("$new"),
                         //array("<a style='background-color:#4A89DC; color:#222;'>$new</a>"),
                         array("<a style='color:#4A89DC;'>$new</a>"),
                         $old);
  return $nmOne;

 }

 public function show_request_words_idtozu($request){

   $getz = '';

   $mez = "";

   $conn = self::connectMysqli();

   $sql = "SELECT id_words, kata_id, huruf_zu, ket_zu FROM zu_words WHERE kata_id='$request' AND kata_id !=''";

   $result = mysqli_query($conn, $sql);

   if (mysqli_num_rows($result) > 0) {

      while($row = mysqli_fetch_assoc($result)) {

       $mez = $row['huruf_zu'];
	
      }

 	$getz .= "<b><i>baca:</i></b> ". strtoupper($mez) ."<br>";
	$getz .= "<b><i>arti:</i></b> ". ucfirst($request);

    } else {

       $getz = '';

    }

   $conn->close();

   return $getz;

 }

 public function show_zu_idtozu($request){

   $getz = '';

   $conn = self::connectMysqli();

   $sql = "SELECT * FROM zu_words WHERE kata_id='$request' AND huruf_zu !=''";

   $result = mysqli_query($conn, $sql);

   if (mysqli_num_rows($result) > 0) {

      while($row = mysqli_fetch_assoc($result)) {

       $getz = strtoupper($row['huruf_zu']);
	
      }
 
    } else {

       $getz = '';

    }

   $conn->close();

   return $getz;

 }

 public function show_suggest_idtozu($request = null){

   $getz = "";
   $mez = "";
   $str = strtolower($request);

   $conn = self::connectMysqli();

   $sql = "SELECT * FROM zu_words WHERE kata_id LIKE '%$str%' LIMIT 10";

   $result = mysqli_query($conn, $sql);

   if (mysqli_num_rows($result) > 0) {
	
      while($row = mysqli_fetch_assoc($result)) {

       $mez .= self::colorFont($str,$row['kata_id']).", ";

      }

	$getz .= "<b><i>Suggest:</i></b> ". self::clearEndStr($mez,-2);

    } else {

        $getz .=<<<_sendData
 		<p style="color:#7F8C8D; font-size:12px;">
			Kata <i style="background-color:powderblue; color:#222;"> $request </i> 
			belum ada dalam database. Ingin menambahkan kata diatas <a style="cursor:pointer;" onclick="requestFromUser('$request');">Klik disini</a>
		</p>
_sendData;

    }

   $conn->close();

   return $getz;

 }

 public function show_suggest_zutoid($request = null){

   $getz = "";

   $mez = "";

   $str = strtoupper($request);

   $s1 = "";

   $conn = self::connectMysqli();

   $sql = "SELECT * FROM zu_words WHERE huruf_zu !='null' AND huruf_zu LIKE '%$str%' LIMIT 10";

   $result = mysqli_query($conn, $sql);

   if (mysqli_num_rows($result) > 0) {

      while($row = mysqli_fetch_assoc($result)) {

       $mez .= self::colorFont($str,$row['huruf_zu']).", ";
	
      }

	$getz = "<b><i>suggest:</i></b> ".self::clearEndStr($mez,-2);
 
    } else {

        $getz .=<<<_sendData
 		<p style="color:#7F8C8D; font-size:12px;">
		Kata <b> $request </b> tidak ditemukan. 
		</p> 
<!-- 		<p style="color:#7F8C8D; font-size:12px;">
			Kata <i style="background-color:powderblue; color:#222;"> $request </i> 
			belum ada dalam database. Ingin menambahkan kata diatas <a style="cursor:pointer;" onclick="requestFromUser('$request');">Klik disini</a>
		</p> -->
_sendData;

    }

   $conn->close();

   return $getz;

 }

 public function show_request_words_zutoid($request){

   $getz = '';

   $mez  = '';

   $conn = self::connectMysqli();

   $sql = "SELECT * FROM zu_words WHERE huruf_zu='$request' AND kata_id !=''";

   $result = mysqli_query($conn, $sql);

   if (mysqli_num_rows($result) > 0) {

      while($row = mysqli_fetch_assoc($result)) {

       $mez .= ucfirst($row['kata_id']).", ";
	
      }
 
	$getz .= "<b><i>baca:</i></b> ". strtoupper($request)."<br>";
	$getz .= "<b><i>arti:</i></b> ". self::clearEndStr($mez,-2);

    } else {

       $getz .= '';

    }

	

   $conn->close();

   return $getz;

 }

 public function show_zu_zutoid($request){

   $getz = '';

   $conn = self::connectMysqli();

   $sql = "SELECT * FROM zu_words WHERE huruf_zu='$request' AND huruf_zu !=''";

   $result = mysqli_query($conn, $sql);

   if (mysqli_num_rows($result) > 0) {

      while($row = mysqli_fetch_assoc($result)) {

       $getz = $row['huruf_zu'];
	
      }
 
    } else {

       $getz = '';

    }

   $conn->close();

   return $getz;

 }

/**
  *
  * checkSessionUser 
  *
  * Digunakan untuk melakukan pengecekan apakah file ada/tidak dalam suatu isi tabel.
  * @param $str   : masukan isi table yang ingin di cek, contoh: $str="nama_img", cukup berikan satu saja untuk diidentifikasi.
  * @param $table : masukan nama tabel tujuan record yang ingin di cek, contoh: $table="images".
  * @param $where : masukan id key dari isi tabel tujuan record yang ingin di cek, contoh: $table="id_img=50".
  *
  */

 public function checkSessionUser ( $tb,$id,$session,$name ){

   $pdo = self::__CONSTRUCT();

   $admin = $pdo->prepare("SELECT * FROM $tb WHERE $name = :id");

   $admin->execute(array(':id' => $id));

   $row = $admin->fetch(PDO::FETCH_ASSOC);

   if (!empty($row)){

    $_SESSION[$session] = $row;

   } else {

      $_SESSION[$session] = null;

     }

   $pdo = null;

  }

/**
  *
  * Fungsi updateOneRows 
  *
  * Digunakan untuk mengedit suatu record pada kolom dengan memberikan key id .
  * @param $str   : masukan nama key id yang ingin diedit, melalui var ini dapatdiperoleh identifikasi nama record tersebut ada dalam table atau tidak, contoh: $str="nama_img", cukup berikan satu saja untuk diidentifikasi.
  * @param $table : masukan nama tabel tujuan record yang ingin diedit, contoh: $table="images".
  * @param $value : masukan colom beserta nilainya, yang ingin diedit, contoh: $value="id='001',name='aan',alamat='jl parang kusumo'".
  * @param $where : masukan id key dari isi tabel tujuan record yang ingin diedit, contoh: $table="id_img=50".
  *
  */

  public function updateOneRows($table=null,$value=null, $where=null){

    $report = '';

    $conn = self::__CONSTRUCT();

    try {
      
      // set the PDO error mode to exception

      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "UPDATE  $table SET $value WHERE $where";

      // Prepare statement

      $stmt = $conn->prepare($sql);

      // execute the query

      $stmt->execute();

      // echo a message to say the UPDATE succeeded

      $report = $stmt->rowCount() . " records successfully";

    }

    catch(PDOException $e){

      $report = $sql . "<br>" . $e->getMessage();

    }

    return $report;

    $conn = null;
  }

/**
  *
  * Fungsi delOneRows 
  *
  * Digunakan untuk menghapus sebaris data dalam sebuah table dengan memberikan suatu id key.
  * @param $str   : masukan isi table yang ingin di hapus, contoh: $str="nama_img", cukup berikan satu saja untuk diidentifikasi.
  * @param $table : masukan nama tabel tujuan record yang ingin di hapus, contoh: $table="images".
  * @param $where : masukan id key dari isi tabel tujuan record yang ingin di hapus, contoh: $table="id_img=50".
  *
  */

  public function delOneRows($table=null, $where=null){

    $conn = self::__CONSTRUCT();

    #self::checkOneRows($str,$table,$where); # Melakukan cek terlebih dahulu apakah file ada/tidak.
                                            # Bila tidak ada maka proses akan dihentikan.
    try
    {
   
      // set the PDO error mode to exception

      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // sql to delete a record

      $sql = "DELETE FROM $table WHERE $where";

      // use exec() because no results are returned

      $conn->exec($sql);

      return " record deleted successfully";

    }

    catch(PDOException $e)
    {

      echo $sql . "<br>" . $e->getMessage();

    }

    $conn = null;

 }

}
