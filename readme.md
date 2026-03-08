# Laravel CRUD — User, Role & Permission Management
### 4-Layer Architecture with Spatie Laravel Permission

---

## 📦 Tech Stack

| Package | Version | Purpose |
|---|---|---|
| Laravel | 10.x / 11.x | PHP Framework |
| Spatie Permission | ^6.x | Role & Permission management |
| Bootstrap | 5.x | UI styling |
| Font Awesome | 6.x | Icons |

---

## 🏗️ Architecture Overview

This project follows a strict **4-Layer Architecture** to separate concerns and keep code clean, testable, and maintainable.

```
HTTP Request
     ↓
┌─────────────────────────────────┐
│  Layer 1 — Controller           │  Receives request, returns response
│  UserController                 │
│  RoleController                 │
│  PermissionController           │
└────────────────┬────────────────┘
                 ↓
┌─────────────────────────────────┐
│  Layer 2 — Service              │  Business logic (hashing, role assign)
│  UserService                    │
│  RoleService                    │
│  PermissionService              │
└────────────────┬────────────────┘
                 ↓
┌─────────────────────────────────┐
│  Layer 3 — Repository           │  Database queries only (Eloquent)
│  UserRepository                 │
│  RoleRepository                 │
│  PermissionRepository           │
└────────────────┬────────────────┘
                 ↓
┌─────────────────────────────────┐
│  Layer 4 — Model                │  Eloquent ORM + Spatie traits
│  User                           │
│  Role  (Spatie)                 │
│  Permission  (Spatie)           │
└─────────────────────────────────┘
```

---

## 📁 File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── UserController.php
│   │   ├── RoleController.php
│   │   └── PermissionController.php
│   └── Requests/
│       ├── StoreUserRequest.php
│       ├── StoreRoleRequest.php
│       └── StorePermissionRequest.php
│
├── Services/
│   ├── UserService.php
│   ├── RoleService.php
│   └── PermissionService.php
│
├── Repositories/
│   ├── Interfaces/
│   │   ├── UserRepositoryInterface.php
│   │   ├── RoleRepositoryInterface.php
│   │   └── PermissionRepositoryInterface.php
│   ├── UserRepository.php
│   ├── RoleRepository.php
│   └── PermissionRepository.php
│
├── Models/
│   └── User.php
│
└── Providers/
    └── AppServiceProvider.php

routes/
└── web.php

resources/views/
├── users/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── roles/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
└── permissions/
    ├── index.blade.php
    ├── create.blade.php
    └── edit.blade.php
```

---

## ⚙️ Installation

### 1. Clone & Install Dependencies

```bash
git clone https://github.com/your-repo/project.git
cd project
composer install
npm install && npm run dev
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Configure your `.env` database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 3. Install Spatie Laravel Permission

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

### 4. Run Migrations & Seeders

```bash
php artisan migrate
php artisan db:seed
```

### 5. Add Spatie Trait to User Model

```php
// app/Models/User.php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
}
```

---

## 🔗 Routes

Register all routes in `routes/web.php`:

```php
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

Route::resource('users',       UserController::class);
Route::resource('roles',       RoleController::class);
Route::resource('permissions', PermissionController::class)->except(['show']);
```

### Generated Route List

| Method | URL | Route Name | Controller Method |
|---|---|---|---|
| GET | `/users` | `users.index` | `index()` |
| GET | `/users/create` | `users.create` | `create()` |
| POST | `/users` | `users.store` | `store()` |
| GET | `/users/{user}/edit` | `users.edit` | `edit()` |
| PUT | `/users/{user}` | `users.update` | `update()` |
| DELETE | `/users/{user}` | `users.destroy` | `destroy()` |
| GET | `/roles` | `roles.index` | `index()` |
| GET | `/roles/create` | `roles.create` | `create()` |
| POST | `/roles` | `roles.store` | `store()` |
| GET | `/roles/{role}/edit` | `roles.edit` | `edit()` |
| PUT | `/roles/{role}` | `roles.update` | `update()` |
| DELETE | `/roles/{role}` | `roles.destroy` | `destroy()` |
| GET | `/permissions` | `permissions.index` | `index()` |
| GET | `/permissions/create` | `permissions.create` | `create()` |
| POST | `/permissions` | `permissions.store` | `store()` |
| GET | `/permissions/{permission}/edit` | `permissions.edit` | `edit()` |
| PUT | `/permissions/{permission}` | `permissions.update` | `update()` |
| DELETE | `/permissions/{permission}` | `permissions.destroy` | `destroy()` |

