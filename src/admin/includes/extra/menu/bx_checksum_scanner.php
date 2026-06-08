<?php
/** -----------------------------------------------------------------------------------------
 * $Id: admin/includes/extra/menu/bx_checksum_scanner.php 2026-06-08 benax $
 * modified eCommerce Shopsoftware
 * http://www.modified-shop.org
 *
 * Copyright (c) 2009 - 2013 [www.modified-shop.org]
 * -----------------------------------------------------------------------------------------
 * Released under the GNU General Public License
 * -----------------------------------------------------------------------------------------
 * BX Checksum Scanner – Admin-Menüeintrag
 * Copyright (c) 2026 Axel Benkert (benax)
 * www.bx-coding.de
 * 2026-06-08
 *
 * Fügt den Menüeintrag „BX Checksum Scanner" in die Tools-Box des
 * Admin-Menüs ein. Der Anzeigetext ist sprachabhängig (de / fallback).
 * -----------------------------------------------------------------------------------------
 */

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
  