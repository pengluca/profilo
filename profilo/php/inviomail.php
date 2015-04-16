<?
require 'auth.php';
if (!ck_sessione())
   exit;
if (!strstr($_SESSION['perms'],'d')&&(!strstr($_SESSION['perms'],'@')))
{
  $_SESSION['orario']=date('U');
    ?>
      <script language="javascript">  top.location="/profilo/index.php" </Script>
    <?
}
$ntel=$_GET[msisdn];
require 'file_conf';
  // CREAZIONE PARAMETRI DI LOG
  $ip_client=$_SERVER[REMOTE_ADDR];
  $user=$_SESSION['usersess'];
  $data_trans=date("dmY")."-".date("H:i:s");
  $file_log=fopen("../log/inviomail_".date("dm").".log","a+");
  $riga_log=$ip_client.' '.$user."-$data_trans-$ntel-$alias\n";
  fwrite($file_log,$riga_log);
  $fp=fsockopen($host_ibox, 25) or die("$errno : $errstr") ;
  $stringa="mail from:ibox@tim.it\nrcpt to:".$ntel."@tim.it\ndata\nfrom:ibox@tim.it\nto:Gentile Cliente\nsubject:Test invio email\nGentile Cliente,\n\n\nStiamo effettuando delle verifiche per la segnalazione da Lei inoltrata, la presente email costituisce un test di funzionamento del servizio\n\n\nLa salutiamo cordialmente\n\nAssistenza Clienti\n.\nquit\n";
  fputs($fp,$stringa);
  sleep(3);
  $line=fread($fp,1024);
  if (strpos($line,"Message received") <> 0)
     {  ?><script language="JavaScript"> alert("Email correttamente inviata!");history.go(-1);</script><?}
  fclose($fp);
  fclose($file_log);
  ?>
