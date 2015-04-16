<?
require 'php/auth.php';
if (!ck_sessione())
   exit;
if (!strstr($_SESSION['perms'],'C')&&(!strstr($_SESSION['perms'],'@')))
{
  $_SESSION['orario']=date('U');
    ?>
      <script language="javascript">  top.location="/profilo/index.php" </Script>
    <?
}
?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<HTML>

<HEAD>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <title>Lettura Profilo su UAB</title>
</HEAD>

<script Language="Javascript">
//<!-- 
function Emptytext(fform)
{
   with(fform)
   for (var i=0; i<elements.length; i++) {
        if ( (elements[i].type.search(/text|password/i) != -1) && (elements[i].value == "") ) {
            alert("Il campo '"+elements[i].name+"' è obbligatorio");
            elements[i].focus();
            return true;
        }
   }
   return false;
}


function CheckInvia(pForm) 
{
   with(pForm)
   if ( Emptytext(pForm))
   {
       return false; 
   }
   return true;
}
//-->
</script>

<BODY onload="document.form1.account.focus();">
<form name="form1" action="php/profalice.php" method="post">
<table width="100%" height="100%">
  <tr><td height="20%">&nbsp;</td></tr>
  <tr><td height="50%" align="center">

    <table height="100%" width="40%" border=1 cellspacing=0>
    <tr><td>

      <table height="100%" width="100%">
        <tr>
          <td align="right"><B>Account Email&nbsp;&nbsp;</B></td>
          <td><input name="account" size=12 title="ACCOUNT" value="" type="text"><B>&nbsp;@alice.it</B></td>
        </tr>
        <tr>
          <td colspan=2 align="center"><input type="submit" value="Ricerca" onclick="return CheckInvia(document.form1);"></td>
        </tr>
      </table>

    </td></tr>
    </table>

  </td></tr>
  <tr><td height="30%">&nbsp;</td></tr>
</table>
</form>
</body>
</html>
