<?
session_start();
$tel=$_POST[telefono];
$em=$_POST[email];
$pwd=$_POST[nuova];
$conndb=mysql_connect("localhost","root","root");
mysql_select_db ("B_O_T", $conndb) or die("Connessione non riuscita al db di autenticazione: " . mysql_error());
$laselect="update utenti set telefono='".$tel."',email='".$em."',pwd='".$pwd."' where usersess='".$_SESSION['usersess']."'";
$ris=mysql_query($laselect, $conndb);
if ($ris)
{
#Aggiorno le variabili di sessione
  $_SESSION['orario']=date('U');
  $_SESSION['telefono']=$tel;
  $_SESSION['email']=$em;
  ?> 
    <script language="javascript">  
       alert("Impostazione eseguita"); 
       top.location="/profilo/index.php"
    </Script>
  <?
} 
mysql_close($conndb);
?>
