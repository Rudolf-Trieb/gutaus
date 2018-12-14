<?php

include('include_0_db_conektion.php');

// Variable zur Sicherheit auf 0 setzen
$x = "";
 
// herausfinden ob Dateien verfallen sind
$sql = "SELECT * FROM anzeigen ";
$result = mysql_query($sql);
$num = mysql_num_rows($result);
for ($i = 0; $i < $num; $i++){
  $row = mysql_fetch_array($result);
  $jetzt = time();
  // ist Datei verfallen?
  $id_anz = $row['id_anz'];
  $verfall = $row['verfall'];
  if ($verfall > $jetzt) {$x = "druck";}
  else {$x = "loesch";}
  // wenn verfallen, loeschen
  if ($x == "loesch") {
    $sql = "DELETE FROM anzeigen WHERE id_anz = '".$id_anz."'";
    mysql_query($sql);
  }
}
?>
<h2>Marktplatz</h2> 
<table width="100%" summary="Die einzelnen Anzeigen">
  <colgroup>
    <col width="90" />
    <col />
    <col />
    <col width="90" />
  </colgroup>
 
<?php
// Verbindung mit anzeigen fuer Eintraege anzeigen
$sql = "SELECT *, DATE_FORMAT(datum,'%d.%m.%y') AS datum_f
FROM anzeigen ORDER BY datum DESC";
$result = mysql_query($sql);
$num = mysql_num_rows($result);
for ($i = 0; $i < $num; $i++){
  $row = mysql_fetch_array($result);
  echo '
 <tr class="bgweiss">
   <td><p><strong>  '.$row['art'].'</strong></p></td>
   <td colspan="2"><p><strong>  '.$row['titel'].'</strong></p></td>
   <td>
     <p class="kl center">'.$row['datum_f'].'</p>
   </td>
 </tr>
 <tr>
   <td> &#160; </td>
   <td colspan="2">'.nl2br($row['anzeige']).'</td>
   <td class="center">
 ';
  if ($row['email'] != ""){
    $id_anz = $row['id_anz'];
    echo '
     <form action ="php_anzeigen_mail.php" method ="post">
        <input type="hidden" name="id_anz" value="'.$id_anz.'" />
        <input class="norm" type="submit" value="email" />
     </form>
   ';
  }
  echo '
   </td>
 </tr>
 <tr>
   <td> &#160; </td>
   <td class="bgweiss"> &#160;
     <p class="kl">'.$row['vname'].' '.$row['nname'].', '.$row['ort'].'</p>
   </td>
   <td class="bgweiss">
     <p class="kl"> &#160;
 ';
  if ( $row['tel'] != "" ){
    echo 'Tel: '.$row['tel'] ;
  }
  echo '
     </p>
   </td>
   <td> &#160; </td>
 </tr>
 <tr>
   <td colspan="4"><hr /></td>
 </tr>
 ';
}
?>
</table>
 
<!--
Quelle Script: http://www.zudila.ch/scripte/php_anzeigen.php
Zudila Kleinanzeigen v1.2, GPL
-->



