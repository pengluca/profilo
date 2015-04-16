<?
require 'php/auth.php';
if (!ck_sessione())
   exit;
if (!strstr($_SESSION['perms'],'D')&&(!strstr($_SESSION['perms'],'@')))
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
  <title>Impostazione Stutter Tone</title>
</HEAD>

<script Language="Javascript">
//<!-- 
function Emptytext(fform)
{
   var nflds = 0;
   var nempty = 0;

   with(fform)
   for (var i=0; i<elements.length; i++) {
        if (elements[i].type.search(/text|file/i) != -1) {
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
   else if (nempty == 0) {
       alert("Inserire un solo parametro di ricerca");
       return true;
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
       alert("la lunghezza del campo "+nomeCampo+" deve essere tra gli 8 e gli 11 caratteri");
       campo.focus();
       campo.value="";
       return true;
   }
   if (string.substring(0,1) != "0")
   {
       alert(nomeCampo+" deve contenere una numerazione di rete fissa");
       campo.focus();
       campo.value="";
       return true;
   }
   return false;
}


function CheckInvia(pForm) 
{
   var o = pForm;
   if ( Emptytext(pForm) || 
        ( (o.allegato.value.length == 0) && 
          (Checkdigit(pForm) || ControlloLunghezzaMsisdn(o.msisdn,"msisdn"))
        )
      )
   {
      return false; 
   }

   if (o.msisdn.value != "") {
       o.action="php/modstutter.php";
   }
   else if (o.allegato.value != "") {
       o.action="php/modstuttfile.php";
   }
   o.allinea.disabled = true;
   o.submit();
   return true;
}
//-->
</script>

<BODY onload="document.form1.msisdn.focus();">
<form name="form1" onSubmit="return CheckInvia(document.form1);" method="POST" enctype="multipart/form-data">
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
          <td>Preleva da file:</td>
          <td><input type="file" name="allegato"></td>
        </tr>
        <tr>
          <td><B>Tipo Utenza </B></td>
          <td><B><input type="radio" name="tipomem" value="memotel" checked>Memotel
              <input type="radio" name="tipomem" disabled value="405">405</B></td>
        </tr>
        <tr>
          <td colspan=2 align="center"><input type="submit" value="Allinea" name="allinea"></td>
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
