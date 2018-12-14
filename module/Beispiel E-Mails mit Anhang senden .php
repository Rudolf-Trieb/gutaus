<?php
// E-Mails mit Anhang senden  
// Nur einfache Mails zu senden ist in einigen Fällen nicht genug - ein Anhang soll mitgeschickt werden. Hierzu sind etwas weitreichendere Änderungen am bestehenden Skript nötig. Schauen wir uns dazu zunächst das fertige Skript an:

  $Empfaenger = "777horus@gmail.com";
  $Betreff = "Mail mit Anhang";
  $DateinameMail = "text.pdf";
  $h = fopen("./test.gif", 'rb');
  $filecontents = fread($h, filesize("./test.gif"));

  $Trenner = md5(uniqid(time()));

  $Header = "From: meinname@meinedomain.de\n";
  $Header .= "MIME-Version: 1.0\n";
  $Header .= "Content-Type: multipart/mixed; boundary=$Trenner\n";
  
  
  		$Header  = "From: PHP Email Tutorial<777horus@gmail.com>\r\n";
		$Header .= "Reply-To: GutscheinTauschSystem GuTauS<777horus@gmail.com>\r\n"; //Bei Antwort
		$Header .= "Return-Path: 777horus@gmail.com\r\n"; // Bei Unzustellbarkeit
		$Header .= "MIME-Version: 1.0\r\n";
		$Header .= "Content-Type: multipart/mixed; boundary=$Trenner\r\n";
		$Header .= "Content-Transfer-Encoding: 8bit\r\n";
		$Header .= "Message-ID: <" .time(). " 777horus@gmail.com>\r\n";
		$Header .= "X-Mailer: PHP v" .phpversion(). "\r\n\r\n";

  $text = "This is a multi-part message in MIME format\n";
  $text .= "--$Trenner\n";
  $text .= "Content-Type: text/plain\n";
  $text .= "Content-Transfer-Encoding: 8bit\n\n";
  $text .= $text."\n";
  $text .= "--$Trenner\n";
  $text .= "Content-Type: image/gif; name=$DateinameMail\n";
  $text .= "Content-Transfer-Encoding: base64\n";
  $text .= "Content-Disposition: attachment; ".
           "filename=$DateinameMail\n\n";
  $text .= chunk_split(base64_encode($filecontents));
  $text .= "\n";
  $text .= "--$Trenner--";

  mail($Empfaenger, $Betreff, $text, $Header);


/*Das Verfahren ist recht einfach: Soll ein Anhang verschickt werden, wird die Mail als Multipart-Mail definiert - d.h. sie besitzt mehrere Teile (eben multi-part). Dazu wird den Header-Daten zwei Zeilen übergeben die dies definieren: einmal die Mime-Version und einmal der Content-Type mit dem entsprechenden Wert multipart/mixed. Außerdem wird beim Content-Typ auch der Trenner beschrieben (boundary=...) - eine einfache Zeichenfolge die zwischen den einzelnen Bestandteilen der Mail für Trennung sorgt. 
Der Inhalt der Mail ($text) wird dann entsprechend erweitert. Zum normalen Inhalt werden, begetrennt durch unseren Trenner, die neuen Bestandteile angefügt: Zunächst der Text ($text) und anschließend der Dateiinhalt ($filecontens) in Base64-Codierung. Letzteres ist notwendig um die Mail auch mit Anhang korrekt versenden zu können.
Alles zusammen wird wieder an die mail-Funktion übergeben und entsprechend verschickt.
*/
?>