> Verify all routes anytime by running: `php artisan route:list --name=users`

---

## 🔒 Custom Form Requests (Validation)

Each module has a dedicated `FormRequest` class for validation.

### StoreUserRequest

| Field | Rules |
|---|---|
| `name` | required, string, min:3, max:255 |
| `email` | required, email, unique:users,email |
| `role` | required, exists:roles,name |
| `password` | required, string, min:8 |

### StoreRoleRequest

| Field | Rules |
|---|---|
| `name` | required, string, min:3, unique:roles,name |
| `permissions` | nullable, array |
| `permissions.*` | exists:permissions,name |

### StorePermissionRequest

| Field | Rules |
|---|---|
| `name` | required, string, min:3, unique:permissions,name |
| `guard_name` | nullable, string, in:web,api |

> On edit, `unique` rules automatically ignore the current record using the route parameter to avoid false conflicts.

---

## 💉 Dependency Injection — AppServiceProvider

Bind each repository interface to its concrete implementation in `AppServiceProvider`:

```php
// app/Providers/AppServiceProvider.php

public function register(): void
{
    $this->app->bind(UserRepositoryInterface::class,       UserRepository::class);
    $this->app->bind(RoleRepositoryInterface::class,       RoleRepository::class);
    $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
}
```

> Without these bindings, Laravel cannot resolve the interfaces via DI and will throw a `BindingResolutionException`.

---

## 🗄️ Database Tables (Spatie)

Spatie automatically creates these tables on migration:

| Table | Description |
|---|---|
| `users` | Application users |
| `roles` | Available roles (e.g. admin, editor) |
| `permissions` | Available permissions (e.g. create-user) |
| `model_has_roles` | Pivot — User ↔ Role |
| `model_has_permissions` | Pivot — User ↔ Permission |
| `role_has_permissions` | Pivot — Role ↔ Permission |

---

## 🌱 Seeder Example

```php
// database/seeders/RolesAndPermissionsSeeder.php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// Create permissions
Permission::create(['name' => 'create-user']);
Permission::create(['name' => 'edit-user']);
Permission::create(['name' => 'delete-user']);
Permission::create(['name' => 'view-user']);

// Create roles and assign permissions
$admin = Role::create(['name' => 'admin']);
$admin->givePermissionTo(Permission::all());

$editor = Role::create(['name' => 'editor']);
$editor->givePermissionTo(['view-user', 'edit-user']);

// Create a default admin user
$user = \App\Models\User::create([
    'name'     => 'Admin User',
    'email'    => 'admin@example.com',
    'password' => bcrypt('password'),
]);
$user->assignRole('admin');
```

Run the seeder:

```bash
php artisan db:seed --class=RolesAndPermissionsSeeder
```

---

## 🛡️ Using Permissions in Blade

```blade
{{-- Check role --}}
@role('admin')
    <a href="{{ route('users.create') }}">Add User</a>
@endrole

{{-- Check permission --}}
@can('create-user')
    <a href="{{ route('users.create') }}">Add User</a>
@endcan

{{-- Check multiple permissions --}}
@canany(['edit-user', 'delete-user'])
    <div>Action buttons here</div>
@endcanany
```

---

## 🔑 Using Permissions in Controller

```php
// Protect a single action
public function store(StoreUserRequest $request): RedirectResponse
{
    $this->authorize('create-user');

    $this->userService->createUser($request->validated());

    return redirect()->route('users.index')->with('success', 'User created.');
}
```

Or protect an entire controller via middleware in `web.php`:

```php
Route::resource('users', UserController::class)
    ->middleware(['auth', 'role:admin']);
```

---

## 🧪 Useful Artisan Commands

```bash
# List all routes
php artisan route:list

# Clear all caches (run after config changes)
php artisan optimize:clear

# Re-run migrations fresh with seed
php artisan migrate:fresh --seed

# Clear Spatie permission cache
php artisan cache:forget spatie.permission.cache
```

