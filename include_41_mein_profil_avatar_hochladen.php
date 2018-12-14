<?php 
    //SESSION
    session_start(); 
	include('include_0_db_conektion.php');
?>



<?php
// Avatar hochladen 

    $errors = array();
    // Uploadfehler prüfen
    switch ($_FILES['pic']['error']){
        case 1: $errors[] = "Bitte w&auml;hlen Sie eine Datei aus, die kleiner als 4 MB ist.";
                            break;
        case 2: $errors[] = "Bitte w&auml;hlen Sie eine Datei aus, die kleiner als 4 MB ist.";
                            break;
        case 3: $errors[] = "Die Datei wurde nur teilweise hochgeladen.";
                            break;
        case 4: $errors[] = "Es wurde keine Datei ausgew&auml;hlt.";
                            break;
        default : break;
    }
    // Prüfen, ob eine Grafikdatei vorliegt
    if(!@getimagesize($_FILES['pic']['tmp_name']))
        $errors[] = "Ihre Datei ist keine g&uuml;ltige Grafikdatei.";
    else {
        // Mime-Typ prüfen
        $erlaubte_typen = array('image/pjpeg',
                                'image/jpeg',
                                'image/gif',
                                'image/png'
                               );
        if(!in_array($_FILES['pic']['type'], $erlaubte_typen))
            $errors[] = "Der Mime-Typ ihrer Datei ist verboten.";

        // Endung prüfen
        $erlaubte_endungen = array('jpeg',
                                   'jpg',
                                   'gif',
                                   'png'
                                  );
        // Endung ermitteln
        $endung = strtolower(substr($_FILES['pic']['name'], strrpos($_FILES['pic']['name'], '.')+1));
            if(!in_array($endung, $erlaubte_endungen))
                $errors[] = "Die Dateiendung muss .jpeg .jpg .gif oder .png lauten ";

        // Ausmaße prüfen
        $size = getimagesize($_FILES['pic']['tmp_name']);
            if ($size[0] > 4000 OR $size[1] > 4000)
                $errors[] = "Die Datei darf maximal 4000 Pixel breit und 4000 Pixel hoch sein.";
    }
    // Dateigröße prüfen
    if($_FILES['pic']['size'] > 40.0*1024*1024)
        $errors[] = "Bitte w&auml;hlen Sie eine Datei aus, die kleiner als 4MB ist.";

    if(count($errors)){
        echo "Ihr Avatar konnte nicht gespeichert werden.<br>\n".
             "<br>\n";
        foreach($errors as $error)
            echo $error."<br>\n";
        echo "<table><tr><td>";
		include("include_41_mein_profil_avatar_formular.php");
		echo "</td></tr></table>";
    }
    else {
        // Bild Verkleinern
        include('./module/SimpleImage.php');
        $image = new SimpleImage();
        $image->load($_FILES['pic']['tmp_name']);
        $image->resizeToWidth(210);
        $image->save($_FILES['pic']['tmp_name']);
        
        // Bild auf dem Server speichern
        $uploaddir = 'avatare/';
        // neuen Bildname erstellen
        $Name = "IMG_".substr(microtime(),-8).".".$endung;
        if (move_uploaded_file($_FILES['pic']['tmp_name'], $uploaddir.$Name)) {
            $sql = "UPDATE
                            mitglieder
                    SET
                            Avatar = '".mysql_real_escape_string(trim($Name))."'
                    WHERE
                            ID = ".$_SESSION['UserID']."
                   ";
            mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
			$_SESSION['Avatar']=trim($Name);
            echo "Ihr Avatar wurde erfolgreich gespeichert.<br>\n"; 
        }
        else {
            echo "Es trat ein Fehler auf, bitte versuche es sp&auml;ter erneut.<br>\n";
            echo "<table><tr><td>";
			include("include_41_mein_profil_avatar_formular.php");
			echo "</td></tr></table>";
        }
    }
         
?>