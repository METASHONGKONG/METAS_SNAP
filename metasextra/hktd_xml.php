<?php
 
function getFeed($feed_url, $location_id, $destination_id, $funit,$flang) {
//function getFeed($feed_url) {     
 // $content = file_get_contents($feed_url);
//  $x = new SimpleXmlElement($content);
	
  if (($xml=simplexml_load_file($feed_url)) == FALSE){
	  header('Content-type: text/html');
	  header('Access-Control-Allow-Origin: *'); 
	  echo("HK GOV SERVER ERROR");      
  }
//print_r($xml); 
//print_r( $xml->description->link );

    foreach($xml->children() as $books) { 
  
  
	  if ($books->LOCATION_ID == $location_id && $books->DESTINATION_ID == $destination_id) {
		  header('Content-type: text/html');
		  header('Access-Control-Allow-Origin: *');       
		  
		  if ($funit == "with unit"){ 
			  ($flang == 'tw') ? $unit_text = "分鐘" : (($flang == 'zh') ? $unit_text = "分钟" : $unit_text = "minutes" );
			  echo $books->JOURNEY_DATA . $unit_text;
		  }else{  
			  echo $books->JOURNEY_DATA;
		  }
		//echo $books->LOCATION_ID . ", "; 
	   // echo $books->DESTINATION_ID . ", ";
		
		//echo $books->CAPTURE_DATE . ", ";
		//echo $books->JOURNEY_TYPE . ", ";
		//echo $books->JOURNEY_DATA . ", ";
		//echo $books->COLOUR_ID . "<br>"; 
		//echo ("<br>"); 
	  }
    }
  

}

function inputError(){
		header('Content-type: text/html');
        header('Access-Control-Allow-Origin: *');       
	    echo ("INPUT ERROR");
		exit();
}

$location = $_GET['location'];  
$unit     = $_GET['unit'];  
$lang     = $_GET['lang'];  

$langIndex = NULL;
$langIndex = $lang;

//if($langIndex == NULL || ($langIndex != 'tw' && $langIndex != 'en' && $langIndex != 'zh')) inputError();

//if ($langIndex == 'en' ){
	$location2= str_replace("Tate's", "Tates" ,$location);
	$locationArray = explode(" via ", $location2 );
//}else if ($langIndex == 'tw' ){
	//$location2= str_replace("Tate's", "Tates" ,$location);
	//$locationArray = explode(" 經 ", $location );
//}else if ($langIndex == 'zh' ){
	//$location2= str_replace("Tate's", "Tates" ,$location);
	//$locationArray = explode(" 经 ", $location );
//}
$locationString = $locationArray[0];
$destString = $locationArray[1];
$dectIndex = NULL;
$locationIndex = NULL;


//echo $langIndex . "<br>";
/*
echo $location . "<br>";
echo $locationArray[0] . "<br>";
echo $locationArray[1] . "<br>";
echo $unit . "<br>";
echo $locationString . "<br>";
echo $destString . "<br>";
*/

switch  ($locationString) {
	
		case "Gloucester Road eastbound near the Revenue Tower"                  : $locationIndex =  "H1" ; break;
		case "Canal Road Flyover northbound near exit of Aberdeen Tunnel"        : $locationIndex =  "H2" ; break;
		case "Island Eastern Corridor westbound near City Garden"                : $locationIndex =  "H3" ; break;
		case "Island Eastern Corridor westbound near Lei King Wan"               : $locationIndex =  "H11"; break; 
		case "Ferry Street southbound near Charming Garden"                      : $locationIndex =  "K01"; break;
		case "Gascoigne Road eastbound near the Hong Kong Polytechnic University": $locationIndex =  "K02"; break;
		case "Waterloo Road southbound near Kowloon Hospital"                    : $locationIndex =  "K03"; break;
		case "Princess Margaret Road southbound near Oi Man Estate"              : $locationIndex =  "K04"; break;
		case "Kai Fuk Road northbound near the petrol stations"                  : $locationIndex =  "K05"; break;
		case "Chatham Road North southbound near Fat Kwong Street Playground"    : $locationIndex =  "K06"; break;
		case "Tai Po Road – Sha Tin near the Racecourse"                         : $locationIndex =  "SJ1"; break;
		case "Tates Cairn Highway near Shek Mun"                                 : $locationIndex =  "SJ2"; break;
		case "Tolo Highway near Science Park"                                    : $locationIndex =  "SJ3"; break;
		case "San Tin Highway near Pok Wai Road"                                 : $locationIndex =  "SJ4"; break;
		case "Tuen Mun Road near Tuen Mun Heung Sze Wui Road"                    : $locationIndex =  "SJ5"; break;
		default :                                                                  $locationIndex =  "INPUT ERROR"; break;
}

  switch  ($destString) {
	  
		case "Cross Harbour Tunnel":          $dectIndex =  "CH";   break;
		case "Eastern Harbour Crossing":      $dectIndex =  "EH";   break;		   
		case "Western Harbour Crossing":      $dectIndex =  "WH";   break;
		case "Lion Rock Tunnel":              $dectIndex =  "LRT";  break;
		case "hing Mun Tunnel":               $dectIndex =  "SMT";  break;
		case "Tates Cairn Tunnel":            $dectIndex =  "TCT";  break;
		case "Tai Lam Tunnel to Ting Kau":    $dectIndex =  "TKTL"; break;
		case "Tuen Mun Road to Ting Kau":     $dectIndex =  "TKTM"; break;
		case "Tsing Sha Control Area":        $dectIndex =  "TSCA"; break;
		case "Castle Peak to Tsuen Wan":      $dectIndex =  "TWCP"; break;
		case "Tuen Mun to Tsuen Wan":         $dectIndex =  "TWTM"; break;
		default :                             $dectIndex =  "INPUT ERROR"; break;
}	

//echo $locationIndex . "222<br>";
//echo $dectIndex . "222<br>";
//http://resource.data.one.gov.hk/td/tc/specialtrafficnews.xml
//getFeed("http://resource.data.one.gov.hk/td/journeytime.xml");
if ( $dectIndex !=  "INPUT ERROR" && $locationIndex !=  "INPUT ERROR" && $dectIndex != NULL ){// && $locationIndex != NULL){// && ($langIndex != NULL && ($langIndex == 'tw' || $langIndex == 'en' || $langIndex == 'zh'))){
	getFeed("http://resource.data.one.gov.hk/td/journeytime.xml", $locationIndex, $dectIndex  , $unit , $langIndex);
}else{
	
		inputError();

}
?>
