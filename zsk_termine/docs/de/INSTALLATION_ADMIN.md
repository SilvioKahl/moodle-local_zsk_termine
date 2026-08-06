# Installationsanleitung: ZSK Nächste Termine

Anleitung für **Moodle-Site-Administratoren** – auch ohne viel Erfahrung mit Plugin-Installationen.

**Zwei zusammengehörige Plugins:**

| Anzeigename | Technischer Name | Ordner auf dem Server | Rolle |
|-------------|------------------|------------------------|--------|
| **ZSK Nächste Termine** | `local_zsk_termine` | `moodle/local/zsk_termine/` | Zentrale Terminverwaltung und Anzeige auf Startseite/Dashboard |
| **ZSK Termine zu diesem Kurs** | `mod_zsktermine` | `moodle/mod/zsktermine/` | Kursaktivität: Termine eines Kurses auf der Kursseite |

**Moodle-Version:** 4.1 oder höher.

---

## Was machen die Plugins?

- **ZSK Nächste Termine** ist das **Haupt-Plugin**. Hier legen berechtigte Personen Termine an (Prüfungstermine, Veranstaltungen, Fristen …). Die Kurzansicht „Nächste Termine“ erscheint auf **Dashboard** und optional auf der **Startseite**.
- **ZSK Termine zu diesem Kurs** ist **optional**, aber für Kurse empfohlen. Lehrende fügen im Kurs die Aktivität hinzu; sie zeigt nur die Termine, die diesem Kurs zugeordnet sind. **Termine werden nicht in der Aktivität gepflegt** – immer zentral über „Termine verwalten“.

> **Wichtig:** Das Aktivitätsmodul heißt im Ordner **`zsktermine`** (ohne Unterstrich). `mod/zsk_termine/` wird von Moodle **nicht** erkannt.

---

## Voraussetzungen

- Sie sind als **Administrator** auf der Moodle-Website angemeldet.
- Sie können Dateien auf den Server legen (**FTP/SFTP**, Dateimanager beim Hoster **oder** ZIP-Upload in Moodle).
- Sie kennen den **Moodle-Hauptordner** auf dem Server (z. B. `/var/www/html/moodle`).

---

## Schritt 1: Haupt-Plugin hochladen

### Variante A – ZIP in Moodle (einfach)

1. Als Administrator anmelden.
2. **Website-Administration** (Zahnrad) öffnen.
3. **Plugins → Plugins installieren**.
4. ZIP-Datei von **ZSK Nächste Termine** hochladen.
5. Den Anweisungen auf dem Bildschirm folgen.

### Variante B – Ordner per FTP/SFTP

1. ZIP auf dem Computer entpacken.
2. Den Ordner `zsk_termine` nach **`moodle/local/zsk_termine/`** kopieren.  
   Im Ordner `local/zsk_termine/` müssen u. a. `version.php` und `lib.php` liegen.

---

## Schritt 2: Plugin in Moodle aktivieren („Mitteilungen“)

1. **Website-Administration** öffnen.
2. Auf **Mitteilungen** klicken (erscheint oft automatisch nach dem Upload).  
   Alternativ: Menüpunkt **Mitteilungen** direkt wählen.
3. Mit **Weiter** / **Upgrade durchführen** bestätigen, bis „Aktuell“ angezeigt wird.

---

## Schritt 3: Caches leeren

**Website-Administration → Entwicklung → Caches leeren → Alle Caches leeren**

Ohne diesen Schritt sehen Nutzer manchmal noch keine Änderungen.

---

## Schritt 4: Anzeige auf Dashboard und Startseite

**Website-Administration → ZSK Termine → ZSK Darstellung nächste Termine**

| Einstellung | Empfehlung |
|-------------|------------|
| **Nächste Termine auf dem Dashboard (Mitte) erlauben** | Ja – zum Testen einschalten |
| **Nächste Termine auf der Startseite (Mitte) erlauben** | Nach Bedarf (siehe unten) |
| **Anzahl Termine in der Kurzansicht** | 3 (Standard) |

**Speichern** nicht vergessen.

### Startseite einrichten (nur wenn gewünscht)

1. Unter **Darstellung → Startseite & Dashboard** Startseite aktivieren (siehe oben).
2. **Website-Administration → Startseite → Startseite-Einstellungen**.
3. Bei **„Startseite nach Anmeldung“** das Element **„Nächste Termine“** auswählen.
4. Speichern.

