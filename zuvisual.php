<?php
/**
 *
 * @category  zuvisual - set pages
 * @package   ZUGRAFI - application custom font
 * @author    Rully Shabara <rullyshabara@gmail.com>
 * @copyright Copyright (c) 2017
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   3.3
 *
 */

class zuvisual extends zudatabase {

 var $pets = PETS ." |";
 
 var $url  = URL;

/**
  *
  * respond_words 
  *
  * handle request word zugrafi.
  * @param : default. 
  *
  */

 public function respond_words(){

  $urls  = URL;
	
 	if(isset($_GET['switch'])){

		$_SESSION['switch'] = $_GET['switch'];

	}

 	switch($_GET['pg']){

		case "ZuToId":
			if(isset($_GET['nzutoid'])){ // menampilkan arti kata zu ke ind
			
				$n = strtoupper($_REQUEST["nzutoid"]);
			
				//$request_word = zufunction::get_string_for_words($n);
				$db = new zudatabase();

				$arti = $db->show_request_words_zutoid($n);
			
				print "<p style='color:#7F8C8D; font-size:12px;'>$arti</p>"; // set statement this if you want use without check database 
			
			}

			if(isset($_GET['qzutoid'])){ // menampilkan huruf zu
			
				$q = $_REQUEST["qzutoid"];
			
				$request_word = strtoupper(zufunction::get_string_for_words($q));

				print zudatabase::show_zu_zutoid($request_word); // set statement this if you want use without check database 
			}

			if(isset($_GET['szutoid'])){ // menampilkan suggest
			
				$s = $_REQUEST["szutoid"];

				if($_GET['szutoid'] != ""){
			
				$q = zufunction::get_string_for_words($s);

				$db = new zudatabase(); // set statement this if you want use without check database 

				$res = $db->show_suggest_zutoid($q);

				print "<p style='color:#7F8C8D; font-size:12px;'>$res</p>";

				} else { print "<p style='color:#7F8C8D; font-size:12px;'>no suggestion</p>"; }  

			}
		break;

		case "IdToZu":
			if(isset($_GET['nidtozu'])){ // menampilkan arti ind ke zu
			
				$n = strtolower($_REQUEST["nidtozu"]);
			
				$request_word = zufunction::get_string_for_words($n);
			
				print "<p style='color:#7F8C8D; font-size:12px;'>".zudatabase::show_request_words_idtozu($request_word)."</p>"; // set statement this if you want use without check database 
			
			}

			if(isset($_GET['qidtozu'])){ // menampilkan huruf zu
			
				$q = strtolower($_REQUEST["qidtozu"]);
			
				$request_word = zufunction::get_string_for_words($q);
			
				print zudatabase::show_zu_idtozu($request_word); // set statement this if you want use without check database 
			}

			if(isset($_GET['sidtozu'])){ // menampilkan suggest

				$s= trim($_REQUEST["sidtozu"]);

				if($_GET['sidtozu'] != ""){
			
				$q = zufunction::get_string_for_words($s);

				$db = new zudatabase(); //::show_suggest_idtozu($q); // set statement this if you want use without check database 

				$res = $db->show_suggest_idtozu($q);

				$_GET['sidtozu'] = "";

				$_REQUEST["sidtozu"]= "";

				$hint = "<p style='color:#7F8C8D; font-size:12px;'>$res</p>";

				print $hint;

				} else { print "<p style='color:#7F8C8D; font-size:12px;'>no suggestion</p>"; }  
			}

		break;

	}

 }

/**
  *
  * respond_login 
  *
  * handle request from login page.
  * @param : default. 
  *
  */

