# Web-Services aktivieren (ZSK Termine API)

Diese Anleitung beschreibt die Schritte, die in der Praxis zum erfolgreichen Einrichten der **ZSK Termine API** führen – inklusive typischer Stolpersteine (falsche Admin-URL, falscher Shell-Befehl).

## Voraussetzungen

- Plugin **ZSK Termine** Version **1.3.0** (`2025061100`) oder neuer installiert und per **Website-Administration → Benachrichtigungen** aktualisiert.
- **Pro-Lizenz** aktiv (REST/Webhook sind Pro-Funktionen).
- Zugriff als **Hauptadministrator** (Manager der Website).

---

## Schritt 1: Web-Services global aktivieren

1. **Website-Administration** öffnen.
2. **Zusatzfunktionen** (engl. *Advanced features*) aufrufen.  
   Direkt-URL: `/admin/settings.php?section=optionalsubsystems`
3. **„Webservices aktivieren“** (`enablewebservices`) auf **Ja** stellen.
4. **Änderungen speichern**.

Ohne diese Einstellung sind viele Web-Service-Menüs nicht nutzbar.

---

## Schritt 2: REST-Protokoll aktivieren

1. In der **Admin-Suche** oben nach **„REST“** oder **„Protokolle“** suchen, oder direkt öffnen:  
   `/admin/webservice/protocols.php`
2. Beim **REST-Server** das Zahnrad öffnen.
3. **REST-Server aktivieren** → Speichern.

---

## Schritt 3: Plugin-Upgrade (Dienst registrieren)

1. **Website-Administration → Benachrichtigungen**
2. Upgrade für **ZSK Termine** ausführen, bis keine Meldungen mehr offen sind.

Danach erscheint der externe Dienst **„ZSK Termine API“** (Plugin: `local_zsk_termine`).

---

## Schritt 4: Externen Dienst prüfen

1. Admin-Suche: **„Integrierte Services“** / **„Externe Dienste“**, oder:  
   `/admin/settings.php?section=externalservices`
2. In der Liste muss **ZSK Termine API** stehen (Shortname: `zsk_termine`).
3. Über den Link **„Funktionen“** prüfen, dass vorhanden sind:
   - `local_zsk_termine_get_events` – Terminliste (JSON)
   - `local_zsk_termine_get_ical` – iCal-Inhalt (JSON)

Der Dienst ist im Plugin standardmäßig **aktiviert**; **Nutzer/innen: Alle Nutzer/innen** ist für den Start in Ordnung.

---

## Schritt 5: Token anlegen

### Wichtig: richtige URL

Die Token-Verwaltung liegt **nicht** unter `settings.php?section=webservicetokens`.  
Diese URL liefert oft **„Bereichsfehler“**.

**Korrekte URL:**

`/admin/webservice/tokens.php`

Alternativ: Admin-Suche nach **„Token verwalten“** oder **„Token erzeugen“**.

### Token erstellen

1. **Token hinzufügen** / **Token erzeugen**
2. Felder:
   - **Name:** z. B. `zsk_termine_api` (optional, zur Orientierung)
   - **Nutzer/in:** API-Benutzer oder Administrator (für Produktion eigenen technischen Benutzer empfehlen)
   - **Service:** **ZSK Termine API**
   - **IP-Beschränkung:** leer lassen (Test) oder später einschränken
   - **Gültig bis:** leer = kein Ablaufdatum
3. **Änderungen speichern**
4. **Token sofort kopieren** – ab Moodle 4.3 wird er nach Verlassen der Seite nicht mehr angezeigt.

Der Token ist ein **langer alphanumerischer Schlüssel** (z. B. `fd73bf06b4865d7903d7e9d0ab9495d5`).  
Die **Zahlen in der Token-Tabelle** (IDs) sind **nicht** der API-Schlüssel.

### Berechtigungen

Die API-Funktionen benötigen die Fähigkeit **`local/zsk_termine:view`**.  
Site-Administratoren haben diese in der Regel automatisch. Für einen separaten API-Benutzer die Rolle **Authentifizierte/r Benutzer/in** um diese Berechtigung ergänzen.

---

## Schritt 6: REST-Aufruf testen

### Browser (einfachster Test)

URL in die Adresszeile (ohne Leerzeichen, `WSTOKEN` ersetzen):

```text
http://IHRE-MOODLE-URL/webservice/rest/server.php?wstoken=WSTOKEN&wsfunction=local_zsk_termine_get_events&moodlewsrestformat=json&limit=5
```

**Erfolg:** JSON mit `"events":[...]`.

### Shell mit curl (Server / SSH)

**Nicht** die URL allein in die Shell eingeben – Bash interpretiert `http://…` als Dateipfad und `&` startet Hintergrundjobs.

