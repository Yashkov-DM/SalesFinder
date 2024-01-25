# Тестовое задание SalesFinder



## Описание endpoints

### GET /api/import?dateFrom=2024-01-22 - импортировать товары.

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
  "current_page": 1,
  "per_page": 10
}
```

### GET offered-price/store/{store_id}/{group_id} - рассчитать цену для всех товаров магазина согласно правила.

- store_id - Id магазина из таблицы stores.
- group_id - Id группы рассчётов таблицы group_calculate_prices.

### GET /calculate-price - получить список групп правил.

- dateFrom - Дата и время последнего изменения по товару.

**Responses**:

**_status 200_**
```
{
  "data": [
    {
      "id": 1,
      "name": "staticRule",
      "conditionId": 1,
      "conditionValueFirst": 10,
      "conditionValueSecond": null,
      "expressionId": 1,
      "expressionValue": 50,
      "resultFieldName": "offerPrice",
      "quantityProduct": 207,
      "active": 1,
      "lastStartTime": "2024-01-25 16:55:58",
      "created_at": "2024-01-25T16:55:39.000000Z",
      "updated_at": "2024-01-25T16:55:58.000000Z"
    }
  ],
  "current_page": 1,
  "per_page": 10
}
```

### POST /calculate-price - создать список групп правил.

- conditionId - Id условия выполнения из таблицы conditions
- conditionValueFirst - первое значение (А)  
- conditionValueSecond - второе значение (B), в случае применения шаблона A<X<B  
- expressionId - Id выражения выполняемого в группе из таблицы expressions  
- expressionValue - величина(А) применяемая в шаблоне вычисления, например X + (X * A)/100    
- resultFieldName - название вычисляемого поля (Х в шаблоная X + (X * A)/100 или X<A)     

**Request body**:
```
{
  "name": "staticRule",
  "conditionId": 1,
  "conditionValueFirst": 10,
  "expressionValue": 50,
  "expressionId": 1,
  "resultFieldName": "offerPrice"  
}
```

### PUT /calculate-price/{group_id} - изменить список групп правил.

- group_id - Id группы

**Responses**:

**_status 200_**
```
{
  "data": [
    {
      "id": 1,
      "name": "staticRule",
      "conditionId": 1,
      "conditionValueFirst": 10,
      "conditionValueSecond": null,
      "expressionId": 1,
      "expressionValue": 50,
      "resultFieldName": "offerPrice",
      "quantityProduct": 207,
      "active": 1,
      "lastStartTime": "2024-01-25 16:55:58",
      "created_at": "2024-01-25T16:55:39.000000Z",
      "updated_at": "2024-01-25T16:55:58.000000Z"
    }
  ]
}
```

### POST /api/offered-price - предложить цену (из 1го задания).

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


