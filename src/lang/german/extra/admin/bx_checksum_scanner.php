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
define('BX_CHECKSUM_SCANNER_NONEWFILES',            'Keine neuen Dateien gefunden.');
define('BX_CHECKSUM_SCANNER_FIRST_START',           'Noch keine Referenz vorhanden. Bitte zuerst &quot;Referenz neu aufbauen&quot; ausführen.');
define('BX_CHECKSUM_SCANNER_RESET',                 'Referenz wurde erfolgreich neu aufgebaut.');
define('BX_CHECKSUM_SCANNER_FIRST_RESET',           'Erste Referenz wurde erfolgreich erstellt.');

// Info-Box (rechte Spalte)
define('BX_CHECKSUM_SCANNER_INFO_HEADING',         'BX Prüfsummen Scanner');
define('BX_CHECKSUM_SCANNER_INFO_ZWECK_HEAD',      'Zweck');
define('BX_CHECKSUM_SCANNER_INFO_ZWECK_TEXT',      'Das Modul berechnet MD5-Prüfsummen aller PHP-, HTML-, CSS- und JS-Dateien des Shops und speichert diese als Referenz in der Datenbank. So können nachträgliche Änderungen, gelöschte oder neu hinzugekommene Dateien zuverlässig erkannt werden.');
define('BX_CHECKSUM_SCANNER_INFO_USAGE_HEAD',      'Handhabung');
define('BX_CHECKSUM_SCANNER_INFO_USAGE_TEXT',      '<ol style="margin:4px 0 0 14px;padding:0;"><li><strong>Referenz aufbauen:</strong> Beim ersten Start oder nach einem Update die Schaltfläche &bdquo;Referenz neu aufbauen&ldquo; anklicken. Alle Dateien werden gescannt und als Grundlage gespeichert.</li><li><strong>Prüfen:</strong> Mit &bdquo;Prüfen&ldquo; wird der aktuelle Zustand aller Dateien gegen die Referenz verglichen.</li><li><strong>Ergebnis auswerten:</strong> Geänderte, gelöschte und neue Dateien werden farblich hervorgehoben.</li></ol>');
define('BX_CHECKSUM_SCANNER_INFO_STATUS_HEAD',     'Statusanzeige');
define('BX_CHECKSUM_SCANNER_INFO_STATUS_TEXT',     '<table style="border-collapse:collapse;margin-top:4px;"><tr><td style="padding:2px 6px 2px 0"><span style="color:#62C650">●</span></td><td>Datei unverändert</td></tr><tr><td style="padding:2px 6px 2px 0"><span style="color:#9B20BF">●</span></td><td>Datei geändert</td></tr><tr><td style="padding:2px 6px 2px 0"><span style="color:#C31D05">●</span></td><td>Datei gelöscht</td></tr><tr><td style="padding:2px 6px 2px 0"><span style="color:red">●</span></td><td>Neue Datei (nicht in Referenz)</td></tr></table>');

// Fortschrittsanzeige
define('BX_CHECKSUM_SCANNER_PROGRESS_INIT',      'Initialisiere ...');
define('BX_CHECKSUM_SCANNER_PROGRESS_CHECKSUMS', 'Prüfsummen erstellen');
define('BX_CHECKSUM_SCANNER_PROGRESS_CHECK',     'Dateien prüfen');
define('BX_CHECKSUM_SCANNER_PROGRESS_LOADING',   'Lade Ergebnisse ...');

// Fallback-Fehlermeldungen (JS)
define('BX_CHECKSUM_SCANNER_ERR_SCAN_CHUNK',  'scan_chunk fehlgeschlagen');
define('BX_CHECKSUM_SCANNER_ERR_SCAN_INIT',   'scan_init fehlgeschlagen');
define('BX_CHECKSUM_SCANNER_ERR_CHECK_CHUNK', 'check_chunk fehlgeschlagen');
define('BX_CHECKSUM_SCANNER_ERR_CHECK_INIT',  'check_init fehlgeschlagen');
define('BX_CHECKSUM_SCANNER_ERR_RESULTS',     'Fehler beim Laden der Ergebnisse');

// Seitennummerierung
define('BX_CHECKSUM_SCANNER_PAGING_SHOWN',   'Angezeigt werden');
define('BX_CHECKSUM_SCANNER_PAGING_TO',      'bis');
define('BX_CHECKSUM_SCANNER_PAGING_TOTAL',   'von insgesamt');
define('BX_CHECKSUM_SCANNER_PAGING_ENTRIES', 'Einträgen');
define('BX_CHECKSUM_SCANNER_PAGING_PAGE',    'Seite');
define('BX_CHECKSUM_SCANNER_PAGING_OF',      'von');

// AJAX-Fehlermeldungen
define('BX_CHECKSUM_SCANNER_AJAX_MODULE_DISABLED', 'Modul deaktiviert');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_RESET',    'DB-Fehler beim Zurücksetzen');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_TMP_WRITE',   'Temp-Datei konnte nicht geschrieben werden');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_NO_SCAN',     'Kein aktiver Scan – bitte zuerst scan_init aufrufen');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_FILELIST',    'Scan-Dateiliste nicht gefunden – bitte scan_init erneut aufrufen');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_INSERT',   'DB-Fehler beim INSERT');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_LOAD',     'DB-Fehler beim Laden');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_NO_CHECK',    'Kein aktiver Check – bitte zuerst check_init aufrufen');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_UPDATE',   'DB-Fehler beim UPDATE');
define('BX_CHECKSUM_SCANNER_AJAX_ERR_UNKNOWN',     'Unbekannte Aktion: ');
