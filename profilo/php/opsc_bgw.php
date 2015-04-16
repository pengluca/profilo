<?
require 'auth.php';
if (!ck_sessione())
   exit;
if (!strstr($_SESSION['perms'],'H')&&(!strstr($_SESSION['perms'],'@')))
{
  $_SESSION['orario']=date('U');
    ?>
      <script language="javascript">  top.location="/profilo/index.php" </Script>
    <?
}
?>
<html>
<body>
<script type="text/javascript">
function doRedirect() {
 top.location="/profilo/index.php"
}
window.setTimeout("doRedirect()", 60000);
</script>
<?
require 'file_conf';
// CREAZIONE RIGA DI LOG
$ntel=$_POST[msisdn];
$ip_client=$_SERVER[REMOTE_ADDR];
$user=$_SESSION['usersess'];
$data_trans=date("dmY")."-".date("H:i:s");
$file_log=fopen("../log/opsc_bgw_".date("dm").".log","a+");
$riga_log=$ip_client.' '.$user."-$data_trans-$ntel\n";
fwrite($file_log,$riga_log);
//CREAZIONE STRINGA DA INVIARE
$account=$tagric.":".$ntel."\r";
$len=strlen($account);
$pp=fsockopen($host_uab,$port_uab,$ernofp,$erstrfp) ;
socket_set_blocking($pp , TRUE);
fwrite($pp,$account,$len);
$risultato=fread($pp,1024);
if (strpos($risultato," Code=0"))
{
  $controllo=0;
  print "<table width=100% ><tr>";
  print "<td align=center valign=top>";
  print "<table border=3 bgcolor='#CBDBEA'>";
  $pieces = explode(" ", $risultato);
  $lungh_array=count($pieces);
  for ($contatore=0; $contatore < $lungh_array; $contatore++)
  {
     if (strstr($pieces[$contatore],'='))
     {
          list($key1,$val1)=explode("=", $pieces[$contatore]);        
          if ($key_opsc[$key1])
          {                                
             if (($controllo == 0) && ($key1 == "LASTSYNCHVALUE"))
             { 
               print "<tr><td bgcolor='#CBDBEA'>$key_opsc[$key1]</td><td bgcolor='#CBDBEA'>$val1</td></tr>";
               $controllo=1;
             }
             elseif ($key1 != "LASTSYNCHVALUE")
                print "<tr><td bgcolor='#CBDBEA'>$key_opsc[$key1]</td><td bgcolor='#CBDBEA'>$val1</td></tr>";
          }
     }
  }
  print "</table>";
  print "</td></tr></table>"; 
}
elseif (strpos($risultato,"Code#1"))
{
  print "<table width=100% ><tr>";
  print "<td align=center valign=top>";
  print "<table border=3 bgcolor='#CBDBEA'>";
  $pieces = explode(" ", $risultato);
  $lungh_array=count($pieces);
  for ($contatore=0; $contatore < $lungh_array; $contatore++)
  {
    if (strstr($pieces[$contatore],'='))
    {
       list($key1,$val1)=explode("=", $pieces[$contatore]);
       print "<tr><td bgcolor='#CBDBEA'>$key1</td><td bgcolor='#CBDBEA'>$val1</td></tr>";
    }
  } 
  print "</table>";
  print "</td></tr></table>";
}
elseif (strpos($risultato,"Code#2"))
{
   print "<BR><BR><BR><BR><BR><BR><center><A><img src='../img/nok.gif' hspace=145 ><BR><BR><BR><B>Sistemi non disponibili</B></A></center>";
}
else
{  
   print "<BR><BR><BR><BR><BR><BR><center><A><img src='../img/nok.gif' hspace=145 ><BR><BR><BR><B>UTENZA NON ATTIVA O DI ALTRO GESTORE</B></A></center>";
}
fclose($pp);
fclose($file_log);
?>
