<?
require 'php/auth.php';
if (!ck_sessione())
   exit;
if (!strstr($_SESSION['perms'],'A')&&(!strstr($_SESSION['perms'],'@')))
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
  <title>Gestione Profilo</title>
</HEAD>

<script Language="Javascript">
//<!--
function trim(stringa)
{
   while (stringa.substring(0,1) == ' ') {
          stringa = stringa.substring(1, stringa.length);
   }

   while (stringa.substring(stringa.length-1, stringa.length) == ' ') {
          stringa = stringa.substring(0,stringa.length-1);
   }

   return stringa;
}


function Emptytext(fform)
{
   var nflds = 0;
   var nempty = 0;

   with(fform)
   for (var i=0; i<elements.length; i++) {
        if (elements[i].type.search(/text|password|file/i) != -1) {
            nflds++;

            if (elements[i].value == "") {
                nempty++;
            }
        }
   }

   if (nempty == nflds) {
       alert("Inserire un parametro di ricerca");
       return true;
   }
   else if (nempty != 2)  {
       alert("Inserire un solo parametro di ricerca");
       return true;
   }
   return false;
}


function Checkdigit(fld)
{
   if ( (fld.value.search(/\D{1,}/) != -1) ) {
         alert("Il campo '"+ fld.title +"' può contenere solo caratteri numerici");
         fld.focus();
         return true;
   }

   if ( (fld.value.substring(0,1) != "0") && (fld.value.substring(0,1) != "3") ) {
         alert("Il campo '"+ fld.title +"' deve appartenere a numerazione fissa o mobile");
         fld.focus();
         return true;
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
   return false;
}


function CheckInvia(pForm)
{
   with(pForm) {
        alias.value=trim(alias.value);
        msisdn.value=trim(msisdn.value);

        if (Emptytext(pForm)) {
            return false;
        }

        if ( ((alias.value.length == 0) && (allegato.value.length == 0)) &&
             (Checkdigit(msisdn) || ControlloLunghezzaMsisdn(msisdn,"msisdn"))
           )
        {
            return false;
        }

        if ( (msisdn.value != "") || (alias.value != "") ) {
            action="php/profilo.php";
        }
        else if (allegato.value != "") {
            action="php/profilofile.php";
        }

        submit();
        return true;
   }
}
//-->
</script>

<BODY onload="document.form1.msisdn.focus();">
<form name="form1" action="php/profilo.php" method="post" enctype="multipart/form-data">
<table width="100%" height="100%">
  <tr><td height="20%">&nbsp;</td></tr>
  <tr><td height="40%" align="center">

    <table height="100%" border=1 cellspacing=0>
    <tr><td>

      <table height="100%" cellpadding=6>
        <tr>
          <td align="right"><B>MSISDN&nbsp;&nbsp;+39</B></td>
          <td><input name="msisdn" maxlength=11 size=12 title="MSISDN" value="" type="text"></td>
        </tr>
        <tr>
          <td align="center"><B>ALIAS</B></td>
          <td><input name="alias" maxlength=255 size=12 value="" type="text"><B>&nbsp;@tim.it</B></td>
        </tr>
         <tr>
          <td>Preleva da file:</td>
          <td><input type="file" name="allegato"></td>
        </tr>
        <tr>
          <td colspan=2 align="center"><input type="submit" name=ricerca value="Ricerca" onclick="return CheckInvia(document.form1);"></td>
        </tr>
      </table>

    </td></tr>
    </table>

  </td></tr>
  <tr><td height="40%" align="center">Inserire un parametro di ricerca (Msisdn o Alias)</td></tr>
</table>
</form>
</BODY>

</HTML>