```bash
curl -G "http://IHRE-MOODLE-URL/webservice/rest/server.php" \
  --data-urlencode "wstoken=WSTOKEN" \
  --data-urlencode "wsfunction=local_zsk_termine_get_events" \
  --data-urlencode "moodlewsrestformat=json" \
  --data-urlencode "limit=5"
```

**Beispiel erfolgreiche Antwort:**

```json
{
  "events": [
    {
      "id": 2,
      "title": "Virtueller Kaffee",
      "categoryid": 3,
      "categoryname": "Social Life",
      "location": "Cafeteria",
      "timestart": 1781859420,
      "timeend": 0,
      "cancelled": false,
      "courseid": 0,
      "url": "http://IHRE-MOODLE-URL/local/zsk_termine/view.php?id=2",
      "datetime": "19.06.2026 09:57"
    }
  ]
}
```

Nach dem ersten erfolgreichen Aufruf zeigt **Token verwalten** bei **„Letzter Zugriff“** einen Zeitstempel (nicht mehr „Nie“).

### iCal per REST (optional)

```bash
curl -G "http://IHRE-MOODLE-URL/webservice/rest/server.php" \
  --data-urlencode "wstoken=WSTOKEN" \
  --data-urlencode "wsfunction=local_zsk_termine_get_ical" \
  --data-urlencode "moodlewsrestformat=json"
```

---

## Schritt 7: Pro-Einstellungen (Webhook / Erinnerung)

Unter **Website-Administration → ZSK-Plugins → ZSK Termine – Einstellungen** (nach Upgrade):

| Einstellung | Bedeutung |
|-------------|-----------|
| **Erinnerung (Tage vor Terminbeginn)** | Automatische Erinnerungs-Mail (Cron, Pro) |
| **Webhook-URL (ausgehend)** | JSON-POST bei Anlegen/Ändern/Absagen eines Termins |
| **Webhook-Geheimnis (optional)** | Header `X-ZSK-Signature` (HMAC-SHA256) |

Diese Felder sind **unabhängig** vom REST-Token. Webhook = Moodle sendet **an** eine externe URL; REST-Token = externes System fragt Moodle **ab**.

### iCal-Abonnement ohne REST-Token

Bei aktiver Pro-Lizenz erscheint in denselben Einstellungen die **iCal-Abonnement-URL**:

`/local/zsk_termine/ical.php?token=…`

Diese URL kann in Outlook/Google als Kalenderabonnement eingetragen werden.

---

## Fehlerbehebung

| Problem | Ursache / Lösung |
|---------|------------------|
| **Bereichsfehler** bei `…?section=webservicetokens` | Falsche URL → `/admin/webservice/tokens.php` verwenden |
| `No such file or directory` in Bash | URL ohne `curl` eingegeben |
| `[1] 1240…` Hintergrundjobs in Bash | `&` in der URL – `curl -G` mit Anführungszeichen nutzen |
| `invalidtoken` | Falscher Token oder Token gelöscht → neuen anlegen |
| `pro_feature_required` | Pro-Lizenz prüfen |
| `Access control exception` | `local/zsk_termine:view` für API-Benutzer vergeben |
| Dienst **ZSK Termine API** fehlt | Plugin-Upgrade (Schritt 3) |
| Token-ID statt Schlüssel verwendet | Nur den langen Schlüssel aus der Erstellungsmaske nutzen |

---

## Admin-Suche (wenn Menüpfade unklar sind)

Auf der Seite **Website-Administration** oben suchen nach:

- `Webservices aktivieren`
- `REST`
- `Integrierte Services` / `Externe Dienste`
- `Token verwalten`

Die Menüstruktur unterscheidet sich je nach Moodle-Version (z. B. unter **Server** oder **Plugins**). Die **direkten URLs** und die Suche funktionieren zuverlässiger als feste Klickpfade.

---

## Sicherheit

- REST-Token wie ein Passwort behandeln; nicht in Chats, Repositories oder Screenshots teilen.
- Für Produktion: eigenen API-Benutzer, optional IP-Beschränkung am Token, Test-Token nach Einrichtung löschen und neuen Token erzeugen.
- Webhook-Geheimnis nur setzen, wenn der Empfänger die Signatur prüft.

---

## Kurz-Checkliste

- [ ] Webservices aktivieren (`enablewebservices`)
- [ ] REST-Server aktivieren
- [ ] ZSK Termine Plugin-Upgrade
- [ ] Dienst **ZSK Termine API** mit beiden Funktionen sichtbar
- [ ] Token unter `/admin/webservice/tokens.php` erzeugt und gespeichert
- [ ] `curl`- oder Browser-Test liefert JSON mit `events`
- [ ] Optional: Webhook-URL / iCal-Abonnement konfiguriert

---

## Siehe auch

- [termine.md](termine.md) – Plugin-Übersicht
- [Moodle-Doku: Webservices nutzen](https://docs.moodle.org/de/Webservices_nutzen)
