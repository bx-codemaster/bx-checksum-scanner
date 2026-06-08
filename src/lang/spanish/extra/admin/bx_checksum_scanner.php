<?php
/* -----------------------------------------------------------------------------------------
   Escáner de sumas de comprobación BX - Archivo de idioma español (interfaz de usuario de administración)

   modified eCommerce Shopsoftware
   http://www.modified-shop.org
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------------------------------- */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

// Seitentitel & Beschreibung
define('BX_CHECKSUM_SCANNER_TEXT_TITLE',            'Escáner de sumas de comprobación BX');
define('BX_CHECKSUM_SCANNER_TEXT_DESCRIPTION',      'Supervisa la integridad de los archivos de la tienda (PHP, HTML, CSS, JS) mediante sumas de comprobación MD5.');
define('BX_CHECKSUM_SCANNER_TEXT_LONG_DESCRIPTION', 'Escanea todos los archivos y verifica su integridad en comparación con la referencia almacenada. Se detectan los archivos nuevos, modificados y eliminados.');
define('BX_CHECKSUM_SCANNER_TEXT_SETTINGS',         'Configuración');

// Botones
define('BX_CHECKSUM_SCANNER_BUTTON_SHOW',           'Comprobar');
define('BX_CHECKSUM_SCANNER_BUTTON_RESET',          'Reconstruir referencia');

// Tooltips
define('BX_CHECKSUM_SCANNER_TOOLTIP_SHOW',          'Comprueba todos los archivos contra la referencia almacenada');
define('BX_CHECKSUM_SCANNER_TOOLTIP_RESET',         'Crea una nueva referencia de todos los archivos actuales');

// Columnas de la tabla
define('BX_CHECKSUM_SCANNER_TH_STATUS',             'Estado');
define('BX_CHECKSUM_SCANNER_TH_FILE',               'Archivo');
define('BX_CHECKSUM_SCANNER_TH_SIZE',               'Tamaño (Bytes)');
define('BX_CHECKSUM_SCANNER_TH_LASTSIZE',           'Tamaño anterior');
define('BX_CHECKSUM_SCANNER_TH_FILEDATE',           'Fecha del archivo');
define('BX_CHECKSUM_SCANNER_TH_DATEADDED',          'Añadido');
define('BX_CHECKSUM_SCANNER_TH_LASTCHECK',          'Última comprobación');

// Etiquetas de estado
define('BX_CHECKSUM_SCANNER_STATUS_OK',             'OK');
define('BX_CHECKSUM_SCANNER_STATUS_CHANGE',         'Modificado');
define('BX_CHECKSUM_SCANNER_STATUS_DELETE',         'Eliminado');
define('BX_CHECKSUM_SCANNER_STATUS_NEW',            'Nuevo');

// Mensajes
define('BX_CHECKSUM_SCANNER_NONEWFILES',            'No se encontraron archivos nuevos.');
define('BX_CHECKSUM_SCANNER_FIRST_START',           'Aún no hay referencia. Por favor, ejecute primero &quot;Reconstruir referencia&quot;.');
define('BX_CHECKSUM_SCANNER_RESET',                 'La referencia se ha reconstruido correctamente.');
define('BX_CHECKSUM_SCANNER_FIRST_RESET',           'La referencia inicial se ha creado correctamente.');

// Info-Box (columna derecha)
define('BX_CHECKSUM_SCANNER_INFO_HEADING',          'BX Escáner de Sumario de Comprobación');
define('BX_CHECKSUM_SCANNER_INFO_ZWECK_HEAD',       'Propósito');
define('BX_CHECKSUM_SCANNER_INFO_ZWECK_TEXT',       'El módulo calcula sumas de verificación MD5 de todos los archivos PHP, HTML, CSS y JS de la tienda y los almacena como referencia en la base de datos. Esto permite detectar de manera confiable cambios posteriores, archivos eliminados o nuevos archivos añadidos.');
define('BX_CHECKSUM_SCANNER_INFO_USAGE_HEAD',       'Uso');
define('BX_CHECKSUM_SCANNER_INFO_USAGE_TEXT',       '<ol style="margin:4px 0 0 14px;padding:0;"><li><strong>Construir referencia:</strong> Al primer uso o después de una actualización, haga clic en &bdquo;Reconstruir referencia&ldquo;. Todos los archivos se escanearán y se guardarán como base.</li><li><strong>Comprobar:</strong> Haga clic en &bdquo;Comprobar&ldquo; para comparar el estado actual de todos los archivos con la referencia.</li><li><strong>Revisar resultados:</strong> Los archivos modificados, eliminados y nuevos se resaltan en color.</li></ol>');
define('BX_CHECKSUM_SCANNER_INFO_STATUS_HEAD',      'Indicadores de estado');
define('BX_CHECKSUM_SCANNER_INFO_STATUS_TEXT',      '<table style="border-collapse:collapse;margin-top:4px;"><tr><td style="padding:2px 6px 2px 0"><span style="color:#62C650">●</span></td><td>Archivo sin cambios</td></tr><tr><td style="padding:2px 6px 2px 0"><span style="color:#9B20BF">●</span></td><td>Archivo modificado</td></tr><tr><td style="padding:2px 6px 2px 0"><span style="color:#C31D05">●</span></td><td>Archivo eliminado</td></tr><tr><td style="padding:2px 6px 2px 0"><span style="color:red">●</span></td><td>Archivo nuevo (no en la referencia)</td></tr></table>');