 public function respond_login(){

  if ( isset($_POST['zuname']) && isset($_POST['zupass'])&& isset($_POST['zulog'])
       && isset($_GET['gtx']) && $_GET['gtx'] == 1 ) {

      zuheader::set_headers_plain();

      zuheader::no_sniff();

      zuheader::set_headers_origin("*");

      zudatabase::checked_login( $table = "zu_users",

                                 $where = "user_email = :emails and user_pass = :passwords",
 
                                 $value = array(':emails' => zufunction::email_filter($_POST['zuname']),':passwords' => zufunction::zuhash($_POST['zupass'])),

                                 $param = "user_pass",

                                 $auth  = $_POST['zulog'] );


       exit();

   } else {
 
      zuheader::set_headers_plain();
  
      zuheader::set_headers_close();
  
      zuheader::set_headers_origin("*");
      
      zuheader::headerCache("no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
  
      exit();

     }

 }

/**
  *
  * login_now 
  *
  * Use show display before in of page admin.
  * @param : default. 
  *
  */

 private function login_now(){


  print'<!DOCTYPE html><html><head><meta charset="utf-8"><title>loading....</title></head><body>';

  printf('<img src="%s/dist/img/ajaxloader.gif" alt=" Loading, please wait ....">',URL);

  print'</body></html>';

   if ( base64_decode($_SESSION['usr-welcome'])=="Zugrafi-v3.3" ) {

     zuheader::set_headers_html();

     zusession::headerExpire(-1);

     $_SESSION['usr-welcome'] = null;

     unset($_SESSION['usr-welcome']);

     $_SESSION['zu-welcome'] = base64_encode("welcome-to-admin");

     $_SESSION['user_mode'] = 1;

     zuheader::headerRefresh(2,URL .'/');

     exit();

   }

 }

/**
  *
  * loading_login 
  *
  * render loading login zugrafi.
  * @param : default. 
  *
  */

 public function loading_login(){

  return self::login_now();

 }

/**
  *
  * logout_now 
  *
  * show display after out of page admin.
  * @param : default. 
  *
  */

 private function logout_now(){

  zuheader::set_headers_html();
  
  zusession::headerExpire(-1);
   
  $_SESSION = array();

  $_COOKIE = array();
  
  session_destroy();

  print'<!DOCTYPE html><html><head><meta charset="utf-8"><title>loading....</title></head><body><script>function delete_cookie(name) { document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC";} delete_cookie("perPage"); delete_cookie("modelOrder"); delete_cookie("whoisOrder"); </script><font size="3" color="#777">Please wait. . . . .</font>';
  
  printf('<br><img src="%s/dist/img/loading.gif" alt=" Loading ....">',URL); 

  print'</body></html>'; 
  
  zuheader::headerRefresh( 2,URL .'/' );
  
  exit();

 }

/**
  *
  * loading_logout 
  *
  * render loading logout zugrafi.
  * @param : default. 
  *
  */

 public function loading_logout(){

  return self::logout_now();

 }

/**
  *
  * visualPublic 
  *
  * set pages for zugrafi public.
  * @param : default. 
  *
  */

 protected function visualPublic(){

  if(empty($_SESSION['switch'])){

	$kamus = <<<_kamus
   <div onclick="switchKamus('2')" title="Tukar bahasa"> Zufrasi <i class="fa fa-fw fa-exchange"></i> Indonesia </div>
_kamus;

	$ckamus = <<<_ckamus
			<div class="col-md-6 col-sm-12">
			  <div class="box box-default">
			    <div class="box-body box-profile">
			     <form>
			     <textarea maxlength="50" height="20" class="col-md-6 full-area" onkeyup="showZuToId(this.value)" placeholder="Enter Text Here"></textarea>
			     </form>
			     <div class="text-just" id="suggestZuToId"></div>
			    </div>
			    <!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			</div>
			<!-- /.col -->
			<div class="col-md-6 col-sm-12">
			  <div class="box box-default">
			    <div class="box-body box-profile">
				<span class="zufont col-md-6 full-area" id="txtZuToId"></span>
			     <div class="text-just" id="getisZuToId">
			     </div>
			    </div>
			    <!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			</div>
_ckamus;

  }

  if($_SESSION['switch'] == 1){

	$kamus = <<<_kamus
   <div onclick="switchKamus('2')" title="Tukar bahasa"> Zufrasi <i class="fa fa-fw fa-exchange"></i> Indonesia </div>
_kamus;

	$ckamus = <<<_ckamus
			<div class="col-md-6 col-sm-12">
			  <div class="box box-default">
			    <div class="box-body box-profile">
			     <form>
			      <textarea maxlength="50" height="20" class="col-md-6 full-area" onkeyup="showZuToId(this.value)" placeholder="Enter Text Here"></textarea>
			     </form>
			     <div class="text-just" id="suggestZuToId"></div>
			    </div>
			    <!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			</div>
			<!-- /.col -->
			<div class="col-md-6 col-sm-12">
			  <div class="box box-default">
			    <div class="box-body box-profile">
				<span class="zufont col-md-6 full-area" id="txtZuToId"></span>
			     <div class="text-just" id="getisZuToId">
			     </div>
			    </div>
			    <!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			</div>
_ckamus;

  }

  if($_SESSION['switch'] == 2){

	$kamus = <<<_kamus
   <div onclick="switchKamus('1')" title="Tukar Bahasa"> Indonesia <i class="fa fa-fw fa-exchange"></i> Zufrasi </div>
_kamus;
	$ckamus = <<<_ckamus
			<div class="col-md-6 col-sm-12">
			  <div class="box box-default">
			    <div class="box-body box-profile">
			     <form>
			     <textarea maxlength="50" height="20" class="col-md-6 full-area" onkeyup="showIdToZu(this.value)" placeholder="Enter Text Here"></textarea>
			     </form>
			     <div class="text-just" id="suggestIdToZu"></div>
			     <div id="confirms"></div>
			    </div>
			    <!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			</div>
			<!-- /.col -->
			<div class="col-md-6 col-sm-12">
			  <div class="box box-default">
			    <div class="box-body box-profile">
				<span class="zufont col-md-6 full-area" id="txtIdToZu"></span>
			     <div class="text-just" id="getisIdToZu">
			     </div>
			    </div>
			    <!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			</div>
_ckamus;

  }

  $owners = OWNERS;

  $titles = PETS;

  $titles_web = strtolower(PETS);

  $url = URL;

  $visualPublic =<<<__visualPublic
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="canonical" href="$url" />
    <link rel="icon" href="img/logos.ico" type="image/x-icon" />
    <meta name="google-site-verification" content="aAVQfqsyTeZdsi8-Tn8_WAYhyoNBtqSC6pcoY99M85c" />
    <meta name="description" content="Khawagaka is a series of six basic teachings from Samasthamarta civilization, consists of 17 verses, covering various concepts of a belief system; from creation, faith, commandments, history, guidance, to prophecy. Original manuscripts of Khawagaka are discovered in forms of decaying ancestral papers made of lontar leaves and natural inks.">
    <meta name="author" content="$owners">
    <title>$titles</title>
    <meta property="og:site_name" content="$titles" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="$titles" />
    <meta property="og:description" content="Khawagaka is a series of six basic teachings from Samasthamarta civilization, consists of 17 verses, covering various concepts of a belief system; from creation, faith, commandments, history, guidance, to prophecy. Original manuscripts of Khawagaka are discovered in forms of decaying ancestral papers made of lontar leaves and natural inks.">
    <meta property="og:url" content="$url" />
    <meta property="og:image" content="$url/img/logokhawagakaOne.png" />
    <meta property="article:published_time" content="2018-12-31T15:43:12.000Z" />
    <meta property="article:modified_time" content="2019-01-01T03:16:33.000Z" />
    <meta property="article:tag" content="Essai" />
    <meta property="article:publisher" content="https://www.facebook.com/zooindonesia/" />
    <meta name="twitter:card" content="summary_small_image" />
    <meta name="twitter:title" content="$titles" />
    <meta name="twitter:description" content="Khawagaka is a series of six basic teachings from Samasthamarta civilization, consists of 17 verses, covering various concepts of a belief system; from creation, faith, commandments, history, guidance, to prophecy. Original manuscripts of Khawagaka are discovered in forms of decaying ancestral papers made of lontar leaves and natural inks.">
    <meta name="twitter:url" content="$url" />
    <meta name="twitter:image" content="$url/img/logokhawagakaOne.png" />
    <meta name="twitter:label1" content="Written by" />
    <meta name="twitter:data1" content="$owners" />
    <meta name="twitter:label2" content="Filed under" />
    <meta name="twitter:data2" content="Essai" />
    <meta name="twitter:site" content="@rullyshabara" />
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="292" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link href="css/agency.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="css/mystyle.css" rel="stylesheet">
 <script>
 function showZuToId(str) {
	var page="ZuToId";
    if (str.length == 0) {
        document.getElementById("txtZuToId").innerHTML = "";
        document.getElementById("getisZuToId").innerHTML = "";
        return;
    } else {
	function sendRequest() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtZuToId").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "resWord/?pg="+page+"&qzutoid=" + str, true);
        xmlhttp.send();
	} sendRequest();

	function sendNotifyZuToId() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("getisZuToId").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "resWord/?pg="+page+"&nzutoid=" + str, true);
        xmlhttp.send();
	} sendNotifyZuToId();

	function getSuggestZuToId() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("suggestZuToId").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "resWord/?pg="+page+"&szutoid=" + str, true);
        xmlhttp.send();
	} getSuggestZuToId();
    }
 }

 function showIdToZu(str) {
	var page="IdToZu";
    if (str.length == 0) {
        document.getElementById("txtIdToZu").innerHTML = "";
        document.getElementById("getisIdToZu").innerHTML = "";
        return;
    } else {
	function sendRequest() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtIdToZu").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "resWord/?pg="+page+"&qidtozu=" + str, true);
        xmlhttp.send();
	} sendRequest();

	function sendNotifyIdToZu() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("getisIdToZu").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "resWord/?pg="+page+"&nidtozu=" + str, true);
        xmlhttp.send();
	} sendNotifyIdToZu();

	function getSuggestIdToZu() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("suggestIdToZu").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "resWord/?pg="+page+"&sidtozu=" + str, true);
        xmlhttp.send();
	} getSuggestIdToZu();
    }
 }
 </script>
