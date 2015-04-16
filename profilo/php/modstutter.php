<?
require 'auth.php';
if (!ck_sessione())
   exit;
if (!strstr($_SESSION['perms'],'D')&&(!strstr($_SESSION['perms'],'@')))
{
  $_SESSION['orario']=date('U');
    ?>
      <script language="javascript">  top.location="/profilo/index.php" </Script>
    <?
}
// CREAZIONE RIGA DI LOG
$ntel=$_POST[msisdn];
$tipout=$_POST[tipomem];
if (!$ntel)
   $ntel=$_GET[msisdn];
if (!$tipout)
   $tipout="memotel";
require 'file_conf';
$ip_client=$_SERVER[REMOTE_ADDR];
$user=$_SESSION['usersess'];
$data_trans=date("dmY")."-".date("H:i:s");
$file_log=fopen("../log/modstutter_".date("dm").".log","a+");
$riga_log=$ip_client.' '.$user."-$stutt-$data_trans-$ntel\n";
fwrite($file_log,$riga_log);
print "<table width=100% ><tr>";
$stringa_stmem=str_replace("service:","service:".$tipout, $stringa_stmem); 
$fpst = fsockopen ($host_stmem, $port_stmem) or die("$errno : $errstr") ;
socket_set_blocking($fpst , TRUE);
fputs($fpst,$stringa_stmem);
$line = fread($fpst,1024);
$sc=split("\n",$line);
while (list($arg, $val) = each($sc))
{
    list($argomento,$valore)=split(':',$val);
    if ($argomento == "rstring") 
      $risposta=$valore;
    elseif ($argomento == "estring") 
      $risposta=$valore;
}
if (substr($line,33,5) == "RESUL")
    print "<BR><BR><BR><BR><BR><BR><center><A><img src='../img/ok.gif' hspace=145 ><BR><BR><BR><B>$risposta</B></A></center>";
else 
    print "<BR><BR><BR><BR><BR><BR><center><A><img src='../img/nok.gif' hspace=145 ><BR><BR><BR><B>$risposta</B></A></center>"; 
fclose($fpst);
fclose($file_log);
?>
