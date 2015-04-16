<?
$azione=$_GET['azione'];
session_start();
if ($azione) 
{
  session_destroy();
  bld_html();
}
function ck_sessione($mex='')
{
  if ((isset($_SESSION['orario']))&&(isset($_SESSION['usersess'])))
  {
       $cktim=$_SESSION['orario'];
       $difftime=date('U')-$cktim;
       if ($difftime>3600)
       { 
           session_destroy();
           bld_html("Sessione Scaduta!");
           return false;
       }
       else
       {
           $_SESSION['orario']=date('U');
           return true;
       }
  }
  else 
  {
       bld_html($mex);
       return false;
  }
}



function bld_html($err='')
{
   ?> <html>
      <body onload="document.autentica.username.focus();">
      <font face='Arial'>
      <form name="autentica" action="/profilo/php/login.php" method="POST">
      <table width="100%" height="100%">
        <tr><td height="20%">&nbsp;</td></tr>

        <tr><td height="50%" align="center">
          <table height="100%" border=0 cellpadding="0" cellspacing="0">
          <tr><td>
            <strong>Area accesso BOT:</strong>
            <hr align="left" width="100%" color="#DC013B">
            <p><font size=1>Inserisci le tue credenziali:</font></p>

            <table height="50%" cellpadding="5" cellspacing="0" border=0>
              <tr>
                <td align="right">User Name&nbsp;&nbsp;</td>
                <td><input type="text" name="username" maxlength=15 size=16 value=""></td>
              </tr>
              <tr>
                <td align="center">Password</td>
                <td><input type="password" name="password" maxlength=12 size=16 value=""></td>
              </tr>
              <tr>
                <td colspan=2 align="center"><input type="submit" value="Login"></td>
              </tr>
            </table>

            <hr align="left" width="100%" color="#DC013B">
          </td></tr>
          </table>
        </td></tr> 

        <tr><td height="30%" align="center" valign="top">
            <script language="JavaScript">
                //if (window.location.search != "") {
                //    myerr=unescape(window.location.search.substring(1, window.location.search.length));
                //}
                document.write("<font color='#DC013B'><strong> <?print $err;?> </strong></font>");
            </script>
        </td></tr>
      </table>
      </form>
      </font>
      </body>
      </html> <?
}
?>
