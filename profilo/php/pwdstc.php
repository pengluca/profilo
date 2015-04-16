<?
require 'auth.php';
if (!ck_sessione())
   exit;
if (!strstr($_SESSION['perms'],'G')&&(!strstr($_SESSION['perms'],'@')))
{
  $_SESSION['orario']=date('U');
    ?>
      <script language="javascript">  top.location="/profilo/index.php" </Script>
    <?
}
$ntel=$_POST[msisdn];
$pwd=$_POST[nuova];
$ip_client=$_SERVER[REMOTE_ADDR];
$user=$_SESSION['usersess'];
$data_trans=date("dmY")."-".date("G:i:s");
$file_log=fopen("../log/pwdstc_".date("dm").".log","a+");
$riga_log=$ip_client.' '.$user."-$data_trans-$ntel-$pwd\n";
fwrite($file_log,$riga_log);
$fp = fsockopen ("fep08", 6350) or die("$errno : $errstr") ;
socket_set_blocking($fp , TRUE);
fputs($fp,"12345678901234seritel202datatype:oper\noper:modify\nenableservices:stc\naccountid:$ntel\npassword:$pwd\n\t\n");
$line = fread($fp,1024);
if (substr($line,33,5) == "RESUL")
{
  print "<BR><BR><BR><BR><BR><BR><center><A><img src='../img/ok.gif' hspace=145 ><BR><BR><BR><B>OPERAZIONE CORRETTAMENTE ESEGUITA</B></A></center>";
}
else
{ 
  $subrisp=strstr($line, 'ESTRING');
  $sc=split(":",$subrisp); 
  if (trim($sc[2])=="utente non esiste sul sistema")
    print "<BR><BR><BR><BR><BR><BR><center><A><img src='../img/nok.gif' hspace=145 ><BR><BR><BR><B>LA NUMERAZIONE INDICATA NON HA LA CASELLA STC ATTIVA</B></A></center>";
  else
  {
    print "<BR><BR><BR><BR><BR><BR><center><font color='#C11B17'><A font style='text-transform: uppercase;'><img src='../img/nok.gif' hspace=145 ><BR><BR><BR><B>ATTENZIONE:$sc[1] $sc[2] </B></A></center>";
  }
}
fclose($file_log);
?>
</body>
</html>
