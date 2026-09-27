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
define('MODULE_BX_CHECKSUM_SCANNER_TITLE', 'BX Prüfsummen Scanner');

$description = '
<details class="bxac-card">
  <summary class="bxac-summary" style="list-style: none;">
  <span class="bxac-arrow">▸</span>
  ' . xtc_image(DIR_WS_ICONS.'heading/bx_checksum_scanner.png', 'BX Prüfsummen Scanner') . '
  <span class="bxac-title">BX Prüfsummen Scanner</span>
  </summary>
  <div class="bxac-body">
    <h3 style="margin-top: 0;">Dateiwächter</h3>
    <p>Überwacht die Integrität aller Shop-Dateien (PHP, HTML, CSS, JS) mittels MD5-Prüfsummen und erkennt Änderungen, Löschungen und neue Dateien.</p>';

  if (basename($_SERVER['PHP_SELF']) == 'module_export.php' && 
  (!defined('MODULE_BX_CHECKSUM_SCANNER_STATUS') || (defined('MODULE_BX_CHECKSUM_SCANNER_STATUS') && MODULE_BX_CHECKSUM_SCANNER_STATUS !== 'True'))) { 
    $description .= '<p><a class="button btnbox but_red" style="text-align:center;" onclick="return confirmLink(\'Alte Moduldateien löschen?\', \'\' ,this);" href="'.xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=bx_checksum_scanner&action=custom&task=delete_old_files').'">Alte Moduldateien löschen?</a></p>';
  }
  $description .= '</div></details>';

  define('MODULE_BX_CHECKSUM_SCANNER_DESC', $description);

define('MODULE_BX_CHECKSUM_SCANNER_STATUS_TITLE', 'Status');
define('MODULE_BX_CHECKSUM_SCANNER_STATUS_DESC',  'Möchten Sie den BX Prüfsummen Scanner aktivieren?'); 

// Deinstallation / Cleanup
define('MODULE_BX_CHECKSUM_SCANNER_UNINSTALL_FIRST',        'Bitte deaktivieren Sie das Modul zuerst (Status = False), bevor Sie die Moduldateien entfernen.');
define('MODULE_BX_CHECKSUM_SCANNER_COULD_NOT_BE_DELETED',   ' konnte nicht gelöscht werden.');
define('MODULE_BX_CHECKSUM_SCANNER_SUCCSESSFULLY_REMOVED',  'Alle Moduldateien wurden erfolgreich entfernt.');
define('MODULE_BX_CHECKSUM_SCANNER_DELETE_FAILED',          'Einige Moduldateien konnten nicht entfernt werden. Bitte prüfen Sie die Dateiberechtigungen.');
