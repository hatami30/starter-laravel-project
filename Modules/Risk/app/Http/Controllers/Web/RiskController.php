<?php

namespace Modules\Risk\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Modules\Risk\Http\Requests\RiskStoreRequest;
use Modules\Risk\Http\Requests\RiskUpdateRequest;
use App\Http\Requests\StoreTableSettingsRequest;
use Modules\Risk\Models\Risk;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\TableSettings;
use App\Constants\TableConstants;

class RiskController extends Controller
{
    protected $roleModel;
    protected $riskModel;

    public function __construct(Role $role, Risk $risk)
    {
        $this->roleModel = $role;
        $this->riskModel = $risk;
    }

    public function index(Request $request)
    {
        $roles = $this->roleModel->all();
        $user = Auth::user();
        $savedSettings = $this->getTableSettingsForUser(Risk::class);

        $limit = $this->getLimit($request, $savedSettings);
        $sortBy = $request->get('sort_by', 'risk_name');
        $sortOrder = $request->get('sort_order', 'ASC');

        [$allColumns, $visibleColumns] = $this->getColumnsForTable();
        $excludedColumns = [];
        $queryColumns = array_diff($visibleColumns, $excludedColumns);

        $risksQuery = $this->riskModel
            ->when($request->q, fn($query) => $this->applySearchFilter($query, $request, $queryColumns))
            ->orderBy($sortBy, $sortOrder);

        $risks = $this->paginateRisks($risksQuery, $limit);

        return view('risk::index', [
            'title' => 'Daftar Risiko',
            'risks' => $risks,
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
                $query->orWhere("risks.{$column}", 'LIKE', '%' . $request->q . '%');
            }
        });
    }

    private function getLimit(Request $request, $savedSettings)
    {
        return $request->get('limit', $savedSettings->limit ?? 10);
    }

    private function getColumnsForTable(): array
    {
        $allColumns = TableConstants::RISK_TABLE_COLUMNS;
        $tableSettings = $this->getTableSettingsForUser(Risk::class);

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

    public function saveTableSettings(StoreTableSettingsRequest $request)
    {
        TableSettings::updateOrCreate(
            [
                'model_name' => Risk::class,
                'user_id' => Auth::id()
            ],
            [
                'table_name' => 'risk_table',
                'visible_columns' => json_encode($request->input('visible_columns')),
                'limit' => $request->input('limit', 10),
                'show_numbering' => $request->input('show_numbering', false),
            ]
        );

        return redirect()->back()->with('success', 'Settings saved successfully!');
    }

    private function paginateRisks($risksQuery, $limit)
    {
        return $risksQuery->paginate($limit);
    }

    public function create()
    {
        return view('risk::create', [
            'title' => 'Risiko Baru',
            'roles' => $this->roleModel->all(),
        ]);
    }

    public function store(RiskStoreRequest $request)
    {
        try {
            $riskData = $request->validated();

            $riskData['reminder_date'] = $request->get('reminder_date') ?? null;
            $risk = $this->riskModel->create($riskData);

            return redirect()->route('risks.index')->with('success', 'Risiko berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat membuat risiko: ' . $e->getMessage());
            return redirect()->route('risks.index')->with('error', 'Gagal membuat risiko.');
        }
    }

    public function edit(Risk $risk)
    {
        return view('risk::edit', [
            'title' => 'Edit Risiko',
            'risk' => $risk,
            'roles' => $this->roleModel->all(),
        ]);
    }

    public function update(RiskUpdateRequest $request, Risk $risk)
    {
        try {
            $risk->update($request->validated());

            return redirect()->route('risks.index')->with('success', 'Risiko berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat memperbarui risiko: ' . $e->getMessage());
            return redirect()->route('risks.index')->with('error', 'Gagal memperbarui risiko.');
        }
    }

    public function destroy(Risk $risk)
    {
        try {
            $risk->delete();
            return redirect()->route('risks.index')->with('success', 'Risiko berhasil dihapus.');
        } catch (ModelNotFoundException $e) {
            Log::error('Risiko tidak ditemukan: ' . $e->getMessage());
            return redirect()->route('risks.index')->with('error', 'Risiko tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat menghapus risiko: ' . $e->getMessage());
            return redirect()->route('risks.index')->with('error', 'Gagal menghapus risiko.');
        }
    }
}
