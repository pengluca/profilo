<?
session_start();

$i="ciccio";
?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<HTML>

<HEAD>
<STYLE TYPE="text/css">
  a { color: black }
  a:hover { color: red; }
  a:link, A:visited { text-decoration: none }

</STYLE>

  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <title>Title page</title>

<script language="JavaScript">
function refresh(mypar)
{
   window.parent.title.location="title.php?" +escape(mypar);
   window.parent.topmenu.location="topmenu.htm?" +escape(mypar);
}

</script>
</HEAD>

<BODY>
<table width="100%" height="95%" border=1 bgcolor="#EFEFEF" cellspacing=0>
  <tr valign="top"><td>
  <table width="100%" border=0 cellpadding=6 cellspacing=0>
    <tr>
      <td><i><font face="Georgia" size=2><a href="blank.php" target="main" onClick="refresh('HOME PAGE');">Home</a></font></i></td>
    </tr>
    <tr>
      <td><i><font face="Georgia" size=2><B>Lettura Profilo</B></font></i></td>
    </tr>
<? 
    if (strstr($_SESSION['perms'],"A")||strstr($_SESSION['perms'],"@")) { ?>
    <tr>
      <td><i><font face="Georgia" size=2 colour="#000000" >-&nbsp;<a href="ric_profilo.php" target="main" onClick="refresh('LETTURA PROFILO INTERMAIL');">Provisioning Intermail</a></font></i></td>
    </tr>
<? } 
    if (strstr($_SESSION['perms'],"B")||strstr($_SESSION['perms'],"@")) { ?>
    <tr>
      <td><i><font face="Georgia" size=2>-&nbsp;<a href="cktim.php" target="main" onClick="refresh('LETTURA PROFILO MAP3');">MAP3</a></font></i></td>
    </tr>
<? }
    if (strstr($_SESSION['perms'],"H")||strstr($_SESSION['perms'],"@")) { ?>
    <tr>
      <td><i><font face="Georgia" size=2>-&nbsp;<a href="ckcreditt.php" target="main" onClick="refresh('LETTURA PROFILO OPSC');">OPSC</a></font></i></td>
    </tr>
<? }
    if (strstr($_SESSION['perms'],"C")||strstr($_SESSION['perms'],"@")) { ?>
    <tr>
      <td><i><font face="Georgia" size=2>-&nbsp;<a href="ricprofalice.php" target="main" onClick="refresh('LETTURA PROFILO UAB');">UAB</a></font></i></td>
    </tr>
<? } ?>
    <tr>
      <td><i><font face="Georgia" size=2><B>Gestione</B></font></i></td>
    </tr>
<?  
    if (strstr($_SESSION['perms'],"D")||strstr($_SESSION['perms'],"@")) { ?>
    <tr>
      <td><i><font face="Georgia" size=2>-&nbsp;<a href="impstutter.php" target="main" onClick="refresh('IMPOSTAZIONE STUTTER TONE');">Stutter Tone</a></font></i></td>
    </tr>
<? }
    if (strstr($_SESSION['perms'],"E")||strstr($_SESSION['perms'],"@")) { ?>
    <tr>
      <td><i><font face="Georgia" size=2>-&nbsp;<a href="imppwdmemo.php" target="main" onClick="refresh('IMPOSTAZIONE PASSWORD MEMOTEL');">Password Memotel</a></font></i></td>
    </tr>
<? }
    if (strstr($_SESSION['perms'],"F")||strstr($_SESSION['perms'],"@")) { ?>
    <tr>
      <td><i><font face="Georgia" size=2>-&nbsp;<a href="rimprofuab.php" target="main" onClick="refresh('RIMOZIONE PROFILO UAB');">Rimozione profilo UAB</a></font></i></td>
    </tr>
<? } 
    if (strstr($_SESSION['perms'],"G")||strstr($_SESSION['perms'],"@")) { ?>
    <tr>
      <td><i><font face="Georgia" size=2>-&nbsp;<a href="imppwdstc.php" target="main" onClick="refresh('IMPOSTAZIONE PASSWORD STC');">Password STC</a></font></i></td>
    </tr>
<? } ?>
    <tr>
      <td><i><font face="Georgia" size=2><B>Area Riservata</B></font></i></td>
    </tr> 
    <tr>
      <td><i><font face="Georgia" size=2>-&nbsp;<a href="modiaccount.php" target="main" onClick="refresh('MODIFICA ACCOUNT');">Modifica Dati Personali</a></font></i></td>
    </tr> 
    <tr>
      <td><i><font face="Georgia" size=2>-&nbsp;<a href="php/auth.php?azione=1" target='_top' >Logout</a></font></i></td>
    </tr> 
  </table>

  </td></tr>
</table>
</BODY>

</HTML>	
