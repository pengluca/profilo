<?
require 'auth.php';
if (!ck_sessione())
   exit;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="-1">


<body onLoad="document.loginForm.submit();" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
<? $msisdn=$HTTP_GET_VARS[msisdn];
   $passwd=$HTTP_GET_VARS[passwd];
?>
<title>Tim - Webmail Utenza <?=$msisdn?></title>
</head>
<form name="loginForm" action="http://webmail.posta.tim.it/login" method="POST">
<input type="hidden" name="servizio" value="mail">
<input type="hidden" name="sottoservizio" value="mail">
<input type="hidden" name="useWhiteList" value="0">
<input type="hidden" name="msisdn" value="<?=$msisdn?>">
<input type="hidden" name="password" value="<?=$passwd?>">
</form>
</body>
</html>
