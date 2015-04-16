<?
require 'auth.php';
if (!ck_sessione())
   exit;
if (!strstr($_SESSION['perms'],'C')&&(!strstr($_SESSION['perms'],'@')))
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
$account=$_POST[account];
$ip_client=$_SERVER[REMOTE_ADDR];
$user=$_SESSION['usersess'];
$data_trans=date("dmY")."-".date("H:i:s");
$file_log=fopen("../log/profalice_".date("dm").".log","a+");
$riga_log=$ip_client.' '.$user."-$data_trans-$account\n";
fwrite($file_log,$riga_log);
//CREAZIONE STRINGA DA INVIARE
$account=$pass.":".$account."\r";
$len=strlen($account);
$fp=fsockopen($host_uab,$port_uab,$ernofp,$erstrfp) ;
socket_set_blocking($fp , TRUE);
fwrite($fp,$account,$len);
$risultato=fread($fp,1024);
$seok=strpos($risultato,"<Result>200</Result>");
if ($seok)
{
  print "<table width=100% ><tr>";
  print "<td align=center valign=top>";
  print "<table border=3 bgcolor='#CBDBEA'>";
  $lungh_array=count($elementi);
  for ($contatore=0; $contatore < $lungh_array; $contatore++) 
  {
//Calcolo prima la posizione del primo tag e del tag di chiusura
    $posin=strpos($risultato,"<".$elementi[$contatore].">");
    $posfi=strrpos($risultato,"</".$elementi[$contatore].">");
    $lenele=strlen($elementi[$contatore]);
    $lenele=$lenele+2;
    if ($posin !== $posfi)
    {
//Lunghezza del tag da cui partire poi per l'estrazione del valore
      $posin=$posin+$lenele;
      $valore=substr($risultato,$posin,($posfi-$posin));
      print "<tr><td bgcolor='#CBDBEA'>$elementi[$contatore]</td><td bgcolor='#CBDBEA'>$valore</td></tr>";
    }
  }
  print "</table>";
  print "</td></tr></table>"; 
}
else
{  
  if (strpos($risultato,"<Result>510</Result>"))
    $risposta="Utente non trovato su UAB";
  else
    $risposta=$risultato;
  print "<BR><BR><BR><BR><BR><BR><center><A><img src='../img/nok.gif' hspace=145 ><BR><BR><BR><B>$risposta</B></A></center>";
}
fclose($fp);
fclose($file_log);
?>
