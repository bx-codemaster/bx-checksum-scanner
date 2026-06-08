# BX Checksum Scanner

**Autor:** Axel Benkert (benax)  
**Website:** [www.bx-coding.de](https://www.bx-coding.de)  
**Version:** v3.0.0  
**Stand:** 08.06.2026  
**Lizenz:** GNU General Public License v2  

---

## Sinn und Zweck

Der **BX Checksum Scanner** überwacht die Integrität aller relevanten Dateien eines modified-Shops. Er berechnet MD5-Prüfsummen für alle PHP-, HTML-, CSS- und JavaScript-Dateien und speichert diese als Referenz in der Datenbank.

Damit lassen sich folgende Szenarien zuverlässig erkennen:

- **Manipulierte Dateien** – z. B. durch Schadsoftware, Hacks oder unbeabsichtigte Änderungen
- **Gelöschte Dateien** – Dateien, die seit dem letzten Referenz-Scan nicht mehr vorhanden sind
- **Neu hinzugekommene Dateien** – Dateien, die nicht in der Referenz enthalten sind (z. B. nach einem Einbruch oder einem unkontrollierten Deployment)

Das Modul ist kein Virenscanner, sondern ein **Datei-Integritätsprüfer** – ähnlich wie `Tripwire` oder `AIDE` in Linux-Umgebungen.

---

## Handhabung

### 1. Modul aktivieren

Vor der ersten Nutzung muss das Modul über die modified-Systemmodulverwaltung aktiviert werden:

> **Admin → Module → System → BX Checksum Scanner → Installieren → Status: True**

### 2. Referenz aufbauen

Nach der Aktivierung – oder nach einem Shop-Update – zunächst eine neue Referenz erstellen:

1. Seite **BX Checksum Scanner** im Admin öffnen
2. Schaltfläche **„Referenz neu aufbauen"** klicken
3. Der Scanner läuft in Chunks (200 Dateien je Request) – der Fortschrittsbalken zeigt den Stand an
4. Nach Abschluss: „Referenz wurde erfolgreich neu aufgebaut."

> **Hinweis:** Der Aufbau der Referenz kann bei großen Shops (10.000+ Dateien) einige Sekunden dauern.

### 3. Integrität prüfen

Um den aktuellen Dateizustand gegen die gespeicherte Referenz zu vergleichen:

1. Schaltfläche **„Prüfen"** klicken
2. Alle bekannten Dateien werden Chunk-weise geprüft
3. Neue (nicht in der Referenz enthaltene) Dateien werden separat erkannt
4. Ergebnisse werden paginiert in einer Tabelle angezeigt

### 4. Ergebnis auswerten

| Farbe | Symbol | Bedeutung |
|---|---|---|
| 🟢 Grün | ✓ | Datei unverändert (OK) |
| 🟣 Lila | ✎ | Datei wurde geändert |
| 🔴 Rot | ✗ | Datei wurde gelöscht |
| 🔴 Rot | + | Neue Datei (nicht in Referenz) |

Geänderte Dateien sollten geprüft werden – bei legitimen Änderungen (z. B. nach einem Update) einfach eine neue Referenz aufbauen.

---

## Was hat sich geändert gegenüber dem Original-Modul?

Das ursprüngliche Modul (`checksum_scanner` von Self-Commerce / xtc-load.de, Stand 2018) wurde vollständig überarbeitet:

### Umbenennung (bx_-Präfix)

| Alt                              | Neu                            |
|----------------------------------|--------------------------------|
| `checksum_scanner.php`           | `bx_checksum_scanner.php`      |
| `checksum_scanner_ajax.php`      | `bx_checksum_scanner_ajax.php` |
| DB-Tabelle `checksum_scanner`    | `bx_checksum_scanner`          |
| Klasse `checksum_scanner`        | `bx_checksum_scanner`          |
| Icons-Ordner `checksum_scanner/` | `bx_checksum_scanner/`         |
| Konstanten-Prefix                | `BX_CHECKSUM_SCANNER_*`        |

### Technische Überarbeitung

- **Chunked AJAX-Processing** statt synchronem PHP-Request-Ablauf: Scan und Prüfung laufen in konfigurierbaren Chunks (200 Dateien je Request), um PHP-Timeouts bei großen Shops zu vermeiden
- **Fortschrittsbalken** während Scan und Prüfung
- **Batch-INSERT** via mehrzeiligem SQL (statt einzelner INSERTs pro Datei) → erheblich schneller
- **Bulk-UPDATE** mit `CASE WHEN`-Konstrukt → ein einzelner SQL-Request pro Status-Gruppe statt N einzelner UPDATEs
- **Temp-Datei statt Session** für die Dateiliste beim Scan (vermeidet `max_allowed_packet`-Probleme bei großen Shops)
- **Paginierte Ergebnisanzeige** im modified-Stil (Dropdown-Navigation, Eintragsanzeige)

### UI-Verbesserungen

- Ergebnistabelle mit korrektem `<thead>`/`<tbody>` und semantischem HTML (`<th>`)
- Deprecated HTML-Attribute (`border`, `cellspacing`, `cellpadding`, `align="texttop"`) durch CSS ersetzt
- Pagination mit Seiten-Dropdown statt langer Link-Kette (257 Seiten = ein Dropdown, kein DOM-Bloat)
- Info-Box in der rechten Spalte mit Zweck, Handhabung und Statuslegende
- Flexbox-Layout im Headboard-Bereich
- CSS in separate `extra/css/`-Datei ausgelagert
- JavaScript in separate `extra/javascript/`-Datei ausgelagert

### Mehrsprachigkeit

- Alle angezeigten Texte (inkl. AJAX-Fehlermeldungen) als Sprachkonstanten (`BX_CHECKSUM_SCANNER_*`)
- Sprachdateien für **Deutsch** und **Englisch** (je `extra/admin/` und `modules/system/`)
- Alle Konstanten mit `defined() or define()` abgesichert gegen doppeltes Laden
- AJAX-Fehlermeldungen als Fallback-Konstanten direkt in der AJAX-Datei

### Sicherheit

- `ob_start()` vor `application_top.php` verhindert versehentliche Output-Ausgaben vor dem JSON-Header
- `session_write_close()` vor JSON-Ausgabe verhindert Session-Lock-Probleme
- CSRF-Token wird beim AJAX-Request mitgesendet
- Admin-Zugriffsrechte werden über `TABLE_ADMIN_ACCESS` verwaltet (`bx_checksum_scanner` + `bx_checksum_scanner_ajax`)

### Deinstallation

Das Systemmodul enthält eine `custom()`-Methode, die bei aktiviertem Modul das Löschen der Dateien verhindert und nach Deaktivierung alle ausgerollten Dateien sauber entfernt (inkl. veralteter Tabellen aus Vorgängerversionen: `bx_checksum_scanner_all`, `*_html`, `*_js`, `*_php`, `*_css`).

---

## Dateistruktur

```
src/
├── admin/
│   ├── bx_checksum_scanner.php             # Hauptseite
│   ├── bx_checksum_scanner_ajax.php        # AJAX-Endpoint
│   ├── images/icons/
│   │   ├── bx_checksum_scanner/            # Status-Icons (CSS, HTML, JS, PHP, OK, Edit, Delete, New)
│   │   └── heading/bx_checksum_scanner.png # Heading-Icon
│   └── includes/
│       ├── extra/
│       │   ├── css/bx_checksum_scanner.php         # Styles
│       │   ├── filenames/bx_checksum_scanner.php   # FILENAME_BX_CHECKSUM_SCANNER*
│       │   ├── javascript/bx_checksum_scanner.php  # Frontend-JS (AJAX-Kette, Tabelle, Pagination)
│       │   └── menu/bx_checksum_scanner.php        # Admin-Menüeintrag
│       └── modules/system/
│           └── bx_checksum_scanner.php             # Systemmodul (Install/Remove/Custom)
└── lang/
    ├── german/
    │   ├── extra/admin/bx_checksum_scanner.php     # DE UI-Texte
    │   └── modules/system/bx_checksum_scanner.php  # DE Modul-Texte
    └── english/
        ├── extra/admin/bx_checksum_scanner.php     # EN UI-Texte
        └── modules/system/bx_checksum_scanner.php  # EN Modul-Texte
```

---

## Datenbankschema

```sql
CREATE TABLE IF NOT EXISTS bx_checksum_scanner (
  `id`            INT(11)      NOT NULL AUTO_INCREMENT,
  `filepath`      TEXT,
  `hash`          VARCHAR(32)  DEFAULT NULL,
  `status`        INT(1)       NOT NULL,
  `filedate`      DATETIME     NOT NULL,
  `filesize`      BIGINT(20)   NOT NULL,
  `date_added`    DATETIME     NOT NULL,
  `last_check`    DATETIME     DEFAULT NULL,
  `last_filesize` BIGINT(20)   NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

| Feld            | Bedeutung                                               |
|-----------------|---------------------------------------------------------|
| `filepath`      | Absoluter Dateipfad                                     |
| `hash`          | MD5-Prüfsumme zum Zeitpunkt des letzten Referenz-Scans  |
| `status`        | 0/1 = OK, 2 = Geändert, 3 = Gelöscht                    |
| `filedate`      | Datei-Änderungsdatum beim Referenz-Scan                 |
| `filesize`      | Aktuelle Dateigröße (wird bei jedem Check aktualisiert) |
| `last_filesize` | Dateigröße zum Zeitpunkt der Referenz                   |
| `last_check`    | Zeitstempel der letzten Prüfung                         |
