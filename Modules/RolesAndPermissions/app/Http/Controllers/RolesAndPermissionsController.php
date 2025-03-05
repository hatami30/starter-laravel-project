<?php

namespace Modules\RolesAndPermissions\Http\Controllers;

use App\Constants\TableConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTableSettingsRequest;
use App\Models\TableSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Modules\RolesAndPermissions\Models\Role;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsController extends Controller
{
    /**
     * Menampilkan daftar sumber daya.
     */
    public function index(Request $request)
    {
        $savedSettings = $this->_getTableSettingsForModel(Role::class);

        $limits = [5, 10, 20, 50, 100];
        $limit = $request->get('limit', $savedSettings->limit ?? 10);
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'ASC');

        // Mengambil semua kolom dan kolom yang terlihat
        [$allColumns, $visibleColumns] = $this->_getColumnsForTable();

        // Mengecualikan '' dari kueri basis data
        $excludedColumns = ['permissions'];
        $queryColumns = array_diff($visibleColumns, $excludedColumns);

        $roles = Role::search(
            keyword: $request->q,
            columns: $queryColumns
        )
            ->sort(
                sort_by: $sortBy,
                sort_order: $sortOrder
            );

        $roles = $roles->paginate($limit)->through(fn($role) => $role->setAttribute('permissions', $role->permissions->pluck('name')->toArray()));

        return view('rolesandpermissions::index', [
            'title' => 'Daftar Role dan Permission',
            'columns' => $allColumns,
            'visibleColumns' => $visibleColumns,
            'excludedSortColumns' => $excludedColumns,
            'limits' => $limits,
            'roles' => $roles,
            'savedSettings' => $savedSettings
        ]);
    }

    /**
     * Menampilkan formulir untuk membuat sumber daya baru.
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy('module');

        return view('rolesandpermissions::create', [
            'title' => 'Buat Role dan Permission',
            'permissions' => $permissions
        ]);
    }

    /**
     * Menyimpan sumber daya yang baru dibuat ke dalam penyimpanan.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'role_name' => 'required|string|max:255',
                'permissions' => 'required|array',
                'permissions.*' => 'integer|exists:permissions,id',
            ]);

            $role = Role::create([
                'name' => $request->input('role_name'),
                'guard_name' => 'web',
            ]);

            $role->permissions()->attach($validated['permissions']);

            return redirect()->route('roles.and.permissions.index')->with('success', 'Role dan permission berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat membuat role dan permissions: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all(),
            ]);

            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat role. Silakan coba lagi nanti.']);
        }
    }

    /**
     * Menampilkan formulir untuk mengedit sumber daya yang ditentukan.
     */
    public function edit(Role $role_and_permission)
    {
        $permissions = Permission::all()->groupBy('module');
        $role = Role::findOrFail($role_and_permission->id);
        $rolePermissions = $role_and_permission->permissions->pluck('id')->toArray();

        return view('rolesandpermissions::edit', [
            'title' => 'Edit Role dan Permission',
            'permissions' => $permissions,
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Memperbarui sumber daya yang ditentukan dalam penyimpanan.
     */
    public function update(Request $request, Role $role_and_permission)
    {
        try {
            $request->validate([
                'role_name' => 'required|string|max:255',
                'permissions' => 'array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            $role_and_permission->update(['name' => $request->input('role_name')]);
            $role_and_permission->permissions()->sync($request->input('permissions', []));

            return redirect()->route('roles.and.permissions.index')->with('success', 'Role dan permission berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat memperbarui role dan permissions: ' . $e->getMessage(), [
                'exception' => $e,
                'role_id' => $role_and_permission->id,
                'request' => $request->all(),
            ]);

            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui role. Silakan coba lagi nanti.']);
        }
    }

    /**
     * Menghapus sumber daya yang ditentukan dari penyimpanan.
     */
    public function destroy(Role $role_and_permission)
    {
        try {
            $role_and_permission->delete();

            return redirect()->route('roles.and.permissions.index')->with('success', 'Role dan permission berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat menghapus role dan permissions: ' . $e->getMessage(), [
                'exception' => $e,
                'role_id' => $role_and_permission->id,
            ]);

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus role. Silakan coba lagi nanti.']);
        }
    }

    /**
     * Menyimpan pengaturan tabel untuk pengguna.
     */
    public function saveTableSettings(StoreTableSettingsRequest $request)
    {
        try {
            $modelClass = Role::class;
            $modelInstance = app($modelClass)->newInstance();

            $tableName = $modelInstance->getTable();
            $modelName = get_class($modelInstance);

            $columns = $request->input('columns', []);
            $showNumbering = $request->has('show_numbering') ? true : false;

            TableSettings::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'table_name' => $tableName,
                    'model_name' => $modelName,
                ],
                [
                    'visible_columns' => json_encode($columns),
                    'limit' => $request->input('limit', 10),
                    'show_numbering' => $showNumbering,
                ]
            );

            return redirect()->back()->with('success', 'Pengaturan tabel berhasil disimpan!');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            // Log error dan kembali dengan pesan gagal
            Log::error('Kesalahan saat menyimpan pengaturan tabel: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan pengaturan tabel.');
        }
    }

    /**
     * Mengambil semua kolom dan kolom yang terlihat untuk tabel.
     */
    private function _getColumnsForTable(): array
    {
        $allColumns = TableConstants::ROLE_AND_PERMISSION_TABLE_COLUMNS;

        // Menggunakan fungsi yang dapat digunakan kembali untuk mendapatkan pengaturan tabel
        $tableSettings = $this->_getTableSettingsForModel(Role::class);

        // Mengambil kolom yang terlihat atau menggunakan default jika tidak diset
        $visibleColumns = $tableSettings->visible_columns ?? $allColumns;

        // Decode JSON jika perlu
        $visibleColumns = is_string($visibleColumns) ? json_decode($visibleColumns, true) : $visibleColumns;

        return [$allColumns, $visibleColumns];
    }

    /**
     * Mengambil pengaturan tabel untuk model dan tabel tertentu.
     *
     * @param string $modelClass Nama kelas model yang lengkap.
     * @return mixed|null Pengaturan tabel atau null jika tidak ditemukan.
     */
    private function _getTableSettingsForModel(string $modelClass)
    {
        // Membuat instansi baru dari model untuk mengambil nama tabelnya
        $modelInstance = app($modelClass)->newInstance();
        $tableName = $modelInstance->getTable();

        // Memeriksa apakah Auth::user()->tableSettings bernilai null
        $userTableSettings = Auth::user()->tableSettings;

        if (is_null($userTableSettings)) {
            return null;
        }

        // Mengambil pengaturan tabel pengguna untuk model dan tabel yang diberikan
        $tableSettings = $userTableSettings
            ->where('model_name', $modelClass)
            ->where('table_name', $tableName)
            ->first();

        return $tableSettings;
    }
}
