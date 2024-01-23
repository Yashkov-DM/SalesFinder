# Тестовое задание SalesFinder



## Описание endpoints

### GET /api/import?dateFrom=2024-01-22 - получить товары.

- dateFrom - Дата и время последнего изменения по товару.

**Responses**:

**_status 200_**
```
{
  "data": [
    {
      "id": 1,
      "nmId": 97091303,
      "supplierArticle": "Pure_D3_5000",
      "warehouseName": "Белая дача",
      "category": "Здоровье",
      "subject": "БАДы",
      "quantityFull": 0,
      "Price": 1630,
      "Discount": 71,
      "created_at": "2024-01-23T06:54:24.000000Z",
      "updated_at": "2024-01-23T06:54:24.000000Z"
    }
  ],
}
```

### POST /api/offered-price - предложить цену.

- stockList - список nmId товара
- offerRuleList - список правил подсчёта

**Request body**:
```
{
  "offerRuleList": [
    "staticRule"
  ],
  "stockList": [
    93057647,
    93057650,
    97091303
  ]
}
```

**Responses**:

**_status 200_**
```
{
  "data": [
    {
      "id": 1,
      "nmId": 97091303,
      "supplierArticle": "Pure_D3_5000",
      "warehouseName": "Белая дача",
      "category": "Здоровье",
      "subject": "БАДы",
      "quantityFull": 0,
      "Price": 1630,
      "Discount": 71,
      "created_at": "2024-01-23T06:54:24.000000Z",
      "updated_at": "2024-01-23T06:54:24.000000Z"
    }
  ],
}
```

### GET /api/stock?perPage=10&page=1 - получить список товаров.

- perPage - Кол-во выводимых записей на страницу.
- page - Номер страницы.

**Responses**:

**_status 200_**
```
{
  "data": [
    {
      "id": 1,
      "nmId": 97091303,
      "supplierArticle": "Pure_D3_5000",
      "warehouseName": "Белая дача",
      "category": "Здоровье",
      "subject": "БАДы",
      "quantityFull": 0,
      "Price": 1630,
      "Discount": 71,
      "created_at": "2024-01-23T06:54:24.000000Z",
      "updated_at": "2024-01-23T06:54:24.000000Z"
    }
  ],
}
```
