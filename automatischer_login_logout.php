<?php 
    //SESSION
    session_start(); 
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
?>


<?php

    // Autologin Cooki Löschen wenn sich User ausslogt
    if (!$_SESSION['UserID']) {
     if(isset($_COOKIE['Autologin']))
         setcookie("Autologin", "", time()-60*60);
    }

    // Wenn 'eingeloggt bleiben' aktiviert wurde
        if(isset($_POST['Autologin'])){
            // Zufallscode erzeugen
            $part_one = substr(time()-rand(100, 100000),5,10);
            $part_two = substr(time()-rand(100, 100000),-5);
            $Login_ID = md5($part_one.$part_two);
            // Code im Cookie speichern, 10 Jahre dürfte genügen
            setcookie("Autologin", $Login_ID, time()+60*60*24*365*10);
            $sql = "UPDATE
                            mitglieder
                    SET
                            Autologin = '".$Login_ID."'
                    WHERE
                            ID = '".$ID."'
                   ";
            mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        }  


    // Prüfen, ob ein Autologin des Users stattfinden muss 
    if(isset($_COOKIE['Autologin']) AND !isset($_SESSION['UserID'])){ 
        $sql = "SELECT 
                        ID 
                FROM 
                        mitglieder 
                WHERE 
                        Autologin = '".mysql_real_escape_string($_COOKIE['Autologin'])."'
               "; 
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 
        $row = mysql_fetch_assoc($result); 
        if(mysql_num_rows($result) == 1) {
           doLogin($row['ID'], '1');
           $_SESSION['angemeldet']=true;
           $_GET['LoginStatus']=1;
           $_SESSION['Content_Ebene_0']='Kontostand'; 
        } 
             
    } 



    // Online Status der User aktualisieren 
    if(isset($_SESSION['UserID'])){ 
        $sql = "UPDATE 
                        mitglieder 
                SET 
                        Letzte_Aktion = '".time()."' 
                WHERE 
                        ID = '".$_SESSION['UserID']."' 
               "; 
        mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 
    }
    
    // User ohne Autologin ausloggen die Lämger 20min inaktiv waren 
    $sql = "UPDATE 
                    mitglieder 
            SET 
                    SessionID = NULL, 
                    Autologin = NULL, 
                    IP = NULL 
            WHERE 
                    '".(time()-60*20)."' > Letzte_Aktion AND     
                    Autologin IS NULL 
           "; 
    mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 
    
  
     // Kontrollieren, ob ein automatisch ausgeloggter User noch eine gültige Session besitzt
    if(isset($_SESSION['UserID'])){ 
        $sql = "SELECT 
                        SessionID 
                FROM 
                        mitglieder 
                WHERE 
                        ID = '".$_SESSION['UserID']."' 
               "; 
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 
        $row = mysql_fetch_assoc($result);
        // Wenn keine SessionID dann ist User ausgelogt und seien Sesssion wird zerstört 
        if(!$row['SessionID']){ 
            $_SESSION = array(); 
            session_destroy(); 
        }
    }  
?>