<style>
@font-face {
   font-family: zufont;
   src: url(fonts/zugrafi.ttf);
}

@font-face {
   font-family: zufonts;
   src: url(fonts/zugrafi3.otf);
}

span {
  font-family: zufonts;
  text-align: justify;
  font-size:3em;
}

.zuf{
  font-family: zufonts;
  font-size:2em;
}

/* set header cover */
.wsize1 {
  max-width: 100%;
  width: 880px;
}

.bor1 {
  border-radius: 5px;
}

.bg1 {background-color: rgba(255,255,255,0.8);}

</style>

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll fontplay" href="#khawagaka">Introduction</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#kamus">Kamus</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#zugrafi">Zugrafi</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#zufrasi">Zufrasi</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#history">History</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#music">Music</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#shop">Shop</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
	<section id="intro-text">
          <div class="container"> 
	   <div class="col-md-3 col-sm-12">
	   </div>
	   <div class="col-md-6 col-sm-12">
            <a href="#khawagaka" class="page-scroll"><img src="img/logokhawagaka.png" class="img-responsive img-center" alt="Khawagaka"></a>
	   </div>
	   <div class="col-md-3 col-sm-12">
	   </div>
          </div>
	</section>
    </header>

    <!-- khawagaka Section -->
    <section id="khawagaka">
        <div class="container">
           <div class="row">
	        <div class="col-md-12 col-sm-12">
                 <h2 class="section-heading text-center fontplay">$titles</h2>
                 <h3 class="section-subheading text-muted"></h3>
		</div>
	        <div class="col-md-6 col-sm-12">
                 <h5 class="text-black fontplay">Introduction</h5>
			<p class="text-muted text-just">Khawagaka is a series of six basic teachings from Samasthamarta civilization, consists of 17 verses,
 			covering various concepts of a belief system; from creation, faith, commandments, history, guidance, to prophecy.</p>
			<p class="text-muted text-just">Original manuscripts of Khawagaka are discovered in forms of decaying ancestral papers made of lontar
			 leaves and natural inks.</p>
 			<p class="text-muted text-just">The writings on the manuscripts use its own alphabetical system called Zugrafi, while the oral language
			 system is called Zufrasi.</p>
			<p class="text-muted text-just">The discovery of these manuscripts marks the closing the prehistoric civilization that have been built 
			by the band Zoo through their past cumulative albums of <a href="http://yesnowave.com/yesno032/" target="blank" title="Trilogi Peradaban">Trilogi Peradaban (2009)</a>, <a href="http://yesnowave.com/yesno067/" target="blank" title="Prasasti">Prasasti (2012)</a>, and <a href="http://yesnowave.com/yesno081/" target="blank" title="Samasthamarta">Samasthamarta (2015)</a>, as well as signifying new beginning of the band Zoo in developing their future albums.</p>

                  <iframe class="img-responsive col-sm-12" alt="video"  src="https://www.youtube.com/embed/3YFSDhsDdc8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> 
                </div>
	        <div class="col-md-6 col-sm-12">

                 <h5 class="text-black fontplay">Pendahuluan</h5>
		  	<p class="text-muted text-just">Khawagaka adalah Enam Ajaran dasar dalam peradaban Samasthamarta, terbagi menjadi 17 ayat, yang mencakup 
			berbagai konsep yang melandasi sistem kepercayaan; mulai dari penciptaan, keyakinan, perintah-larangan, sejarah, panduan, hingga ramalan.</p> 
		  	<p class="text-muted text-just">Manuskrip asli Khawagaka berbentuk puluhan lembar kertas primitif yang terbuat dari daun lontar 
			dan tinta alami.</p>
		  	<p class="text-muted text-just">Aksara yang digunakan pada manuskrip tersebut dinamakan Zugrafi, dengan bahasa tutur yang dinamakan Zufrasi.</p>
		  	<p class="text-muted text-just">Penemuan manuskrip Khawagaka ini menandai awal baru bagi kelompok musik Zoo dalam penciptaan album-album
			selanjutnya. sekaligus menutup babak peradaban prasejarah yang telah dibangun sebelumnya melalui album <a href="http://yesnowave.com/yesno032/" target="blank" title="Trilogi Peradaban">Trilogi Peradaban (2009)</a>, <a href="http://yesnowave.com/yesno067/" target="blank" title="Prasasti">Prasasti (2012)</a>, dan <a href="http://yesnowave.com/yesno081/" target="blank" title="Samasthamarta">Samasthamarta (2015)</a>.</p>   

                  <iframe class="img-responsive col-sm-12" alt="video" src="https://www.youtube.com/embed/hHVihIVxgHU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> 
                </div>
           </div>
        </div>
    </section>


    <!-- kamus Section -->
    <section id="kamus">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading fontplay">KAMUS</h2>
                    <h3 class="section-subheading text-muted point">$kamus</h3>
		     <div id="reload"></div>
