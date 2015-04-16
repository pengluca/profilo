<?
$ntel=$_POST[msisdn];
$alias=$_POST[alias];
if (!$ntel)
   $ntel=$_GET[msisdn];
require 'file_conf';
require 'auth.php';
if (!ck_sessione())
   exit;
if (!strstr($_SESSION['perms'],'A')&&(!strstr($_SESSION['perms'],'@')))
{
  $_SESSION['orario']=date('U');
    ?>
      <script language="javascript">  top.location="/profilo/index.php" </Script>
    <?
}
//RIMUOVERE LE BARRE DI COMMENTO PER ABILITARE IL CONTROLLO SE PUO' VEDERE PASSWORD
//elseif (strstr($_SESSION['perms'],'@'))
//{
   $stringa_ibox=str_replace('mailmessagestore',"password:\nmailmessagestore",$stringa_ibox);
   $stringa_stc=str_replace('mailmessagestore',"password:\nmailmessagestore",$stringa_stc);
   $stringa_stchz=str_replace('mailmessagestore',"password:\nmailmessagestore",$stringa_stchz);
 //  $stringa_memo=str_replace('mailmessagestore',"password:\nmailmessagestore",$stringa_memo);
   $stringa_memo=str_replace('mailmessagestore',"password:\npassword_405:\nmailmessagestore",$stringa_memo);
//}
?>
<html>
<body>
<script type="text/javascript">
function doRedirect() {
 top.location="/profilo/index.php" 
}
window.setTimeout("doRedirect()", 1200000);
</script>
<?
// CREAZIONE PARAMETRI DI LOG
$ip_client=$_SERVER[REMOTE_ADDR];
$user=$_SESSION['usersess'];
$data_trans=date("dmY")."-".date("H:i:s");
$file_log=fopen("../log/accesso_".date("dm").".log","a+");
$riga_log=$ip_client.' '.$user."-$data_trans-$ntel-$alias\n";
fwrite($file_log,$riga_log);
$primochar=substr($ntel,0,1);
// INTERPRETO IL TIPO DI NUMERAZIONE (MEMOTEL,MOBILE)
if (($primochar == "3") || (strlen($alias) > 0))
{
  $fp = fsockopen ($host_ibox, $port_ibox) or die("$errno : $errstr") ;
  socket_set_blocking($fp , TRUE);
  fputs($fp,$stringa_ibox);
}
else
{
  $fp = fsockopen ($host_memo, $port_memo) or die("$errno : $errstr") ;
  socket_set_blocking($fp , TRUE);
  fputs($fp,$stringa_memo);
}
$line = fread($fp,1024);
$seunitim="NIENTE";
print "<table width=100% ><tr>";
if (substr($line,33,5) == "RESUL")  
{
//UNITIM o IBOX
  $controllo="ok";
  $sc=split("\n",$line);
  print "<td align=center valign=top>";
  print "<table border=3 bgcolor='#CBDBEA'>";
  while (list($arg, $val) = each($sc))
  {
    list($argomento,$valore,$a,$b,$c,$d,$e,$f,$g,$h)=split(':',$val);
    if ((substr($argomento,0,10) !== "1234567890") && (trim($argomento) !== "emailbuffer")) 	
    { 
      if (trim($argomento) == "enableservices") 
      { 
        $en=$valore; 
        $argomento="<b>UTENZA</b>"; 	
        $tipoen=array("unitim" => "UNITIM","um" => "IBOX","tiw" => "MEMOTEL"); 
        if ($tipoen[$valore])
           $seunitim=$tipoen[$valore];
        else
           $seunitim=$valore;
        $valore="<font style='text-transform: uppercase;'><b>$seunitim</b></font>"; 
      } 
      elseif ($argomento == "accountid")
      {
// MSISDN MI SERVE DOPO PER IL LINK APRI WEBMAIL .NTEL NEL CASO AVESSE CERCATO PER ALIAS
        $msisdn=$valore;
        $ntel=$valore;
      }
      elseif ($argomento == "password")
        $passwd=$valore;
      elseif ($argomento == "isp") 
      {
        if (strstr($_SESSION['perms'],'@'))
          $valore=$g." ".$h;
        else
          $valore=$g;
      }
      elseif ($argomento == "mailmessagestore")
        $mss=$valore; 
      elseif ($argomento == "not_data_enabled")
        $notif=$valore; 
      if ($valore === "0" )
        $valore="disattivo";
      elseif ($valore === "1")
        $valore="attivo";
      if (strlen(trim($valore)) > 0)
        print "<tr><td bgcolor='#CBDBEA'>$argomento</td><td bgcolor='#CBDBEA'>$valore</td></tr>";
    }
  }
  print "</table>";
  print "</td>";
  //SE UNITIM O MMS CONTROLLIAMO LA CASELLA STC
  if (($seunitim == "UNITIM") || ($seunitim == "mms") || ($seunitim == "timbase"))
  {
    fputs($fp,$stringa_stc);
    $line = fread($fp,1024);
    if (substr($line,33,5) == "RESUL")
    {
      //SOLO STC
      $sc=split("\n",$line);
      print "<td align=center valign=top>";
      print "<table border=3 bgcolor='#CBDBEA'>";
      while (list($arg, $val) = each($sc))
      {
        list($argomento,$valore)=split(':',$val);
        if ((substr($argomento,0,10) !== "1234567890") && (trim($argomento) !== "emailbuffer"))
        {
          if ($argomento == "enableservices")
          {
            $en=$en."_".$valore;
            $argomento="<b>UTENZA</b>";   
            $valore=strtoupper($valore);
            $valore="<b>$valore</b>";
          }
          elseif ($argomento == "mailmessagestore")
            $mss=$mss."_".$valore;          
          elseif ($argomento == "not_data_enabled")
            $notif=$notif."_".$valore;   
          elseif ($valore === "0")
            $valore="disattivo";
          elseif ($valore === "1")
            $valore="attivo";
          if (strlen(trim($valore)) > 0)
          print "<tr><td>$argomento</td><td>$valore</td></tr>";
        }
      }
      print "</table>";
      print "</td>";
    }
  }
}
else 
  $controllo="ko";
