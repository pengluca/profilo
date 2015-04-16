<?
require 'auth.php';
session_start();
$_SESSION['usersess']=$_POST['username'];
$_SESSION['pwd']=$_POST['password'];
$conndb=mysql_connect("localhost","root","root");
mysql_select_db ("B_O_T", $conndb) or die("Connessione non riuscita al db di autenticazione: " . mysql_error());
$laselect="select * from utenti where usersess='".$_SESSION['usersess']."' and pwd='".$_SESSION['pwd']."'";
$ris=mysql_query($laselect, $conndb);
$num_righe = mysql_num_rows($ris);
if ($num_righe)
{
  $rga = mysql_fetch_row($ris);
  for ($i=0; $i < count($rga); $i++)
  {
    $campo=mysql_field_name($ris, $i);
    $_SESSION[$campo]=$rga[$i];
  }
  if ($_SESSION['stato'] !== 'S')
    ck_sessione("Utente disattivo!"); 
  else
  {
    $_SESSION['orario']=date('U');
    ?> 
      <script language="javascript">  
             alert("Questo sistema e' proprietà privata ad uso del solo personale autorizzato. Gli utenti (autorizzati o NON autorizzati) non hanno esplicita o implicita aspettativa di privacy. Tutti gli usi di questo sistema ed i dati presenti in esso possono essere intercettati, monitorati, registrati, copiati, analizzati, ispezionati dal proprietario del sito. Usando questo sistema, l'utente consente che tali intercettazioni, registrazioni, copie, analisi ed ispezioni siano effettuate a discrezione del proprietario. L'uso non autorizzato o improprio di questo sistema può provocare l'azione disciplinare amministrativa nonché sanzioni civili e penali. Continuando ad usare questo sistema indicate la vostra consapevolezza ed acconsentite questi termini e le condizioni di uso. CHIUDERE IMMEDIATAMENTE il collegamento se in disaccordo con quanto dichiarato in questo avvertimento.");
             top.location="/profilo/index.php" 
      </Script>
    <?
  }
} 
else
{
  ck_sessione("Login Errata!");
}
mysql_close($conndb);
?>
