<?php
require 'auth.php';
if (!ck_sessione())
   exit;
if (!strstr($_SESSION['perms'],'D')&&(!strstr($_SESSION['perms'],'@')))
{
  $_SESSION['orario']=date('U');
    ?>
      <script language="javascript">  top.location="/profilo/index.php" </Script>
    <?
}
  // Prelevo i campi del form relativi all'allegato
  $tipout=$_POST[tipomem];
  require 'file_conf';
  $allegato = $_FILES['allegato']['tmp_name'];
  $user=$_SESSION['usersess'];
  $data_trans=date("H:i:s");
  system("find $temp -mtime +5 -exec rm {} \;");
  // Verifico se il file è stato correttamente scaricato via HTTP
  if (is_uploaded_file($allegato)) 
  {
    // CREAZIONE FILE DI OUTPUT
    $nomef="ristut_".$user."_".$data_trans.".rtf";
    $nome_file=$temp.$nomef;
    $file_log=fopen("$nome_file","w");
    $prid='13';
    $lista=fopen($allegato,"r");
  // Connessione per il reset ST
    $fpst = fsockopen ($host_stmem, $port_stmem) or die("$errno : $errstr") ;
    socket_set_blocking($fpst , TRUE);
    $stringa_stmem=str_replace("service:","service:".$tipout, $stringa_stmem);
    while(!feof($lista))
    {
      $ntel=fgets($lista, 255);
      $ntel=trim($ntel); 
      if ($ntel)
      {
        $stringa_stappo=str_replace("accountid:","accountid:".$ntel, $stringa_stmem);
        fputs($fpst,$stringa_stappo);
        $line = fread($fpst,1024);
        $sc=split("\n",$line);
        while (list($arg, $val) = each($sc))
        {
          list($argomento,$valore)=split(':',$val);
          if ($argomento == "rstring")
            $risposta=$valore;
          elseif ($argomento == "estring")
            $risposta=$valore;
         }
        $esito=$ntel." ".$risposta."\n";                         
        fwrite($file_log,$esito);
      }
    }  
    fclose($file_log); 
    fclose($lista);
    fclose($fpst);
    $dimensioni_file=filesize($nome_file); 
    if ($dimensioni_file > 0)
    {
      ?>
      <HTML>
      <BODY>
      <TABLE BORDER=1 WIDTH=40% VALIGN=CENTER ALIGN=CENTER>
      <TR><TH>Fai clic sul link per scaricare il file di report</TH></TR>
      <tr><td>
      <?
        print "<a href='../../profilo/tmp/$nomef'>$nomef</a>";
      ?>
      </td></tr>
      </TABLE>
      </BODY>
      </HTML>
      <?
    }
  }
  else {
    echo "<p>Errore nell'upload del file!</p>";
  }
?>
