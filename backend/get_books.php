<?php 

header("Content-type: application/json ; charset = UTF-8");

class ioTranslateException extends Exception { }

try{



 $query = "https://www.bubok.es/tienda/";


 
 	 
$html = file_get_contents($query);



libxml_use_internal_errors(true); 
$doc = new DomDocument("1.0","UTF-8");
$doc->loadHTML(utf8_decode($html));
$xpath = new DOMXPath($doc);


$books = $xpath->query('//*/ul[contains(@class, "thumbs")]/li');
$tops = $xpath->query('//*/div[contains(@class, "contenidocarru")]/div');


$html = array();

foreach ($books as $book) {



	$_book = array(
		  "img" => 'https://www.bubok.es/' . $xpath->query('a/img/@src', $book)->item(0)->value,
		  "url" => $xpath->query('a/@href', $book)->item(0)->value,
		  "nombre" => $xpath->query('a/@title', $book)->item(0)->value		  		 
		);

	$html['books'][] = $_book;
		

}


$_tops = array();

	foreach ($tops as $top) {
			
			$lis = $xpath->query('ul/li', $top);	
			$tops_ = array();		

			foreach($lis as $li){
				 $item = array(
				 	      "img" => $xpath->query('a/@style', $li)->item(0)->value,
				 	      "nombre" => $xpath->query('a/@title', $li)->item(0)->value,
				 	      "url" => $xpath->query('a/@href', $li)->item(0)->value,

				 	  );

				 $tops_[] = $item;
			}

			$_tops[] = $tops_;


	}

	$html["tops"] = $_tops;


$json = array(
	"http_code" => 200,
	"rs" => $html,
	"length" => count($html)
	);

 if(!isset($_GET["callback"])){
    echo json_encode($json);
   }
 else
 	{
 		if($_GET["callback"] != "?")
 		echo "{$_GET["callback"]}(" . json_encode($json) . ")";
 	    else
        echo json_encode($json);

 	}



}catch(ioTranslateException $e){


	$json = array(
	"http_code" => 400,
	"rs" => array(
			"error_message" => "Bad request: " . $e->getMessage()			
		)
	);

 if(!isset($_GET["callback"])){
    echo json_encode($json);
   }
 else
 	{
 		if($_GET["callback"] != "?")
 		echo "{$_GET["callback"]}(" . json_encode($json) . ")";
 	    else
        echo json_encode($json);

 	}	

}

catch(Exception $e){


	$json = array(
	"http_code" => 400,
	"rs" => array(
			"error_message" => "Bad request: Malformed URL"			
		)
	);

 if(!isset($_GET["callback"])){
    echo json_encode($json);
   }
 else
 	{
 		if($_GET["callback"] != "?")
 		echo "{$_GET["callback"]}(" . json_encode($json) . ")";
 	    else
        echo json_encode($json);

 	}	

}
