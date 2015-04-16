<?
require 'file_conf';
require 'auth.php';
if (!ck_sessione())
   exit;
if (!strstr($_SESSION['perms'],'B')&&(!strstr($_SESSION['perms'],'@')))
{
  $_SESSION['orario']=date('U');
    ?>
      <script language="javascript">  top.location="/profilo/index.php" </Script>
    <?
}
// CREAZIONE RIGA DI LOG
$ntel=$_POST[msisdn];
$ip_client=$_SERVER[REMOTE_ADDR];
$user=$_SESSION['usersess'];
$data_trans=date("dmY")."-".date("H:i:s");
$file_log=fopen("../log/euntim_".date("dm").".log","a+");
$riga_log=$ip_client.' '.$user."-$data_trans-$ntel\n";
fwrite($file_log,$riga_log);
//CREAZIONE STRINGA DA INVIARE
$ntel='39'.$ntel;
$len=strlen($ntel);   
$stringa="MS".$len.$ntel."TO02YN";
$len=strlen($stringa);
$stringa="OI0".$len.$stringa;
$len=strlen($stringa);
for ($i=0;$i<7;$i++)
{
  if(($fp=fsockopen($MAP,$PORTMAP,$errno,$errstr,4)))
  {
    socket_set_blocking($fp , TRUE);
    fwrite($fp,$stringa,$len);
    $risultato=fread($fp,1024);
    fclose($fp);
    if ($risultato)
    {
      $i=11;
      $codice=substr($risultato,6,6);
      if ($codice == "RS0200")
      {
        $i=11;
        $sub=strstr($risultato,"OP");
        $op=substr($sub,4,3);
        $oper=array('010' => 'TIM', '100' => 'VODAFONE', '990' => 'TRE', '880' => 'WIND', '01A' => 'COOP', '01B' => 'TISCALI','01C' => 'MTV','01D' => 'NOVERCA'); 
        $sub=strstr($risultato,"TO");
        $tipo=substr($sub,4,1);
        if ($tipo==="1")
          $aob="A";
        elseif ($tipo==="2")
          $aob="B";
        $ntel=substr($ntel,2,15);
        if ($oper[$op])
           print "<BR><BR><BR><BR><BR><BR><center><A><img src='../img/ok.gif' hspace=145 ><BR><BR><BR><B>L'utenza $ntel risulta $oper[$op]</B></A></center>";
        else 
           print "<BR><BR><BR><BR><BR><BR><center><A><img src='../img/ok.gif' hspace=145 ><BR><BR><BR><B>L'utenza $ntel è presente sul MAP3 con codice $op, verificare operatore appartenenza</B></A></center>";
        if (isset($aob))
        { 
          $sub=strstr($risultato,"M2");
          $altronum=substr($sub,6,15);   
          print "<center><B>E' il numero $aob dell'utenza $altronum</B></A></center>";
        }
      }
      elseif ($codice == "RS0201")
      {
        $i=11;
        print "<BR><BR><BR><BR><BR><BR><center><A><img src='../img/nok.gif' hspace=145 ><BR><BR><BR><B>UTENTE NON TROVATO SU MAP3</B></A></center>";   
      }
    }   
  }
  else
  {
    if ($i==3)
      $MAP=$MAP1;
  }
}
if ($i!=12)
  print "<BR><BR><BR><BR><BR><BR><center><A><img src='../img/nok.gif' hspace=145 ><BR><BR><BR><B>SISTEMI NON DISPONIBILI </B></A></center>";
fclose($file_log);
?>
