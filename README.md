# EthniGo

EthniGo is a website that finds tipical restaurants in your city.

## APIs

This project uses three public APIs: TomTom, Nominatim and WikiData.

## TomTom

TomTom is used to locate restaurants, using coordinates (lat & lon).

To get the API key you need to login on the developer page in TomTom website:
```text
https://developer.tomtom.com/
```

If you register in 2026 or later, you need to go here:
```text
https://my.tomtom.com/
```

API link:
```text
https://api.tomtom.com/search/2/categorySearch/ristorante.json?key=<API_KEY>&lat=<LAT>&lon=<LON>&categorySet=<CATEGORY_ID>
```

## Nominatim

Nominatim is used to get the city coordinates (lat & lon)

```text
https://nominatim.openstreetmap.org/search?format=json&city=<CITY_NAME>
```

## WikiData

WikiData is used to get cities area (in km²), used by TomTom to filter results.

With this we find the city ID by name:
```text
https://www.wikidata.org/w/api.php?action=wbsearchentities&search=<CITY_NAME>&language=it&format=json&limit=1
```

Then we can use the ID to get the area:

```text
https://www.wikidata.org/wiki/Special:EntityData/<CITY_ID>.json
```

## Database

The database with the logins and restaurants IDs is inside the res/ folder.

(Note that this database is only for educational purposes and cannot be used in real life situations!!)
