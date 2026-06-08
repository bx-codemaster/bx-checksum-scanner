<?php
/* -----------------------------------------------------------------------------------------
   BX Prüfsummen Scanner - Deutsche Sprachdatei (System-Modul)

   modified eCommerce Shopsoftware
   http://www.modified-shop.org
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------------------------------- */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

// Modul-Informationen
define('MODULE_BX_CHECKSUM_SCANNER_TEXT_TITLE', 'BX Prüfsummen Scanner');
define('MODULE_BX_CHECKSUM_SCANNER_TEXT_DESC',  'Überwacht die Integrität aller Shop-Dateien (PHP, HTML, CSS, JS) mittels MD5-Prüfsummen und erkennt Änderungen, Löschungen und neue Dateien.');

define('MODULE_BX_CHECKSUM_SCANNER_STATUS_TITLE', 'Status');
define('MODULE_BX_CHECKSUM_SCANNER_STATUS_DESC',  'Möchten Sie den BX Prüfsummen Scanner aktivieren?'); 

// Deinstallation / Cleanup
define('MODULE_BX_CHECKSUM_SCANNER_TEXT_UNINSTALL_FIRST',        'Bitte deaktivieren Sie das Modul zuerst (Status = False), bevor Sie die Moduldateien entfernen.');
define('MODULE_BX_CHECKSUM_SCANNER_TEXT_COULD_NOT_BE_DELETED',   ' konnte nicht gelöscht werden.');
define('MODULE_BX_CHECKSUM_SCANNER_TEXT_SUCCSESSFULLY_REMOVED',  'Alle Moduldateien wurden erfolgreich entfernt.');
define('MODULE_BX_CHECKSUM_SCANNER_TEXT_DELETE_FAILED',          'Einige Moduldateien konnten nicht entfernt werden. Bitte prüfen Sie die Dateiberechtigungen.');