> **Kostenlose Version:** Es ist nur **eine** Anzeige-Position gleichzeitig möglich – **entweder** Startseite **oder** Dashboard. Mit Premium-Lizenz können beide parallel genutzt werden.

---

## Schritt 5: Erste Kategorie und ersten Termin anlegen

1. Als Administrator anmelden.
2. Im Browser öffnen:  
   **`https://ihre-moodle-adresse/local/zsk_termine/manage.php`**
3. **Kategorie anlegen** (z. B. „Allgemein“ oder „Veranstaltungen“).
4. **Termin anlegen** – Titel, Datum/Uhrzeit, optional Ort und Beschreibung.
5. Speichern.

**Test:** Dashboard (`/my/`) öffnen – erscheint der neue Termin unter „Nächste Termine“?

Ohne mindestens eine **Kategorie** können keine Termine gespeichert werden.

---

## Schritt 6: Wer darf Termine pflegen?

Site-Administratoren dürfen **immer** alles. Zusätzlich können Sie andere Personen berechtigen.

### Berechtigte Benutzer eintragen

**Website-Administration → ZSK Termine → Berechtigungen ZSK Termine**

Direkt-URL: `/local/zsk_termine/manageaccess.php`

1. Im Feld **Berechtigte Benutzer** Namen suchen und auswählen.
2. **Speichern**.

> **Kostenlose Version:** Maximal **2** zusätzliche berechtigte Benutzer (neben Administratoren). Mit Premium unbegrenzt.

### Zugriffsmodus (optional)

**Website-Administration → ZSK Termine → ZSK Termine – Einstellungen**

- **Benutzerliste + Administratoren** (Standard) oder  
- **Nur Berechtigung „Termine verwalten“** (für Rollen in Moodle)

---

## Schritt 7: Kursaktivität installieren (empfohlen)

Nur nötig, wenn Termine **in einzelnen Kursen** sichtbar sein sollen.

### 7.1 Dateien hochladen

1. ZIP **ZSK Termine zu diesem Kurs** entpacken.
2. Ordner nach **`moodle/mod/zsktermine/`** kopieren – **ohne** Unterstrich im Namen.
3. **Website-Administration → Mitteilungen** erneut ausführen.
4. **Caches leeren**.

### 7.2 Aktivität im Kurs hinzufügen (durch Kursverantwortliche)

1. Kurs öffnen.
2. **Aktivität oder Material anlegen** einschalten.
3. **ZSK Termine zu diesem Kurs** wählen.
4. Name vergeben, optional Kurzbeschreibung, speichern.

Die Aktivität listet nur Termine, die in der zentralen Pflege **diesem Kurs zugeordnet** wurden. Beim Anlegen eines Termins im Feld **Kurszuordnung** den passenden Kurs wählen.

---

## Schritt 8: E-Mail-Benachrichtigungen (optional)

**Website-Administration → ZSK Termine → ZSK Termine – Einstellungen**

- **E-Mail-Benachrichtigungen erlauben** aktivieren.

Beim **neuen** Termin kann die Pflegeperson optional eine E-Mail auslösen. Der Versand läuft **im Hintergrund** (Moodle-Cron).

**Voraussetzung:** Der **geplante Task (Cron)** Ihrer Moodle-Instanz muss regelmäßig laufen (typisch alle 5–15 Minuten). Ohne Cron kommen E-Mails verzögert oder gar nicht.

| Version | E-Mail |
|---------|--------|
| Kostenlos | Nur **Kurstermine**, max. **50** eingeschriebene Empfänger |
| Premium | Auch übergreifende Termine, Erinnerungen, Absagen, Statistik |

---

## Schritt 9: Premium-Lizenz (optional)

Ohne Lizenz funktionieren die **kostenlosen** Grenzen (siehe oben). Premium hebt u. a. Limits für Kategorien, Anzeige-Positionen, E-Mail und Pro-Funktionen (Webhook, iCal, Statistik) auf.

**Website-Administration → ZSK Termine → ZSK Termine – Lizenz**

| Reihenfolge | Feld | Inhalt |
|-------------|------|--------|
| 1 | **URL des Lizenzservers** | z. B. `https://ihr-server/zsk-license/api/v1/verify.php` → **Speichern** |
| 2 | Offline-Toleranz | Standard 7 Tage |
| 3 | **Premium-Lizenzschlüssel** | Präfix **`ZSK-TE-`** → speichern |

