<?php
# MUSTER für DATEI in admin/includes/extra_menu - Dateiname 01_example.php
# Damit ist es moeglich das Adminmenue mit weiteren Eintraegen beliebig zu ergaenzen
# Die neuen Menueeintaege werden unten an die bestehenden Eintraege hinzugefuegt
# Die Reihenfolge der neuen Einträge kann mit einer vorangestellten Nummer im Dateinamen gesteuert werden

defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );

//Sprachabhaengiger Menueeintrag, kann fuer weiter Sprachen ergaenzt werden
switch ($_SESSION['language_code']) {
  case 'de':
    define('MENU_NAME_BX_CHECKSUMS_CANNER','BX Prüfsummen Scanner');
    break;
  default:
    define('MENU_NAME_BX_CHECKSUMS_CANNER','BX Checksum Scanner');
    break;
}

//BOX_HEADING_TOOLS = Name der box in der der neue Menüeintrag erscheinen soll
$add_contents[BOX_HEADING_TOOLS][] = array( 
	'admin_access_name' => 'bx_checksum_scanner',	//Eintrag für Adminrechte
	'filename' => 'bx_checksum_scanner.php',			//Dateiname der neuen Admindatei
	'boxname' => MENU_NAME_BX_CHECKSUMS_CANNER,		//Anzeigename im Menue
	'parameters' => '',								            //zusätzliche Parameter z.B. 'set=export'
	'ssl' => ''										                //SSL oder NONSSL, kein Eintrag = NONSSL
  );
  