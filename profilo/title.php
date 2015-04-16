<? session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<HTML>

<HEAD>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <title>Title page</title>
</HEAD>

<BODY>
<table width="100%" height=50 cellspacing=0>
  <tr><td>

    <table BGCOLOR="#EFEFEF" width="100%">
      <tr>
        <td><I><font face="Georgia" size=5 color="#DC013B">

<script language="JavaScript">
   if (window.location.search != "") {
       document.write(unescape(window.location.search.substring(1, window.location.search.length)));
   }
   else {
       document.write(unescape("HOME PAGE"));
   }
</script>

   </font></td><td align=right><B>Utente loggato: </B><? print $_SESSION['usersess'];?></I></td>
      </tr>
    </table>

  </td></tr>
  <tr>
    <td width="100%" height="23" valign="bottom"><img src="img/image008.gif" border="no" width="100%"></td>
  </tr>
</table>
</BODY>
</HTML>
