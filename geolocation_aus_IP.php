<?php
########################### 
# Funktionsaufbau 
########################### 
/* 
Parameter 1 = IP-Adresse 
Parameter 2 = gewünschter Rückgabewert (Outcome) 
Die beiden Parameter werden durch ein Komma "," getrennt 
 -> Funktion = geo_location(IP-Adresse, Outcome); 


1. Parameter-Liste (IP-Adresse):  

- Standart: $_SERVER['REMOTE_ADDR']  
    -> Die Funktion liest die IP des Besuchers aus und verwendet diese für den GeoLocation-Dienst 
  
 - variable IP-Adresse 
     -> Sie können der Funktion jede beliebige IP-Adresse bergeben: manuell, via Variable etc. 
  
########################### 

2. Parameter-Liste (Outcome):  

- city (Var: $geo_location) !Standard! 
    ->  = z.B. CH: "Thurgau" / USA: "Chicaco, IL" 

- all (Array: $geo_location[]) 
    -> [breitengrad] = "B: Breitengrad" 
    -> [laengengrad] = "L: Breitengrad" 
    -> [city] = CH: "Kanton" / USA: z.B."Chicaco, IL" 
    -> [country_with_code] = z.B."SWITZERLAND (CH)" 
    -> [countrycode] = z.B."(CH)" 

- coordinates (Array: $geo_location[]) 
    -> [breitengrad] = z.B. "B: 41.746" 
    -> [laengengrad] = z.B. "L: -88.3749" 

- country (Var: $geo_location)  
    ->  = z.B. CH: "SWITZERLAND" / USA: "UNITED STATES" 

- countrycode (Var: $geo_location)  
    ->  = z.B. CH: "(CH)" / USA: "USA" 

- country_with_code (Var: $geo_location) 
    ->  = z.B. CH: "SWITZERLAND (CH)" / USA: "UNITED STATES (USA)" 
*/ 


function geo_location($ip = '$_SERVER[\'REMOTE_ADDR\']', $outcome = "city") 
    { 
    // hier kommen die Daten her 
	// http://maps.googleapis.com/maps/api/geocode/json?latlng=49.452030,11.076750&sensor=false
    $file="http://api.hostip.info/get_html.php?ip="; 
    $file.=$ip; 
    $file.="&position=true"; 

    // liest die GeoLocation Daten aus und erstell ein Array ($datei) nach Zeilen (Funktion file();) 
    // Trennt die Strings in die Benötigten Einzelteiel. Et voila... 
    $datei = file($file);  
    $breitengrad=explode(":","$datei[3]"); 
    $langengrad=explode(":","$datei[4]");  
    $city=explode(":","$datei[1]");  
    $country=explode(":","$datei[0]"); 
    $countrycode=explode(" ","$datei[0]");  
    
	//echo $file;
	
    $file2="http://maps.googleapis.com/maps/api/geocode/json?latlng=".$langengrad.",".$breitengrad."&sensor=false";
	$datei2 = file($file2); 
    //echo $datei2;
	 
     // Hier werden nur noch die verschiedenen Ourcome-Parameter (2) vorbereitet (siehe oben) 
      if($outcome=="all") 
         { 
        $geo_location=array();     
        $geo_location[breitengrad]="B: ".$breitengrad; 
        $geo_location[laengengrad]="L: ".$langengrad; 
        $geo_location[city]=$city; 
        $geo_location[country_with_code]=$country; 
        $geo_location[country]=$countrycode; 
        $geo_location[countrycode]=$countrycode; 
         } 
     
     else if($outcome=="coordinates") 
         { 
        $geo_location=array();     
        $geo_location[breitengrad]="B: ".$breitengrad; 
        $geo_location[laengengrad]="L: ".$langengrad; 
         } 
      
     else if($outcome=="city") 
         { 
        $geo_location=$city; 
         } 

    else if($outcome=="countrycode") 
         { 
        $geo_location=$countrycode; 
         } 
      
    else if($outcome=="country") 
         { 
        $geo_location=$countrycode; 
         } 
      
    else if($outcome=="country_with_code") 
         { 
        $geo_location=$country; 
         } 
      
     else 
         { 
        $geo_location=$city; 
         } 
      
    return $geo_location; 
    } 
?>