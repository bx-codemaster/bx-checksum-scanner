<?php
/** --------------------------------------------------------------
 * $Id: admin/bx_checksum_scanner_ajax.php 2026-06-08 benax $
 * modified eCommerce Shopsoftware
 * http://www.modified-shop.org
 *
 * Copyright (c) 2009 - 2013 [www.modified-shop.org]
 * --------------------------------------------------------------
 * based on:
 * (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
 * (c) 2002-2003 osCommerce(manufacturers.php,v 1.14 2003/02/16); www.oscommerce.com
 * (c) 2003 nextcommerce (manufacturers.php,v 1.4 2003/08/14); www.nextcommerce.org
 * (c) 2006 xt:Commerce; www.xt-commerce.com
 *
 * Released under the GNU General Public License
 * --------------------------------------------------------------
 * BX Checksum Scanner – AJAX-Endpoint (Chunked Processing)
 * Copyright (c) 2026 Axel Benkert (benax)
 * www.bx-coding.de
 * 2026-06-08
 *
 * Aktionen (JSON-Antwort):
 *   POST  scan_init    - Tabelle leeren, Dateiliste in Temp-Datei schreiben,
 *                        GC verwaister Temp-Dateien (älter als 2 h)
 *   POST  scan_chunk   - Chunk hashen + Batch-INSERT in DB
 *   POST  check_init   - DB-Einträge laden, neue Dateien ermitteln
 *   POST  check_chunk  - Chunk prüfen + Bulk-UPDATE in DB
 *   GET   results      - Ergebnisse paginiert zurückgeben (nur lesend)
 *
 * Hilfsfunktionen:
 *   bx_cs_json()          - JSON-Ausgabe, beendet Script
 *   bx_cs_unlink()        - Sicheres Löschen (prüft is_file + is_writable)
 *   bx_cs_collect_files() - Rekursive Dateisammlung via DirectoryIterator
 *
 * Fehlerbehandlung:
 *   register_shutdown_function - wandelt PHP Fatal Errors in JSON um
 *   set_exception_handler      - wandelt uncaught Exceptions in JSON um
 * --------------------------------------------------------------
 */

ob_start();
require('includes/application_top.php');

