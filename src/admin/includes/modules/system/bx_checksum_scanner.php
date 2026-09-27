<?php
/** -----------------------------------------------------------------------------------------
 * $Id: admin/includes/modules/system/bx_checksum_scanner.php 2026-06-08 benax $
 * modified eCommerce Shopsoftware
 * http://www.modified-shop.org
 *
 * Copyright (c) 2009 - 2013 [www.modified-shop.org]
 * -----------------------------------------------------------------------------------------
 * Released under the GNU General Public License
 * -----------------------------------------------------------------------------------------
 * BX Checksum Scanner – System-Modul-Klasse
 * Copyright (c) 2026 Axel Benkert (benax)
 * www.bx-coding.de
 * 2026-06-08
 *
 * Registriert das Modul im modified-Systemmodul-Framework und stellt
 * Install- / Remove-Methoden sowie Konfigurationsparameter bereit.
 * -----------------------------------------------------------------------------------------
 */

defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );

// include needed functions
class bx_checksum_scanner {
  public string $code;
  public string $version;
  public string $title;
  public string $description;
  public int $sort_order;
  public bool $enabled;
  private bool $_check;
  public string $development_status; // 'p' = production ready, 'd' = in development
  public bool $is_hot;               // Kennzeichnung als "Hot Module" für besondere Hervorhebung in der Admin-Oberfläche

  public function __construct() {
     $this->code        = 'bx_checksum_scanner';
     $this->version     = '3.2.0';
     $this->title       = MODULE_BX_CHECKSUM_SCANNER_TITLE;
     $this->description = MODULE_BX_CHECKSUM_SCANNER_DESC;
     $this->sort_order  = defined('MODULE_BX_CHECKSUM_SCANNER_SORT_ORDER') ? MODULE_BX_CHECKSUM_SCANNER_SORT_ORDER : 0;
     $this->enabled     = ((defined('MODULE_BX_CHECKSUM_SCANNER_STATUS') && MODULE_BX_CHECKSUM_SCANNER_STATUS == 'True') ? true : false);
     $this->development_status = 'p';
     $this->is_hot      = false; // Kennzeichnung als "Hot Module" für besondere Hervorhebung in der Admin-Oberfläche
  }

  public function process($file): void {
    if (isset($_POST['configuration']) && $_POST['configuration']['MODULE_BX_CHECKSUM_SCANNER_STATUS'] == 'True') {
      xtc_redirect(xtc_href_link(FILENAME_BX_CHECKSUM_SCANNER));
    }
  }

