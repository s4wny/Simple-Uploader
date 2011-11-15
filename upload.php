<?php

define('RANDOMD5', md5(microtime()));
define('SCRIPTFOLDER', 'http://'. $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']));

$ini['allowedFiles'] = array('png', 'gif', 'jpg', 'jpeg'); //Filtyper som �r till�tna. Att till�ta php filer �r en STOR s�kerhets risk, s� till�t inte dem.
$ini['maxSize']      = 100 * 1024 * 1024; //Hur stor f�r filen max vara? (10mb = 10 * 1024 * 1024)
$ini['dir']          = 'uploads'; //Mapp som filerna hammnar i. (utan avslutade /)

$ini['newFileName'] = false; //false f�r samma gammla filnamn + ev pre/su-fix. F�r helt nytt filnamn $ini['newFileName'] = "nyttfilnamn"
$ini['prefix']      = RANDOMD5 ."_"; //text f�re orginal filnamnet
$ini['sufix']       = ''; //text efter orginal filnamnet

$ini['log']         = true; //Logga alla som f�rs�ker ladda upp?
$ini['logFile']     = 'logs.php'; //I vilken fil ska loggarna sparas?
$ini['logSettings'] = array('ip'   => true,
                            'ref'  => true,
							'url'  => true,
							'date' => 'Y-m-d H:i:s'); //Vad ska den logga?

$bitLyUser = ''; //F�r att g�ra korta bit.ly l�nkar m�ste du skaffa ett konto samt API nyckel p� https://bitly.com/
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
        //Till�ten?
	    $allowedFiles = implode("|", $ini['allowedFiles']);
    	
    	if(preg_match("/.($allowedFiles)$/i", $_FILES['file']['name'], $fileType))
    	{
    	
    	    //R�tt filstorlek?
            if($_FILES['file']['size'] < $ini['maxSize'])
    		{
    		    //Byt namn
    		    $filename = ($ini['newFileName']) ? $ini['newFileName'] . $fileType[0] :  $ini['prefix'] . $_FILES['file']['name'] . $ini['sufix'] . $fileType[0];
    			
    			//F�rs�ker laddar upp filen
                if(move_uploaded_file($_FILES["file"]["tmp_name"], "$ini[dir]/$filename"))
    			{
    			    //Lyckades, laddar HTML filen osv l�ngre ner
    				$success = true;
    			}
    			else //Fel
    			{
    			    //Finns mappen? Om inte f�rs�k skapa den, om den skapades f�rs�k ladda upp filen igen.
    			    if(!is_dir($ini['dir'])) {
    				    if(mkdir($ini['dir'])) {
    					    if(move_uploaded_file($_FILES["file"]["tmp_name"], "$ini[dir]/$filename")) {
    						    $success = true;
    						}
    						else {
    						    $error['cantUploadFile'] = "Kan inte ladda upp filen, vet inte varf�r.";
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
    		    $error['2BigFile'] = 'F�rs�ker du ta ner servern?! (f�r stor fil)';
    		}
	    }
	    else {
	        //Ogiltigt format
	    	$error['fileTypeNotAllowed'] = 'Vi till�ter endast '. implode(", ", $ini['allowedFiles']) .'.';
	    }
	}
	else {
	    
		//Se http://www.php.net/manual/en/features.file-upload.errors.php
		switch($_FILES["file"]["error"])
		{
		    case 1: $e = 'F�r stor fil, �verskred "upload_max_filesize" i php.ini'; break;
		    case 2: $e = 'F�r stor fil.'; break;
		    case 3: $e = 'Hela filen blev inte uppladdad.'; break;
		    case 4: $e = 'Ange en fil.'; break;
		    case 6: $e = 'Finns ingen _temor�r_ mapp att ladda upp filen till.'; break;
		    case 7: $e = 'Kan inte skriva till den tempor�ra mappen.'; break;
		    case 8: $e = 'Sjukt konstigt fel. "A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help."'; break;
			default: $e = 'Ok�nt fel'; break;
		}
		
	    $error['phpFileError'] = $e;
	}
}
else
{
    //Visa formul�ret
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
	
	$data = array('success'  => "Filen �r nu uppladdad! :)",
				  'fullUrl'  => $url,
				  'bitlyUrl' => get_bitly_url($url, $bitLyUser, $bitLyKey),
				  'tinyUrl'  => get_tinyurl($url)); 
	
	loadView('header');
	loadView('success', $data);
	loadView('footer');
}

?>