**Wichtig:** Zuerst URL, **danach** Schlüssel – sonst schlägt die Prüfung fehl.

Status prüfen: Auf derselben Seite wird der **Lizenzstatus** angezeigt.

---

## Checkliste nach der Installation

- [ ] `local/zsk_termine/` liegt im Moodle-Ordner `local/`
- [ ] Mitteilungen ohne Fehlermeldung durchgelaufen
- [ ] Caches geleert
- [ ] Mindestens **eine Kategorie** und **ein Test-Termin** angelegt
- [ ] Dashboard zeigt „Nächste Termine“ (wenn aktiviert)
- [ ] Optional: Startseite mit Element „Nächste Termine“ konfiguriert
- [ ] Berechtigte Pflege-Nutzer eingetragen
- [ ] Optional: `mod/zsktermine/` installiert und Aktivität im Testkurs getestet
- [ ] Optional: Premium-Lizenz mit Status „Premium“
- [ ] Optional: Cron läuft (für E-Mails)

---

## Häufige Probleme

| Problem | Lösung |
|---------|--------|
| Plugin erscheint nicht | Ordnerpfad prüfen: `local/zsk_termine/`, nicht z. B. `local/zsk_termine/zsk_termine/` |
| Keine Mitteilungen | Als Admin anmelden; ggf. **Mitteilungen** manuell aufrufen |
| Termine werden nicht angezeigt | Kategorie + Termin angelegt? Anzeige unter **ZSK Termine → Darstellung** aktiv? Caches geleert? |
| Nur Dashboard **oder** Startseite möglich | Kostenlose Version – Premium für beide Positionen |
| Aktivität fehlt im Kurs | `mod/zsktermine/` installiert? Mitteilungen für **beide** Plugins ausgeführt? |
| `mod/zsk_termine/` funktioniert nicht | Falscher Ordnername – muss **`zsktermine`** heißen (ohne `_`) |
| E-Mails kommen nicht | Cron einrichten lassen; nur **neue** Termine; bei Kursterminen eingeschriebene Nutzer |
| Doppelte Menüpunkte „Startseite & Dashboard“ | Altes Plugin `local_termine` noch aktiv – deinstallieren, Ordner löschen, Caches leeren |
| Lizenz „ungültig“ | Zuerst Lizenzserver-URL speichern; Schlüssel mit Präfix `ZSK-TE-` |

---

## Upgrade von älteren Plugins (`local_termine` / `mod_termine`)

Wenn Sie früher **Termine** (ohne „ZSK“) nutzten:

1. Neue Plugins installieren, **beide** upgraden.
2. Daten prüfen.
3. Alte Plugins deinstallieren.
4. Ordner `local/termine/` und `mod/termine/` vom Server **löschen**.
5. Caches leeren.

Ausführlich: [MIGRATION.md](../MIGRATION.md)

---

## Nützliche Adressen (Direkt-URLs)

Ersetzen Sie `ihre-moodle-adresse` durch Ihre Domain.

| Seite | URL |
|-------|-----|
| Termine verwalten | `/local/zsk_termine/manage.php` |
| Alle Termine (öffentlich) | `/local/zsk_termine/index.php` |
| Berechtigungen | `/local/zsk_termine/manageaccess.php` |
| Kategorien | `/local/zsk_termine/categories.php` |

---

## Weitere Hilfe

| Thema | Dokument |
|-------|----------|
| Alle Einstellungen | [EINSTELLUNGEN.md](EINSTELLUNGEN.md) |
| Dozenten | [KLICKANLEITUNG_DOZENTEN.md](KLICKANLEITUNG_DOZENTEN.md) |
| Studierende | [KLICKANLEITUNG_STUDENTEN.md](KLICKANLEITUNG_STUDENTEN.md) |
| Web-Services / REST (Premium) | [webservices.md](webservices.md) |
| Migration Legacy-Plugins | [MIGRATION.md](../MIGRATION.md) |
| moodle.org-Texte | [MOODLE_ORG_TERMINE.md](../../../../docs/MOODLE_ORG_TERMINE.md) |
| Gesamtübersicht ZSK-Plugins | [INSTALLATION_ADMIN.md](../../../../docs/INSTALLATION_ADMIN.md) |

---

*Stand: ZSK Nächste Termine 1.4.14 · ZSK Termine zu diesem Kurs 1.0.3*
