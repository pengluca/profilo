<?
require 'file_conf';
require 'auth.php';
if (!ck_sessione())
   exit;
if (!strstr($_SESSION['perms'],'b')&&(!strstr($_SESSION['perms'],'@')))
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
  $file_log=fopen("../log/modnot_".date("dm").".log","a+");
  $riga_log=$ip_client.' '.$user."-$stutt-$data_trans-$ntel\n";
  fwrite($file_log,$riga_log);
  fclose($file_log);
  // CONTROLLO STATO CASELLA
  //VEDIAMO A QUALE MSS APPARTIENE
  if ($notif == "1") {
    $stringa="12345678901234seritel202datatype:oper\noper:modify\naccountid:$ntel\nenableservices:$en\nnot_data_enabled:0\n\t\n";
    $ris="Disattivata";
  } 
  else { 
    $stringa="12345678901234seritel202datatype:oper\noper:modify\naccountid:$ntel\nenableservices:$en\nnot_data_enabled:1\n\t\n";
    $ris="Attivata";
  }
  if ($en == "tiw")
    $fp = fsockopen ($host_memo, $port_memo) or die("$errno : $errstr") ;
  else 
    $fp = fsockopen ($host_ibox, $port_ibox) or die("$errno : $errstr") ;
  socket_set_blocking($fp , TRUE);
  fputs($fp,$stringa);
  $line=fread($fp,1024);
  if (strpos($line,"RESULT") <> 0)
  { ?> <script language="javascript"> 
          alert("La Notifica  e' stata <?=$ris?>!");
          window.parent.main.location="profilo.php?msisdn=<?=$ntel?>";
          </script><?}
  fclose($fp);
?>
