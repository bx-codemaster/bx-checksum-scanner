<?php
/** -----------------------------------------------------------------------------------------
 * $Id: admin/includes/extra/css/bx_checksum_scanner.php 2026-06-08 benax $
 * modified eCommerce Shopsoftware
 * http://www.modified-shop.org
 *
 * Copyright (c) 2009 - 2013 [www.modified-shop.org]
 * -----------------------------------------------------------------------------------------
 * Released under the GNU General Public License
 * -----------------------------------------------------------------------------------------
 * BX Checksum Scanner – Admin-Styles
 * Copyright (c) 2026 Axel Benkert (benax)
 * www.bx-coding.de
 * 2026-06-08
 *
 * Gibt die CSS-Stile für die Admin-Seite bx_checksum_scanner.php aus
 * (Layout, Fortschrittsbalken, Tabelle, Statusfarben).
 * -----------------------------------------------------------------------------------------
 */
  defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

  if (basename($_SERVER['PHP_SELF']) == 'bx_checksum_scanner.php') {
?>
<style>
  /* BX Checksum Scanner Admin Styles */

  #bxCsProgress > div,
  .bxcs-button-panel {
    margin: 6px 0;
    padding: 12px 12px 10px 12px !important;
    background: #fdfdfd;
    border: 1px solid #d9d9d9;
    border-left: 3px solid #af417e;
    border-radius: 4px;
    box-shadow: inset 0 1px 0 #ffffff;
    overflow: hidden;
  }

  .bxcs-button-grid {
    margin-top: 2px;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: flex-start;
  }

  .bxcs-section {
    margin: 0;
  }

  #bxCsBtnShow,
  #bxCsBtnRebuild {
    margin: 2px 0 0 0;
  }

  #bxCsProgress {
    display: none;
    margin: 10px 0 6px 0;
  }
  /*
  #bxCsProgress > div {
    background: #ddd;
    border-radius: 3px;
    height: 20px;
    width: 100%;
    max-width: 480px;
    overflow: hidden;
  }
  */
  #bxCsProgressBar {
    background: #4a90d9;
    height: 100%;
    width: 0%;
    text-align: center;
    color: #fff;
    font-size: 11px;
    line-height: 20px;
    transition: width 0.15s;
  }

  #bxCsProgressText {
      margin-top: 4px;
  }

  .fixed_messageStack {
    position: fixed;
    top: 88px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
    width: 80%;
    padding: 10px 0;
    text-align: center;
    display: none;
  }
</style>
<?php } ?>