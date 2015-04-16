<?
require 'php/auth.php';
if (!ck_sessione())
   exit;
$_SESSION['orario']=date('U');
?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<HTML>

<HEAD>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <title>Impostazioni Account</title>
</HEAD>

<script Language="Javascript">
//<!-- 
function ConfermaPassword(campo1,campo2,nomeCampo1,nomeCampo2)
{
   var stringa1 = campo1.value;
   var stringa2 = campo2.value;

   if (stringa1.length != stringa2.length)
   {
       alert("il campo "+nomeCampo2+" non corrisponde al campo "+nomeCampo1+" ");
       campo2.focus();
       campo1.value="";
       campo2.value="";
       return true;
   }
   return false;
}


function Password(campo3,campo4,nomeCampo3,nomeCampo4)
{
   var stringa3 = campo3.value;
   var stringa4 = campo4.value;

   for (var i=0;i < stringa3.length;i++)
   {
        if (stringa3.charAt(i) != stringa4.charAt(i))
        {
            alert("il campo "+nomeCampo3+" non è uguale al campo "+nomeCampo4+" ");
            campo3.focus();
            campo3.value="";
            campo4.value="";
            return true;
        }

   }
   return false;
}


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


function ControlloLunghezzaPassword(campo,nomeCampo)
{
   var string = campo.value;

   if (string.length<8)
   {
       alert("il campo "+nomeCampo+" deve contenere almeno 8 Caratteri");
       campo.focus();
       campo.value="";
       return true;
   }
   return false;
}



function CheckInvia(pForm) 
{
   with(pForm)
   if ( ControlloLunghezzaPassword(nuova,"Nuova Password") ||
        ControlloLunghezzaPassword(conferma,"Conferma Nuova Password") ||
        Password(nuova,conferma,"Nuova Password","Conferma Nuova Password") ||
        ConfermaPassword(nuova,conferma,"Nuova Password","Conferma Nuova Password")
      )
   {
       return false; 
   }
   return true;
}
//-->
</script>

<BODY onload="document.form1.msisdn.focus();">
<form method="post" name="form1" action="php/modacc.php">
<table width="100%" height="100%">
  <tr><td height="20%">&nbsp;</td></tr>
  <tr><td height="50%" align="center">

    <table height="100%" border=1 cellspacing=0>
      <tr><td>

      <table height="100%" cellpadding=6>
        <tr>
          <td align="center"><B><?=$_SESSION['nome']?></td>
          <td align="center"><B><?=$_SESSION['cognome']?></B></td> 
        </tr>
        <tr>
          <td align="left"><B>Matricola</B></td>
          <td><?=$_SESSION['usersess']?></td>
        </tr>
        <tr>
          <td align="left"><B>Telefono</B></td>
          <td><input name=telefono maxlength=11 size=12 value="<?=$_SESSION['telefono']?>" type=text></td>
        </tr>
        <tr>
          <td align="left"><B>Email</B></td>
          <td><input name=email maxlength=40 size=25 value="<?=$_SESSION['email']?>" type=text></td>
        </tr>
        <tr>
          <td align="left"><B>Nuova password</B></td>
          <td><input name=nuova maxlength=12 size=12 value="<?=$_SESSION['pwd']?>" type=password></td>
        </tr>
        <tr>
          <td align="left"><B>Conferma password</B></td>
          <td><input name=conferma maxlength=12 size=12 value="<?=$_SESSION['pwd']?>" type=password></td>
        </tr>
        <tr>
          <td colspan=2 align="center"><input type=submit value=Modifica name="invia" onclick="return CheckInvia(document.form1);"></td>
        </tr>
      </table>

      </td></tr>
    </table>

  </td></tr>
  <tr><td height="30%">&nbsp;</td></tr>
</table>
</form>
</BODY>

</HTML>
