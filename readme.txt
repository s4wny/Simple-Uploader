                            _                
                           | |               
         _ __ ___  __ _  __| |_ __ ___   ___ 
        | '__/ _ \/ _` |/ _` | '_ ` _ \ / _ \
        | | |  __/ (_| | (_| | | | | | |  __/
        |_|  \___|\__,_|\__,_|_| |_| |_|\___|
                                     
.

==============================
        - Inneh�ll-
==============================
* Installation
* Inst�llningar
* FAQ
* Licens

==============================
      - Installation -
==============================

Zipa upp filen och dra �ver alla filer till ditt webbhotell, klart! :)

==============================
     - Inst�llningar- 
==============================

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
							
F�r att g�ra korta bit.ly l�nkar m�ste du skaffa ett konto samt API nyckel p� https://bitly.com/
$bitLyUser = ''; //bitLy User
$bitLyKey  = ''; //bitLy Key
							
==============================
          - FAQ -
==============================
	
	* Har n�got problem som jag inte lyckas l�sa sj�lv eller med hj�lp utav ett forum, tex phpportalen.net
	- Kontakta mig p� 4morefun.net, text genom en kommentar i http://4morefun.net/koda/239/

	
==============================
         - Licens -
==============================
Simple Uploader g�r under 'Attribution-ShareAlike 3.0 Unported'.
Det inneb�r kortfattat att du f�r anv�nda Simple Uploader gratis, �ven f�r kommersiell anv�ndning.
Du f�r �ven �ndra och modifiera verket s� l�nge du anv�nder samma licens.

L�s mer p�: http://creativecommons.org/licenses/by-sa/3.0/