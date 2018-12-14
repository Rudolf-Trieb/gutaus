<?php 
    //SESSION
    session_start();
	header("Content-Type: text/html; charset=ISO-8859-1");
	include_once('include_0_db_conektion.php');
?>


<?php
    echo "<h2>Halbe Deals (Wechselkurse zum ".$_SESSION['Einheit'].")</h2>";
    // Prüfen, ob das Formular gesendet wurde
    if(isset($_POST['submit']) AND $_POST['submit']=='Entscheidung Senden') {
        if ($_POST['Zustimmung']=="Ja") {
            echo "Dem Deal <b>".$_POST['deal_wk_eigen']." ".$_SESSION['Einheit']
                 ." = ".$_POST['deal_wk_fremd']." ".$_POST['deal_einheit_fremd']
                 ."</b> wurde von Ihnen zugestimmt!";
            // Deal-Vorschlag IN DB ändern ==> Halber Deal bzw. Voller Deal?
            aendere_zustimmung_deal($_POST['deal_ID'],1,1);
            // Formular anzeigen
            include('include_8_halbe_deals_anzeigen.php');            
        }
        elseif ($_POST['Zustimmung']=="Nein") {
            echo "Der Deal <b>".$_POST['deal_wk_eigen']." ".$_SESSION['Einheit']
                 ." = ".$_POST['deal_wk_fremd']." ".$_POST['deal_einheit_fremd']
                 ."</b> wurde von Ihnen abgelent!";
            // Gegenforschlags-Formular
            include('include_8_gegenforschlag_formular.php');            
        } 
        else {
            echo "Fehler: Bitte entscheiden sie sich ob sie den Deal <b>".$_POST['deal_wk_eigen']." ".$_SESSION['Einheit']
                 ." = ".$_POST['deal_wk_fremd']." ".$_POST['deal_einheit_fremd']
                 ."</b> zustimmen oder ihn ablehnen!";
            // Formular anzeigen     
            include('include_8_halbe_deals_anzeigen.php');
        }
   
    }
    else 
        // Formular anzeigen
        include('include_8_halbe_deals_anzeigen.php');
?>