---

## 📝 Blade Route Links Quick Reference

```blade
{{-- Index --}}
<a href="{{ route('users.index') }}">Users</a>

{{-- Create --}}
<a href="{{ route('users.create') }}">Add User</a>

{{-- Edit --}}
<a href="{{ route('users.edit', $user->id) }}">Edit</a>

{{-- Delete --}}
<form action="{{ route('users.destroy', $user->id) }}" method="POST"
      onsubmit="return confirm('Are you sure?')">
    @csrf
    @method('DELETE')
    <button type="submit">Delete</button>
</form>
```

---

## 👨‍💻 Author

Built with ❤️ using Laravel + Spatie Permission + 4-Layer Architecture.


# Laravel CRUD — User, Role & Permission Management
### 4-Layer Architecture with Spatie Laravel Permission

---

## 📦 Tech Stack

| Package | Version | Purpose |
|---|---|---|
| Laravel | 10.x / 11.x | PHP Framework |
| Spatie Permission | ^6.x | Role & Permission management |
| Bootstrap | 5.x | UI styling |
| Font Awesome | 6.x | Icons |

---

## 🏗️ Architecture Overview

This project follows a strict **4-Layer Architecture** to separate concerns and keep code clean, testable, and maintainable.

```
HTTP Request
     ↓
┌─────────────────────────────────┐
│  Layer 1 — Controller           │  Receives request, returns response
│  UserController                 │
│  RoleController                 │
│  PermissionController           │
└────────────────┬────────────────┘
                 ↓
┌─────────────────────────────────┐
│  Layer 2 — Service              │  Business logic (hashing, role assign)
│  UserService                    │
│  RoleService                    │
│  PermissionService              │
└────────────────┬────────────────┘
                 ↓
┌─────────────────────────────────┐
│  Layer 3 — Repository           │  Database queries only (Eloquent)
│  UserRepository                 │
│  RoleRepository                 │
│  PermissionRepository           │
└────────────────┬────────────────┘
                 ↓
┌─────────────────────────────────┐
│  Layer 4 — Model                │  Eloquent ORM + Spatie traits
│  User                           │
│  Role  (Spatie)                 │
│  Permission  (Spatie)           │
└─────────────────────────────────┘
```

---

## 📁 File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── UserController.php
│   │   ├── RoleController.php
│   │   └── PermissionController.php
│   └── Requests/
│       ├── StoreUserRequest.php
│       ├── StoreRoleRequest.php
│       └── StorePermissionRequest.php
│
├── Services/
│   ├── UserService.php
│   ├── RoleService.php
│   └── PermissionService.php
│
├── Repositories/
│   ├── Interfaces/
│   │   ├── UserRepositoryInterface.php
│   │   ├── RoleRepositoryInterface.php
│   │   └── PermissionRepositoryInterface.php
│   ├── UserRepository.php
│   ├── RoleRepository.php
│   └── PermissionRepository.php
│
├── Models/
│   └── User.php
│
└── Providers/
    └── AppServiceProvider.php

routes/
└── web.php

resources/views/
├── users/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── roles/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
└── permissions/
    ├── index.blade.php
    ├── create.blade.php
    └── edit.blade.php
```

---

## ⚙️ Installation

### 1. Clone & Install Dependencies

```bash
git clone https://github.com/your-repo/project.git
cd project
composer install
npm install && npm run dev
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Configure your `.env` database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 3. Install Spatie Laravel Permission

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

### 4. Run Migrations & Seeders

```bash
php artisan migrate
php artisan db:seed
```

### 5. Add Spatie Trait to User Model

```php
// app/Models/User.php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
}
```

---

## 🔗 Routes

Register all routes in `routes/web.php`:

```php
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

Route::resource('users',       UserController::class);
Route::resource('roles',       RoleController::class);
Route::resource('permissions', PermissionController::class)->except(['show']);
```

### Generated Route List

