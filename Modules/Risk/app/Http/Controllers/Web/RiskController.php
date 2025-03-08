<?php

namespace Modules\Risk\Http\Controllers\Web;

use App\Constants\TableConstants;
use App\Models\TableSettings;
use App\Http\Requests\StoreTableSettingsRequest;
use App\Http\Controllers\Controller;
use Modules\User\Models\User;
use Modules\Risk\Models\Risk;
use Modules\Risk\Models\RiskExport;
use Modules\Division\Models\Division;
use Modules\Risk\Http\Requests\RiskStoreRequest;
use Modules\Risk\Http\Requests\RiskUpdateRequest;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RiskController extends Controller
{
    protected $roleModel;
    protected $riskModel;

    public function __construct(Role $role, Risk $risk)
    {
        $this->roleModel = $role;
        $this->riskModel = $risk;
        Log::info('RiskController diakses', ['timestamp' => now()->toDateTimeString()]);
    }

    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            Log::info('Akses halaman daftar risiko', [
                'user_id' => $user ? $user->id : 'tidak terautentikasi',
                'user_name' => $user ? $user->name : 'tidak terautentikasi',
                'ip_address' => $request->ip(),
                'division' => $user && $user->division ? $user->division->name : 'tidak ada divisi'
            ]);

            if (!$user || !$user->division) {
                Log::warning('Pengguna tanpa divisi mencoba mengakses halaman risiko', [
                    'user_id' => $user ? $user->id : 'tidak terautentikasi'
                ]);
                return redirect()->route('dashboard.index')
                    ->with('error', 'Anda tidak memiliki divisi yang valid untuk mengakses halaman ini.');
            }

            $tableSettings = $this->getTableSettingsForUser(Risk::class);
            $limit = $request->get('limit', optional($tableSettings)->limit ?? 10);
            $sortBy = $request->get('sort_by', 'risk_name');
            $sortOrder = $request->get('sort_order', 'ASC');

            [$allColumns, $visibleColumns] = $this->getColumnsForTable();
            $excludedColumns = [];
            $queryColumns = array_diff($visibleColumns, $excludedColumns);

            $risksQuery = $this->buildRisksQuery($user, $request, $queryColumns, $sortBy, $sortOrder);
            $risks = $this->paginateRisks($risksQuery, $limit);

            Log::info('Data risiko berhasil diambil', [
                'user_id' => $user->id,
                'jumlah_data' => $risks->count(),
                'limit' => $limit,
                'filter_pencarian' => $request->q
            ]);

            return view('risk::index', [
                'title' => 'Daftar Risiko',
                'risks' => $risks,
                'columns' => $allColumns,
                'visibleColumns' => $visibleColumns,
                'excludedSortColumns' => $excludedColumns,
                'limits' => [5, 10, 20, 50, 100],
                'roles' => $this->roleModel->all(),
                'savedSettings' => $tableSettings,
                'userDivision' => $user->division->name,
                'canViewAllRisks' => $this->isQualityDivision($user)
            ]);
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat memuat daftar risiko: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('dashboard.index')
                ->with('error', 'Terjadi kesalahan saat memuat daftar risiko: ' . $e->getMessage());
        }
    }

    // Export to Excel (need to improve)
    public function exportToExcel(Request $request)
    {
        $user = Auth::user();
        Log::info('Permintaan ekspor Excel', [
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : null,
            'filter' => $request->q
        ]);

        $risksQuery = $this->buildExportQuery($request);
        return Excel::download(new RiskExport($risksQuery), 'risks.xlsx');
    }

    // Export to PDF (need to improve)
    public function exportToPDF(Request $request)
    {
        $user = Auth::user();
        Log::info('Permintaan ekspor PDF', [
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : null,
            'filter' => $request->q
        ]);

        $risks = $this->buildExportQuery($request)->get();
        $pdf = Pdf::loadView('risk::pdf_template', compact('risks'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('risks_report.pdf');
    }

    // View PDF (need to improve)
    public function viewPdf(Risk $risk)
    {
        $user = Auth::user();
        Log::info('Melihat detail risiko dalam PDF', [
            'risk_id' => $risk->id,
            'risk_name' => $risk->risk_name,
            'user_id' => $user ? $user->id : null
        ]);

        $pdf = Pdf::loadView('risk::pdf_template', compact('risk'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("risk_detail_{$risk->id}.pdf");
    }

    // Save table settings (need to improve)
    public function saveTableSettings(StoreTableSettingsRequest $request)
    {
        $user = Auth::user();
        Log::info('Menyimpan pengaturan tabel risiko', [
            'user_id' => $user ? $user->id : null,
            'pengaturan' => [
                'kolom_terlihat' => $request->input('visible_columns', []),
                'limit' => $request->input('limit', 10),
                'show_numbering' => $request->input('show_numbering') === 'on'
            ]
        ]);

        $showNumbering = $request->input('show_numbering') === 'on' ? 1 : 0;

        TableSettings::updateOrCreate(
            [
                'model_name' => Risk::class,
                'user_id' => Auth::id()
            ],
            [
                'table_name' => 'risk_table',
                'visible_columns' => json_encode($request->input('visible_columns', [])),
                'limit' => $request->input('limit', 10),
                'show_numbering' => $showNumbering,
            ]
        );

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan!');
    }

    public function create()
    {
        $user = Auth::user();
        Log::info('Akses halaman pembuatan risiko baru', [
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : null,
            'division' => $user && $user->division ? $user->division->name : null
        ]);

        return view('risk::create', [
            'title' => 'Risiko Baru',
            'roles' => $this->roleModel->all(),
            'users' => User::all(),
            'divisions' => Division::all(),
        ]);
    }

    public function store(RiskStoreRequest $request)
    {
        try {
            $riskData = $request->validated();

            $userId = Auth::id();
            if (!$userId) {
                throw new \Exception('Tidak ada pengguna yang terautentikasi');
            }

            $riskData['user_id'] = $userId;
            $riskData['division_id'] = $request->get('division_id') ?? Auth::user()->division_id;
            $riskData['reminder_date'] = $request->get('reminder_date') ?: null;

            $risk = Risk::create($riskData);

            Log::info('Risiko baru berhasil dibuat', [
                'risk_id' => $risk->id,
                'risk_name' => $risk->risk_name,
                'user_id' => $userId,
                'division_id' => $riskData['division_id']
            ]);

            return redirect()->route('risks.index')->with('success', 'Risiko berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat membuat risiko: ' . $e->getMessage(), [
                'request_data' => $request->except('_token'),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('risks.create')
                ->withInput()
                ->with('error', 'Gagal membuat risiko: ' . $e->getMessage());
        }
    }

    public function edit(Risk $risk)
    {
        $user = Auth::user();
        Log::info('Akses halaman edit risiko', [
            'user_id' => $user ? $user->id : null,
            'risk_id' => $risk->id,
            'risk_name' => $risk->risk_name
        ]);

        return view('risk::edit', [
            'title' => 'Edit Risiko',
            'risk' => $risk,
            'roles' => $this->roleModel->all(),
            'users' => User::all(),
            'divisions' => Division::all(),
        ]);
    }

    public function update(RiskUpdateRequest $request, Risk $risk)
    {
        try {
            $oldData = $risk->toArray();
            $risk->update($request->validated());

            Log::info('Risiko berhasil diperbarui', [
                'risk_id' => $risk->id,
                'risk_name' => $risk->risk_name,
                'user_id' => Auth::id(),
                'perubahan_data' => [
                    'sebelum' => $oldData,
                    'sesudah' => $risk->toArray()
                ]
            ]);

            return redirect()->route('risks.index')->with('success', 'Risiko berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat memperbarui risiko: ' . $e->getMessage(), [
                'request_data' => $request->except('_token'),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('risks.index')
                ->with('error', 'Gagal memperbarui risiko: ' . $e->getMessage());
        }
    }

    public function destroy(Risk $risk)
    {
        try {
            $riskData = $risk->toArray();
            $risk->delete();

            Log::info('Risiko berhasil dihapus', [
                'risk_id' => $risk->id,
                'risk_name' => $risk->risk_name,
                'user_id' => Auth::id(),
                'data_terhapus' => $riskData
            ]);

            return redirect()->route('risks.index')->with('success', 'Risiko berhasil dihapus.');
        } catch (ModelNotFoundException $e) {
            Log::error('Risiko tidak ditemukan: ' . $e->getMessage());
            return redirect()->route('risks.index')->with('error', 'Risiko tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat menghapus risiko: ' . $e->getMessage());
            return redirect()->route('risks.index')->with('error', 'Gagal menghapus risiko.');
        }
    }

    private function isQualityDivision($user): bool
    {
        $divisionName = $user->division->name;
        return in_array($divisionName, ['Mutu', 'Quality', 'IT']);
    }

    private function buildRisksQuery($user, $request, $queryColumns, $sortBy, $sortOrder)
    {
        $risksQuery = $this->riskModel->with(['user', 'division']);

        if (!$this->isQualityDivision($user)) {
            $risksQuery->where('division_id', $user->division_id);
        }

        return $risksQuery
            ->when($request->q, fn($query) => $this->applySearchFilter($query, $request, $queryColumns))
            ->orderBy($sortBy, $sortOrder);
    }

    private function buildExportQuery($request)
    {
        return $this->riskModel
            ->with(['user', 'division'])
            ->when($request->q, fn($query) => $this->applySearchFilter($query, $request, TableConstants::RISK_TABLE_COLUMNS))
            ->orderBy($request->get('sort_by', 'risk_name'), $request->get('sort_order', 'ASC'));
    }

    // Apply search filter (need to improve)
    private function applySearchFilter($query, $request, $queryColumns)
    {
        return $query->where(function ($query) use ($request, $queryColumns) {
            foreach ($queryColumns as $column) {
                $query->orWhere("risks.{$column}", 'LIKE', '%' . $request->q . '%');
            }
        });
    }

    // Get columns for table (need to improve)
    private function getColumnsForTable(): array
    {
        $allColumns = TableConstants::RISK_TABLE_COLUMNS;
        $tableSettings = $this->getTableSettingsForUser(Risk::class);

        if (!$tableSettings) {
            return [$allColumns, $allColumns];
        }

        $visibleColumns = json_decode($tableSettings->visible_columns, true) ?: $allColumns;
        return [$allColumns, $visibleColumns];
    }

    // Get table settings for user (need to improve)
    private function getTableSettingsForUser(string $modelClass)
    {
        $user = Auth::user();
        if (!$user || !$user->tableSettings) {
            return null;
        }

        return $user->tableSettings->where('model_name', $modelClass)->first();
    }

    // Paginate risks (need to improve)
    private function paginateRisks($risksQuery, $limit)
    {
        return $risksQuery->paginate($limit)->through(function ($risk) {
            return $risk
                ->setAttribute('user_name', $risk->user ? $risk->user->name : 'Tidak Diketahui')
                ->setAttribute('division_name', $risk->division ? $risk->division->name : 'Tidak Ada Divisi');
        });
    }
}
