<?
require 'php/auth.php';
session_start();
if (!ck_sessione())
   exit;
?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<HTML>

<HEAD>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <title>Profilo v. 2.7.0</title>
</HEAD>
<frameset rows="15%,*">
   <frame name="top" src="top.html" marginwidth=10 marginheight=10 scrolling="no" frameborder=0 noresize>
   <frameset cols="1%,22%,*">
      <frameset rows="19%,*">
         <frame marginwidth=10 marginheight=1 scrolling="no" frameborder=0 noresize>
         <frame marginwidth=1 marginheight=1 scrolling="no" frameborder=0 noresize>
      </frameset>    

      <frameset rows="19%,*">
         <frame name="topmenu" src="topmenu.htm" marginwidth=10 marginheight=1 scrolling="no" frameborder=0 noresize>
         <frame name="menu" src="menu.php" marginwidth=1 marginheight=1 scrolling="no" frameborder=0 noresize>
      </frameset>    
      <frameset rows="13%,*">
         <frame name="title" src="title.php" marginwidth=10 marginheight=1 scrolling="no" frameborder=0 noresize>
         <frame name="main" src="blank.php" marginwidth=1 marginheight=1 scrolling="auto" frameborder=0 noresize>
      </frameset>
   </frameset>
</frameset>
<NOFRAMES>
<BODY>
Questa pagina e' sviluppata per essere utilizzata soltanto in un browser che supporta i frame.
</BODY>
</NOFRAMES>

</HTML>