| Method | URL | Route Name | Controller Method |
|---|---|---|---|
| GET | `/users` | `users.index` | `index()` |
| GET | `/users/create` | `users.create` | `create()` |
| POST | `/users` | `users.store` | `store()` |
| GET | `/users/{user}/edit` | `users.edit` | `edit()` |
| PUT | `/users/{user}` | `users.update` | `update()` |
| DELETE | `/users/{user}` | `users.destroy` | `destroy()` |
| GET | `/roles` | `roles.index` | `index()` |
| GET | `/roles/create` | `roles.create` | `create()` |
| POST | `/roles` | `roles.store` | `store()` |
| GET | `/roles/{role}/edit` | `roles.edit` | `edit()` |
| PUT | `/roles/{role}` | `roles.update` | `update()` |
| DELETE | `/roles/{role}` | `roles.destroy` | `destroy()` |
| GET | `/permissions` | `permissions.index` | `index()` |
| GET | `/permissions/create` | `permissions.create` | `create()` |
| POST | `/permissions` | `permissions.store` | `store()` |
| GET | `/permissions/{permission}/edit` | `permissions.edit` | `edit()` |
| PUT | `/permissions/{permission}` | `permissions.update` | `update()` |
| DELETE | `/permissions/{permission}` | `permissions.destroy` | `destroy()` |

> Verify all routes anytime by running: `php artisan route:list --name=users`

---

## 🔒 Custom Form Requests (Validation)

Each module has a dedicated `FormRequest` class for validation.

### StoreUserRequest

| Field | Rules |
|---|---|
| `name` | required, string, min:3, max:255 |
| `email` | required, email, unique:users,email |
| `role` | required, exists:roles,name |
| `password` | required, string, min:8 |

### StoreRoleRequest

| Field | Rules |
|---|---|
| `name` | required, string, min:3, unique:roles,name |
| `permissions` | nullable, array |
| `permissions.*` | exists:permissions,name |

### StorePermissionRequest

| Field | Rules |
|---|---|
| `name` | required, string, min:3, unique:permissions,name |
| `guard_name` | nullable, string, in:web,api |

> On edit, `unique` rules automatically ignore the current record using the route parameter to avoid false conflicts.

---

## 💉 Dependency Injection — AppServiceProvider

Bind each repository interface to its concrete implementation in `AppServiceProvider`:

```php
// app/Providers/AppServiceProvider.php

public function register(): void
{
    $this->app->bind(UserRepositoryInterface::class,       UserRepository::class);
    $this->app->bind(RoleRepositoryInterface::class,       RoleRepository::class);
    $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
}
```

> Without these bindings, Laravel cannot resolve the interfaces via DI and will throw a `BindingResolutionException`.

---

## 🗄️ Database Tables (Spatie)

Spatie automatically creates these tables on migration:

| Table | Description |
|---|---|
| `users` | Application users |
| `roles` | Available roles (e.g. admin, editor) |
| `permissions` | Available permissions (e.g. create-user) |
| `model_has_roles` | Pivot — User ↔ Role |
| `model_has_permissions` | Pivot — User ↔ Permission |
| `role_has_permissions` | Pivot — Role ↔ Permission |

---

## 🌱 Seeder Example

```php
// database/seeders/RolesAndPermissionsSeeder.php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// Create permissions
Permission::create(['name' => 'create-user']);
Permission::create(['name' => 'edit-user']);
Permission::create(['name' => 'delete-user']);
Permission::create(['name' => 'view-user']);

// Create roles and assign permissions
$admin = Role::create(['name' => 'admin']);
$admin->givePermissionTo(Permission::all());

$editor = Role::create(['name' => 'editor']);
$editor->givePermissionTo(['view-user', 'edit-user']);

// Create a default admin user
$user = \App\Models\User::create([
    'name'     => 'Admin User',
    'email'    => 'admin@example.com',
    'password' => bcrypt('password'),
]);
$user->assignRole('admin');
```

Run the seeder:

```bash
php artisan db:seed --class=RolesAndPermissionsSeeder
```

---

## 🛡️ Using Permissions in Blade

```blade
{{-- Check role --}}
@role('admin')
    <a href="{{ route('users.create') }}">Add User</a>
@endrole

{{-- Check permission --}}
@can('create-user')
    <a href="{{ route('users.create') }}">Add User</a>
@endcan

{{-- Check multiple permissions --}}
@canany(['edit-user', 'delete-user'])
    <div>Action buttons here</div>
@endcanany
```

