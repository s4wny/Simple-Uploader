                            _                
                           | |               
         _ __ ___  __ _  __| |_ __ ___   ___ 
        | '__/ _ \/ _` |/ _` | '_ ` _ \ / _ \
        | | |  __/ (_| | (_| | | | | | |  __/
        |_|  \___|\__,_|\__,_|_| |_| |_|\___|
                                     
.

==============================
        - Innehåll-
==============================
* Installation
* Inställningar
* FAQ
* Licens

==============================
      - Installation -
==============================

Zipa upp filen och dra över alla filer till ditt webbhotell, klart! :)

==============================
     - Inställningar- 
==============================

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
							
För att göra korta bit.ly länkar måste du skaffa ett konto samt API nyckel på https://bitly.com/
$bitLyUser = ''; //bitLy User
$bitLyKey  = ''; //bitLy Key
							
==============================
          - FAQ -
==============================
	
	* Har något problem som jag inte lyckas lösa själv eller med hjälp utav ett forum, tex phpportalen.net
	- Kontakta mig på 4morefun.net, text genom en kommentar i http://4morefun.net/koda/239/

	
==============================
         - Licens -
==============================
Simple Uploader går under 'Attribution-ShareAlike 3.0 Unported'.
Det innebär kortfattat att du får använda Simple Uploader gratis, även för kommersiell användning.
Du får även ändra och modifiera verket så länge du använder samma licens.

Läs mer på: http://creativecommons.org/licenses/by-sa/3.0/