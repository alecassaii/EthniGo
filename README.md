# EthniGo

EthniGo is a website that finds tipical restaurants in your city.

## APIs

This project uses two public APIs: TomTom and Nominatim.

## TomTom

TomTom is used to locate restaurants, using coordinates (lat & lon).

To  get the API key you need to register on the developer page in TomTom website:
```text
https://developer.tomtom.com/
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

## Database

The database with the logins and restaurants IDs is inside the res/ folder.

(Note that this database is only for educational purposes and cannot be used in real life situations!!)
