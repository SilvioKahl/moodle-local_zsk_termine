# Klickanleitung für Dozenten

**Plugins:** ZSK Nächste Termine + optional ZSK Termine zu diesem Kurs

---

## Zwei Rollen verstehen

| Aufgabe | Wo? |
|---------|-----|
| Termine **anlegen und pflegen** | Zentrale Verwaltung (`/local/zsk_termine/manage.php`) – nur mit Berechtigung |
| Termine **im Kurs anzeigen** | Aktivität **ZSK Termine zu diesem Kurs** im Kurs hinzufügen |

**Termine werden nie in der Kursaktivität bearbeitet** – immer zentral.

---

## Teil A: Termin pflegen (wenn berechtigt)

Voraussetzung: Administrator, Eintrag in der Allowlist oder Capability `local/zsk_termine:manage`.

1. **Termine verwalten** öffnen (Navigation oder `/local/zsk_termine/manage.php`)
2. **Kategorie** wählen oder anlegen
3. **Termin anlegen** – Titel, Datum/Uhrzeit, Ort, Beschreibung
4. Bei **Kurstermin:** Feld **Kurszuordnung** setzen
5. Optional: E-Mail-Ankündigung, Erinnerung (Premium)
6. Speichern

Übersicht aller Termine: `/local/zsk_termine/index.php`

---

## Teil B: Kursaktivität hinzufügen

1. Kurs im Bearbeitungsmodus
2. **Aktivität oder Material anlegen** → **ZSK Termine zu diesem Kurs** (engl. UI: „Dates for this course“ / „ZSK course events“)
3. Name und optionale Beschreibung speichern

Auf der Kursseite erscheinen darunter die dem Kurs zugeordneten Termine (Tabs „All events“ / „Past events“).

---

## Mehrsprachigkeit

- UI-Texte (Tabs, leere Meldungen) folgen der Moodle-Sprache
- Kategorien: optional **Name (Englisch)** in der Kategorieverwaltung
- Aktivitätsname: bei Standardnamen Anzeige in der gewählten Sprache

---

## Häufige Fragen

**Ich sehe „Termine verwalten“ nicht.**  
→ Nur berechtigte Personen; Support um Freischaltung bitten.

**Aktivität zeigt keine Termine.**  
→ Termin muss in der Zentralpflege **diesem Kurs** zugeordnet sein; übergreifende Termine (`courseid = 0`) erscheinen nicht in der Aktivität.

**E-Mail ging nicht raus.**  
→ Cron muss laufen; bei Free nur Kurstermine, max. 50 Empfänger.