$ckamus
<script>
 function switchKamus(str){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("reload").innerHTML = this.responseText;
		window.location.href = "$url/#kamus";
		window.location.reload(true);
            }
        };
        xmlhttp.open("GET", "resWord/?switch=" + str, true);
        xmlhttp.send();
 }

function requestFromUser(kt){

 sendReqWord = function(){
  var wn=window,url = wn.location.protocol+"//"+wn.location.hostname+wn.location.pathname;
  var cer = btoa("zufrasi3.3");
  var wod = kt;
   $.ajax({url: 'resWord/?goto='+cer+'&reqWord='+wod, success: function(result){
    $("#confirms").html(result);
   }});
 }

 if(confirm("Tambahkan kata " + kt + ", sekarang?")==true){
  this.sendReqWord();
  } else {  };
}
</script>
             </div>
           </div>
        </div>
    </section>

    <!-- Zugrafi Section -->
    <section id="zugrafi" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading col-hitam fontplay"> ZUGRAFI </h2>
                    <h3 class="section-subheading text-muted"></h3>
		      <div class="col-md-3 col-sm-12">
		      </div>
		      <div class="col-md-6 col-sm-12 bor1 bg1">
		       <img id="mandalas" onclick="showMe('mandalas');" src="img/mandala.png" class="img-responsive img-centered point" alt="MANDALA">
		      </div>
		      <div class="col-md-3 col-sm-12">
		      </div>
		      <div class="col-md-12 col-sm-12 pad-top70">
		       <a href="pdf/Zugrafi3.zip" class="btn btn-xl" download> Download Font </a>
		       <p class="text-muted"><i>Type: zip - File size: 829kb.</i></p>
		      </div>
		<!-- The Modal -->
		<div id="myModal" class="modal">
		
		  <!-- The Close Button -->
		  <span class="close">&times;</span>
		
		 <!-- Modal Content (The Image) -->
		  <img class="modal-content" id="img01">
		
		  <!-- Modal Caption (Image Text) -->
		  <div id="caption"></div>
		</div>

                </div>
	    </div>
        </div>
    </section>

    <!-- Zufrasi Section -->
    <section id="zufrasi">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 text-center">
              <h2 class="section-heading fontplay"> ZUFRASI </h2>
              <h3 class="section-subheading text-muted"></h3>
	    </div>
	  </div>
          <div class="row">
            <div class="col-lg-12 text-center">
	     <h4 class="playfair text-center"> Gramatika Dasar Bahasa Zufrasi </h4>
	     <hr>
	    </div>
	    <div class="col-md-6 col-sm-12">
		<p>Verba aktif; tambahkan prefiks a- (konsonan) / al- (vokal)<br />Contoh : (men)cipta = Arijma</p>
		<p>Verba pasif; tambahkan prefiks ka- (konsonan) / kal- (vokal)<br />Contoh: (di)bagi = Kanaci</p>
		<p>Nomina bentukan merujuk obyek; tambahkan sufiks -a (konsonan) / -la (vokal)<br />Contoh: Ramalan= Kawasa</p>
		<p>Nomina bentukan merujuk proses; tambahkan sufiks -ana (konsonan) / -na (vokal)<br />Contoh : (pen)cipta(an) = Rijmana</p>
		<p>Bentuk jamak (tidak berlaku ketika kata mengikuti angka); tambahkan sufiks -ha atau &ndash;aha<br />Contoh: Malam-malam = Wasawaha,<br/>&nbsp;&nbsp;&nbsp; 5 Malam = Wawasa</p>
		<p>Kata bergender makhluk hidup(kecuali tumbuhan),<br />tambahkan artikel ahl-.</p>
		<p class="text-muted text-center"><i>(1)</i></p>
	    </div>
	    <div class="col-md-6 col-sm-12">
		<p>Kata bergender alam (seperti matahari, bulan, bintang, tumbuhan), tambahkan artikel Ahr-.</p>
		<p>Kata seruan; tambahkan sufiks &ndash;sa</p>
		<p>Kata ganti milik orang ketiga; tambahkan sufiks &ndash;ta</p>
		<p>Tambahkan sufiks &ndash;sya jika bertanya kepada orang kedua tunggal<br />Contoh: Khawa-sya? = Siapa namamu?</p>
		<p>Tambahkan sufiks &ndash;syaha jika bertanya kepada orang kedua jamak<br />Contoh: Khawa-syaha? &ndash; Siapa kalian?</p>
		<p>Tambahkan sufiks &ndash;za jika bertanya kepada orang ketiga tunggal<br />Contoh: Khawa-za? &ndash; Siapa dia/Siapa namanya?</p>
		<p>Tambahkan sufiks &ndash;zaha jika bertanya kepada orang ketiga jamak<br />Contoh: Khawa-zaha? &ndash; Siapa mereka?</p>
		<p class="text-muted text-center"><i>(2)</i></p>
	    </div>

	  </div>
          <div class="row pad-top70">
            <div class="col-lg-12 text-center">
	     <h4 class="playfair text-center"> ANGKA </h4>
	     <hr>
	    </div>
	    <div class="col-md-6 col-sm-12">
		<table class="table table-bordered table-striped table-hover">
		<tbody>
		 <tr>
			<td>0</td>
			<td>KHIS</td>
			<td class="zuf">KHIS</td>
		 </tr>
		 <tr>
			<td>1</td>
			<td>MU</td>
			<td class="zuf" >MU</td>
		 </tr>
		 <tr>
			<td>2</td>
			<td>BA</td>
			<td class="zuf">BA</td>
		 </tr>
		 <tr>
			<td>3</td>
			<td>CA</td>
			<td class="zuf">CA</td>
	 	 </tr>
		 <tr>
			<td>4</td>
			<td>JA</td>
			<td class="zuf">JA</td>
		 </tr>
		 <tr>
			<td>5</td>
			<td>WA</td>
			<td class="zuf">WA</td>
		 </tr>
		 <tr>
			<td>6</td>
			<td>KHA (W)</td>
			<td class="zuf">KHA</td>
		 </tr>
		 <tr>
			<td>7</td>
			<td>GU</td>
			<td class="zuf">GU</td>
		 </tr>
		 <tr>
			<td>8</td>
			<td>JAKH</td>
			<td class="zuf">JAKH</td>
		 </tr>
		 <tr>
			<td>9</td>
			<td>SAKH</td>
			<td class="zuf">SAKH</td>
		 </tr>
		 <tr>
			<td>10</td>
			<td>SU</td>
			<td class="zuf">SU</td>
		 </tr>
		</tbody>
		</table><br/>
		<table class="table table-bordered table-striped table-hover">
		<tbody>
		 <tr>
			<td>11</td>
			<td>MUSU</td>
			<td class="zuf">MUSU</td>
		 </tr>
		 <tr>
			<td>12</td>
			<td>BAMU</td>
			<td class="zuf">BAMU</td>
		 </tr>
		</tbody>
		</table>

		<p class="text-center"> dan seterusnya</p>	
		<hr>
		<p class="text-muted text-center"><i>(1)</i></p>
	    </div>
	    <div class="col-md-6 col-sm-12">
		<table class="table table-bordered table-striped table-hover">
		<tbody>
		 <tr>
			<td>20</td>
			<td>BASU</td>
			<td class="zuf">BASU</td>
		 </tr>
		 <tr>
			<td>21</td>
			<td>BASUMU</td>
			<td class="zuf">BASUMU</td>
		 </tr>
		</tbody>
		</table>
		<p class="text-center"> dan seterusnya</p><br/><br/>	
		<table class="table table-bordered table-striped table-hover">
		<tbody>
		 <tr>
			<td>30</td>
			<td>CASU</td>
			<td class="zuf">CASU</td>
		 </tr>
		 <tr>
			<td>31</td>
			<td>CASUMU</td>
			<td class="zuf">CASUMU</td>
		 </tr>
		</tbody>
		</table>
		<p class="text-center"> dan seterusnya</p><br/><br/>
		<table class="table table-bordered table-striped table-hover">
		<tbody>
		 <tr>
			<td>100</td>
			<td>MUHA</td>
			<td class="zuf">MUHA</td>
		 </tr>
		 <tr>
			<td>101</td>
			<td>MUHAMU</td>
			<td class="zuf">MUHAMU</td>
		 </tr>
		</tbody>
		</table>
		<p class="text-center"> dan seterusnya</p><br/><br/>
		<table class="table table-bordered table-striped table-hover">
		<tbody>
		 <tr>
			<td>1000</td>
			<td>NU</td>
			<td class="zuf">NU</td>
		 </tr>
		 <tr>
			<td>1001</td>
			<td>NUMU</td>
			<td class="zuf">NUMU</td>
		 </tr>
		</tbody>
		</table>
		<p class="text-center"> dan seterusnya</p>	
		<hr>
		<p class="text-muted text-center"><i>(2)</i></p>
	    </div>

          </div>
        </div>
    </section>

    <!-- History Section -->
    <section id="history">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading fontplay col-hitam"> HISTORY </h2>
                    <h3 class="section-subheading text-muted">-- History Of Samasthamarta / Sebelum Samasthamarta --</h3>
                </div>
            </div>
            <div class="row text-center">
		<div class="col-md-3 col-sm-12">
		  <img id="s1" onclick="showMe('s1');" src="img/samasthamarta/s1.png" class="img-samasthamarta img-centered point" alt="1">
		</div>
		<div class="col-md-3 col-sm-12">
		  <img id="s2" onclick="showMe('s2');" src="img/samasthamarta/s2.png" class="img-samasthamarta img-centered point" alt="2">
		</div>
		<div class="col-md-3 col-sm-12">
		  <img id="s3" onclick="showMe('s3');" src="img/samasthamarta/s3.png" class="img-samasthamarta img-centered point" alt="3">
		</div>
		<div class="col-md-3 col-sm-12">
		  <img id="s4" onclick="showMe('s4');" src="img/samasthamarta/s4.png" class="img-samasthamarta img-centered point" alt="4">
		</div>
		<div class="col-md-3 col-sm-12">
		  <img id="s5" onclick="showMe('s5');" src="img/samasthamarta/s5.png" class="img-samasthamarta img-centered point" alt="5">
		</div>
		<div class="col-md-3 col-sm-12">
		  <img id="s6" onclick="showMe('s6');" src="img/samasthamarta/s6.png" class="img-samasthamarta img-centered point" alt="6">
		</div>
		<div class="col-md-3 col-sm-12">
		  <img id="s7" onclick="showMe('s7');" src="img/samasthamarta/s7.png" class="img-samasthamarta img-centered point" alt="7">
		</div>
		<div class="col-md-3 col-sm-12">
		  <img id="s8" onclick="showMe('s8');" src="img/samasthamarta/s8.png" class="img-samasthamarta img-centered point" alt="8">
		</div>
		<div class="col-md-3 col-sm-12">
		  <img id="s9" onclick="showMe('s9');" src="img/samasthamarta/s9.png" class="img-samasthamarta img-centered point" alt="9">
		</div>
		<div class="col-md-3 col-sm-12">
		  <img id="s10" onclick="showMe('s10');" src="img/samasthamarta/s10.png" class="img-samasthamarta img-centered point" alt="10">
		</div>
		<div class="col-md-3 col-sm-12">
		  <img id="s11" onclick="showMe('s11');" src="img/samasthamarta/s11.png" class="img-samasthamarta img-centered point" alt="11">
		</div>
		<div class="col-md-3 col-sm-12">
		  <img id="s12" onclick="showMe('s12');" src="img/samasthamarta/s12.png" class="img-samasthamarta img-centered point" alt="12">
		</div>
		<div class="col-md-3 col-sm-12">
		  <img id="s13" onclick="showMe('s13');" src="img/samasthamarta/s13.png" class="img-samasthamarta img-centered point" alt="13">
		</div>
		<div class="col-md-12 col-sm-12 pad-top70 text-center">
		  <a href="pdf/SAMASTHAMARTA.pdf" target="blank" title="SEBELUM SAMASTHAMARTA" class="btn btn-xl" download>Sebelum Samasthamartha</a>
		  <p class="text-muted"><i>Type: pdf - File size: 149mb.</i></p>
		</div>
            </div>
        </div>
    </section>

   <!-- Shop Section -->
    <section id="shop">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading fontplay"> SHOP </h2>
                    <h3 class="section-subheading text-muted">-- Khawagaka Dan Terjemahannya --</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                 <div class="col-md-6 col-sm-12">
                    <img id="books" onclick="showMe('books');" src="img/book_khawagaka.jpg" title="Book Khawagaka" class="img-responsive img-centered point" alt="Book Khawagaka">
		 </div>
 
                 <div class="col-md-6 col-sm-6">
			<p>Terjemahan pertama manuskrip Khawagaka dalam bahasa Indonesia dan bahasa Inggris,
			disertai tulisan asli dalam aksara Zugrafi terkini, cara baca, dan gramatika dasar bahasa Zufrasi.</p>

			<p>Harga: IDR 100K</p>
			<p>Sampul hard cover semi kulit, emboss logo tinta emas, dan tali pengikat kitab beserta pendulum logam yang bisa dijadikan gelang.</p>   

			<p>DM ke akun resmi Zoo di Instagram <a href="https://instagram.com/samasthamarta" target="_blank">@Samasthamarta</a> dengan menyertai nama lengkap dan alamat kirim.</p>

			<p><i>Foto kitab: Adit Tama I </i></p>
			<p class="pad-top70"><a href="http://yesnowave.com/" target="blank" class="btn btn-xl" title="Unduh album Khawagaka"> Unduh album Khawagaka </a></p>
 		 </div>
                </div>
            </div>
        </div>
    </section>
   
    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading fontplay">Contact</h2>
                    <h3 class="section-subheading"></h3>
                    <h3 class="section-subheading" style="color:#434A54;">
			Zoo:<br>
			Rully Shabara<br>
			Bhakti Prasetyo<br>
			Ramberto Agozalie<br>
			Dimas Budi Satya<br><br><br>

			Contact:<br>
			DewanRijmana@khawagaka.com<br>
		    </h3>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="copyright">Samasthamarta, Zugrafi, Zufrasi, Khawagaka created by Rully Shabara</p>
                </div>
            </div>
        </div>
    </footer>

    
       <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/agency.js"></script>
    <script>
      function showMe(str){
	var img = document.getElementById(str);
	var modal = document.getElementById('myModal');
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");

	img.onclick = function(){
	  modal.style.display = "block";
	  modalImg.src = this.src;
	  captionText.innerHTML = this.alt;
	}

	var span = document.getElementsByClassName("close")[0];
	span.onclick = function() {
	  modal.style.display = "none";
	} 
      } 


    </script>