// PER I FISSI ANDIAMO A CERCARE COMUNQUE ALICE_SMS ALTRIMENTI
if (($primochar !== "3") && (empty($alias))) 
{
// SE E' UN FISSO ALLORA CERCHIAMO IL PROFILO ALICE_SMS
  $conn=mysql_connect ($host_mysql, $user_db, $pass_db);
  mysql_select_db ($db, $conn);
  $laselect="select account,stato,user_profile,user_type,cli,servizio,mittente,master_account,data_login from profilo where cli=$ntel";
  $ris=mysql_query($laselect, $conn);
  $num_righe = mysql_num_rows($ris);
  if ($num_righe)
  {
    if ($controllo=="ok") 
    {
      $en=$en."_"."alicesms";
      $mss=$mss."_"."alicesms";
    }
    else
      $en=$mss="alicesms";
    print "<td align=center >";
    print "<table border=3 bgcolor='#CBDBEA'>";
    print "<tr><td><b> PROFILO</b><td><b> ALICE_SMS</td></b>";
    while ($rga = mysql_fetch_row($ris))
    {
      for ($i=0; $i < count($rga); $i++) 
      {
        $campo=mysql_field_name($ris, $i);
        if (($campo == "msisdn") && ($rga[$i] !== ""))
           $campo="<b>CONVERGENTE CON</b>"; 
        elseif ($campo == "password")
        {
           if ($controllo=="ok")
              $passwd=$passwd."_".$rga[$i]; 
           else 
              $passwd=$rga[$i];
        }
        if ($rga[$i] !== "")
          print "<tr><td>$campo</td><td>$rga[$i]</td></tr>";
      }
    }
    print "</table>";
    print "</td>";
    $controllo="ok";
  }
  mysql_close($conn);
}
// CONTROLLIAMO SE HOMEZONE 
if (($primochar == "3") || (strlen($alias) > 0))
{
  fputs($fp,$stringa_stchz);
  $line = fread($fp,1024);
  if (substr($line,33,5) == "RESUL")
  {
    $sc=split("\n",$line);
    print "<td align=center valign=top>";
    print "<table border=3 bgcolor='#CBDBEA'>";
    while (list($arg, $val) = each($sc))
    {
      list($argomento,$valore)=split(':',$val);
      if ((substr($argomento,0,10) !== "1234567890") && (trim($argomento) !== "emailbuffer"))
      {
        if ($argomento == "enableservices")
        {
//        $en=$en."_".$valore;
          $argomento="<b>UTENZA</b>";
          $valore=strtoupper($valore);
          $valore="<b>$valore</b>";
        }
//      elseif ($argomento == "mailmessagestore")
//        $mss=$mss."_".$valore;
//      elseif ($argomento == "not_data_enabled")
//        $notif=$notif."_".$valore;
        elseif ($valore === "0")
          $valore="disattivo";
        elseif ($valore === "1")
          $valore="attivo";
        if (strlen(trim($valore)) > 0)
        print "<tr><td>$argomento</td><td>$valore</td></tr>";
      }
    }
    print "</table>";
    print "</td>";
    $controllo="ok";
  }
}

// NESSUN PROFILO TROVATO
if ($controllo=="ko")
  print "<BR><BR><BR><BR><BR><BR><center><A><img src='../img/nok.gif' hspace=145 ><BR><BR><BR><B>NESSUN SERVIZIO ATTIVO O ERRATA NUMERAZIONE</B></A></center>";
else
{
  ?>
  <script language="JavaScript">
     window.parent.menu.location="../menusx.php?msisdn=<?=$ntel?>&passwd=<?=$passwd?>&en=<?=$en?>&mss=<?=$mss?>&notif=<?=$notif?>";
  </script>
  <? 
}
fclose($file_log);
print "</tr></table>";
fputs($fp,"12345678901234seritel202datatype:oper\noper:exit\n\t\n");
fclose($fp);
?>
</body>
</html>
