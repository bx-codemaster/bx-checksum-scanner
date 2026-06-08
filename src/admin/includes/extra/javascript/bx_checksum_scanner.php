<?php
/** -----------------------------------------------------------------------------------------
 * $Id: admin/includes/extra/javascript/bx_checksum_scanner.php 2026-06-08 benax $
 * modified eCommerce Shopsoftware
 * http://www.modified-shop.org
 *
 * Copyright (c) 2009 - 2013 [www.modified-shop.org]
 * -----------------------------------------------------------------------------------------
 * Released under the GNU General Public License
 * -----------------------------------------------------------------------------------------
 * BX Checksum Scanner – Frontend-JavaScript (Admin UI)
 * Copyright (c) 2026 Axel Benkert (benax)
 * www.bx-coding.de
 * 2026-06-08
 *
 * Gibt das JavaScript für die Admin-Seite bx_checksum_scanner.php aus.
 * Steuert die chunked AJAX-Verarbeitung (Scan / Prüfung), Fortschrittsanzeige,
 * Ergebnis-Tabelle und Seitennummerierung. Alle Anzeigetexte werden über
 * PHP-Sprachkonstanten in das JS-Objekt `lang` injiziert.
 * -----------------------------------------------------------------------------------------
 */
  defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

  if (defined('MODULE_BX_CHECKSUM_SCANNER_STATUS') && 'True' == MODULE_BX_CHECKSUM_SCANNER_STATUS && basename($_SERVER['PHP_SELF']) == 'bx_checksum_scanner.php') {
?>
<script>
"use strict";
document.addEventListener('DOMContentLoaded', function () {

  var ajaxUrl    = '<?php echo FILENAME_BX_CHECKSUM_SCANNER_AJAX; ?>';
  var iconBase   = '<?php echo DIR_WS_ICONS; ?>bx_checksum_scanner/';
  var dateLocale = '<?php echo defined('DATE_LOCALE') ? str_replace('_', '-', DATE_LOCALE) : ''; ?>';
  var csrfName   = '<?php echo isset($_SESSION['CSRFName'])  ? $_SESSION['CSRFName']  : ''; ?>';
  var csrfToken  = '<?php echo isset($_SESSION['CSRFToken']) ? $_SESSION['CSRFToken'] : ''; ?>';
  var lang = <?php echo json_encode(array(
    'status_delete'      => BX_CHECKSUM_SCANNER_STATUS_DELETE,
    'status_change'      => BX_CHECKSUM_SCANNER_STATUS_CHANGE,
    'status_new'         => BX_CHECKSUM_SCANNER_STATUS_NEW,
    'status_ok'          => BX_CHECKSUM_SCANNER_STATUS_OK,
    'th_status'          => BX_CHECKSUM_SCANNER_TH_STATUS,
    'th_file'            => BX_CHECKSUM_SCANNER_TH_FILE,
    'th_size'            => BX_CHECKSUM_SCANNER_TH_SIZE,
    'th_lastsize'        => BX_CHECKSUM_SCANNER_TH_LASTSIZE,
    'th_filedate'        => BX_CHECKSUM_SCANNER_TH_FILEDATE,
    'th_dateadded'       => BX_CHECKSUM_SCANNER_TH_DATEADDED,
    'th_lastcheck'       => BX_CHECKSUM_SCANNER_TH_LASTCHECK,
    'no_new_files'       => BX_CHECKSUM_SCANNER_NONEWFILES,
    'first_start'        => BX_CHECKSUM_SCANNER_FIRST_START,
    'reset_ok'           => BX_CHECKSUM_SCANNER_RESET,
    'first_reset'        => BX_CHECKSUM_SCANNER_FIRST_RESET,
    'progress_init'      => BX_CHECKSUM_SCANNER_PROGRESS_INIT,
    'progress_checksums' => BX_CHECKSUM_SCANNER_PROGRESS_CHECKSUMS,
    'progress_check'     => BX_CHECKSUM_SCANNER_PROGRESS_CHECK,
    'progress_loading'   => BX_CHECKSUM_SCANNER_PROGRESS_LOADING,
    'err_scan_chunk'     => BX_CHECKSUM_SCANNER_ERR_SCAN_CHUNK,
    'err_scan_init'      => BX_CHECKSUM_SCANNER_ERR_SCAN_INIT,
    'err_check_chunk'    => BX_CHECKSUM_SCANNER_ERR_CHECK_CHUNK,
    'err_check_init'     => BX_CHECKSUM_SCANNER_ERR_CHECK_INIT,
    'err_results'        => BX_CHECKSUM_SCANNER_ERR_RESULTS,
    'paging_shown'       => BX_CHECKSUM_SCANNER_PAGING_SHOWN,
    'paging_to'          => BX_CHECKSUM_SCANNER_PAGING_TO,
    'paging_total'       => BX_CHECKSUM_SCANNER_PAGING_TOTAL,
    'paging_entries'     => BX_CHECKSUM_SCANNER_PAGING_ENTRIES,
    'paging_page'        => BX_CHECKSUM_SCANNER_PAGING_PAGE,
    'paging_of'          => BX_CHECKSUM_SCANNER_PAGING_OF,
  ), JSON_UNESCAPED_UNICODE); ?>;

  var pendingNewFiles = [];

  // ---- Hilfsfunktionen ----

  function setButtons(disabled) {
    document.getElementById('bxCsBtnShow').disabled    = disabled;
    document.getElementById('bxCsBtnRebuild').disabled = disabled;
  }

  function setProgress(done, total, label) {
    var wrap = document.getElementById('bxCsProgress');
    var bar  = document.getElementById('bxCsProgressBar');
    var txt  = document.getElementById('bxCsProgressText');
    wrap.style.display = 'block';
    var pct = total > 0 ? Math.round(done / total * 100) : 0;
    bar.style.width = pct + '%';
    bar.textContent = pct + '%';
    txt.textContent = label + ' (' + done + ' / ' + total + ')';
  }

  function hideProgress() {
    document.getElementById('bxCsProgress').style.display = 'none';
  }

  function setResult(html) {
    document.getElementById('bxCsResultArea').innerHTML = html;
  }

  function postAction(action, extra) {
    var params = 'action=' + encodeURIComponent(action);
    if (extra) {
      Object.keys(extra).forEach(function (k) {
        params += '&' + encodeURIComponent(k) + '=' + encodeURIComponent(extra[k]);
      });
    }
    if (csrfName) {
      params += '&' + encodeURIComponent(csrfName) + '=' + encodeURIComponent(csrfToken);
    }
    return fetch(ajaxUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: params
    }).then(function (r) {
      return r.json().then(function (data) {
        if (!r.ok) throw new Error(data.error || 'HTTP ' + r.status);
        return data;
      }).catch(function (e) {
        if (e.message && e.message !== 'HTTP ' + r.status) throw e;
        throw new Error('HTTP ' + r.status);
      });
    });
  }

  function getAction(action, extra) {
    var params = 'action=' + encodeURIComponent(action);
    if (extra) {
      Object.keys(extra).forEach(function (k) {
        params += '&' + encodeURIComponent(k) + '=' + encodeURIComponent(extra[k]);
      });
    }
    return fetch(ajaxUrl + '?' + params).then(function (r) {
      return r.json().then(function (data) {
        if (!r.ok) throw new Error(data.error || 'HTTP ' + r.status);
        return data;
      }).catch(function (e) {
        if (e.message && e.message !== 'HTTP ' + r.status) throw e;
        throw new Error('HTTP ' + r.status);
      });
    });
  }

  // ---- Scan-Kette (Referenz neu aufbauen) ----

  function runScanChunk(done, total) {
    return postAction('scan_chunk', { offset: done }).then(function (d) {
      if (!d.success) throw new Error(d.error || lang.err_scan_chunk);
      setProgress(d.done, d.total, lang.progress_checksums);
      if (d.complete) return;
      return runScanChunk(d.done, d.total);
    });
  }

  window.bxCsRebuild = function () {
    setButtons(true);
    setResult('');
    pendingNewFiles = [];
    setProgress(0, 1, lang.progress_init);
    postAction('scan_init')
      .then(function (d) {
        if (!d.success) throw new Error(d.error || lang.err_scan_init);
        setProgress(0, d.total, lang.progress_checksums);
        return runScanChunk(0, d.total);
      })
      .then(function () {
        hideProgress();
        setResult('<p style="color:#62C650;font-weight:bold;">' + lang.reset_ok + '</p>');
        setButtons(false);
      })
      .catch(function (e) {
        hideProgress();
        setResult('<p style="color:#C31D05;">' + e.message + '</p>');
        setButtons(false);
      });
  };

  // ---- Prüf-Kette (Anzeigen) ----

  function runCheckChunk(done, total) {
    return postAction('check_chunk', { offset: done }).then(function (d) {
      if (!d.success) throw new Error(d.error || lang.err_check_chunk);
      setProgress(d.done, d.total, lang.progress_check);
      if (d.complete) return;
      return runCheckChunk(d.done, d.total);
    });
  }

  window.bxCsShow = function () {
    setButtons(true);
    setResult('');
    pendingNewFiles = [];
    setProgress(0, 1, lang.progress_init);
    postAction('check_init')
      .then(function (d) {
        if (!d.success) throw new Error(d.error || lang.err_check_init);
        if (d.total === 0) {
          hideProgress();
          setResult('<p>' + lang.first_start + '</p>');
          setButtons(false);
          return Promise.resolve(null);
        }
        pendingNewFiles = d.new_files || [];
        setProgress(0, d.total, lang.progress_check);
        return runCheckChunk(0, d.total).then(function () {
          setProgress(d.total, d.total, lang.progress_loading);
          return bxCsLoadResults(1);
        });
      })
      .then(function () {
        hideProgress();
        setButtons(false);
      })
      .catch(function (e) {
        hideProgress();
        setResult('<p style="color:#C31D05;">' + e.message + '</p>');
        setButtons(false);
      });
  };

  // ---- Ergebnisse laden ----

  function bxCsLoadResults(page) {
    return getAction('results', { page: page, per_page: 50 }).then(function (d) {
      if (!d.success) throw new Error(d.error || lang.err_results);
      renderTable(d);
    });
  }

  window.bxCsPage = function (page) {
    setResult('');
    bxCsLoadResults(page).catch(function (e) {
      setResult('<p style="color:#C31D05;">' + e.message + '</p>');
    });
  };

  // ---- Tabelle rendern ----

  function esc(s) {
    return String(s)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  function fmtDate(s) {
    if (!s || s === '0000-00-00 00:00:00') return '-';
    var d = new Date(s.replace(' ', 'T'));
    if (isNaN(d.getTime())) return s;
    return d.toLocaleDateString(dateLocale || undefined, { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' });
  }

  var statusMap = {
    icon:  { 3: 'icon_delete', 2: 'icon_edit',   1: 'icon_ok',    0: 'icon_ok'    },
    label: { 3: 'status_delete', 2: 'status_change', 1: 'status_ok', 0: 'status_ok' },
    color: { 3: '#C31D05',     2: '#9B20BF',     1: '#62C650',   0: '#62C650'   }
  };

  function statusIcon(st) {
    var key   = statusMap.icon[st]  || 'icon_ok';
    var label = lang[statusMap.label[st] || 'status_ok'];
    return '<img src="' + iconBase + key + '.png" width="16" height="16" style="vertical-align:text-top" alt="' + esc(label) + '" title="' + esc(label) + '" />';
  }

  function renderTable(data) {
    var newIcon = '<img src="' + iconBase + 'icon_new.png" width="16" height="16" style="vertical-align:text-top" alt="' + esc(lang.status_new) + '" title="' + esc(lang.status_new) + '" />';
    var h = '<table class="dataTable w100 collapse">';
    h += '<thead><tr>';
    h += '<th class="dataTableHeadingContent" colspan="2">' + lang.th_status   + '</th>';
    h += '<th class="dataTableHeadingContent">'             + lang.th_file     + '</th>';
    h += '<th class="dataTableHeadingContent">'             + lang.th_size     + '</th>';
    h += '<th class="dataTableHeadingContent">'             + lang.th_lastsize + '</th>';
    h += '<th class="dataTableHeadingContent">'             + lang.th_filedate + '</th>';
    h += '<th class="dataTableHeadingContent">'             + lang.th_dateadded+ '</th>';
    h += '<th class="dataTableHeadingContent">'             + lang.th_lastcheck+ '</th>';
    h += '</tr></thead>';
    h += '<tbody>';

    // Neue Dateien nur auf Seite 1
    if (data.page === 1 && pendingNewFiles.length > 0) {
      pendingNewFiles.forEach(function (fp) {
        h += '<tr>';
        h += '<td class="dataTableContent" style="padding-right:5px">' + newIcon + '</td>';
        h += '<td class="dataTableContent" style="padding-right:5px"><span style="color:red">' + lang.status_new + '</span></td>';
        h += '<td class="dataTableContent" style="padding-right:5px">' + esc(fp) + '</td>';
        h += '<td class="dataTableContent" style="padding-right:5px">-</td>';
        h += '<td class="dataTableContent" style="padding-right:5px">-</td>';
        h += '<td class="dataTableContent" style="padding-right:5px">-</td>';
        h += '<td class="dataTableContent" style="padding-right:5px">-</td>';
        h += '<td class="dataTableContent">-</td>';
        h += '</tr>';
      });
    }

    // DB-Einträge
    data.rows.forEach(function (row) {
      var color = statusMap.color[row.status] || '#62C650';
      var label = lang[statusMap.label[row.status] || 'status_ok'];
      h += '<tr>';
      h += '<td class="dataTableContent" style="padding-right:5px">'  + statusIcon(row.status) + '</td>';
      h += '<td class="dataTableContent" style="padding-right:5px"><span style="color:' + color + '">' + label + '</span></td>';
      h += '<td class="dataTableContent" style="padding-right:5px">'  + esc(row.filepath)      + '</td>';
      h += '<td class="dataTableContent" style="padding-right:5px">'  + row.filesize           + '</td>';
      h += '<td class="dataTableContent" style="padding-right:5px">'  + row.last_filesize      + '</td>';
      h += '<td class="dataTableContent" style="padding-right:5px">'  + fmtDate(row.filedate)  + '</td>';
      h += '<td class="dataTableContent" style="padding-right:5px">'  + fmtDate(row.date_added)+ '</td>';
      h += '<td class="dataTableContent">'                            + fmtDate(row.last_check) + '</td>';
      h += '</tr>';
    });

    h += '</tbody></table>';

    // Pagination im modified-Stil
    var pages = Math.ceil(data.total / data.per_page);
    if (pages > 0) {
      var cur   = data.page;
      var from  = (cur - 1) * data.per_page + 1;
      var to    = Math.min(cur * data.per_page, data.total);

      h += '<div class="clear"></div>';
      h += '<div class="smallText pdg2 flt-l">';
      h += '<span style="line-height:28px;">' + lang.paging_shown + ' <b>' + from + '</b> ' + lang.paging_to + ' <b>' + to + '</b>';
      h += ' (' + lang.paging_total + ' <b>' + data.total + '</b> ' + lang.paging_entries + ')</span>';
      h += '</div>';

      if (pages > 1) {
        h += '<div class="smallText pdg2 flt-r">';
        h += lang.paging_page + ' <select onchange="bxCsPage(this.value)" style="margin:0 4px;">';
        for (var i = 1; i <= pages; i++) {
          h += '<option value="' + i + '"' + (i === cur ? ' selected="selected"' : '') + '>' + i + '</option>';
        }
        h += '</select>';
        h += ' ' + lang.paging_of + ' ' + pages + '&nbsp;&nbsp;';
        if (cur < pages) {
          h += '<a href="javascript:bxCsPage(' + (cur + 1) + ')" class="button">&raquo;</a>';
        }
        h += '</div>';
      }

      h += '<div class="clear"></div>';
    }

    setResult(h);
  }

});
</script>
<?php
  }
?>