</body>

</html>

__visualPublic;

  return $visualPublic;

 }

/**
  *
  * showPublic 
  *
  * render pages for page zugrafi public.
  * @param : default. 
  *
  */

 public function showPublic(){

  print self::visualPublic(); 

 }

/**
  *
  * visualLogin 
  *
  * set pages for login zugrafi.
  * @param : default. 
  *
  */

 protected function visualLogin(){

  $pets = PETS;

  $url  = URL;

  $param = base64_encode("Zugrafi-v3.3");

  $visualLogin =<<<__visualLogin
<!DOCTYPE html>
<html lang="en-id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>$pets | Login</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="$url/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="$url/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="$url/plugins/iCheck/square/blue.css">
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
   <div class="login-logo">
    <a href="$url"><b>$pets</b></a>
  </div>
  <div class="login-box-body">
   <p class="login-box-msg">version 3.3</p>
    <form>
      <div class="form-group has-feedback">
        <input type="hidden" id="zulog" value="$param">
        <input type="email" id="zuname" class="form-control" placeholder="Email" required="required">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" id="zupass" class="form-control" placeholder="Password" required="required">
        <input type="hidden" id="zucount" value="1">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <div class="col-xs-4">
          <button type="submit" id="zusubmit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
      </div>
    </form>
    <div class="msg"></div>
    <a href="#">Forgot my password</a><br>
  </div>
</div>
<script src="$url/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="$url/bootstrap/js/bootstrap.min.js"></script>
<script src="$url/plugins/iCheck/icheck.min.js"></script>
<script src="$url/plugins/zuGrafi/zug.min.js"></script>
</body>
</html>
__visualLogin;

  return $visualLogin;

 }

