<?php
/* -----------------------------------------------------------------------------------------
   BX Checksum Scanner - English Language File (System Module)

   modified eCommerce Shopsoftware
   http://www.modified-shop.org
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------------------------------- */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

// Module Information
define('MODULE_BX_CHECKSUM_SCANNER_TITLE', 'BX Checksum Scanner');

$description = '
<details class="bxac-card">
  <summary class="bxac-summary" style="list-style: none;">
  <span class="bxac-arrow">▸</span>
  ' . xtc_image(DIR_WS_ICONS.'heading/bx_checksum_scanner.png', 'BX Checksum Scanner') . '
  <span class="bxac-title">BX Checksum Scanner</span>
  </summary>
  <div class="bxac-body">
    <h3 style="margin-top: 0;">File Guard</h3>
    <p>Monitors the integrity of all shop files (PHP, HTML, CSS, JS) using MD5 checksums and detects changes, deletions, and new files.</p>';

  if (basename($_SERVER['PHP_SELF']) == 'module_export.php' && 
  (!defined('MODULE_BX_CHECKSUM_SCANNER_STATUS') || (defined('MODULE_BX_CHECKSUM_SCANNER_STATUS') && MODULE_BX_CHECKSUM_SCANNER_STATUS !== 'True'))) { 
    $description .= '<p><a class="button btnbox but_red" style="text-align:center;" onclick="return confirmLink(\'Delete old module files?\', \'\' ,this);" href="'.xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=bx_checksum_scanner&action=custom&task=delete_old_files').'">Delete old module files?</a></p>';
  }
  $description .= '</div></details>';

  define('MODULE_BX_CHECKSUM_SCANNER_DESC', $description);

define('MODULE_BX_CHECKSUM_SCANNER_STATUS_TITLE', 'Status');
define('MODULE_BX_CHECKSUM_SCANNER_STATUS_DESC',  'Do you want to enable the BX Checksum Scanner?'); 

// Deinstallation / Cleanup
define('MODULE_BX_CHECKSUM_SCANNER_UNINSTALL_FIRST',        'Please disable the module first (Status = False) before removing the module files.');
define('MODULE_BX_CHECKSUM_SCANNER_COULD_NOT_BE_DELETED',   ' could not be deleted.');
define('MODULE_BX_CHECKSUM_SCANNER_SUCCSESSFULLY_REMOVED',  'All module files were successfully removed.');
define('MODULE_BX_CHECKSUM_SCANNER_DELETE_FAILED',          'Some module files could not be removed. Please check the file permissions.');