  public function display(): array {
    return array('text' => '<br /><div align="center">' . xtc_button(BUTTON_SAVE) .
                           xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_BX_CHECKSUM_SCANNER, 'set=' . $_GET['set'] . '&module=bx_checksum_scanner')) . "</div>");
  }

  public function check(): bool {
    if (!isset($this->_check)) {
      $check_query = xtc_db_query("SELECT configuration_value 
                                     FROM " . TABLE_CONFIGURATION . "
                                    WHERE configuration_key = 'MODULE_BX_CHECKSUM_SCANNER_STATUS'");
      $this->_check = xtc_db_num_rows($check_query);
    }
    return $this->_check;
  }

  public function install(): void {
    xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_BX_CHECKSUM_SCANNER_STATUS', 'False',  '6', '1', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
    xtc_db_query("CREATE TABLE IF NOT EXISTS bx_checksum_scanner (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `filepath` text,
                  `hash` varchar(32) default NULL,
                  `status` int(1) NOT NULL,
                  `filedate` DATETIME NOT NULL,
                  `filesize` BIGINT(20) NOT NULL,
                  `date_added` DATETIME NOT NULL,
                  `last_check` DATETIME DEFAULT NULL,
                  `last_filesize` BIGINT(20) NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=MYISAM" );
    xtc_db_query("ALTER TABLE " . TABLE_ADMIN_ACCESS . " ADD bx_checksum_scanner INT(1) NOT NULL DEFAULT '1'");
    xtc_db_query("UPDATE " . TABLE_ADMIN_ACCESS . " SET bx_checksum_scanner = 1");
    xtc_db_query("ALTER TABLE " . TABLE_ADMIN_ACCESS . " ADD bx_checksum_scanner_ajax INT(1) NOT NULL DEFAULT '1'");
    xtc_db_query("UPDATE " . TABLE_ADMIN_ACCESS . " SET bx_checksum_scanner_ajax = 1");
  }

  public function remove(): void {
    xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key in ('" . implode("', '", $this->keys()) . "')");
    xtc_db_query("DROP TABLE IF EXISTS bx_checksum_scanner");
    xtc_db_query("DROP TABLE IF EXISTS checksum_scanner");		    // falls die Tabelle von Vorgängerversionen noch existiert
    xtc_db_query("DROP TABLE IF EXISTS checksum_scanner_all");		// falls die Tabelle von Vorgängerversionen noch existiert
    xtc_db_query("DROP TABLE IF EXISTS checksum_scanner_html");	// falls die Tabelle von Vorgängerversionen noch existiert
    xtc_db_query("DROP TABLE IF EXISTS checksum_scanner_js");		// falls die Tabelle von Vorgängerversionen noch existiert
    xtc_db_query("DROP TABLE IF EXISTS checksum_scanner_php");		// falls die Tabelle von Vorgängerversionen noch existiert
    xtc_db_query("DROP TABLE IF EXISTS checksum_scanner_css");		// falls die Tabelle von Vorgängerversionen noch existiert
    xtc_db_query("ALTER TABLE " . TABLE_ADMIN_ACCESS . " DROP bx_checksum_scanner");
    xtc_db_query("ALTER TABLE " . TABLE_ADMIN_ACCESS . " DROP bx_checksum_scanner_ajax");
  }

  public function keys(): array {
    $key = array('MODULE_BX_CHECKSUM_SCANNER_STATUS');

    return $key;
  }

			
		public function custom(): void {
			global $messageStack;

			// Moduldateien dürfen erst entfernt werden, nachdem das Modul logisch
			// aus dem System abgemeldet wurde.
			if ($this->check()) {
				$messageStack->add_session(MODULE_BX_CHECKSUM_SCANNER_UNINSTALL_FIRST, 'error');
				return;
			}

			$delete = (isset($_GET['delete']) && $_GET['delete'] === 'true');

			if ($delete !== true) {
				return;
			}

			$result = true;
				
			// Diese Liste enthält die in der Live-Installation ausgerollten Dateien.
			$dirs_and_files   = array();
			$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'bx_checksum_scanner.php';
			$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'bx_checksum_scanner_ajax.php';
			$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'includes/extra/filenames/bx_checksum_scanner.php';
			$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'includes/extra/javascript/bx_checksum_scanner.php';
			$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'includes/extra/menu/bx_checksum_scanner.php';
			$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'images/icons/bx_checksum_scanner/icon_css.png';
			$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'images/icons/bx_checksum_scanner/icon_delete.png';
			$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'images/icons/bx_checksum_scanner/icon_edit.png';
			$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'images/icons/bx_checksum_scanner/icon_html.png';
			$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'images/icons/bx_checksum_scanner/icon_javascript.png';
			$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'images/icons/bx_checksum_scanner/icon_new.png';
			$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'images/icons/bx_checksum_scanner/icon_ok.png';
			$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'images/icons/bx_checksum_scanner/icon_php.png';
			$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'images/icons/heading/bx_checksum_scanner.png';
			$dirs_and_files[] = DIR_FS_CATALOG.DIR_ADMIN.'images/icons/bx_checksum_scanner';
			
			$dirs_and_files[] = DIR_FS_CATALOG.'lang/german/modules/system/bx_checksum_scanner.php';
			$dirs_and_files[] = DIR_FS_CATALOG.'lang/english/modules/system/bx_checksum_scanner.php';
			$dirs_and_files[] = DIR_FS_CATALOG.'lang/german/extra/admin/bx_checksum_scanner.php';
			$dirs_and_files[] = DIR_FS_CATALOG.'lang/english/extra/admin/bx_checksum_scanner.php';
				
			// Dateien löschen
			foreach ($dirs_and_files as $dir_or_file) {
        if (!$this->rrmdir($dir_or_file)) {
          $messageStack->add_session($dir_or_file.MODULE_BX_CHECKSUM_SCANNER_TEXT_COULD_NOT_BE_DELETED, 'error');
          $result = false;
        }
			}
				
			if ($result === true) {
				$messageStack->add_session(MODULE_BX_CHECKSUM_SCANNER_TEXT_SUCCSESSFULLY_REMOVED, 'success');
      } else {
				$messageStack->add_session(MODULE_BX_CHECKSUM_SCANNER_TEXT_DELETE_FAILED, 'error');
      }
				
			// Datei selbst löschen
			unlink(DIR_FS_CATALOG.DIR_ADMIN.'includes/modules/system/bx_checksum_scanner.php');
		}
			
		private function rrmdir(string $dir): bool {
			if (is_dir($dir)) {
				$objects = scandir($dir);
				foreach ($objects as $object) {
					if ($object != "." && $object != "..") {
						if (filetype($dir."/".$object) == "dir") {
							$this->rrmdir($dir."/".$object);
						} else {
							unlink($dir."/".$object);
						}
					}
				}
				reset($objects);
				rmdir($dir);
				return true;
			} elseif (is_file($dir)) {
				unlink($dir);
				return true;
			}
			return false;
		}

}