---

## 🔑 Using Permissions in Controller

```php
// Protect a single action
public function store(StoreUserRequest $request): RedirectResponse
{
    $this->authorize('create-user');

    $this->userService->createUser($request->validated());

    return redirect()->route('users.index')->with('success', 'User created.');
}
```

Or protect an entire controller via middleware in `web.php`:

```php
Route::resource('users', UserController::class)
    ->middleware(['auth', 'role:admin']);
```

---

## 🧪 Useful Artisan Commands

```bash
# List all routes
php artisan route:list

# Clear all caches (run after config changes)
php artisan optimize:clear

# Re-run migrations fresh with seed
php artisan migrate:fresh --seed

# Clear Spatie permission cache
php artisan cache:forget spatie.permission.cache
```

---

## 📝 Blade Route Links Quick Reference

```blade
{{-- Index --}}
<a href="{{ route('users.index') }}">Users</a>

{{-- Create --}}
<a href="{{ route('users.create') }}">Add User</a>

{{-- Edit --}}
<a href="{{ route('users.edit', $user->id) }}">Edit</a>

{{-- Delete --}}
<form action="{{ route('users.destroy', $user->id) }}" method="POST"
      onsubmit="return confirm('Are you sure?')">
    @csrf
    @method('DELETE')
    <button type="submit">Delete</button>
</form>
```

---

## 👨‍💻 Author

Built with ❤️ using Laravel + Spatie Permission + 4-Layer Architecture.


# Laravel Brand → Product → Stock Management

A full **4-Layer Architecture** Laravel application for managing Brands, Products, and Stock (Serial Numbers) using the **Repository Pattern**.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 10+ |
| Language | PHP 8.1+ |
| Database | MySQL / PostgreSQL |
| Frontend | Blade + Bootstrap 5 |
| Architecture | Controller → Service → Repository → Model |

---

## Architecture Overview

```
HTTP Request
     │
     ▼
┌─────────────────┐
│   Form Request  │  ← Validation (StoreRequest / UpdateRequest)
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   Controller    │  ← Handles HTTP, delegates to Service
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│    Service      │  ← Business logic (hashing, role assign, etc.)
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   Repository    │  ← Database queries via Eloquent
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│     Model       │  ← Eloquent ORM, relationships, casts
└─────────────────┘
```

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── BrandController.php
│   │   ├── ProductController.php
│   │   └── StockController.php
│   └── Requests/
│       ├── BrandStoreRequest.php
│       ├── BrandUpdateRequest.php
│       ├── ProductStoreRequest.php
│       ├── ProductUpdateRequest.php
│       ├── StockStoreRequest.php
│       └── StockUpdateRequest.php
├── Models/
│   ├── Brand.php
│   ├── Product.php
│   └── Stock.php
├── Repositories/
│   ├── Contracts/
│   │   ├── BrandRepositoryInterface.php
│   │   ├── ProductRepositoryInterface.php
│   │   └── StockRepositoryInterface.php
│   └── Eloquent/
│       ├── BrandRepository.php
│       ├── ProductRepository.php
│       └── StockRepository.php
├── Services/
│   ├── BrandService.php
│   ├── ProductService.php
│   └── StockService.php
└── Providers/
    └── RepositoryServiceProvider.php

database/
└── migrations/
    ├── 2024_01_01_000001_create_brands_table.php
    ├── 2024_01_01_000002_create_products_table.php
    └── 2024_01_01_000003_create_stocks_table.php

resources/views/
├── brands/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── products/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
└── stocks/
    ├── index.blade.php
    ├── create.blade.php
    └── edit.blade.php

