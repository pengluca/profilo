<?
require 'php/file_conf';
require 'php/auth.php';
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<HTML>

<HEAD>
<STYLE TYPE="text/css">
  a { color: black }
  a:hover { color: red; }
  a:link, A:visited { text-decoration: none }

</STYLE>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <title>Menu</title>

<script language="JavaScript">
   var Profile = new Object();
   var query = "";

   if (window.location.search != "") {
       query = unescape(window.location.search.substring(1, window.location.search.length));
       arrQuery = query.split("&");
       
      for (var i in arrQuery) {
            arrParameter = arrQuery[i].split("=");
            Profile[arrParameter[0]] = arrParameter[1];
       }

/* FOR BUG PURPOSE, ONLY
       document.write(query +"<br>");
       for (var i in Profile) {
            document.write('Profile[\''+i+'\'] is ' + Profile[i]+'<br>')
       }
*/
   }
   else {
       document.write("ASSENZA DI PARAMETRI!<BR>IMPOSSIBILE COSTRUIRE IL MENU'");
   }


function sendMail(ms)
{
   answer=confirm("Confermi l'invio di una email di prova verso " +ms+ "?");

   if (answer != 0) { 
       window.parent.main.location="php/inviomail.php?msisdn=" +ms;
   }  
}

//function statocasella(id,en,mss)
function statocasella(k)
{
   resultwindow=window.open("php/statocasella.php?msisdn=" +Profile.msisdn+ "&en=" +arrEn[k]+ "&mss=" +arrMss[k],"ResultW","width=300,height=350,status=no,resizable=1");
   resultwindow.document.close();
}
</script>
</HEAD>

<BODY>
<table width="100%" height="95%" border=1 bgcolor="#EFEFEF" cellspacing=0>
  <tr valign="top"><td>

  <table width="100%" border=0 cellpadding=3 cellspacing=0>
    <tr>
      <td><i><font face="Georgia" size=2><a href="index.htm" target="_top" onClick="refresh('HOME PAGE');">Home</a></font></i></td>
    </tr>
    <tr>
      <td><i><font face="Georgia" size=2><a href="ric_profilo.php" target='main' onClick="window.parent.menu.location='menu.php';">Lettura Profilo</a></font></i></td>
    </tr>

<script language="JavaScript">
  arrEn = Profile.en.split("_"); 
  arrMss = Profile.mss.split("_"); 
  arrNot = Profile.notif.split("_"); 
  for (var i in arrEn) {
    if (arrEn[i] == 'um' || arrEn[i] == 'unitim') {
        document.write("<tr><td><i><B><font face='Georgia' size=2>-&nbsp;Menu' Profilo " +arrEn[i].toUpperCase()+ " </font></B></i></td></tr>");

<? if (strstr($_SESSION['perms'],"e")||strstr($_SESSION['perms'],"@")) { ?>

        document.write("<tr><td><i><font face='Georgia' size=2 >&nbsp;&nbsp;&nbsp;<a href='php/goto.php?msisdn=" +Profile.msisdn+ "&passwd=" +Profile.passwd+ "' target='_blank'>Apri Casella</a></font></i></td></tr>");
<? } 
   if (strstr($_SESSION['perms'],"a")||strstr($_SESSION['perms'],"@")) { ?>
        document.write("<tr><td><i><font face='Georgia' size=2>&nbsp;&nbsp;&nbsp;<a href='javascript:statocasella("+i+");'>Stato Casella</a></font></i></td></tr>");
<? } 
   if (strstr($_SESSION['perms'],"b")||strstr($_SESSION['perms'],"@")) { ?>
        document.write("<tr><td><i><font face='Georgia' size=2>&nbsp;&nbsp;&nbsp;<a href='php/modnot.php?notif=" +arrNot[i]+ "&msisdn=" +Profile.msisdn+ "&en=" +arrEn[i]+ "' target='main'>Imposta Notifica SMS</a></font></i></td></tr>"); 
<? } 
   if (strstr($_SESSION['perms'],"d")||strstr($_SESSION['perms'],"@")) { ?>
        document.write("<tr><td><i><font face='Georgia' size=2>&nbsp;&nbsp;&nbsp;<a href='javascript:sendMail(\"" +Profile.msisdn+ "\");'>Invio Email Di Prova</a></font></i></td></tr>");
<? } ?>
    }
    else if (arrEn[i] == 'sunrise') {
        document.write("<tr><td><i><font face='Georgia' size=2><B>-&nbsp;Menu' Profilo SUNRISE</B></font></i></td></tr>");
<? if (strstr($_SESSION['perms'],"a")||strstr($_SESSION['perms'],"@")) { ?>
        document.write("<tr><td><i><font face='Georgia' size=2>&nbsp;&nbsp;&nbsp;<a href='javascript:statocasella("+i+");'>Stato Servizi Mobili</a></font></i></td></tr>");
<? } ?>
    }
    else if (arrEn[i] == 'mms') {
        document.write("<tr><td><i><font face='Georgia' size=2><B>-&nbsp;Menu' Profilo MMS</B></font></i></td></tr>");
    }
    else if (arrEn[i] == 'stc') {
        document.write("<tr><td><i><font face='Georgia' size=2><B>-&nbsp;Menu' Profilo STC</B></font></i></td></tr>");
<? if (strstr($_SESSION['perms'],"a")||strstr($_SESSION['perms'],"@")) { ?>
        document.write("<tr><td><i><font face='Georgia' size=2>&nbsp;&nbsp;&nbsp;<a href='javascript:statocasella("+i+");'>Stato Casella</a></font></i></td></tr>");
<? }
   if (strstr($_SESSION['perms'],"c")||strstr($_SESSION['perms'],"@")) { ?>
        document.write("<tr><td><i><font face='Georgia' size=2>&nbsp;&nbsp;&nbsp;<a href='php/modlan.php?msisdn=" +Profile.msisdn+ "&en=" +arrEn[i]+ "' target='main'>Reset Lingua STC</a></font></i></td></tr>");
<? } ?>
    }
    else if (arrEn[i] == 'tiw') {
        document.write("<tr><td><i><B><font face='Georgia' size=2>-&nbsp;Menu' Profilo TIW</B></font></i></td></tr>");
<? if (strstr($_SESSION['perms'],"D")||strstr($_SESSION['perms'],"@")) { ?>
        document.write("<tr><td><i><font face='Georgia' size=2>&nbsp;&nbsp;&nbsp;<a href='modstuttprof.php?" +Profile.msisdn+ "' target='main'>Imposta Stutter Tone</a></font></i></td></tr>");
<? }
   if (strstr($_SESSION['perms'],"a")||strstr($_SESSION['perms'],"@")) { ?>
        document.write("<tr><td><i><font face='Georgia' size=2>&nbsp;&nbsp;&nbsp;<a href='javascript:statocasella("+i+");'>Stato Casella</a></font></i></td></tr>");
<? } ?>
    }
    else if (arrEn[i] == 'alice') {
        document.write("<tr><td><i><font face='Georgia' size=2><B>-&nbsp;Menu' Profilo ALICE</B></font></i></td></tr>");
        document.write("<tr><td><i><font face='Georgia' size=2>&nbsp;&nbsp;&nbsp;<a href='blank.php' target='main'>Stato Profilo Utente</a></font></i></td></tr>");
    }
    document.write("<tr><td>&nbsp;</td></tr>");
  }
</script>
  </table>

  </td></tr>
</table>
</BODY>
</HTML>	
