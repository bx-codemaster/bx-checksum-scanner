<?php
/* -----------------------------------------------------------------------------------------
   BX Checksum Scanner - Spanish Language File (Admin UI)

   modified eCommerce Shopsoftware
   http://www.modified-shop.org
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------------------------------- */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

// Page title & description
define('BX_CHECKSUM_SCANNER_TEXT_TITLE',            'BX Checksum Scanner');
define('BX_CHECKSUM_SCANNER_TEXT_DESCRIPTION',      'Monitorea la integridad de los archivos del comercio (PHP, HTML, CSS, JS) utilizando sumas de verificación MD5.');
define('BX_CHECKSUM_SCANNER_TEXT_LONG_DESCRIPTION', 'Escanea todos los archivos y verifica su integridad contra la referencia almacenada. Se detectarán archivos nuevos, modificados y eliminados.');
define('BX_CHECKSUM_SCANNER_TEXT_SETTINGS',         'Configuraciones');

// Buttons
define('BX_CHECKSUM_SCANNER_BUTTON_SHOW',           'Verificar');
define('BX_CHECKSUM_SCANNER_BUTTON_RESET',          'Reconstruir referencia');

// Tooltips
define('BX_CHECKSUM_SCANNER_TOOLTIP_SHOW',          'Verificar todos los archivos contra la referencia almacenada');
define('BX_CHECKSUM_SCANNER_TOOLTIP_RESET',         'Crear una nueva referencia de todos los archivos actuales');

// Table headers
define('BX_CHECKSUM_SCANNER_TH_STATUS',             'Estado');
define('BX_CHECKSUM_SCANNER_TH_FILE',               'Archivo');
define('BX_CHECKSUM_SCANNER_TH_SIZE',               'Tamaño (bytes)');
define('BX_CHECKSUM_SCANNER_TH_LASTSIZE',           'Tamaño anterior');
define('BX_CHECKSUM_SCANNER_TH_FILEDATE',           'Fecha del archivo');
define('BX_CHECKSUM_SCANNER_TH_DATEADDED',          'Agregado');
define('BX_CHECKSUM_SCANNER_TH_LASTCHECK',          'Última verificación');

// Status labels
define('BX_CHECKSUM_SCANNER_STATUS_OK',             'OK');
define('BX_CHECKSUM_SCANNER_STATUS_CHANGE',         'Modificado');
define('BX_CHECKSUM_SCANNER_STATUS_DELETE',         'Eliminado');
define('BX_CHECKSUM_SCANNER_STATUS_NEW',            'Nuevo');

// Messages
define('BX_CHECKSUM_SCANNER_NONEWFILES',            'No se encontraron archivos nuevos.');
define('BX_CHECKSUM_SCANNER_FIRST_START',           'No se encontró ninguna referencia. Por favor, ejecute &quot;Reconstruir referencia&quot; primero.');
define('BX_CHECKSUM_SCANNER_RESET',                 'La referencia se ha reconstruido correctamente.');
define('BX_CHECKSUM_SCANNER_FIRST_RESET',           'La referencia inicial se ha creado correctamente.');

// Info box (right column)
define('BX_CHECKSUM_SCANNER_INFO_HEADING',         'BX Checksum Scanner');
define('BX_CHECKSUM_SCANNER_INFO_ZWECK_HEAD',      'Propósito');
define('BX_CHECKSUM_SCANNER_INFO_ZWECK_TEXT',      'El módulo calcula sumas de verificación MD5 para todos los archivos PHP, HTML, CSS y JS en la tienda y los almacena como referencia en la base de datos. Esto permite una detección confiable de cambios posteriores, archivos eliminados o archivos recién agregados.');
define('BX_CHECKSUM_SCANNER_INFO_USAGE_HEAD',      'Uso');
define('BX_CHECKSUM_SCANNER_INFO_USAGE_TEXT',      '<ol style="margin:4px 0 0 14px;padding:0;"><li><strong>Reconstruir referencia:</strong> En el primer uso o después de una actualización, haga clic en &ldquo;Reconstruir referencia&rdquo;. Todos los archivos se escanearán y se guardarán como línea base.</li><li><strong>Verificar:</strong> Haga clic en &ldquo;Verificar&rdquo; para comparar el estado actual de todos los archivos con la referencia.</li><li><strong>Revisar resultados:</strong> Los archivos modificados, eliminados y nuevos se resaltan en color.</li></ol>');
define('BX_CHECKSUM_SCANNER_INFO_STATUS_HEAD',     'Indicadores de estado');
define('BX_CHECKSUM_SCANNER_INFO_STATUS_TEXT',     '<table style="border-collapse:collapse;margin-top:4px;"><tr><td style="padding:2px 6px 2px 0"><span style="color:#62C650">&#9679;</span></td><td>Archivo sin cambios</td></tr><tr><td style="padding:2px 6px 2px 0"><span style="color:#9B20BF">&#9679;</span></td><td>Archivo modificado</td></tr><tr><td style="padding:2px 6px 2px 0"><span style="color:#C31D05">&#9679;</span></td><td>Archivo eliminado</td></tr><tr><td style="padding:2px 6px 2px 0"><span style="color:red">&#9679;</span></td><td>Archivo nuevo (no en la referencia)</td></tr></table>');

// Etiquetas de progreso
define('BX_CHECKSUM_SCANNER_PROGRESS_INIT',      'Inicializando ...');
define('BX_CHECKSUM_SCANNER_PROGRESS_CHECKSUMS', 'Creando sumas de verificación');
define('BX_CHECKSUM_SCANNER_PROGRESS_CHECK',     'Verificando archivos');
define('BX_CHECKSUM_SCANNER_PROGRESS_LOADING',   'Cargando resultados ...');

// Mensajes de error de reserva (JS)
define('BX_CHECKSUM_SCANNER_ERR_SCAN_CHUNK',  'scan_chunk fallido');
define('BX_CHECKSUM_SCANNER_ERR_SCAN_INIT',   'scan_init fallido');
define('BX_CHECKSUM_SCANNER_ERR_CHECK_CHUNK', 'check_chunk fallido');
define('BX_CHECKSUM_SCANNER_ERR_CHECK_INIT',  'check_init fallido');
define('BX_CHECKSUM_SCANNER_ERR_RESULTS',     'Error al cargar los resultados');

// Paginación
define('BX_CHECKSUM_SCANNER_PAGING_SHOWN',   'Mostrando');
define('BX_CHECKSUM_SCANNER_PAGING_TO',      'a');
define('BX_CHECKSUM_SCANNER_PAGING_TOTAL',   'de');
define('BX_CHECKSUM_SCANNER_PAGING_ENTRIES', 'entradas');
define('BX_CHECKSUM_SCANNER_PAGING_PAGE',    'Página');
define('BX_CHECKSUM_SCANNER_PAGING_OF',      'de');

// AJAX error messages
define('BX_CHECKSUM_SCANNER_AJAX_MODULE_DISABLED', 'Módulo deshabilitado');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_RESET',    'Error de base de datos al reiniciar');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_TMP_WRITE',   'No se pudo escribir el archivo temporal');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_NO_SCAN',     'No hay un escaneo activo – por favor, llame a scan_init primero');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_FILELIST',    'Lista de archivos de escaneo no encontrada – por favor, llame a scan_init nuevamente');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_INSERT',   'Error de base de datos durante INSERT');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_LOAD',     'Error de base de datos al cargar');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_NO_CHECK',    'No hay una verificación activa – por favor, llame a check_init primero');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_UPDATE',   'Error de base de datos durante UPDATE');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_UNKNOWN',     'Acción desconocida: ');