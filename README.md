# rex_config mit Ablaufdatum für REDAXO 5

Dieses Addon ermöglicht es, rex_config-Einträge mit Ablaufdatum anzulegen. Das kann nützlich sein, wenn man z.B. API-Auth-Codes nutzt, die nur eine gewisse Zeit lang gültig sind.

```php
// null wenn abgelaufen/nicht vorhanden
$apiKey = rex_transient::get('namespace', 'key');

if (is_null($apiKey)) {
  // get new api key...
}

// im letzten Parameter wird die Zeit in Sekunden angegeben
rex_transient::set('namespace', 'key', 'value', 60);
rex_transient::set('namespace', 'key', 'value', rex_transient::HOUR_IN_SECONDS * 3);

// löscht den Eintrag
rex_transient::remove('namespace', 'key');

// verfügbare Konstanten
rex_transient::MINUTE_IN_SECONDS // 60 Sekunden
rex_transient::HOUR_IN_SECONDS // 3600 Sekunden
rex_transient::DAY_IN_SECONDS // 86400 Sekunden

// verfügbare Helper-Funktionen
rex_transient::minutes(int $minutes = 1); // 60 Sekunden
rex_transient::hours(int $hours = 1); // 3600 Sekunden
rex_transient::days(int $days = 1); // 86400 Sekunden
```

## Features

Über das Addon können rex_config-Einträge gesetzt werden, die automatisch nach einer gewissen Zeit wieder gelöscht werden. Dabei funktioniert das Addon ziemlich genau wie rex_config, nur muss beim Anlegen eine Zeit in Sekunden gesetzt werden, um das Ablaufdatum festzusetzen.

## Installation

~Im REDAXO-Installer das Addon `transient`,~ alternativ die aktuelle Beta-Version auf [GitHub](../../tree/master) herunterladen und installieren. Das Addon verfügt über keine eigene Einstellungsseite.

## Lizenz

[MIT Lizenz](https://github.com/eaCe/transient/blob/master/LICENSE)

## Autoren

**eaCe**
https://github.com/eaCe
