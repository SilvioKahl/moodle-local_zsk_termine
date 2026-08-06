# Beschreibung – ZSK Termine

Gemeinsame Produktbeschreibung für die beiden zusammengehörigen Moodle-Plugins:

| Plugin | Technischer Name | Rolle |
|--------|------------------|--------|
| **ZSK Nächste Termine** | `local_zsk_termine` | Zentrale Terminverwaltung und plattformweite Anzeige |
| **ZSK Termine zu diesem Kurs** | `mod_zsktermine` | Kursaktivität zur Anzeige kursbezogener Termine |

**Version (Stand):** Local 1.4.14 · Mod 1.0.3 · Moodle 4.1+

Weitere Dokumentation: [README.md](README.md) · [INSTALLATION_ADMIN.md](INSTALLATION_ADMIN.md) · [EINSTELLUNGEN.md](EINSTELLUNGEN.md)

---

## Anliegen

Moodle-Instanzen sind Lern- und Kommunikationsplattformen – doch **wichtige Termine** (Prüfungen, Anmeldefristen, Veranstaltungen, Sprechstunden, Schulungen, Behördenfristen) landen in der Praxis oft **verstreut**: im Moodle-Kalender einzelner Kurse, in Forenbeiträgen, auf der Startseite als statischer HTML-Block, in externen PDFs oder per E-Mail an Verteilerlisten.

Betreiber und Verantwortliche wünschen sich dagegen:

- **eine zentrale, pflegbare Quelle** für institutionelle und kursbezogene Termine,
- **Sichtbarkeit dort, wo Nutzer ohnehin arbeiten** (Startseite, Dashboard, Kurs),
- **klare Zuständigkeiten** ohne volle Administrator-Rechte an jede Kursleitung,
- optional **Benachrichtigung und Anbindung** an Kalender- und Kommunikationssysteme.

Genau dieses Anliegen adressieren **ZSK Nächste Termine** und die ergänzende Kursaktivität **ZSK Termine zu diesem Kurs**.

---

## Welche Probleme werden wie gelöst?

### 1. Verstreute und veraltete Termininformationen

| Problem | Lösung |
|---------|--------|
| Termine stehen an mehreren Stellen (Kalender, Foren, Startseiten-HTML) und widersprechen sich | **Eine zentrale Terminverwaltung** (`local_zsk_termine`): Anlegen, Bearbeiten, Absagen an einer Stelle |
| Kursseiten zeigen keine aktuellen Termine, oder jede Kursleitung pflegt eigene Listen | **Kursaktivität** (`mod_zsktermine`) zeigt automatisch die dem Kurs zugeordneten Termine aus derselben Datenquelle – **ohne zweite Pflege** |
| Übergreifende Plattform-Termine vermischen sich mit Kursterminen | Termine können **site-weit** oder **einem Kurs zugeordnet** werden; die Kursaktivität filtert strikt auf den jeweiligen Kurs |

### 2. Geringe Sichtbarkeit für Lernende und Lehrende

| Problem | Lösung |
|---------|--------|
| Nutzer finden Termine nicht, weil sie den Kalender nicht öffnen | Kurzansicht **„Nächste Termine“** auf **Dashboard**, optional **Startseite** und **Meine Kurse** – integriert in die Moodle-Oberfläche, ohne separates Block-Plugin |
| Termine im Kurskontext fehlen | Aktivität **ZSK Termine zu diesem Kurs** listet kommende Kurstermine **direkt auf der Kursseite** unter der Aktivität (ohne zusätzlichen Klick) |
| Wichtige Termine gehen in langen Listen unter | **Kategorien mit Icons**, optional **Hervorhebung** (Premium) und **Absage-Kennzeichnung** |

### 3. Hoher Aufwand für die Plattform-Administration

| Problem | Lösung |
|---------|--------|
| Nur Site-Admins dürfen Termine pflegen | **Freigabeliste** oder Systemberechtigung „Termine verwalten“ – Delegation an Koordination, Sekretariat, Fachbereich ohne volle Admin-Rechte |
| Unklar, wer Termine anlegen darf | Getrennte Verwaltung unter **Termine verwalten** und **Berechtigungen ZSK Termine** |
| Testsysteme versenden versehentlich Massen-E-Mails | Master-Schalter **E-Mail-Versand aktivieren** – auf Testumgebungen abschaltbar |

### 4. Unzureichende Kommunikation bei neuen oder geänderten Terminen

| Problem | Lösung |
|---------|--------|
| Teilnehmende erfahren zu spät von Terminen | Optionale **E-Mail-Benachrichtigung** beim Anlegen neuer Termine (asynchron über Cron, batched) |
| Keine Erinnerung vor dem Termin | **Erinnerungs-E-Mails** konfigurierbar (Premium, Tage vor Beginn) |
| Absagen werden nicht mitgeteilt | Kennzeichnung **„Abgesagt“** in der Anzeige; Premium: **Absage-E-Mails** |
| Externe Kalender (Outlook, Google) bleiben abgekoppelt | Premium: **iCal-Abonnement**, **Webhook** (JSON bei Änderungen), **REST-Webdienste** |

