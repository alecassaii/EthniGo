# EthniGo

EthniGo is a website that finds tipical restaurants in your city.

## APIs

This project uses two public APIs: TomTom and Nominatim.

## TomTom

TomTom is used to actually locate the restaurants using coordinates (lat & lon).

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
https://nominatim.openstreetmap.org/search?format=json&city=<city_name>
```

## Website

[EthniGo](https://example.com/)
