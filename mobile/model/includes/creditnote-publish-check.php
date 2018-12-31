<?php
//**********************************************************************************************************************************************************
// GUTSCHEIN-NAME PRÜFEN ***********************************************************************************************************************************
//**********************************************************************************************************************************************************
//	Gutscheiname eingegeben ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     if($_SESSION['creditnote_publish_name']=='') {
           $errors[]='Bitte geben Sie einen Gutscheinnamen ein.';
	 }
	 else	// creditnote_publish_name is set
	 {
//	check creditnote_publish_name length+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		 if(strlen($_SESSION['creditnote_publish_name'])>20) {
			   $errors[]='Ihr Gutscheinname ist zu lang. Bitte geben Sie maximla 20 Zeichen ein.';
		 }
		 else 
		 {
//	Gutscheibegriffe MINUTO und EURO sind geschützt +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			if($_SESSION['creditnote-publish-type']=='Minuto') {// Minuto 
				if($_SESSION['creditnote_publish_name']<>($_SESSION["user_name"].'-Minuto'))
					$errors[]='Muss bei GuTauS aus Ihren Mitgliedsnamen mit der Endung "-Minuto" zusamengesetzt sein. Ihr Minuto muss also '.$_SESSION["user_name"].'-Minuto benannt werden';	
			}
				elseif($_SESSION['creditnote-publish-type']=='Euro') { // Euro
					if($_SESSION['creditnote_publish_name']<>($_SESSION["user_name"].'-Euro'))
						$errors[]='Muss bei GuTauS aus Ihren Mitgliedsnamen mit der Endung "-Euro" zusamengesetzt sein. Ihr Euro muss also '.$_SESSION["user_name"].'-Euro benannt werden';	
			}
				else 	// Goods or Service    
			{
				$Minuto_pos=strpos(strtoupper($_SESSION['creditnote_publish_name']), 'MINUTO');
				$Euro_pos=strpos(strtoupper($_SESSION['creditnote_publish_name']), 'EURO');
//				echo "NAME_Euro:".$Euro;
//				echo "NAME_Minuto:".$Minuto;
				if($Minuto_pos<>0)
					$errors[]='Der Begriff MINUTO darf bei GuTauS nur in Minuto-Gutscheinen enthalten sein. Bitte wähelen Sie ggf. die Gutscheinart MINUTO aus oder meiden Sie den Begriffe MINUTO in Ihrem Gutscheinnamen.';	
				elseif($Euro_pos<>0)
					$errors[]='Der Begriff EURO darf bei GuTauS nur in Euro-Gutscheinen enthalten sein. Bitte wähelen Sie ggf. die Gutscheinart EURO aus oder meiden die diese Begriffe EURO in Ihrem Gutscheinnamen.';	
			}
		 }
	 }
//	Gutscheiname in DB prüfen ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	if(ermittle_Einheit_ID($_SESSION['creditnote_publish_name'])<>0)
		   $errors[]='Ihr Gutscheinname '.$_SESSION['creditnote_publish_name'].' ist bereits bei GuTauS vergeben!';
	
	
//**********************************************************************************************************************************************************			   
// GUTSCHEIN-WERT PRÜFEN ***********************************************************************************************************************************
//**********************************************************************************************************************************************************
	if($_SESSION['creditnote-publish-type']<>'Minuto' and $_SESSION['creditnote-publish-type']<>'Euro')		
		if($_SESSION['creditnote_publish_value']=='')
			   $errors[]='Sie habe den Wert Ihres '.$_SESSION['creditnote_publish_name'].'-Gutscheines nicht festgelegt!';
		   
		   
//**********************************************************************************************************************************************************
// HERAUSGABE MENGE PRÜFEN *********************************************************************************************************************************
//**********************************************************************************************************************************************************
	if (!is_int ($_SESSION['creditnote_publish_credit_limit_user']))
		$errors[]='Die maximal Anzahl der '.$_SESSION['creditnote_publish_name'].'-Gutscheine die Sie in den Umlauf brigen wollen muss ein  ganzzahliger Werte sein!';
	elseif ($_SESSION['creditnote_publish_credit_limit_user']*(-1)<20) 
		$errors[]='Die maximal Anzahl der '.$_SESSION['creditnote_publish_name'].'-Gutscheine die Sie in den Umlauf brigen wollen sollte min. 20 betragen!';
	elseif ($_SESSION['creditnote_publish_credit_limit_user']*(-1)>1000000) 
		$errors[]='Die maximal Anzahl der '.$_SESSION['creditnote_publish_name'].'-Gutscheine die Sie in den Umlauf brigen wollen sollte max. 1.000.000 betragen!';
		
//**********************************************************************************************************************************************************
// HERAUSGABE MEMBER PRÜFEN ********************************************************************************************************************************
//**********************************************************************************************************************************************************
	if (!is_int ($_SESSION['creditnote_publish_credit_limit_member']))
		$errors[]='Die Anzahl der Gutscheien die eine Person, die ein '.$_SESSION['creditnote_publish_name'].'-Konto durch Erst-Überweisung eröffnet bekommen, muss ein ganzzahliger Wert sein! 0 ist hierür  der empfohlene Wert!';
	elseif ($_SESSION['creditnote_publish_credit_limit_user']*(-1)>1000000) 
		$errors[]='Die Anzahl der Gutscheien um die eine Person, die ein '.$_SESSION['creditnote_publish_name'].'-Konto durch Erst-Überweisung eröffnet bekam, diese Konto überziehen darf, sollte max. 1.000.000 betragen!';
//**********************************************************************************************************************************************************
// NACHKOMMASTELLEN PRÜFEN *********************************************************************************************************************************
//**********************************************************************************************************************************************************
//echo "user=".$_SESSION['creditnote_publish_credit_limit_user']."/n";	
//echo "member=".$_SESSION['creditnote_publish_credit_limit_member']."/n";	
//echo "digits=".$_SESSION['creditnote-publish_digits']."/n";
//echo "privat=".$_SESSION['creditnote_publish_privat']."/n";
	if (!is_int ($_SESSION['creditnote-publish_digits']))
		$errors[]='Die Anzahl der Nachkommastellen Ihrer'.$_SESSION['creditnote_publish_name'].'-Gutscheine, muss ein ganzzahliger Wert sein! Wählen Sie 0, wenn Sie nur mit ganzen Gutscheien handeln wollen.';
	elseif ($_SESSION['creditnote-publish_digits']>7) 
		$errors[]='Die Anzahl der Nachkommastellen Ihrer'.$_SESSION['creditnote_publish_name'].'-Gutscheine, darf maximal 7 sein!';
//**********************************************************************************************************************************************************
// PRIVAT ODER ÖFFENDLICH WENN nicht PRIVAT DANN 0 = ÖFFENDLICH SETZEN ***************************************************************************************************************************
//**********************************************************************************************************************************************************
if($_SESSION['creditnote_publish_privat']<>'true')
	$_SESSION['creditnote_publish_privat']='false';





?>