<?php
/* -----------------------------------------------------------------------------------------
   BX Prüfsummen Scanner - Deutsche Sprachdatei (Admin UI)

   modified eCommerce Shopsoftware
   http://www.modified-shop.org
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------------------------------- */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

// Seitentitel & Beschreibung
define('BX_CHECKSUM_SCANNER_TEXT_TITLE',            'BX Prüfsummen Scanner');
define('BX_CHECKSUM_SCANNER_TEXT_DESCRIPTION',      'Überwacht die Integrität von Shop-Dateien (PHP, HTML, CSS, JS) mittels MD5-Prüfsummen.');
define('BX_CHECKSUM_SCANNER_TEXT_LONG_DESCRIPTION', 'Scannen Sie alle Dateien und prüfen Sie deren Integrität im Vergleich zur gespeicherten Referenz. Neu hinzugekommene, geänderte und gelöschte Dateien werden dabei erkannt.');
define('BX_CHECKSUM_SCANNER_TEXT_SETTINGS',         'Einstellungen');

// Schaltflächen
define('BX_CHECKSUM_SCANNER_BUTTON_SHOW',           'Prüfen');
define('BX_CHECKSUM_SCANNER_BUTTON_RESET',          'Referenz neu aufbauen');

// Tooltips
define('BX_CHECKSUM_SCANNER_TOOLTIP_SHOW',          'Prüft alle Dateien gegen die gespeicherte Referenz');
define('BX_CHECKSUM_SCANNER_TOOLTIP_RESET',         'Erstellt eine neue Referenz aller aktuellen Dateien');

// Tabellenspalten
define('BX_CHECKSUM_SCANNER_TH_STATUS',             'Status');
define('BX_CHECKSUM_SCANNER_TH_FILE',               'Datei');
define('BX_CHECKSUM_SCANNER_TH_SIZE',               'Größe (Byte)');
define('BX_CHECKSUM_SCANNER_TH_LASTSIZE',           'Vorige Größe');
define('BX_CHECKSUM_SCANNER_TH_FILEDATE',           'Dateidatum');
define('BX_CHECKSUM_SCANNER_TH_DATEADDED',          'Hinzugefügt');
define('BX_CHECKSUM_SCANNER_TH_LASTCHECK',          'Letzte Prüfung');

// Status-Labels
define('BX_CHECKSUM_SCANNER_STATUS_OK',             'OK');
define('BX_CHECKSUM_SCANNER_STATUS_CHANGE',         'Geändert');
define('BX_CHECKSUM_SCANNER_STATUS_DELETE',         'Gelöscht');
define('BX_CHECKSUM_SCANNER_STATUS_NEW',            'Neu');

// Meldungen
defined('BX_CHECKSUM_SCANNER_NONEWFILES')            or define('BX_CHECKSUM_SCANNER_NONEWFILES',            'Keine neuen Dateien gefunden.');
defined('BX_CHECKSUM_SCANNER_FIRST_START')           or define('BX_CHECKSUM_SCANNER_FIRST_START',           'Noch keine Referenz vorhanden. Bitte zuerst &quot;Referenz neu aufbauen&quot; ausführen.');
defined('BX_CHECKSUM_SCANNER_RESET')                 or define('BX_CHECKSUM_SCANNER_RESET',                 'Referenz wurde erfolgreich neu aufgebaut.');
defined('BX_CHECKSUM_SCANNER_FIRST_RESET')           or define('BX_CHECKSUM_SCANNER_FIRST_RESET',           'Erste Referenz wurde erfolgreich erstellt.');

