<?php
 
function getFeed($feed_url, $flocation) {
     
  $content = file_get_contents($feed_url);
  $x = new SimpleXmlElement($content);
/*	
	$xml=simplexml_load_file($feed_url);
print_r($xml); 
print_r( $xml->description->link );

*/
//	echo stristr($x, $flocation); 
	//$rss = simplexml_load_string($content);
	//echo $rss;
    
    //echo "<ul>";
     
    foreach($x->channel->item as $entry) {
		
		/* get html element with tag name
		$dom = new DOMDocument;
		 $dom->loadHTML($entry->description);
		 $dom->preserveWhiteSpace = false;
        $tables = $dom->getElementsByTagName('table');
		$rows = $tables->item(1)->getElementsByTagName('tr');

		foreach ($rows as $row) {
        	$cols = $row->getElementsByTagName('td');
        	echo $cols[2];
		}
		*/
		//echo ($entry->description);
		//echo ("<br>. $flocation . <br>");
		$part1 = stristr($entry->description, "The air temperatures at other places were:"); 
		$part2 = strip_tags($part1);
		$part3 = stristr($part2, $flocation); 
		$part4 = explode(";", $part3 );
		$part5 = str_replace($flocation, "" ,$part4[0]);
		$part6 = str_replace("degrees ", "" ,$part5);
        header('Content-type: text/html');
        header('Access-Control-Allow-Origin: *');       
	    echo $part6;
		
       // echo "<li><a href='$entry->link' title='$entry->description'>" . $entry->description . "</a></li>";
    }
    //echo "</ul>";
	

}

$location = $_GET['location'];  
//getFeed("http://rss.weather.gov.hk/rss/CurrentWeather.xml");
getFeed("http://rss.weather.gov.hk/rss/CurrentWeather.xml", $location);
?>