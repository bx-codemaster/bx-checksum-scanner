<?php
/* -----------------------------------------------------------------------------------------
   BX Checksum Scanner - English Language File (Admin UI)

   modified eCommerce Shopsoftware
   http://www.modified-shop.org
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------------------------------- */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

// Page title & description
define('BX_CHECKSUM_SCANNER_TEXT_TITLE',            'BX Checksum Scanner');
define('BX_CHECKSUM_SCANNER_TEXT_DESCRIPTION',      'Monitors the integrity of shop files (PHP, HTML, CSS, JS) using MD5 checksums.');
define('BX_CHECKSUM_SCANNER_TEXT_LONG_DESCRIPTION', 'Scan all files and verify their integrity against the stored reference. New, changed, and deleted files will be detected.');
define('BX_CHECKSUM_SCANNER_TEXT_SETTINGS',         'Settings');

// Buttons
define('BX_CHECKSUM_SCANNER_BUTTON_SHOW',           'Check');
define('BX_CHECKSUM_SCANNER_BUTTON_RESET',          'Rebuild reference');

// Tooltips
define('BX_CHECKSUM_SCANNER_TOOLTIP_SHOW',          'Check all files against the stored reference');
define('BX_CHECKSUM_SCANNER_TOOLTIP_RESET',         'Create a new reference of all current files');

// Table headers
define('BX_CHECKSUM_SCANNER_TH_STATUS',             'Status');
define('BX_CHECKSUM_SCANNER_TH_FILE',               'File');
define('BX_CHECKSUM_SCANNER_TH_SIZE',               'Size (bytes)');
define('BX_CHECKSUM_SCANNER_TH_LASTSIZE',           'Previous size');
define('BX_CHECKSUM_SCANNER_TH_FILEDATE',           'File date');
define('BX_CHECKSUM_SCANNER_TH_DATEADDED',          'Added');
define('BX_CHECKSUM_SCANNER_TH_LASTCHECK',          'Last check');

// Status labels
define('BX_CHECKSUM_SCANNER_STATUS_OK',             'OK');
define('BX_CHECKSUM_SCANNER_STATUS_CHANGE',         'Changed');
define('BX_CHECKSUM_SCANNER_STATUS_DELETE',         'Deleted');
define('BX_CHECKSUM_SCANNER_STATUS_NEW',            'New');

// Messages
define('BX_CHECKSUM_SCANNER_NONEWFILES',            'No new files found.');
define('BX_CHECKSUM_SCANNER_FIRST_START',           'No reference found yet. Please run &quot;Rebuild reference&quot; first.');
define('BX_CHECKSUM_SCANNER_RESET',                 'Reference has been successfully rebuilt.');
define('BX_CHECKSUM_SCANNER_FIRST_RESET',           'Initial reference has been successfully created.');

// Info box (right column)
defined('BX_CHECKSUM_SCANNER_INFO_HEADING')         or define('BX_CHECKSUM_SCANNER_INFO_HEADING',         'BX Checksum Scanner');
defined('BX_CHECKSUM_SCANNER_INFO_ZWECK_HEAD')      or define('BX_CHECKSUM_SCANNER_INFO_ZWECK_HEAD',      'Purpose');
defined('BX_CHECKSUM_SCANNER_INFO_ZWECK_TEXT')      or define('BX_CHECKSUM_SCANNER_INFO_ZWECK_TEXT',      'The module calculates MD5 checksums for all PHP, HTML, CSS and JS files in the shop and stores them as a reference in the database. This allows reliable detection of subsequent changes, deleted files, or newly added files.');
defined('BX_CHECKSUM_SCANNER_INFO_USAGE_HEAD')      or define('BX_CHECKSUM_SCANNER_INFO_USAGE_HEAD',      'Usage');
defined('BX_CHECKSUM_SCANNER_INFO_USAGE_TEXT')      or define('BX_CHECKSUM_SCANNER_INFO_USAGE_TEXT',      '<ol style="margin:4px 0 0 14px;padding:0;"><li><strong>Build reference:</strong> On first use or after an update, click &ldquo;Rebuild reference&rdquo;. All files will be scanned and saved as the baseline.</li><li><strong>Check:</strong> Click &ldquo;Check&rdquo; to compare the current state of all files against the reference.</li><li><strong>Review results:</strong> Changed, deleted, and new files are highlighted in colour.</li></ol>');
defined('BX_CHECKSUM_SCANNER_INFO_STATUS_HEAD')     or define('BX_CHECKSUM_SCANNER_INFO_STATUS_HEAD',     'Status indicators');
defined('BX_CHECKSUM_SCANNER_INFO_STATUS_TEXT')     or define('BX_CHECKSUM_SCANNER_INFO_STATUS_TEXT',     '<table style="border-collapse:collapse;margin-top:4px;"><tr><td style="padding:2px 6px 2px 0"><span style="color:#62C650">&#9679;</span></td><td>File unchanged</td></tr><tr><td style="padding:2px 6px 2px 0"><span style="color:#9B20BF">&#9679;</span></td><td>File changed</td></tr><tr><td style="padding:2px 6px 2px 0"><span style="color:#C31D05">&#9679;</span></td><td>File deleted</td></tr><tr><td style="padding:2px 6px 2px 0"><span style="color:red">&#9679;</span></td><td>New file (not in reference)</td></tr></table>');

// AJAX error messages
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