routes/
└── web.php
```

---

## Database Schema

### `brands`
| Column | Type | Notes |
|---|---|---|
| id | bigIncrements | Primary Key |
| name | string(100) | Unique |
| created_at | timestamp | |
| updated_at | timestamp | |

### `products`
| Column | Type | Notes |
|---|---|---|
| id | bigIncrements | Primary Key |
| brand_id | foreignId | FK → brands.id (cascade delete) |
| name | string(150) | |
| created_at | timestamp | |
| updated_at | timestamp | |

### `stocks`
| Column | Type | Notes |
|---|---|---|
| id | bigIncrements | Primary Key |
| product_id | foreignId | FK → products.id (cascade delete) |
| serial_number | string(100) | Unique |
| created_at | timestamp | |
| updated_at | timestamp | |

---

## Installation

### 1. Clone the repository
```bash
git clone https://github.com/your-username/your-repo.git
cd your-repo
```

### 2. Install dependencies
```bash
composer install
npm install && npm run build
```

### 3. Environment setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run migrations
```bash
php artisan migrate
```

### 6. Register the Service Provider

Open `config/app.php` and add to the `providers` array:

```php
'providers' => [
    // ...
    App\Providers\RepositoryServiceProvider::class,
],
```

### 7. Serve the application
```bash
php artisan serve
```

Visit: `http://127.0.0.1:8000`

---

## Routes

| Method | URI | Controller@Action | Name |
|---|---|---|---|
| GET | /brands | BrandController@index | brands.index |
| GET | /brands/create | BrandController@create | brands.create |
| POST | /brands | BrandController@store | brands.store |
| GET | /brands/{id}/edit | BrandController@edit | brands.edit |
| PUT | /brands/{id} | BrandController@update | brands.update |
| DELETE | /brands/{id} | BrandController@destroy | brands.destroy |
| GET | /products | ProductController@index | products.index |
| GET | /products/create | ProductController@create | products.create |
| POST | /products | ProductController@store | products.store |
| GET | /products/{id}/edit | ProductController@edit | products.edit |
| PUT | /products/{id} | ProductController@update | products.update |
| DELETE | /products/{id} | ProductController@destroy | products.destroy |
| GET | /stocks | StockController@index | stocks.index |
| GET | /stocks/create | StockController@create | stocks.create |
| POST | /stocks | StockController@store | stocks.store |
| GET | /stocks/{id}/edit | StockController@edit | stocks.edit |
| PUT | /stocks/{id} | StockController@update | stocks.update |
| DELETE | /stocks/{id} | StockController@destroy | stocks.destroy |

---

## Feature Highlights

### Brand
- Simple CRUD with a unique brand name.
- Displays total product count per brand on the index page.

### Product
- Linked to a brand via dropdown select.
- Displays brand name and total stock (serial) count on the index page.

### Stock (Serial Numbers)
- Select a product, then add **one or more serial numbers** dynamically.
- The **"+ Add Another Serial"** button appends a new input row.
- Each serial number is validated for uniqueness before saving.
- Uses **bulk insert** (`Model::insert()`) for performance when saving multiple serials at once.
- Edit page updates a single serial number entry.

---

## Relationships

```
Brand  ──has many──▶  Product  ──has many──▶  Stock
                                               (serial_number)
```

```php
// Brand
$brand->products        // HasMany → Product

// Product
$product->brand         // BelongsTo → Brand
$product->stocks        // HasMany → Stock

// Stock
$stock->product         // BelongsTo → Product
$stock->product->brand  // Nested: BelongsTo → Brand
```

---

## Validation Rules Summary

### Brand Store / Update
| Field | Rules |
|---|---|
| name | required, string, max:100, unique:brands |

### Product Store / Update
| Field | Rules |
|---|---|
| brand_id | required, integer, exists:brands,id |
| name | required, string, max:150 |

### Stock Store
| Field | Rules |
|---|---|
| product_id | required, integer, exists:products,id |
| serial_numbers | required, array, min:1 |
| serial_numbers.* | required, string, max:100, distinct, unique:stocks |

### Stock Update
| Field | Rules |
|---|---|
| product_id | required, integer, exists:products,id |
| serial_number | required, string, max:100, unique (ignore self) |

---

## How Repository Binding Works

`RepositoryServiceProvider` binds each interface to its concrete Eloquent implementation:

```php
$this->app->bind(BrandRepositoryInterface::class,   BrandRepository::class);
$this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
$this->app->bind(StockRepositoryInterface::class,   StockRepository::class);
```

This means you can swap `BrandRepository` for any other implementation (e.g. an API-based repository) without touching the Service or Controller.

---

## License

MIT License. Free to use and modify.