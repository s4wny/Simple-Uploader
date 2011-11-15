<?php

define('RANDOMD5', md5(microtime()));
define('SCRIPTFOLDER', 'http://'. $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']));

$ini['allowedFiles'] = array('png', 'gif', 'jpg', 'jpeg'); //Filtyper som är tillåtna. Att tillåta php filer är en STOR säkerhets risk, så tillåt inte dem.
$ini['maxSize']      = 100 * 1024 * 1024; //Hur stor får filen max vara? (10mb = 10 * 1024 * 1024)
$ini['dir']          = 'uploads'; //Mapp som filerna hammnar i. (utan avslutade /)

$ini['newFileName'] = false; //false för samma gammla filnamn + ev pre/su-fix. För helt nytt filnamn $ini['newFileName'] = "nyttfilnamn"
$ini['prefix']      = RANDOMD5 ."_"; //text före orginal filnamnet
$ini['sufix']       = ''; //text efter orginal filnamnet

$ini['log']         = true; //Logga alla som försöker ladda upp?
$ini['logFile']     = 'logs.php'; //I vilken fil ska loggarna sparas?
$ini['logSettings'] = array('ip'   => true,
                            'ref'  => true,
							'url'  => true,
							'date' => 'Y-m-d H:i:s'); //Vad ska den logga?

$bitLyUser = ''; //För att göra korta bit.ly länkar måste du skaffa ett konto samt API nyckel på https://bitly.com/
$bitLyKey  = '';

$success = false;
$error   = null;


//Funktioner
//--------------------------------------------------
include('functions.php');


//Scriptet
//--------------------------------------------------

if(isset($_POST['submit']))
{
    if($_FILES["file"]["error"] === 0)
	{
        //Tillåten?
	    $allowedFiles = implode("|", $ini['allowedFiles']);
    	
    	if(preg_match("/.($allowedFiles)$/i", $_FILES['file']['name'], $fileType))
    	{
    	
    	    //Rätt filstorlek?
            if($_FILES['file']['size'] < $ini['maxSize'])
    		{
    		    //Byt namn
    		    $filename = ($ini['newFileName']) ? $ini['newFileName'] . $fileType[0] :  $ini['prefix'] . $_FILES['file']['name'] . $ini['sufix'] . $fileType[0];
    			
    			//Försöker laddar upp filen
                if(move_uploaded_file($_FILES["file"]["tmp_name"], "$ini[dir]/$filename"))
    			{
    			    //Lyckades, laddar HTML filen osv längre ner
    				$success = true;
    			}
    			else //Fel
    			{
    			    //Finns mappen? Om inte försök skapa den, om den skapades försök ladda upp filen igen.
    			    if(!is_dir($ini['dir'])) {
    				    if(mkdir($ini['dir'])) {
    					    if(move_uploaded_file($_FILES["file"]["tmp_name"], "$ini[dir]/$filename")) {
    						    $success = true;
    						}
    						else {
    						    $error['cantUploadFile'] = "Kan inte ladda upp filen, vet inte varför.";
    						}
    					}
    					else {
    					    $error['failed2CreateFolder'] = "Kunde inte skapa mappen $ini[dir].";
    					}
    				}
    				else {
    				    $error['folderDontExist'] = "Man kan inte ladda upp filer till mappar som inte finns.. (Mappen $ini[dir] finns inte.)";
    				}
    			}
    		}
    		else {
    		    $error['2BigFile'] = 'Försöker du ta ner servern?! (för stor fil)';
    		}
	    }
	    else {
	        //Ogiltigt format
	    	$error['fileTypeNotAllowed'] = 'Vi tillåter endast '. implode(", ", $ini['allowedFiles']) .'.';
	    }
	}
	else {
	    
		//Se http://www.php.net/manual/en/features.file-upload.errors.php
		switch($_FILES["file"]["error"])
		{
		    case 1: $e = 'För stor fil, överskred "upload_max_filesize" i php.ini'; break;
		    case 2: $e = 'För stor fil.'; break;
		    case 3: $e = 'Hela filen blev inte uppladdad.'; break;
		    case 4: $e = 'Ange en fil.'; break;
		    case 6: $e = 'Finns ingen _temorär_ mapp att ladda upp filen till.'; break;
		    case 7: $e = 'Kan inte skriva till den temporära mappen.'; break;
		    case 8: $e = 'Sjukt konstigt fel. "A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help."'; break;
			default: $e = 'Okänt fel'; break;
		}
		
	    $error['phpFileError'] = $e;
	}
}
else
{
    //Visa formuläret
	loadView('header');
	loadView('form');
	loadView('footer');
}


//Error
if(isset($error))
{
    //Logga?
	($ini['log']) ? log_it($error, $ini['logSettings'], $ini['logFile']) : null;
	
    $error['error'] = $error;
	
    loadView('header');
    loadView('form', $error);
    loadView('footer');
}
elseif($success === true)
{
    ($ini['log']) ? log_it('Lyckades ladda upp '. $filename .' :)', $ini['logSettings'], $ini['logFile']) : null;
	
    $url  = SCRIPTFOLDER ."/$ini[dir]/$filename";
	
	$data = array('success'  => "Filen är nu uppladdad! :)",
				  'fullUrl'  => $url,
				  'bitlyUrl' => get_bitly_url($url, $bitLyUser, $bitLyKey),
				  'tinyUrl'  => get_tinyurl($url)); 
	
	loadView('header');
	loadView('success', $data);
	loadView('footer');
}

?>