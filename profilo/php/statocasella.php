<?
require 'file_conf';
require 'auth.php';
if (!ck_sessione())
   exit;
if (!strstr($_SESSION['perms'],'a')&&(!strstr($_SESSION['perms'],'@')))
{
  $_SESSION['orario']=date('U');
    ?>
      <script language="javascript">top.location="/profilo/index.php"</script>
    <?
}
$login="imail";
$passwd="imail";
$msisdn=$_GET[msisdn];
$en=$_GET[en];
?>

 <html>
 <head>
 <title>Stato Casella <?=$msisdn?></title>
 </head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
//DETERMINIAMO L'ISTANZA ORACLE DA INTERROGARE
$mss=$_GET[mss];
if (substr($mss,3,2)=="na")
  $db="IMM6NA".substr($mss,5,2);
elseif (substr($mss,3,2)=="mi")
  $db="IMM6MI".substr($mss,5,2);
else
  $db="IMM6_".substr($mss,3,2);
$ntel=$prefid[$en].$msisdn;
$query="SELECT b.fldr_foldername folder,
               b.relativefoldernum foldernum
          FROM mx_mailboxnames a,
               s_folder b
         WHERE b.boxid='$ntel'
           AND b.boxid=a.boxid
           AND b.hashedboxid=a.hashedboxid";

$conn=OCILogon($login,$passwd,$db) or die("Connessione Fallita al DB, Riprovare piu' tardi");
$stmt = oci_parse($conn, $query) or die("Errore nella query");
oci_execute($stmt, OCI_DEFAULT);
// QUESTA PARTE ESEGUE LA SECONDA QUERY 
$query2="SELECT INV_TYPE,
                sum(INV_MSGCOUNT),
                sum(INV_TOTCOUNTREAD)
         FROM S_FOLDERINVENTORY a,
              MX_MAILBOXNAMES b  
         WHERE a.HASHEDBOXID = b.HASHEDBOXID  
         AND a.boxid=b.boxid
         AND b.boxid='$ntel'
         GROUP BY INV_TYPE";
$stmt2 = oci_parse($conn, $query2) or die("Errore nella query");
oci_execute($stmt2, OCI_DEFAULT);


?>
<table border=0 cellpadding="2" cellspacing="0" width='100%' height='100%'>
<tr><td>

 <table border=3 width='100%' height='100%' bgcolor='#CBDBEA'>
 <tr>
    <td><B>Cartella</td>
    <td><B>Nuovi</td>
    <td><B>Letti</td>
    <td><B>Bytes</td>
 </tr>
<?
while (oci_fetch($stmt)) 
{
   $a=oci_result($stmt,"FOLDER");
   $rfn=oci_result($stmt,"FOLDERNUM");
   $query1="SELECT NVL(SUM(instr(a.fm_countedasunread, 'T')), 0) unread,
                   NVL(SUM(instr(a.fm_countedasunread, 'F')), 0) read,
                   NVL(SUM(a.msg_bytesstored), 0) nbytes
              FROM mx_mboxmsgs_view a,
                   mx_mailboxnames b
             WHERE b.boxid='$ntel'
               AND b.boxid=a.boxid
               AND b.hashedboxid=a.hashedboxid
               AND a.relativefoldernum='$rfn'";
   $stmt1 = oci_parse($conn, $query1) or die("Errore nella query1");
   oci_execute($stmt1, OCI_DEFAULT);
   oci_fetch($stmt1);
   $b=oci_result($stmt1,"UNREAD");
   $c=oci_result($stmt1,"READ");
   $d=oci_result($stmt1,"NBYTES");
   $totb=$totb+$b;
   $totc=$totc+$c;
   $totd=$totd+$d;
?>
 <tr>
    <td><?=$a?></td>
    <td><?=$b?></td>
    <td><?=$c?></td>
    <td><?=$d?></td>
 </tr>
<?
  }
?>
 <tr>
    <td><B>Totale</td>
    <td><?=$totb?></td>
    <td><?=$totc?></td>
    <td><?=$totd?></td>
 </tr>

 <tr>
    <td colspan=4><br><B>Tipologia messaggi:</B></td>
 </tr> 
<?
while (oci_fetch($stmt2))
{
   $a=oci_result($stmt2,"INV_TYPE");
   $b=oci_result($stmt2,'SUM(INV_MSGCOUNT)');
   $c=oci_result($stmt2,'SUM(INV_TOTCOUNTREAD)');
   ?>
   <tr>
    <td><?=$a?></td>
    <td><?=$b?></td>
    <td colspan=2><?=$c?></td>
   </tr>
  <?
}
   OCILogOff($conn);
?>
   </table>
 </td></tr>

</table> 
</body>
</html>