### 5. Fehlende Struktur und Auswertung

| Problem | Lösung |
|---------|--------|
| Termine ohne thematische Ordnung | **Kategorien** mit Name, Icon, Sortierung; optional englischer Kategoriename für mehrsprachige Oberflächen |
| Keine Transparenz über E-Mail-Reichweite | Premium: **E-Mail-Statistik** (Versand, Öffnungen, Klicks, Seitenaufrufe) |
| Einheitliche Kommunikation in mehreren Sprachen schwierig | Premium: **E-Mail-Vorlagen pro Kategorie und Sprache** |

### 6. Komplexe oder teure Alternativen

| Problem | Lösung |
|---------|--------|
| Moodle-Kalender ist aktivitätsbezogen, nicht institutionell zentral | ZSK Termine ergänzt Moodle um eine **redaktionelle, zentral gesteuerte Terminliste** – unabhängig vom persönlichen Kalender |
| Externe Event-Tools erfordern Doppelpflege oder SSO | Termine bleiben **in Moodle**; Premium optional an externe Systeme angebunden |
| Block-Plugins müssen pro Seite manuell platziert werden | Anzeige über **Output-Hooks** auf Startseite, Dashboard und Meine Kurse – konfigurierbar in den Plugin-Einstellungen |

---

## Zusammenspiel der beiden Plugins

```
┌─────────────────────────────────────────────────────────────┐
│  local_zsk_termine – Zentrale Terminverwaltung             │
│  • Termine anlegen / bearbeiten / absagen                   │
│  • Kategorien, Berechtigungen, E-Mail, Premium-Features     │
│  • Anzeige: Startseite · Dashboard · Meine Kurse            │
└──────────────────────────┬──────────────────────────────────┘
                           │ gleiche Datenquelle
                           ▼
┌─────────────────────────────────────────────────────────────┐
│  mod_zsktermine – Kursaktivität (optional)                  │
│  • Lehrende fügen Aktivität im Kurs hinzu                   │
│  • Zeigt nur Termine mit Kurszuordnung                      │
│  • Keine eigene Termin-Pflege in der Aktivität              │
└─────────────────────────────────────────────────────────────┘
```

**Kernprinzip:** Pflege **zentral**, Anzeige **kontextbezogen** (plattformweit und im Kurs).

---

## Zielgruppen und Nutzen

| Zielgruppe | Nutzen |
|------------|--------|
| **Moodle-Betreiber / IT** | Weniger Support-Anfragen („Wo steht der Termin?“), kontrollierbarer E-Mail-Versand, Freemium-Einstieg mit Premium-Erweiterung |
| **Administration / Koordination** | Zentrale Pflege, Kategorien, Absagen, Delegation an definierte Nutzer |
| **Lehrende / Kursverantwortliche** | Kursaktivität einfügen – Termine erscheinen automatisch, wenn sie zentral dem Kurs zugeordnet wurden |
| **Lernende / Teilnehmende** | Kommende Termine auf Dashboard, Startseite, Meine Kurse und in relevanten Kursen – ohne Kalender-Suche |

---

## Freemium-Modell (Kurzüberblick)

| | Kostenlos | Premium (Lizenz `ZSK-TE-`) |
|---|-----------|----------------------------|
| Kategorien | max. 3 | unbegrenzt |
| Berechtigte Pflege-Nutzer | max. 2 | unbegrenzt |
| Anzeige Startseite + Dashboard | nur eine Position | beide parallel |
| Termine in Kurzansicht | max. 3 | bis 10 |
| E-Mail bei neuen Terminen | nur Kurstermine, max. 50 Empfänger | auch site-weit, alle Nutzer |
| Erinnerungen, Webhook, iCal, REST, Statistik | — | ja |

Details: [EINSTELLUNGEN.md](EINSTELLUNGEN.md)

---

## Abgrenzung: Was die Plugins nicht ersetzen

- **Kein persönlicher Moodle-Kalender** für Einzelnutzer (Termine, die Nutzer selbst anlegen)
- **Keine Raumbuchung** oder Ressourcenplanung
- **Keine Ticketing-** oder Anmeldeverwaltung für Veranstaltungen
- Die Kursaktivität ist **keine Pflegemaske** – Termine werden immer in der zentralen Verwaltung bearbeitet

---

## Fazit für Moodle-Betreiber

Mit **ZSK Nächste Termine** und optional **ZSK Termine zu diesem Kurs** erhalten Sie ein **schlankes, in Moodle integriertes Termin-Ökosystem**: eine Quelle der Wahrheit, sichtbare Termine an den üblichen Aufenthaltsorten der Nutzer, delegierbare Pflege und – bei Bedarf – professionelle Kommunikation und Anbindung über Premium-Funktionen.

Beide Plugins sind **GPL v3** und für Moodle **4.1+** ausgelegt (4.4+ empfohlen).

---

*Silvio Kuhn – die-schulungsexperten.de*
