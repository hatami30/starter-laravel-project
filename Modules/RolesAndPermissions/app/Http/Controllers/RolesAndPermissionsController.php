<?php

namespace Modules\RolesAndPermissions\Http\Controllers;

use App\Models\TableSettings;
use App\Constants\TableConstants;
use App\Http\Requests\StoreTableSettingsRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modules\RolesAndPermissions\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsController extends Controller
{
    private const DEFAULT_LIMIT = 10;
    private const DEFAULT_SORT_BY = 'name';
    private const DEFAULT_SORT_ORDER = 'ASC';
    private const EXCLUDED_COLUMNS = ['permissions'];

    public function index(Request $request)
    {
        $savedSettings = $this->getTableSettingsForModel(Role::class);

        $limit = $request->get('limit', $savedSettings->limit ?? self::DEFAULT_LIMIT);
        $sortBy = $request->get('sort_by', self::DEFAULT_SORT_BY);
        $sortOrder = $request->get('sort_order', self::DEFAULT_SORT_ORDER);

        [$allColumns, $visibleColumns] = $this->getColumnsForTable();
        $queryColumns = array_diff($visibleColumns, self::EXCLUDED_COLUMNS);

        $roles = Role::search($request->q, $queryColumns)
            ->sort($sortBy, $sortOrder)
            ->paginate($limit)
            ->through(fn($role) => $role->setAttribute('permissions', $role->permissions->pluck('name')->toArray()));

        return view('rolesandpermissions::index', [
            'title' => 'Daftar Role dan Permission',
            'columns' => $allColumns,
            'visibleColumns' => $visibleColumns,
            'excludedSortColumns' => self::EXCLUDED_COLUMNS,
            'limits' => [5, 10, 20, 50, 100],
            'roles' => $roles,
            'savedSettings' => $savedSettings
        ]);
    }

    public function create()
    {
        return view('rolesandpermissions::create', [
            'title' => 'Buat Role dan Permission',
            'permissions' => Permission::all()->groupBy('module')
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'role_name' => 'required|string|max:255',
                'permissions' => 'required|array',
                'permissions.*' => 'integer|exists:permissions,id',
            ]);

            $role = Role::create([
                'name' => $validated['role_name'],
                'guard_name' => 'web',
            ]);

            $role->permissions()->attach($validated['permissions']);

            return redirect()->route('roles.and.permissions.index')
                ->with('success', 'Role dan permission berhasil dibuat.');
        } catch (\Exception $e) {
            $this->logError('membuat', $e, $request->all());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat role. Silakan coba lagi nanti.']);
        }
    }

    public function edit(Role $role_and_permission)
    {
        return view('rolesandpermissions::edit', [
            'title' => 'Edit Role dan Permission',
            'permissions' => Permission::all()->groupBy('module'),
            'role' => $role_and_permission,
            'rolePermissions' => $role_and_permission->permissions->pluck('id')->toArray()
        ]);
    }

    public function update(Request $request, Role $role_and_permission)
    {
        try {
            $validated = $request->validate([
                'role_name' => 'required|string|max:255',
                'permissions' => 'array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            $role_and_permission->update(['name' => $validated['role_name']]);
            $role_and_permission->permissions()->sync($request->input('permissions', []));

            return redirect()->route('roles.and.permissions.index')
                ->with('success', 'Role dan permission berhasil diperbarui.');
        } catch (\Exception $e) {
            $this->logError('memperbarui', $e, $request->all(), $role_and_permission->id);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui role. Silakan coba lagi nanti.']);
        }
    }

    public function destroy(Role $role_and_permission)
    {
        try {
            $role_and_permission->delete();
            return redirect()->route('roles.and.permissions.index')
                ->with('success', 'Role dan permission berhasil dihapus.');
        } catch (\Exception $e) {
            $this->logError('menghapus', $e, [], $role_and_permission->id);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus role. Silakan coba lagi nanti.']);
        }
    }

    public function saveTableSettings(StoreTableSettingsRequest $request)
    {
        try {
            $modelClass = Role::class;
            $modelInstance = app($modelClass)->newInstance();

            TableSettings::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'table_name' => $modelInstance->getTable(),
                    'model_name' => $modelClass,
                ],
                [
                    'visible_columns' => json_encode($request->input('columns', [])),
                    'limit' => $request->input('limit', self::DEFAULT_LIMIT),
                    'show_numbering' => $request->has('show_numbering'),
                ]
            );

            return redirect()->back()->with('success', 'Pengaturan tabel berhasil disimpan!');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Kesalahan saat menyimpan pengaturan tabel: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan pengaturan tabel.');
        }
    }

    private function getColumnsForTable(): array
    {
        $allColumns = TableConstants::ROLE_AND_PERMISSION_TABLE_COLUMNS;
        $tableSettings = $this->getTableSettingsForModel(Role::class);
        $visibleColumns = $tableSettings->visible_columns ?? $allColumns;

        if (is_string($visibleColumns)) {
            $visibleColumns = json_decode($visibleColumns, true);
        }

        return [$allColumns, $visibleColumns];
    }

    private function getTableSettingsForModel(string $modelClass)
    {
        $modelInstance = app($modelClass)->newInstance();
        $userTableSettings = Auth::user()->tableSettings;

        if (is_null($userTableSettings)) {
            return null;
        }

        return $userTableSettings
            ->where('model_name', $modelClass)
            ->where('table_name', $modelInstance->getTable())
            ->first();
    }

    private function logError(string $action, \Exception $exception, array $requestData = [], $roleId = null)
    {
        $context = [
            'exception' => $exception,
            'request' => $requestData
        ];

        if ($roleId) {
            $context['role_id'] = $roleId;
        }

        Log::error("Kesalahan saat {$action} role dan permissions: " . $exception->getMessage(), $context);
    }
}
