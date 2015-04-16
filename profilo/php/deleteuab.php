<?
require 'file_conf';
require 'auth.php';
if (!ck_sessione())
   exit;
if (!strstr($_SESSION['perms'],'F')&&(!strstr($_SESSION['perms'],'@')))
{
  $_SESSION['orario']=date('U');
    ?>
      <script language="javascript">  top.location="/profilo/index.php" </Script>
    <?
}
// CREAZIONE RIGA DI LOG
$ntel=$_GET[msisdn];
$account=$_GET[account];
$tid=$_GET[tid];
$ip_client=$_SERVER[REMOTE_ADDR];
$user=$_SESSION['usersess'];

$data_trans=date("dmY")."-".date("H:i:s");
$file_log=fopen("../log/deleteuab_".date("dm").".log","a+");
$riga_log=$ip_client.' '.$user."-$data_trans-$ntel-$account\n";
fwrite($file_log,$riga_log);
fclose($file_log);

$remote_file=$path_host."10".$ntel.".delete.sunrise.it";
$data_trans=date("Ymd").date("His");
$riga_att=$account."@alice.it\n".$causale."\n".$tid."\n".$data_trans;
$controllo=0;
$connection = ssh2_connect($ftp_host, 22);
if ($connection) {
  if (ssh2_auth_pubkey_file($connection, $user_ftp,'/home/apache/.ssh/id_dsa.pub','/home/apache/.ssh/id_dsa')) {
    $sftp = ssh2_sftp($connection);
    if ($sftp) {
      $stream = fopen("ssh2.sftp://$sftp$remote_file", 'w');
      if ($stream)
         fwrite($stream, $riga_att);
      else
         $controllo="no stream";
      fclose($stream);
    }
    else 
      $controllo="no sftp";
  }
  else 
    $controllo="no auth";
}
else
  $controllo="no connect";
if ($controllo == 0)
    print "<BR><BR><BR><BR><BR><BR><center><A><img src='../img/ok.gif' hspace=145 ><BR><BR><BR><B>RICHIESTA INOLTRATA</B></A></center>";
else
    print "<BR><BR><BR><BR><BR><BR><center><A><img src='../img/nok.gif' hspace=145 ><BR><BR><BR><B>SISTEMI NON DISPONIBILI ".$controllo."</B></A></center>";
?>
