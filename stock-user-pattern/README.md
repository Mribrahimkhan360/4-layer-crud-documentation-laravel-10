# Stock — Laravel 4-Layer Architecture
# Pattern: UserController / UserService / UserRepository / UserRepositoryInterface

## ═══════════════════════════════════════════════════
## File Structure (mirrors User pattern exactly)
## ═══════════════════════════════════════════════════

app/
├── Http/
│   ├── Controllers/
│   │   └── StockController.php                        ← same as UserController
│   └── Requests/
│       ├── StockStoreRequest.php                      ← same as UserStoreRequest
│       └── StockUpdateRequest.php                     ← same as UserUpdateRequest
│
├── Services/
│   └── StockService.php                               ← same as UserService
│
├── Repositories/
│   ├── Contracts/
│   │   └── StockRepositoryInterface.php               ← same as UserRepositoryInterface
│   └── Eloquent/
│       └── StockRepository.php                        ← same as UserRepository
│
├── Models/
│   └── Stock.php                                      ← same as User model
│
└── Providers/
    └── AppServiceProvider.php                         ← binds Interface → Repository

routes/
└── web.php                                            ← Route::resource('stocks', ...)

database/migrations/
└── 2024_01_01_000001_create_stocks_table.php

resources/views/stocks/
├── index.blade.php                                    ← list all stocks
├── create.blade.php                                   ← jQuery append (bulk serial)
└── edit.blade.php                                     ← edit single stock

## ═══════════════════════════════════════════════════
## Setup Steps
## ═══════════════════════════════════════════════════

1. Copy all files into your Laravel project

2. Run migration:
      php artisan migrate

3. AppServiceProvider binding already done:
      StockRepositoryInterface::class → StockRepository::class

4. Ensure jQuery is loaded in layout:
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

5. Visit:
      /stocks          → index (list)
      /stocks/create   → create (jQuery append form)

## ═══════════════════════════════════════════════════
## User → Stock Pattern Mapping
## ═══════════════════════════════════════════════════

| User File                  | Stock File                   | Role              |
|----------------------------|------------------------------|-------------------|
| UserRepositoryInterface    | StockRepositoryInterface     | Contract          |
| UserRepository             | StockRepository              | DB Access         |
| UserService                | StockService                 | Business Logic    |
| UserController             | StockController              | HTTP Layer        |
| UserStoreRequest           | StockStoreRequest            | Create Validation |
| UserUpdateRequest          | StockUpdateRequest           | Update Validation |
| User (Model)               | Stock (Model)                | Eloquent ORM      |

## ═══════════════════════════════════════════════════
## Flow
## ═══════════════════════════════════════════════════

Browser POST /stocks
    │
    ▼
Route::resource (web.php)
    │
    ▼
StockStoreRequest          → validate product_id + serial_number[]
    │
    ▼
StockController            → $this->stockService->createBulkStocks()
    │
    ▼
StockService               → business logic, build rows array
    │
    ▼
StockRepositoryInterface   → contract (dependency inversion)
    │
    ▼
StockRepository            → $this->model->insert($rows)
    │
    ▼
Stock (Model)              → Eloquent → stocks table
    │
    ▼
redirect → /stocks → flash success