// ---------------------------------------------------------------
// Globaler Fehler-Handler – wandelt jeden Fatal Error / Exception
// in eine saubere JSON-Antwort um (verhindert leere Antworten bei
// display_errors = Off auf Produktivservern)
// ---------------------------------------------------------------
register_shutdown_function(function () {
    $err = error_get_last();
    if ($err !== null && in_array($err['type'], array(E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR), true)) {
        while (ob_get_level()) ob_end_clean();
        http_response_code(500);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(array(
            'success' => false,
            'error'   => 'PHP Fatal Error: ' . $err['message'] . ' in ' . $err['file'] . ':' . $err['line'],
        ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
});

set_exception_handler(function (Throwable $e) {
    while (ob_get_level()) ob_end_clean();
    http_response_code(500);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(array(
        'success' => false,
        'error'   => get_class($e) . ': ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(),
    ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
});

// ---------------------------------------------------------------
// Sprachkonstanten – Fallback falls Sprachdatei nicht geladen wurde
// ---------------------------------------------------------------
defined('BX_CHECKSUM_SCANNER_AJAX_MODULE_DISABLED') or define('BX_CHECKSUM_SCANNER_AJAX_MODULE_DISABLED', 'Module disabled');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_RESET')    or define('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_RESET',    'DB error while resetting');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_TMP_WRITE')   or define('BX_CHECKSUM_SCANNER_AJAX_ERR_TMP_WRITE',   'Could not write temporary file');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_NO_SCAN')     or define('BX_CHECKSUM_SCANNER_AJAX_ERR_NO_SCAN',     'No active scan – please call scan_init first');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_FILELIST')    or define('BX_CHECKSUM_SCANNER_AJAX_ERR_FILELIST',    'Scan file list not found – please call scan_init again');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_INSERT')   or define('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_INSERT',   'DB error during INSERT');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_LOAD')     or define('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_LOAD',     'DB error while loading');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_NO_CHECK')    or define('BX_CHECKSUM_SCANNER_AJAX_ERR_NO_CHECK',    'No active check – please call check_init first');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_UPDATE')   or define('BX_CHECKSUM_SCANNER_AJAX_ERR_DB_UPDATE',   'DB error during UPDATE');
defined('BX_CHECKSUM_SCANNER_AJAX_ERR_UNKNOWN')     or define('BX_CHECKSUM_SCANNER_AJAX_ERR_UNKNOWN',     'Unknown action: ');

// ---------------------------------------------------------------
// JSON-Helper – leert Output-Buffer, setzt Header, gibt aus, beendet
// ---------------------------------------------------------------

function bx_cs_unlink(string $path): void {
    if (is_file($path) && is_writable($path)) {
        unlink($path);
    }
}

function bx_cs_json(array $data, int $status = 200): void {
    session_write_close();
    while (ob_get_level()) ob_end_clean();
    http_response_code($status);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

// ---------------------------------------------------------------
// Guards (application_top.php hat Auth + Admin-Status bereits geprüft)
// ---------------------------------------------------------------

if (!defined('MODULE_BX_CHECKSUM_SCANNER_STATUS') || MODULE_BX_CHECKSUM_SCANNER_STATUS !== 'True') {
    bx_cs_json(array('success' => false, 'error' => BX_CHECKSUM_SCANNER_AJAX_MODULE_DISABLED), 403);
}

// ---------------------------------------------------------------
// Datei-Sammlung via RecursiveDirectoryIterator
// ---------------------------------------------------------------

function bx_cs_collect_files(string $dir, array &$files): void {
    static $extensions = array('htm' => true, 'html' => true, 'js' => true, 'css' => true, 'php' => true);

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST,
        RecursiveIteratorIterator::CATCH_GET_CHILD  // nicht lesbare Verzeichnisse überspringen
    );

    foreach ($iterator as $file) {
        if (!$file->isFile()) continue;
        $path = $file->getPathname();
        // Pfadtrenner normalisieren (Windows-Kompatibilität)
        $path = str_replace('\\', '/', $path);
        $ext  = strtolower($file->getExtension());
        if (isset($extensions[$ext]) && strpos($path, 'templates_c/') === false) {
            $files[] = $path;
        }
    }
}

// ---------------------------------------------------------------
// Action-Dispatch
// ---------------------------------------------------------------

// 'results' ist eine lesende Aktion – nur via GET erlaubt.
// Schreibende Aktionen (scan_init, scan_chunk, check_init, check_chunk) nur via POST.
$action = '';
if (isset($_GET['action']) && (string)$_GET['action'] === 'results') {
    $action = 'results';
} elseif (isset($_POST['action'])) {
    $action = (string)$_POST['action'];
}

switch ($action) {
    // ----------------------------------------------------------
    // scan_init: Tabelle leeren, Dateiliste in Temp-Datei ablegen
    // (nicht in Session – MySQL max_allowed_packet wäre überschritten)
    // ----------------------------------------------------------
    case 'scan_init':
        // Garbage Collection: verwaiste Temp-Dateien älter als 2 Stunden löschen
        $tmp_dir = defined('SQL_CACHEDIR') ? SQL_CACHEDIR : sys_get_temp_dir();
        $gc_ttl  = 7200; // 2 Stunden in Sekunden
        if (is_dir($tmp_dir) && is_readable($tmp_dir)) {
            try {
                foreach (new DirectoryIterator($tmp_dir) as $gc_file) {
                    if (!$gc_file->isFile()) continue;
                    $gc_name = $gc_file->getFilename();
                    if (strncmp($gc_name, 'bx_cs_scan_', 11) !== 0 || substr($gc_name, -5) !== '.json') continue;
                    if ((time() - $gc_file->getMTime()) > $gc_ttl) {
                        bx_cs_unlink($gc_file->getPathname());
                    }
                }
            } catch (Exception $e) {
                // GC nicht möglich (fehlende Rechte) – scan_init trotzdem fortsetzen
            }
        }

        if (!xtc_db_query('TRUNCATE TABLE bx_checksum_scanner')) {
            bx_cs_json(array('success' => false, 'error' => BX_CHECKSUM_SCANNER_AJAX_ERR_DB_RESET));
        }

        $files = array();
        try {
            bx_cs_collect_files(DIR_FS_DOCUMENT_ROOT, $files);
        } catch (Exception $e) {
            bx_cs_json(array('success' => false, 'error' => 'collect_files: ' . $e->getMessage()));
        }
        $total = count($files);

        $tmp_file = (defined('SQL_CACHEDIR') ? SQL_CACHEDIR : sys_get_temp_dir() . DIRECTORY_SEPARATOR) . 'bx_cs_scan_' . session_id() . '.json';
        if (file_put_contents($tmp_file, json_encode($files)) === false) {
            bx_cs_json(array('success' => false, 'error' => BX_CHECKSUM_SCANNER_AJAX_ERR_TMP_WRITE));
        }

        $_SESSION['bx_checksum_scan'] = array(
            'mode'     => 'scan',
            'tmp_file' => $tmp_file,
            'total'    => $total,
            'done'     => 0,
        );

        bx_cs_json(array(
            'success' => true,
            'total'   => $total,
        ));
    break;

    // ----------------------------------------------------------
    // scan_chunk: N Dateien hashen + Batch-INSERT
    // ----------------------------------------------------------
    case 'scan_chunk':
        if (empty($_SESSION['bx_checksum_scan']) || $_SESSION['bx_checksum_scan']['mode'] !== 'scan') {
            bx_cs_json(array('success' => false, 'error' => BX_CHECKSUM_SCANNER_AJAX_ERR_NO_SCAN));
        }

        $chunk_size = 200;
        $offset     = isset($_POST['offset']) ? (int)$_POST['offset'] : (int)$_SESSION['bx_checksum_scan']['done'];
        $total      = (int)$_SESSION['bx_checksum_scan']['total'];
        $tmp_file   = $_SESSION['bx_checksum_scan']['tmp_file'];

        if (!file_exists($tmp_file)) {
            unset($_SESSION['bx_checksum_scan']);
            bx_cs_json(array('success' => false, 'error' => BX_CHECKSUM_SCANNER_AJAX_ERR_FILELIST));
        }
        $all_files = json_decode(file_get_contents($tmp_file), true);
        $chunk     = array_slice($all_files, $offset, $chunk_size);

        if (empty($chunk)) {
            unset($_SESSION['bx_checksum_scan']);
            bx_cs_unlink($tmp_file);
            bx_cs_json(array('success' => true, 'done' => $total, 'total' => $total, 'complete' => true));
        }

        $values = array();
        foreach ($chunk as $filepath) {
            if (!file_exists($filepath) || !is_readable($filepath)) continue;
            $hash = hash_file('md5', $filepath);
            if ($hash === false) continue;
            $filedate = date('Y-m-d H:i:s', (int)filemtime($filepath));
            $filesize = (int)filesize($filepath);
            $values[] = "('" . xtc_db_input($filepath) . "','"
                      . xtc_db_input($hash) . "','0','"
                      . xtc_db_input($filedate) . "','"
                      . $filesize . "',now(),'" . $filesize . "')";
        }

        if (!empty($values)) {
            $sql = "INSERT INTO `bx_checksum_scanner` (`filepath`,`hash`,`status`,`filedate`,`filesize`,`date_added`,`last_filesize`) VALUES "
                 . implode(',', $values);
            if (!xtc_db_query($sql)) {
                bx_cs_json(array('success' => false, 'error' => BX_CHECKSUM_SCANNER_AJAX_ERR_DB_INSERT));
            }
        }

        $done     = $offset + count($chunk);
        $complete = ($done >= $total);
        $_SESSION['bx_checksum_scan']['done'] = $done;
        if ($complete) {
            unset($_SESSION['bx_checksum_scan']);
            bx_cs_unlink($tmp_file);
        }

        bx_cs_json(array(
            'success'  => true,
            'done'     => $done,
            'total'    => $total,
            'complete' => $complete,
        ));
    break;

    // ----------------------------------------------------------
    // check_init: Anzahl DB-Einträge ermitteln + neue Dateien finden
    // (DB-Rows nicht in Session – MySQL max_allowed_packet)
    // ----------------------------------------------------------
    case 'check_init':
        $query = xtc_db_query("SELECT filepath FROM bx_checksum_scanner");
        if ($query === false) {
            bx_cs_json(array('success' => false, 'error' => BX_CHECKSUM_SCANNER_AJAX_ERR_DB_LOAD));
        }

        $db_paths = array();
        $total_check = 0;
        while ($row = xtc_db_fetch_array($query, true)) {
            $db_paths[$row['filepath']] = true;
            $total_check++;
        }

        // Einmaliger Scan – erkennt neue Dateien
        $all_files = array();
        try {
            bx_cs_collect_files(DIR_FS_DOCUMENT_ROOT, $all_files);
        } catch (Exception $e) {
            bx_cs_json(array('success' => false, 'error' => 'collect_files: ' . $e->getMessage()));
        }

        $new_files = array();
        foreach ($all_files as $path) {
            if (!isset($db_paths[$path])) {
                $new_files[] = str_replace(DIR_FS_DOCUMENT_ROOT, '', $path);
            }
        }

        $_SESSION['bx_checksum_check'] = array(
            'mode'  => 'check',
            'total' => $total_check,
            'done'  => 0,
        );

        bx_cs_json(array(
            'success'   => true,
            'total'     => $total_check,
            'new_files' => $new_files,
        ));
    break;

    // ----------------------------------------------------------
    // check_chunk: N Einträge prüfen + Bulk-UPDATE
    // ----------------------------------------------------------
    case 'check_chunk':
        if (empty($_SESSION['bx_checksum_check']) || $_SESSION['bx_checksum_check']['mode'] !== 'check') {
            bx_cs_json(array('success' => false, 'error' => BX_CHECKSUM_SCANNER_AJAX_ERR_NO_CHECK));
        }

        $chunk_size = 200;
        $offset     = isset($_POST['offset']) ? (int)$_POST['offset'] : (int)$_SESSION['bx_checksum_check']['done'];
        $total      = (int)$_SESSION['bx_checksum_check']['total'];

        // Direkt aus DB lesen (keine großen Session-Daten)
        $q = xtc_db_query("SELECT id, filepath, hash FROM bx_checksum_scanner ORDER BY id ASC
                           LIMIT " . $chunk_size . " OFFSET " . $offset);
        $chunk = array();
        while ($row = xtc_db_fetch_array($q, true)) {
            $chunk[] = array('id' => (int)$row['id'], 'filepath' => $row['filepath'], 'hash' => $row['hash']);
        }

        if (empty($chunk)) {
            unset($_SESSION['bx_checksum_check']);
            bx_cs_json(array('success' => true, 'done' => $total, 'total' => $total, 'complete' => true));
        }

        $ids_deleted = array();
        $ids_changed = array();
        $ids_ok      = array();

        foreach ($chunk as $row) {
            $id       = $row['id'];
            $exists   = file_exists($row['filepath']);
            $filesize = $exists ? (int)filesize($row['filepath']) : 0;
            $cur_hash = ($exists && is_readable($row['filepath'])) ? hash_file('md5', $row['filepath']) : false;

            if ($cur_hash === false) {
                $ids_deleted[$id] = $filesize;
            } elseif ($cur_hash !== $row['hash']) {
                $ids_changed[$id] = $filesize;
            } else {
                $ids_ok[$id] = $filesize;
            }
        }

        // Bulk-UPDATE je Status-Gruppe mit CASE WHEN für individuelle Dateigrößen
        foreach (array(3 => $ids_deleted, 2 => $ids_changed, 1 => $ids_ok) as $status => $group) {
            if (empty($group)) continue;
            $case_parts = array();
            foreach ($group as $id => $filesize) {
                $case_parts[] = 'WHEN ' . $id . ' THEN ' . $filesize;
            }
            $sql = "UPDATE bx_checksum_scanner SET status = '" . intval($status) . "', last_check = now(), "
                 . "filesize = (CASE id " . implode(' ', $case_parts) . " END) "
                 . "WHERE id IN (" . implode(',', array_keys($group)) . ")";
            if (!xtc_db_query($sql)) {
                bx_cs_json(array('success' => false, 'error' => BX_CHECKSUM_SCANNER_AJAX_ERR_DB_UPDATE));
            }
        }

        $done     = $offset + count($chunk);
        $complete = ($done >= $total);
        $_SESSION['bx_checksum_check']['done'] = $done;
        if ($complete) unset($_SESSION['bx_checksum_check']);

        bx_cs_json(array(
            'success'  => true,
            'done'     => $done,
            'total'    => $total,
            'complete' => $complete,
        ));
    break;

    // ----------------------------------------------------------
    // results: Ergebnisse paginiert zurückgeben
    // ----------------------------------------------------------
    case 'results':
        $page      = max(1, (int)(isset($_REQUEST['page'])     ? $_REQUEST['page']     : 1));
        $per_page  = min(200, max(10, (int)(isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 50)));
        $db_offset = ($page - 1) * $per_page;

        $count_query = xtc_db_query("SELECT COUNT(*) AS cnt FROM bx_checksum_scanner");
        $count_row   = xtc_db_fetch_array($count_query, true);
        $total       = (int)$count_row['cnt'];

        $query = xtc_db_query(
            "SELECT id, status, filepath, filesize, last_filesize, filedate, date_added, last_check
               FROM bx_checksum_scanner
              ORDER BY status DESC, filepath ASC
              LIMIT " . $per_page . " OFFSET " . $db_offset
        );

        $result_rows = array();
        while ($row = xtc_db_fetch_array($query, true)) {
            $result_rows[] = array(
                'id'            => (int)$row['id'],
                'status'        => (int)$row['status'],
                'filepath'      => str_replace(DIR_FS_DOCUMENT_ROOT, '', $row['filepath']),
                'filesize'      => (int)$row['filesize'],
                'last_filesize' => (int)$row['last_filesize'],
                'filedate'      => $row['filedate'],
                'date_added'    => $row['date_added'],
                'last_check'    => $row['last_check'],
            );
        }

        bx_cs_json(array(
            'success'  => true,
            'total'    => $total,
            'page'     => $page,
            'per_page' => $per_page,
            'rows'     => $result_rows,
        ));
    break;

    // ----------------------------------------------------------
    default:
        bx_cs_json(array('success' => false, 'error' => BX_CHECKSUM_SCANNER_AJAX_ERR_UNKNOWN . htmlspecialchars($action)), 400);
}
