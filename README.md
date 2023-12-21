# Json shema for pricelist data

[![Tests](https://github.com/erikroznbeker/pricelist-json-shema/actions/workflows/php.yml/badge.svg)](https://github.com/erikroznbeker/pricelist-json-shema/actions)

[schema.json](schema.json)  - json shema for pricelist data

### valid json:
```json
[
  {
    "name":"Pašareta",
    "price":2.99
  },
  {
    "group":"Pizza",
    "name":"Margarita",
    "price":10
  },
  {
    "group":"Pizza",
    "name":"Napolitana",
    "variations":[
      {
        "name":"small",
        "price":10.23
      },
      {
        "name":"big", 
        "price":15
      }
    ]
  }
]
```

## tests (and examples)

```composer install```

```composer test```
