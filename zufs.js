 //refPageZu =function(){ return window.setTimeout(function(){ window.location="http://"+window.location.hostname + window.location.pathname; },5000); }

 sendReqWord = function(){
  //var port=":8585",wn=window,url = wn.location.protocol+"//"+wn.location.hostname+ports+wn.location.pathname;
  var port=":8585",wn=window,url = wn.location.protocol+"//"+wn.location.hostname+wn.location.pathname;
  urls = function(){ return url; }
  var cer = btoa("zufrasi3.3");
  var wod = $("#words").val();
   $.ajax({url: 'resWord/?goto='+cer+'&reqWord='+wod, success: function(result){
    $(".btns").html('<button type="submit" class="btn btn-warning btn-xs marg-top10"><i class="fa fa-search"></i> reload </button>');
    $("#getis").html(result);
    //refPageZu('http://a.n/zugrafi.com',5000);
   }});
  //alert(wod);
 }

$(document).ready(function(){

 show = function(id,st,kn,pl){
 var dc=document,sta=st,konsonan='',kons=[],kon=kn,pola=pl,cn=dc.getElementById(id); this.ins=''; this.spacing=0;
/*
 * getLines
 * drawing pattern vocal A,I,U,E,O
 *
 */
  getLines = function(aa,bb,cc,dd){
   this.x1=aa;
   this.x2=bb;
   this.y1=cc;
   this.y2=dd;
   var grHr = cn.getContext("2d");
   var grVr = cn.getContext("2d");
   var aCon = [this.x1,this.x2,this.y1,this.y2];
   var aCons;
   this.alpha={
    divs:function(a,b){ return a / b; },
    mins:function(a,b){ return a - b; },
    plus:function(a,b){ return a + b; },
    aConA:function(){ return this.plus(aCon[0],1)/*30*/; },
    aConB:function(){ return this.mins(aCon[1],1)/*49*/; }, 
    aConC:function(){ return this.mins(aCon[3],1)/*8*/; }, 
    getPart:function(){ var gtSize=aCon[1]-aCon[0]/*21*/; return this.divs(gtSize,3)/*7*/; }, 
    getVars:function(){ var a=aCon[0]+this.getPart()/*36*/,b=a+this.getPart()/*43*/,c=b+this.getPart()/*50*/,d=this.mins(a,1)/*35*/,e=this.plus(a,1)/*37*/,f=this.mins(b,1)/*42*/,g=this.plus(b,1)/*44*/,z=[a,b,c,d,e,f,g]; return z; },
    isAH:function(x,y,xFirst,yLast,xF,yL){ grHr.beginPath(); grHr.moveTo(x,y); grHr.lineTo(xFirst,yLast); grHr.lineTo(xF,yL); grHr.lineWidth=2; grHr.strokeStyle="#33"; grHr.stroke(); },
    isHr:function(xFirst,xLast,y){ grHr.beginPath(); grHr.moveTo(xFirst,y); grHr.lineTo(xLast,y); grHr.lineWidth=2; grHr.strokeStyle="#33"; grHr.stroke(); },
    isVr:function(x,yFirst,yLast){ grVr.beginPath(); grVr.moveTo(x,yFirst); grVr.lineTo(x,yLast); grVr.lineWidth=2; grVr.strokeStyle="#33"; grVr.stroke(); },
    isA:function(){
     /*1*/this.isHr(aCon[0],aCon[1],aCon[2]); //  1______________
    },
    isI:function(){
     /*1*/this.isHr(aCon[0],aCon[1],aCon[2]);  // 1______________
     /*2*/this.isHr(aCon[0],aCon[1],aCon[3]);  // 2______________
    },
    isU:function(){
     /*1*/this.isHr(aCon[0],aCon[1],aCon[3]);      //     |         |              
     /*2*/this.isVr(this.aConA(),aCon[2],aCon[3]); //   2 |_________| 3                          
     /*3*/this.isVr(this.aConB(),aCon[2],aCon[3]); //          1                  
    },
    isE:function(){
     /*1*/this.isHr(aCon[0],aCon[1],aCon[2]);      //         1       
     /*2*/this.isVr(this.aConA(),aCon[2],aCon[3]); //    ___________  
     /*3*/this.isVr(this.aConB(),aCon[2],aCon[3]); //  2 |         |3 
    },                                             //    |         |
    isO:function(){
     var aCons = aCon.concat(this.getVars());
     /*1*/this.isVr(this.aConA(),aCon[3],aCon[2]);    //                                        
     /*2*/this.isHr(aCon[0],aCons[8],aCon[2]);        //       2         6                        
     /*3*/this.isVr(aCons[4],aCon[3],aCon[2]);        //     ____       ____                            
     /*4*/this.isHr(aCons[7],aCons[10],this.aConC()); //    |    |     |    |                               
     /*5*/this.isVr(aCons[5],aCon[3],aCon[2]);        //  1 |    |3   5|    |7                           
     /*6*/this.isHr(aCons[9],aCon[1],aCon[2]);        //    |    |_____|    |                              
     /*7*/this.isVr(this.aConB(),aCon[3],aCon[2]);    //            4                            
    },
    isAHR:function(){
     /*AHR = >>*/
      this.isAH(5,5,10,10,5,15);   
      this.isAH(10,5,15,10,10,15);   
      //this.isAH(0,0,5,5,0,10);   
      //this.isAH(5,0,10,5,5,10);   
 
    },
    isAHL:function(){
     /*AHL = > */
      this.isAH(5,5,10,10,5,15);   
    }
   };
  }; 

/*
 * shapedVoc
 * set formation the vocal alpha
 *
 */
 shapedVoc = function(a,b,c,d,e){
   var formation='',shaped = new getLines(a,b,c,d);
   switch(e){
    case '2':  
     formation = shaped.alpha.isA();
    break;
    case '3':  
     formation = shaped.alpha.isI();
    break;
    case '4':  
     formation = shaped.alpha.isU();
    break;
    case '5':  
     formation = shaped.alpha.isE();
    break;
    case '6':  
     formation = shaped.alpha.isO();
    break;
   }
   return formation;
 }

/*
 *
 * https://stackoverflow.com/questions/33955754/adding-letter-spacing-in-html-canvas/33967139
 * James Carlyle-Clarke
 *
 */
 this.fillTextWithSpacing = function(context, text, x, y, spacing){
    //Start at position (X, Y).
    //Measure wAll, the width of the entire string using measureText()
    wAll = context.measureText(text).width;

    do
    {
    //Remove the first character from the string
    char = text.substr(0, 1);
    text = text.substr(1);

    //Print the first character at position (X, Y) using fillText()
    context.fillText(char, x, y);

    //Measure wShorter, the width of the resulting shorter string using measureText().
    if (text == "")
        wShorter = 0;
    else
        wShorter = context.measureText(text).width;

    //Subtract the width of the shorter string from the width of the entire string, giving the kerned width of the character, wChar = wAll - wShorter
    wChar = wAll - wShorter;

    //Increment X by wChar + spacing
    x += wChar + spacing;

    //wAll = wShorter
    wAll = wShorter;

    //Repeat from step 3
    } while (text != "");
 }

/*
 * eXec
 * execution pattern alphabeth vocals n consonants
 *
 */
 eXec = function (){
  /*  default size font (29,50,30,49,5,9)  */
  var defX1,defX2,ahl,ahr;
  var defY1=5,defY2=9;
  divz=function(a,b){ return a / b; }
  String.prototype.trim =function(){ return this.replace(/^\s+|\s+$/g, '');}; 
  coma =function(sa){ 
   var da=sa.replace(/,/g, ''); 
   return da.replace(/1/g, ' ');
  }

  if (sta === '1'){
     defX1=29; defX2=50; 
     ahr = new getLines(defX1,defX2,defY1,defY2); ahr.alpha.isAHR();
   } else if( sta === '2'){
     defX1=29; defX2=50; 
     ahl = new getLines(defX1,defX2,defY1,defY2); ahl.alpha.isAHL();
   } else { defX1=31; defX2=52; }
   var r,s=[],ur,us=[],ru,su=[],rur,sus=[],uru,usu=[]; 
   var n,me=defX1,ne=defX2-defX1,get,getspace=-4,getz=[],voc='',ng='';
   var j,setA=[],setI=[],setU=[],setE=[],setO=[];
   var m=[],de=[],oneF=[],oneL=[],minF=[],minL=[],minz={1:defY1-4,2:defY1-3,3:defY1-2,4:defY1-1,5:defY1,6:defY1+1,7:defY1+2,8:defY1+3,9:defY1+4,10:defY1+5};
   voc = pola.trim();
   /*parse coordinat*/  
   var setp1U=[],setp2U=[],setp3U=[],setp4U=[];
   var setp1E=[],setp2E=[],setp3E=[],setp4E=[];
   var ps1U='',ps2U='',ps1E='',ps2E='';
   var Fmina,Lmina,Fmini,Lmini,Fmine,Lmine,Fminu,Lminu,Fmino,Lmino;
   for (n = 0; n < pola.length; n++){
    m[n]= pola.substr(n,1);
    oneF[n]= me+(n*ne); oneL[n]=oneF[n]+ne; 
    minF[n]=oneF[n]-ne; minL[n]=oneL[n]-ne;
   }
   /*parse consonant*/ 
   var konso=[];
   for (n = 0; n < kon.length; n++){
    konso[n]= kon.substr(n,1);
   }
   /*set display*/
   var k=0,ron=[],rons=[];
   for (n = 0; n < m.length; n++){
    r = n+1;  
    s[n]= pola.substr(r,1);     // s +1
    ur = n-2;  
    us[n]= pola.substr(ur,1);   // us -2
    uru = n-3;  
    usu[n]= pola.substr(uru,1); // usu -3
    ru = n-1;  
    su[n]= pola.substr(ru,1);   // su -1
    rur = n+2;  
    sus[n]= pola.substr(rur,1); // sus +2
 
    //alert(m[n]);

    if(m[n] !== '1'){
     kons.push('1');
    }
//    if(us[n] === '1'){
//     kons.pop();
//    }
 
   if(m[n] !=='' && n !== undefined){
     switch(m[n]){
     case '1':
      //alert(us[n]);
      if(m[n] === '1'){
       kons.push(konso[n]);
      } 
//      if(sus[n] === '1'){
//       kons.push(konso[n+2]);
//      }
    break;
     case '2':
      setA.push(minF[n]+'-'+minL[n]+':'+m[n]+'n:'+n);
      if(s[n] !=='2' && s[n] === '3' || s[n] === '4' || s[n] === '5' || s[n] === '6'){ /*this.spacing=getspace;*/ Fmina=2; Lmina=2; } else { Fmina=1; Lmina=1; }
      get = shapedVoc(minF[n]-Fmina,minL[n]-Lmina,defY1,defY2,m[n]);
     break;
     case '3':
      setI.push(minF[n]+'-'+minL[n]+':'+m[n]+'n:'+n);
      if(s[n] !=='3' && s[n] === '2' || s[n] === '4' || s[n] === '5' || s[n] === '6'){ Fmini=2; Lmini=2; } else { Fmini=1; Lmini=1; }
      get = shapedVoc(minF[n]-Fmini,minL[n]-Lmini,defY1,defY2,m[n]);
     break;
     case '4':
      setU.push('('+minF[n]+','+minL[n]+') m='+m[n]+' n='+n);
      if(s[n] !=='4' && s[n] === '2' || s[n] === '3' || s[n] === '5' || s[n] === '6'){ Fminu=2; Lminu=2; } else { Fminu=1; Lminu=1; }
      if(m[n] === s[n]){
       //setp4U.push(n);
       setp1U.push(n); 
       if(setp1U.length > 1 ){
        setp1U.pop(); 
       }
      }
      if(m[n] !== s[n]){
       setp2U.push(n); 
       if(setp2U.length > 0){
        setp3U = setp1U.concat(setp2U);
        ps1U = setp1U[0];
        ps2U = setp3U[setp3U.length-1];
        if(setp1U.length === 0){
         ps1U = ps2U;
        }

        //alert(us[n]); // s +1 , us -2 , usu -3 , su -1 , sus +2
        //if(us[n] === '4' && su[n] === '1'){ alert(ps1U); ps1U=setp1U[0]; ps2U=setp3U[setp3U.length-1]; }
        if(su[n] === '4' && s[n] === '1' || su[n] === '2' && s[n] === '1' || su[n] === '3' && s[n] === '1' || su[n] === '5' && s[n] === '1' || su[n] === '6' && s[n] === '1'){ ron.push('414'); ps2U = setp3U[setp3U.length-1]+1; }
        if(ron[0] === '414' && su[n] === '1' && s[n] === '' ){ ron.splice(0,ron.length); m[n]=''; }
        if(su[n] === '1' && s[n] === '1' && sus[n] === '4'){ rons.push('4141'); ps2U = setp3U[setp3U.length-1]+1; }
        if(rons[0] === '4141' && s[n] === '1' && sus[n] === '' ){ rons.splice(0,rons.length); m[n]=''; }
        if(su[n] === '1' && s[n] === ''){ ps1U=ps1U-1; ps2U=ps2U-1; }

        get = shapedVoc(minF[ps1U]-Fminu,minL[ps2U]-Lminu,defY1,defY2,m[n]);
        setp1U.splice(0,setp1U.length);
        setp2U.splice(0,setp2U.length);
       }
      }
     break;
     case '5':
      setE.push(minF[n]+'-'+minL[n]+':'+m[n]+'n:'+n);
      if(s[n] !=='5' && s[n] === '2' || s[n] === '3' || s[n] === '4' || s[n] === '6'){ Fmine=2; Lmine=2; } else { Fmine=1; Lmine=1; }
      if(m[n] === s[n]){
       //setp4E.push(n);
       setp1E.push(n); 
       if(setp1E.length > 1 ){
        setp1E.pop(); 
       }
      }
      if(m[n] !== s[n]){
       setp2E.push(n); 
       if(setp2E.length > 0){
        setp3E = setp1E.concat(setp2E);
        ps1E = setp1E[0];
        ps2E = setp3E[setp3E.length-1];
        if(setp1E.length === 0){
         ps1E = ps2E;
        }
        if(m[n] === su[n] && s[n] === '1'){ ps2E = setp3E[setp3E.length-1]+1; }
        if(m[n] === us[n] && su[n] === '1' && s[n] === '' || s[n] === '2' || s[n] === '3' || s[n] === '4' || s[n] === '6'){ m[n]=''; } 
        get = shapedVoc(minF[ps1E]-Fmine,minL[ps2E]-Lmine,defY1,defY2,m[n]);
        setp1E.splice(0,setp1E.length);
        setp2E.splice(0,setp2E.length);
       }
      }
     break;
     case '6':
      setO.push(minF[n]+'-'+minL[n]+':'+m[n]+'n:'+n);
      //this.ins = ' ';
      if(s[n] !=='6' && s[n] === '2' || s[n] === '3' || s[n] === '4' || s[n] === '5'){ Fmino=2; Lmino=2; } else { Fmino=1; Lmino=1; }
      get = shapedVoc(minF[n]-Fmino,minL[n]-Lmino,defY1,defY2,m[n]);
     break;
    }
   }

 }

konsonan = coma(kons.toString()); //coma(kons.toString());

//$("#exec").html( 'pola:'+ pola +
// '<br>m:'+ m +
// //'<br>minF:'+ minF[0] +
// //'<br>minL:'+ minL[0] +
// //'<br>word:'+ kon +
// //'<br>s:' + s[0] +
// '<br><b>setp1:</b>'+ setp1U + '\t length:' + setp1U.length + ' - ps1='+ ps1U+
// '<br><b>setp2:</b>'+ setp2U + '\t length:' + setp2U.length + ' - ps2='+ ps2U+
// '<br><b>setp3:</b>'+ setp3U + //'\t length:' + setp3.length +
// '<br><b>setp4:</b>'+ setp4U + //'\t length:' + setp4.length +
// '<br>konsonan= '+konsonan+
// '<br>s= '+s+
// '<br>us= '+us+
// '<br>su= '+su+
// //'<br><b>set-A:</b>'+ setA.join(',') +
// //'<br><b>set-I:</b>'+ setI.join(',') +
// '<br><b>set-U:</b>'+ setU.join(',') +
// //'<br><b>set-E:</b>'+ setE.join(',') +
// //'<br><b>set-O:</b>'+ setO.join(',') +
// //'<br>sand:'+ sand +
// '<br>n:'+ n );

/*
 * getText
 * showing all request image method
 *
 */
  getText = function(){
   showKon = cn.getContext("2d");
   showKon.font = "30px zugfont";
   showKon.fillStyle= "#000000"/*"#FF0000"*/;
   //this.fillTextWithSpacing(showKon,this.ins+kons,10,35,this.spacing);
   showKon.fillText(this.ins+konsonan,10,35); //(kon,10,35); 
  }; getText();

   return get; 

 };
 eXec();

 };/* end show()*/

});

 $("#zusubmit").click(function(){
  var ports = ":8585";
  var word = $("#words").val();
  //var who = btoa(location.hostname+ports+location.pathname);
  var who = btoa(location.hostname+location.pathname);
  var maen = '1';
  //var obj;
  ifilters=function(n){ b=n.replace(/' '/g,'');  return b;}
  var dataString='zuword='+word+'&zuwho='+who+'&zumaen='+maen;
  if(ifilters(word) == '')
  { $(".messg").html('<div class="text-red"><i class="fa fa-warning"></i> Please fill this fields</div>'); //alert("Please Fill All Fields"); 
    $('#getis').html(''); 
  } else {
     $.ajax({ type: "POST", url:"https://"+ window.location.hostname + window.location.pathname+"resWord/", data: dataString, cache: false, success: function(resp){
if(resp == ''){ 
$('#getis').html('<p class="text-info">Kata belum masuk dalam database.</p><button class="btn btn-success btn-xs" onclick="sendReqWord()">Usulkan kata</button>');
} else {

   Obj=JSON.parse(resp);
//$('#getis').html(resp); 
   $('#getis').html('<canvas id="ios" alt="zugrafifont" class="col-md-12">Your browser does not support the HTML5 canvas tag.</canvas><a id="download" download="image.png"><button type="button" class="btn btn-warning btn-xs marg-top10" onClick="download()"><i class="fa fa-save"></i> Export to png </button></a> <script> function download(){ var download = document.getElementById("download"); var image = document.getElementById("ios").toDataURL("image/png").replace("image/png","image/octet-stream"); download.setAttribute("href",image); }</script>'); //alert(res);
//$('#getis').addClass('zug');
    show('ios',Obj.gtStatus,Obj.zuword,Obj.getPola);

  }
       }
     });
  }
 return false;
});


