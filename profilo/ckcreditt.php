<?
require 'php/auth.php';
if (!ck_sessione())
   exit;
if (!strstr($_SESSION['perms'],'H')&&(!strstr($_SESSION['perms'],'@')))
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
  <title>Stato Utenza su OPSC</title>
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

function Checkdigit(fform)
{
   with(fform)
   for (var i=0; i<elements.length; i++) {
        if ( (elements[i].type.search(/text|password/i) != -1) && (elements[i].value.search(/\D{1,}/) != -1) ) {
            alert("Il campo '"+ elements[i].name +"' può contenere solo caratteri numerici");
            elements[i].focus();
            return true;
        }
   }
   return false;
}


function ControlloLunghezzaMsisdn(campo,nomeCampo)
{
   var string = campo.value;
   if (string.length<8)
   {
       alert("la lunghezza del campo "+nomeCampo+" deve essere tra i 8 e gli 11 caratteri");
       campo.focus();
       campo.value="";
       return true;
   }
   if (string.substring(0,1) != "3")
   {
       alert(nomeCampo+" deve contenere una numerazione di rete mobile");
       campo.focus();
       campo.value="";
       return true;
   }
   return false;
}


function CheckInvia(pForm) 
{
   with(pForm)
   if ( Emptytext(pForm) ||
        Checkdigit(pForm) ||
        ControlloLunghezzaMsisdn(msisdn,"msisdn")
      )
   {
       return false; 
   }
   return true;
}
//-->
</script>

<BODY onload="document.form1.msisdn.focus();">
<form name="form1" action="php/opsc_bgw.php" method="post">
<table width="100%" height="100%">
  <tr><td height="20%">&nbsp;</td></tr>
  <tr><td height="50%" align="center">

    <table height="100%" width="40%" border=1 cellspacing=0>
    <tr><td>

      <table height="100%" width="100%">
        <tr>
          <td align="right"><B>MSISDN&nbsp;&nbsp;+39</B></td>
          <td><input name="msisdn" maxlength=11 size=12 title="MSISDN" value="" type="text"></td>
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
