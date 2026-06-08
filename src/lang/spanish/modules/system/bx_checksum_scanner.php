<?php
/* -----------------------------------------------------------------------------------------
   BX Prüfsummen Scanner - Spanische Sprachdatei (System-Modul)

   modified eCommerce Shopsoftware
   http://www.modified-shop.org
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------------------------------- */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

// Modul-Informationen
define('MODULE_BX_CHECKSUM_SCANNER_TITLE', 'BX Escáner de Checksums');

$description = '
<details class="bxac-card">
  <summary class="bxac-summary" style="list-style: none;">
  <span class="bxac-arrow">▸</span>
  <span class="bxac-title">' . xtc_image(DIR_WS_ICONS.'heading/bx_checksum_scanner.png', 'BX Escáner de Checksums', '', '', 'style="max-height: 32px; vertical-align: middle; margin-right: 8px;"') . 'BX Escáner de Checksums</span>
  </summary>
  <div class="bxac-body">
    <h3 style="margin-top: 0;">Guardia de Archivos</h3>
    <p>Monitorea la integridad de todos los archivos de la tienda (PHP, HTML, CSS, JS) utilizando sumas de verificación MD5 y detecta cambios, eliminaciones y archivos nuevos.</p>';

  if (basename($_SERVER['PHP_SELF']) == 'module_export.php' && 
  (!defined('MODULE_BX_CHECKSUM_SCANNER_STATUS') || (defined('MODULE_BX_CHECKSUM_SCANNER_STATUS') && MODULE_BX_CHECKSUM_SCANNER_STATUS !== 'True'))) { 
    $description .= '<p><a class="button btnbox but_red" style="text-align:center;" onclick="return confirmLink(\'¿Eliminar archivos antiguos del módulo?\', \'\' ,this);" href="'.xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=bx_checksum_scanner&action=custom&task=delete_old_files').'">¿Eliminar archivos antiguos del módulo?</a></p>';
  }
  $description .= '</div></details>';

  define('MODULE_BX_CHECKSUM_SCANNER_DESC', $description);

define('MODULE_BX_CHECKSUM_SCANNER_STATUS_TITLE', 'Estado');
define('MODULE_BX_CHECKSUM_SCANNER_STATUS_DESC',  '¿Desea activar el BX Escáner de Checksums?'); 

// Desinstalación / Limpieza
define('MODULE_BX_CHECKSUM_SCANNER_UNINSTALL_FIRST',        'Por favor, desactive el módulo primero (Estado = Falso) antes de eliminar los archivos del módulo.');
define('MODULE_BX_CHECKSUM_SCANNER_COULD_NOT_BE_DELETED',   ' no se pudo eliminar.');
define('MODULE_BX_CHECKSUM_SCANNER_SUCCSESSFULLY_REMOVED',  'Todos los archivos del módulo se eliminaron correctamente.');
define('MODULE_BX_CHECKSUM_SCANNER_DELETE_FAILED',          'Algunos archivos del módulo no se pudieron eliminar. Por favor, verifique los permisos de los archivos.');
