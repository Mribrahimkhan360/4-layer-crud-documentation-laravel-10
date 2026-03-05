# =============================================
# routes/web.php — এ add করো
# =============================================

use App\Http\Controllers\RoleController;

Route::resource('roles', RoleController::class);


# =============================================
# app/Providers/AppServiceProvider.php — এ add করো
# =============================================

use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\Eloquent\PermissionRepository;

public function register(): void
{
    $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
    $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
}
