<?php

/*
        Functions.php
		
		Funktioner
*/


//Laddar en html fil, $data(array) görs om till variabler
function loadView($file, $data = null)
{
	if(is_array($data)) {
	    extract($data);
	}
		
	include('view/'. $file .'.php');
}


//Loggar hänelser
function log_it($mess, $settings, $file)
{	
	$ini  = $settings; //Kortare	
	
	$mess = (is_array($mess)) ? implode(", ", $mess) : $mess;
	
    //Vilka inställningar ska användas?	
	$ip   = ($ini['ip'])   ? $_SERVER['REMOTE_ADDR']  : '';
	$ref  = ($ini['ref'])  ? $_SERVER['HTTP_REFERER'] : '';
	$url  = ($ini['url'])  ? $_SERVER['REQUEST_URI']  : ''; //Om inte REQUEST URI funkar testa PHP_SELF + SCRIPT_NAME
	$date = ($ini['date']) ? date($ini['date'])       : '';
	
	$buf = "$date | $mess | $ip | $ref | $url \n";
	
	//Skriv till filen
	$fh = fopen($file, 'a');
	fwrite($fh, $buf);
	fclose($fh);
}


//Korta länkar
//------------------------------------------------

//Bit.ly url
function get_bitly_url($url,$login,$appkey,$format='txt') {
    $connectURL = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode($url).'&format='.$format;
    return curl_get_result($connectURL);
}

//Tinyurl.com url
function get_tinyurl($url) {
     return curl_get_result('http://tinyurl.com/api-create.php?url='. $url);
}

//Hämtar den korta länken
function curl_get_result($url) {
    $ch = curl_init();
    $timeout = 3;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}