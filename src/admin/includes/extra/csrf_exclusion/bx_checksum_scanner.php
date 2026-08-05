<?php
/**
 * BX Checksum Scanner - CSRF Exclusion
 *
 * Prevents CSRF token rotation on AJAX GET requests to
 * bx_checksum_scanner_ajax.php. Without this exclusion, later POST
 * requests can lose their action payload after CSRF validation clears
 * $_POST on token mismatch.
 */

if (!isset($module_exclusions) || !is_array($module_exclusions)) {
    $module_exclusions = array();
}

$module_exclusions[] = 'bx_checksum_scanner_ajax';