/**
  *
  * showLogin 
  *
  * render pages for login zugrafi.
  * @param : default. 
  *
  */

 public function showLogin(){

  print self::visualLogin(); 

 }

/**
  *
  * visualAdmin 
  *
  * set pages for admin zugrafi.
  * @param : default. 
  *
  */

 private function visualAdmin(){
 
  $val=''; 
   
  if( !isset($_GET) ) { $_GET = null; }

   foreach ($_GET as $var => $val) 

  if( !isset($var) ) { $var = null; }

  if ($var === "logout"){

   self::loading_logout();

   exit();

   } else { $val = ''; }

  $user = zufunction::open_kurawal($_SESSION['zu-usr']['user_name']);

  $email = zufunction::open_kurawal($_SESSION['zu-usr']['user_email']);

  $last_login_date = zufunction::open_simple_date($_SESSION['zu-usr']['user_last_login']);

  $last_login_time = zufunction::open_time($_SESSION['zu-usr']['user_last_login']);

  $pets = PETS;

  $urls = URL;

  $visualAdmin =<<<_visualAdmin
<!DOCTYPE html>
<html>
 <head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="ROBOTS" content="NOINDEX,NOFOLLOW,NOARCHIVE">
 <title>$this->pets ADMIN</title>
 <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
 <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
 <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
 <link rel="stylesheet" href="plugins/pace/pace.min.css">
 <link rel="stylesheet" href="dist/css/zugrafi.css">
 <!--[if lt IE 9]>
 <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
 <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
 <![endif]-->
 </head>
 <body class="hold-transition skin-blue sidebar-mini">
 <!-- Site wrapper -->
 <div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="$urls" class="logo zuHome">
      <span class="logo-mini"><b>Z</b>U</span>
      <span class="logo-lg"><b>$pets</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-commenting-o"></i>
              <span id="notifyCount" class="label label-warning"></span>
            </a>
            <ul class="dropdown-menu">
              <li id="notifyMsg" class="header"></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li id="notifyMe"><!-- start message -->
                  </li>
                  <!-- end message -->
                </ul>
              </li>
              <li id="notifyFooter" class="footer"><center class="text-muted"> no request now</center></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user" alt="user"></i>
              <span class="hidden-xs">$email</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="$urls/dist/img/mandalazu.jpg" class="img-circle" alt="User Image">
                <p>
                  $user - Author
                  <small>Last update  </small>
                  <small> Date: $last_login_date - Time: $last_login_time </small>
                </p>
              </li>
             <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#profile" class="btn btn-default btn-flat zuProfile">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="?logout" id="logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/mandalazu.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p id="nameis"></p>
          <a><i class="fa fa-circle text-success"></i> Online</a>
        </div>

      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">
         NAVIGATION
        </li>
        <li id="dashboardAct">
          <a href="#Dashboard" class="zuDashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li id="profileAct">
          <a href="#profile" class="zuProfile">
            <i class="fa fa-user"></i>
            <span>Profile</span>
         </a>
        </li>
        <li id="pagesAct" class="treeview">
          <a href="#pages">
            <i class="fa fa-file-o"></i>
            <span>Pages</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#allWords" id="menu-allWords" class="zuAllWords"><i id="tree-allWords" class="fa fa-circle-o"></i> All Words</a></li>
            <li><a href="#addNewWord" id="menu-addNewWord" class="zuAddNewWord"><i id="tree-addNewWord" class="fa fa-circle-o"></i> Add New Word</a></li>
          </ul>
        </li>
        <li id="informationAct" class="treeview">
          <a href="#">
            <i class="fa fa-cloud"></i>
            <span>Info</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#requestWord" id="menu-requestWord" class="zuRequestWord"><i id="tree-requestWord" class="fa fa-circle-o"></i> Request Word</a></li>
            <li><a href="#engineeCall" id="menu-engineeServer" class="zuEngineeServer"><i id="tree-engineeServer" class="fa fa-circle-o"></i> Information</a></li>
            <!--<li><a href="#diskUsage" id="menu-diskUsage" class="zuDiskUsage"><i id="tree-diskUsage" class="fa fa-circle-o"></i> Disk Usage</a></li>-->
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 id="namePages">
        <small> $pets</small>
      </h1>
      <ol class="breadcrumb">
        <li id="subOne"></li>   
        <li id="subTwo"></li>   
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>
           <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
               <i class="fa fa-minus"></i></button>
           </div>
        </div>
        <div class="box-body">

         <div class="zu-content"></div>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <div class="content-anw-one"></div> 
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 3.3
    </div>
    <strong>Copyright &copy; 2017-2018 <a href="#">$pets</a>.</strong> All rights reserved.
  </footer>

 <div class="control-sidebar-bg"></div>
<!-- ./wrapper -->
</div>
 <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
 <script src="bootstrap/js/bootstrap.min.js"></script>
 <!--<script src="plugins/pace/pace.min.js"></script>-->
<script>
//$(document).ajaxStart(function() { Pace.restart(); });
</script>
 <!--<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>-->
 <!--<script src="plugins/fastclick/fastclick.js"></script>-->
 <script src="dist/js/app.min.js"></script>
 <!--<script src="dist/js/demo.js"></script>-->
 <script src="plugins/zuGrafi/zugers.js"></script>
 </body>
</html>
_visualAdmin;

return $visualAdmin;

 }

/**
  *
  * visualAdmin 
  *
  * render pages for admin zugrafi.
  * @param : default. 
  *
  */

 public function showAdmin(){

  print self::visualAdmin(); 

 }

}

