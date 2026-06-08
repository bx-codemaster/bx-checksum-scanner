<?php
/** --------------------------------------------------------------
 * $Id: admin/bx_checksum_scanner.php 2026-06-08 benax $
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
 * 2016-05-12, updated for modified-shop 2.0.0.0, astaller, webald
 * 2018-09-18, updated for modified-shop 2.x to scan also new files, astaller
 * 2018-09-21, updated for modified-shop 2.x to faster scan also new files, p3e
 * 2018-09-24, updated for modified-shop 2.x Text adjustments, astaller
 * 2018-10-03, updated 5 time faster md5 hash calculation, p3e
 * 2018-10-04, updated now scans for css, html, js and php in one go, p3e
 * --------------------------------------------------------------
 * BX Checksum Scanner
 * Copyright (c) 2026 Axel Benkert (benax) www.bx-coding.de
 * 2026-06-08, complete reengineered
 * --------------------------------------------------------------
 */

require('includes/application_top.php');

require(DIR_WS_INCLUDES.'head.php');
?>
</head>
<body>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
<!-- body //-->
<table class="tableBody">
  <tr>
    <?php //left_navigation
    if (USE_ADMIN_TOP_MENU == 'false') {
      echo '<td class="columnLeft2">'.PHP_EOL;
      echo '<!-- left_navigation //-->'.PHP_EOL;
      require_once(DIR_WS_INCLUDES . 'column_left.php');
      echo '<!-- left_navigation eof //-->'.PHP_EOL;
      echo '</td>'.PHP_EOL;
    }
    ?>
    <!-- body_text //-->
    <td class="boxCenter">
      <div class="pageHeadingImage"><?php echo xtc_image(DIR_WS_ICONS.'heading/bx_checksum_scanner.png', BX_CHECKSUM_SCANNER_TEXT_TITLE, '', '', 'style="max-height: 40px;"'); ?></div>
      <div class="pageHeading pdg2"><?php echo BX_CHECKSUM_SCANNER_TEXT_TITLE; ?></div>
      <div class="main"><?php echo BX_CHECKSUM_SCANNER_TEXT_DESCRIPTION; ?></div>

      <div class="clear"></div>

      <table class="tableCenter" style="margin-top: 5px;">
        <tr>
          <td class="boxCenterLeft">

          <div id="headboard">
            <?php
              if (defined('MODULE_BX_CHECKSUM_SCANNER_STATUS') && MODULE_BX_CHECKSUM_SCANNER_STATUS == 'True') {
            ?>
            <div class="main"><?php echo BX_CHECKSUM_SCANNER_TEXT_LONG_DESCRIPTION; ?></div>
            <?php
              } else {
            ?>
              <div class="main">
                <strong><?php echo BX_CHECKSUM_SCANNER_TEXT_TITLE; ?></strong>
              </div>
              <div class="main">
                <a class="button" href="<?php echo xtc_href_link('module_export.php', 'set=system&module=bx_checksum_scanner'); ?>"><u><?php echo BX_CHECKSUM_SCANNER_TEXT_SETTINGS; ?></u></a>
              </div>
            <?php
              }
            ?>
          </div> <!-- eof headboard //-->

          <?php
            if (defined('MODULE_BX_CHECKSUM_SCANNER_STATUS') && MODULE_BX_CHECKSUM_SCANNER_STATUS == 'True') {
          ?>
            <div class="main bxcs-button-panel">
              <div class="bxcs-button-grid">
                <div class="bxcs-section">
                  <img src="<?php echo DIR_WS_ICONS; ?>bx_checksum_scanner/icon_css.png" alt="CSS" border="" title="CSS" />
                  <img src="<?php echo DIR_WS_ICONS; ?>bx_checksum_scanner/icon_html.png" alt="HTML" border="" title="HTML" />
                  <img src="<?php echo DIR_WS_ICONS; ?>bx_checksum_scanner/icon_javascript.png" alt="JS" border="" title="JS" />
                  <img src="<?php echo DIR_WS_ICONS; ?>bx_checksum_scanner/icon_php.png" alt="PHP" border="" title="PHP" />
                </div>
                <div class="bxcs-section">
                  <button type="button" id="bxCsBtnShow"  class="button" title="<?php echo BX_CHECKSUM_SCANNER_TOOLTIP_SHOW;  ?>" onclick="bxCsShow()">
                    <?php echo BX_CHECKSUM_SCANNER_BUTTON_SHOW;  ?>
                  </button>
                  <button type="button" id="bxCsBtnRebuild" class="button" title="<?php echo BX_CHECKSUM_SCANNER_TOOLTIP_RESET; ?>" onclick="bxCsRebuild()">
                    <?php echo BX_CHECKSUM_SCANNER_BUTTON_RESET; ?>
                  </button>
                </div>
              </div>
            </div>
            <!-- BOF Fortschrittsanzeige -->
            <div id="bxCsProgress">
              <div>
                <div id="bxCsProgressBar"></div>
              </div>
              <div id="bxCsProgressText" class="main"></div>
            </div> <!-- EOF Fortschrittsanzeige -->

            <!-- Ergebnisbereich -->
            <div id="bxCsResultArea" class="main"></div>
          <?php
            }
          ?>

          </td> <!-- eof boxCenterLeft //-->
          <td class="boxRight">
<?php
  $heading  = array();
  $contents = array();

  $heading[] = array('text' => '<strong>' . BX_CHECKSUM_SCANNER_INFO_HEADING . '</strong>');

  $contents[] = array('text' =>
    '<strong>' . BX_CHECKSUM_SCANNER_INFO_ZWECK_HEAD . '</strong><br />' .
    '<span class="smallText">' . BX_CHECKSUM_SCANNER_INFO_ZWECK_TEXT . '</span>'
  );
  $contents[] = array('text' => '<br />');
  $contents[] = array('text' =>
    '<strong>' . BX_CHECKSUM_SCANNER_INFO_USAGE_HEAD . '</strong>' .
    '<span class="smallText">' . BX_CHECKSUM_SCANNER_INFO_USAGE_TEXT . '</span>'
  );
  $contents[] = array('text' => '<br />');
  $contents[] = array('text' =>
    '<strong>' . BX_CHECKSUM_SCANNER_INFO_STATUS_HEAD . '</strong><br />' .
    '<span class="smallText">' . BX_CHECKSUM_SCANNER_INFO_STATUS_TEXT . '</span>'
  );

  if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
    $box = new box;
    echo $box->infoBox($heading, $contents);
  }
?>
          </td> <!-- eof boxRight //-->
       </tr>
      </table> <!-- eof tableCenter //-->
    </td> <!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>