<?php

namespace Modules\User\Http\Controllers\Web;

use App\Constants\TableConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTableSettingsRequest;
use Modules\User\Http\Requests\UserStoreRequest;
use Modules\User\Http\Requests\UserUpdateRequest;
use Modules\User\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\Division\Models\Division;
use App\Models\TableSettings;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    protected $roleModel;
    protected $divisionModel;
    protected $userModel;

    public function __construct(Role $role, Division $division, User $user)
    {
        $this->roleModel = $role;
        $this->divisionModel = $division;
        $this->userModel = $user;
    }

    public function index(Request $request)
    {
        $roles = $this->roleModel->all();
        $user = Auth::user();
        $savedSettings = $this->getTableSettingsForUser(User::class);

        $limit = $this->getLimit($request, $savedSettings);
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'ASC');

        [$allColumns, $visibleColumns] = $this->getColumnsForTable();
        $excludedColumns = ['roles', 'division_name'];
        $queryColumns = array_diff($visibleColumns, $excludedColumns);

        $usersQuery = $this->userModel->with(['roles', 'division:id,name'])
            ->when($request->q, fn($query) => $this->applySearchFilter($query, $request, $queryColumns))
            ->when($request->role, fn($query) => $this->filterByRole($query, $request))
            ->orderBy($sortBy, $sortOrder);

        $users = $this->paginateUsers($usersQuery, $limit);

        return view('user::index', [
            'title' => 'Daftar Pengguna',
            'users' => $users,
            'columns' => $allColumns,
            'visibleColumns' => $visibleColumns,
            'excludedSortColumns' => $excludedColumns,
            'limits' => [5, 10, 20, 50, 100],
            'roles' => $roles,
            'savedSettings' => $savedSettings,
        ]);
    }

    private function applySearchFilter($query, $request, $queryColumns)
    {
        $query->where(function ($query) use ($request, $queryColumns) {
            foreach ($queryColumns as $column) {
                $query->orWhere("users.{$column}", 'LIKE', '%' . $request->q . '%');
            }
            if (in_array('division_name', $queryColumns)) {
                $query->orWhere('divisions.name', 'LIKE', '%' . $request->q . '%');
            }
        });
    }

    private function filterByRole($query, $request)
    {
        return $query->whereHas('roles', fn($q) => $q->where('name', $request->role));
    }

    private function getLimit(Request $request, $savedSettings)
    {
        return $request->get('limit', $savedSettings->limit ?? 10);
    }

    private function getColumnsForTable(): array
    {
        $allColumns = TableConstants::USER_TABLE_COLUMNS;
        $tableSettings = $this->getTableSettingsForUser(User::class);

        return $tableSettings
            ? [$allColumns, json_decode($tableSettings->visible_columns, true) ?: $allColumns]
            : [$allColumns, $allColumns];
    }

    private function getTableSettingsForUser(string $modelClass)
    {
        $user = Auth::user();

        if ($user && $user->tableSettings) {
            return $user->tableSettings->where('model_name', $modelClass)->first();
        }

        return null;
    }

    private function paginateUsers($usersQuery, $limit)
    {
        return $usersQuery->paginate($limit)->through(fn($user) => $user->setAttribute(
            'roles',
            $user->roles->pluck('name')->toArray()
        ));
    }

    public function create()
    {
        return view('user::create', [
            'title' => 'Pengguna Baru',
            'roles' => $this->roleModel->all(),
            'divisions' => $this->divisionModel->all(),
        ]);
    }

    public function store(UserStoreRequest $request)
    {
        try {
            $userData = $request->validated();
            $userData['password'] = Hash::make($request->input('password'));

            $user = $this->userModel->create($userData);
            $role = $this->roleModel->find($request->input('role_id'));
            $user->assignRole($role->name);

            if ($request->has('division_id')) {
                $user->division()->associate($this->divisionModel->find($request->input('division_id')));
                $user->save();
            }

            return redirect()->route('users.index')->with('success', 'Pengguna berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat membuat pengguna: ' . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'Gagal membuat pengguna.');
        }
    }

    public function edit(User $user)
    {
        return view('user::edit', [
            'title' => 'Edit Pengguna',
            'user' => $user,
            'roles' => $this->roleModel->all(),
            'divisions' => $this->divisionModel->all(),
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $userData = $request->all();
            if ($request->has('password')) {
                $userData['password'] = Hash::make($request->input('password'));
            }

            $user->update($userData);
            $role = $this->roleModel->findById($request->input('role_id'));
            $user->syncRoles([$role->name]);

            if ($request->has('division_id')) {
                $user->division()->associate($this->divisionModel->find($request->input('division_id')));
                $user->save();
            }

            return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat memperbarui pengguna: ' . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'Gagal memperbarui pengguna.');
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
        } catch (ModelNotFoundException $e) {
            Log::error('Pengguna tidak ditemukan: ' . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'Pengguna tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat menghapus pengguna: ' . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'Gagal menghapus pengguna.');
        }
    }

    public function saveTableSettings(StoreTableSettingsRequest $request)
    {
        try {
            $columns = $request->input('columns', []);
            $showNumbering = $request->has('show_numbering');

            TableSettings::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'table_name' => User::class,
                    'model_name' => User::class,
                ],
                [
                    'visible_columns' => json_encode($columns),
                    'limit' => $request->input('limit', 10),
                    'show_numbering' => $showNumbering,
                ]
            );

            return redirect()->back()->with('success', 'Pengaturan tabel berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat menyimpan pengaturan tabel: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan pengaturan tabel.');
        }
    }
}
