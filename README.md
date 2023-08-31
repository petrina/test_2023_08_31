## Task
- Реализовать возможность обмена средствами между кошельками пользователей.
- С каждой транзакции брать комиссию 2% в пользу системы.
- Подготовить данные (seed) для демонстрации (несколько пользователей, кошельков и заявок)
- Работа с системой осуществляется только через REST API.

Example:
```
1 The user A has 2 wallets USD - 100, UAH - 500
2 The user B has 3 wallets USD - 10, UAH - 2500, EUR - 400
3 Any user has ability to create requests:
   3.1 The user A creates a request to sell 50 USD for 2000 UAH
4 Any user has ability to get listing of requests except own price for buyer: 2040 UAH (2000 + 2%), 40UAH system fee
5 Any user who has ability, can apply request
6 After transaction user A wallets USD - 50, UAH - 2500, user B - USD - 60, UAH - 460, EUR - 400
7 The additional API endpoint: sum of system fee for date interval
   Example:
   Request : date_from = 2022-07-01 date_to = 2022-08-01
   Response [{currency: UAH, amount: 40}, {currency: USD, amount: 130}]
```
## Install
``git clone``

``copy .env.example to .env``

``update connection in .env``

`` add to .env next params ``
- TIME_LIVE_AUTH_TOKEN_MINUTES=10
- FEE_PERCENT=2

`` run migration and seeding ``

`` php artisan serve ``

## Using
- **Authentication**

POST /api/auth

**Params**:

_email_ table users -> email

_token_  table users -> token

**Response**:

```
{
    "success": true,
    "data": {
        "auth_token": "V3d3M1pSVUlSNzIwMjMtMDgtMzEgMTY6Mzk6MDg=",
        "current_time": "2023-08-31T16:39:08.938396Z",
        "current_time_timestamp": 1693499948,
        "auth_token_life_to": "2023-08-31T18:39:08.927393Z",
        "auth_token_life_to_timestamp": 1693507148
    }
}
```
- **Get My Wallets**

GET /api/wallets

**Header**

_Auth-Token_ response -> auth_token

**Response**:

```
{
    "success": true,
    "data": [
        {
            "walletId": 4,
            "currency": "UAH",
            "amount": 6000
        },
        {
            "walletId": 5,
            "currency": "USD",
            "amount": 300
        },
        {
            "walletId": 6,
            "currency": "EUR",
            "amount": 200
        }
    ]
}
```

- **Create Sell**

POST /api/wallets/{WALLET_ID}/sell

**Header**

_Auth-Token_ response -> auth_token

**Params**:

_count_ float, count of sell money

_price_ float, count of get money

_currency_ string, currency of get money

**Response**:

Header: status 204

- **Get Opened Sell**

GET /api/sells

**Header**

_Auth-Token_ response -> auth_token

**Response**:
```
{
    "success": true,
    "data": [
        {
            "id": 1,
            "sell": {
                "currency": "USD",
                "count": 50
            },
            "buy": {
                "currency": "UAH",
                "count": 2040
            }
        },
        {
            "id": 2,
            "sell": {
                "currency": "EUR",
                "count": 50
            },
            "buy": {
                "currency": "UAH",
                "count": 2550
            }
        }
    ]
}
```

- **Approve Sell**

GET /api/sells/{SELL_ID}/approve

**Header**

_Auth-Token_ response -> auth_token

**Response**:

Header: status 204

- **Report**

GET /api/report

**Response**

```
{
    "success": true,
    "data": [
        [
            "User Oleta Bahringer bought 50 EUR and fee 50 UAH at 2023-08-31 18:32:19"
        ]
    ]
}
```
