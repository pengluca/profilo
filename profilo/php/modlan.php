<?
require 'file_conf';
require 'auth.php';
if (!ck_sessione())
   exit;
if (!strstr($_SESSION['perms'],'c')&&(!strstr($_SESSION['perms'],'@')))
{
  $_SESSION['orario']=date('U');
    ?>
      <script language="javascript">  top.location="/profilo/index.php" </Script>
    <?
}
  // CREAZIONE RIGA DI LOG
  $ntel=$_GET[msisdn];
  $en=$_GET[en];
  $ip_client=$_SERVER[REMOTE_ADDR];
  $user=$_SESSION['usersess'];
  $notif=$_GET[notif];
  $data_trans=date("dmY")."-".date("H:i:s");
  $file_log=fopen("../log/modlan_".date("dm").".log","a+");
  $riga_log=$ip_client.' '.$user."-$data_trans-$ntel\n";
  fwrite($file_log,$riga_log);
  fclose($file_log);
  // CONTROLLO STATO CASELLA
  //VEDIAMO A QUALE MSS APPARTIENE
  $stringa="12345678901234seritel202datatype:oper\noper:modify\naccountid:$ntel\nenableservices:$en\nlang:it\n\t\n";
  $fp = fsockopen ($host_ibox, $port_ibox) or die("$errno : $errstr") ;
  socket_set_blocking($fp , TRUE);
  fputs($fp,$stringa);
  $line=fread($fp,1024);
  if (strpos($line,"RESULT") <> 0)
     { ?> <script language="javascript"> alert("E' stata impostata la lingua standard"); 
          window.parent.main.location="profilo.php?msisdn=<?=$ntel?>";
          </script><?}
  fclose($fp);
?>