// Info-Box (rechte Spalte)
defined('BX_CHECKSUM_SCANNER_INFO_HEADING')         or define('BX_CHECKSUM_SCANNER_INFO_HEADING',         'BX Prüfsummen Scanner');
defined('BX_CHECKSUM_SCANNER_INFO_ZWECK_HEAD')      or define('BX_CHECKSUM_SCANNER_INFO_ZWECK_HEAD',      'Zweck');
defined('BX_CHECKSUM_SCANNER_INFO_ZWECK_TEXT')      or define('BX_CHECKSUM_SCANNER_INFO_ZWECK_TEXT',      'Das Modul berechnet MD5-Prüfsummen aller PHP-, HTML-, CSS- und JS-Dateien des Shops und speichert diese als Referenz in der Datenbank. So können nachträgliche Änderungen, gelöschte oder neu hinzugekommene Dateien zuverlässig erkannt werden.');
defined('BX_CHECKSUM_SCANNER_INFO_USAGE_HEAD')      or define('BX_CHECKSUM_SCANNER_INFO_USAGE_HEAD',      'Handhabung');
defined('BX_CHECKSUM_SCANNER_INFO_USAGE_TEXT')      or define('BX_CHECKSUM_SCANNER_INFO_USAGE_TEXT',      '<ol style="margin:4px 0 0 14px;padding:0;"><li><strong>Referenz aufbauen:</strong> Beim ersten Start oder nach einem Update die Schaltfläche &bdquo;Referenz neu aufbauen&ldquo; anklicken. Alle Dateien werden gescannt und als Grundlage gespeichert.</li><li><strong>Prüfen:</strong> Mit &bdquo;Prüfen&ldquo; wird der aktuelle Zustand aller Dateien gegen die Referenz verglichen.</li><li><strong>Ergebnis auswerten:</strong> Geänderte, gelöschte und neue Dateien werden farblich hervorgehoben.</li></ol>');
defined('BX_CHECKSUM_SCANNER_INFO_STATUS_HEAD')     or define('BX_CHECKSUM_SCANNER_INFO_STATUS_HEAD',     'Statusanzeige');
defined('BX_CHECKSUM_SCANNER_INFO_STATUS_TEXT')     or define('BX_CHECKSUM_SCANNER_INFO_STATUS_TEXT',     '<table style="border-collapse:collapse;margin-top:4px;"><tr><td style="padding:2px 6px 2px 0"><span style="color:#62C650">●</span></td><td>Datei unverändert</td></tr><tr><td style="padding:2px 6px 2px 0"><span style="color:#9B20BF">●</span></td><td>Datei geändert</td></tr><tr><td style="padding:2px 6px 2px 0"><span style="color:#C31D05">●</span></td><td>Datei gelöscht</td></tr><tr><td style="padding:2px 6px 2px 0"><span style="color:red">●</span></td><td>Neue Datei (nicht in Referenz)</td></tr></table>');

// AJAX-Fehlermeldungen
defined('BX_CHECKSUM_SCANNER_AJAX_MODULE_DISABLED') or define('BX_CHECKSUM_SCANNER_AJAX_MODULE_DISABLED', 'Modul deaktiviert');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_RESET')    or define('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_RESET',    'DB-Fehler beim Zurücksetzen');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_TMP_WRITE')   or define('BX_CHECKSUM_SCANNER_AJAX_ERR_TMP_WRITE',   'Temp-Datei konnte nicht geschrieben werden');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_NO_SCAN')     or define('BX_CHECKSUM_SCANNER_AJAX_ERR_NO_SCAN',     'Kein aktiver Scan – bitte zuerst scan_init aufrufen');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_FILELIST')    or define('BX_CHECKSUM_SCANNER_AJAX_ERR_FILELIST',    'Scan-Dateiliste nicht gefunden – bitte scan_init erneut aufrufen');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_INSERT')   or define('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_INSERT',   'DB-Fehler beim INSERT');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_LOAD')     or define('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_LOAD',     'DB-Fehler beim Laden');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_NO_CHECK')    or define('BX_CHECKSUM_SCANNER_AJAX_ERR_NO_CHECK',    'Kein aktiver Check – bitte zuerst check_init aufrufen');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_UPDATE')   or define('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_UPDATE',   'DB-Fehler beim UPDATE');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_UNKNOWN')     or define('BX_CHECKSUM_SCANNER_AJAX_ERR_UNKNOWN',     'Unbekannte Aktion: ');
