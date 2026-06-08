<?php
/* -----------------------------------------------------------------------------------------
   Escáner de sumas de comprobación BX - Archivo de idioma alemán (módulo del sistema)

   modified eCommerce Shopsoftware
   http://www.modified-shop.org
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------------------------------- */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

// Modul-Informationen
define('MODULE_BX_CHECKSUM_SCANNER_TEXT_TITLE', 'Escáner de sumas de comprobación BX');
define('MODULE_BX_CHECKSUM_SCANNER_TEXT_DESC',  'Supervisa la integridad de todos los archivos de la tienda (PHP, HTML, CSS, JS) mediante sumas de comprobación MD5 y detecta cambios, eliminaciones y archivos nuevos.');

define('MODULE_BX_CHECKSUM_SCANNER_STATUS_TITLE', 'Estado');
define('MODULE_BX_CHECKSUM_SCANNER_STATUS_DESC',  '¿Desea activar el Escáner de sumas de comprobación BX?'); 

// Deinstallation / Cleanup
define('MODULE_BX_CHECKSUM_SCANNER_TEXT_UNINSTALL_FIRST',        'Por favor, desactive primero el módulo (Estado = Falso) antes de eliminar los archivos del módulo.');
define('MODULE_BX_CHECKSUM_SCANNER_TEXT_COULD_NOT_BE_DELETED',   ' no se pudo eliminar.');
define('MODULE_BX_CHECKSUM_SCANNER_TEXT_SUCCSESSFULLY_REMOVED',  'Todos los archivos del módulo se eliminaron correctamente.');
define('MODULE_BX_CHECKSUM_SCANNER_TEXT_DELETE_FAILED',          'Algunos archivos del módulo no se pudieron eliminar. Por favor, verifique los permisos de los archivos.');
