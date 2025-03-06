<?php

namespace Modules\Risk\Http\Controllers\Web;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TableSettings;
use Modules\Risk\Models\Risk;
use Modules\User\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Constants\TableConstants;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Modules\Risk\Models\RiskExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Division\Models\Division;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreTableSettingsRequest;
use Modules\Risk\Http\Requests\RiskStoreRequest;
use Modules\Risk\Http\Requests\RiskUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        try {
            $roles = $this->roleModel->all();
            $user = Auth::user();

            // Pastikan pengguna terautentikasi dan memiliki divisi
            if (!$user || !$user->division) {
                Log::warning('Pengguna tanpa divisi mencoba mengakses halaman risiko', [
                    'user_id' => $user ? $user->id : 'tidak terautentikasi'
                ]);
                return redirect()->route('dashboard.index')
                    ->with('error', 'Anda tidak memiliki divisi yang valid untuk mengakses halaman ini.');
            }

            $savedSettings = optional($this->getTableSettingsForUser(Risk::class))->limit ?? 10;
            $limit = $this->getLimit($request, $savedSettings);
            $sortBy = $request->get('sort_by', 'risk_name');
            $sortOrder = $request->get('sort_order', 'ASC');

            [$allColumns, $visibleColumns] = $this->getColumnsForTable();
            $excludedColumns = [];
            $queryColumns = array_diff($visibleColumns, $excludedColumns);

            // Mulai membangun query
            $risksQuery = $this->riskModel->with(['user', 'division']); // Memuat relasi secara eager

            // Batasi akses berdasarkan divisi
            $isQualityDivision = $user->division->name === 'Mutu' || $user->division->name === 'Quality' || $user->division->name === 'IT';

            if (!$isQualityDivision) {
                // Pengguna non-Quality hanya bisa melihat risiko dari divisi mereka sendiri
                $risksQuery->where('division_id', $user->division_id);
                Log::info('Pengguna dibatasi hanya untuk risiko divisi mereka sendiri', [
                    'user_id' => $user->id,
                    'division_id' => $user->division_id,
                    'division_name' => $user->division->name
                ]);
            } else {
                // Pengguna divisi Quality bisa melihat semua risiko
                Log::info('Pengguna divisi Quality mengakses semua risiko', [
                    'user_id' => $user->id
                ]);
            }

            // Terapkan filter pencarian dan pengurutan
            $risksQuery->when($request->q, fn($query) => $this->applySearchFilter($query, $request, $queryColumns))
                ->orderBy($sortBy, $sortOrder);

            // Lakukan paginasi
            $risks = $this->paginateRisks($risksQuery, $limit);

            Log::debug('Query risiko selesai', [
                'total_risks' => $risks->total(),
                'current_page' => $risks->currentPage(),
                'per_page' => $risks->perPage()
            ]);

            return view('risk::index', [
                'title' => 'Daftar Risiko',
                'risks' => $risks,
                'columns' => $allColumns,
                'visibleColumns' => $visibleColumns,
                'excludedSortColumns' => $excludedColumns,
                'limits' => [5, 10, 20, 50, 100],
                'roles' => $roles,
                'savedSettings' => $savedSettings,
                'userDivision' => $user->division->name,
                'canViewAllRisks' => $isQualityDivision // Flag untuk pengguna divisi Quality
            ]);
        } catch (\Exception $e) {
            Log::error('Error in risks index page: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('dashboard.index')
                ->with('error', 'Terjadi kesalahan saat memuat daftar risiko: ' . $e->getMessage());
        }
    }

    // Fungsi untuk mengekspor data Risiko ke Excel
    public function exportToExcel(Request $request)
    {
        $risksQuery = $this->riskModel
            ->with(['user', 'division'])
            ->when($request->q, fn($query) => $this->applySearchFilter($query, $request, TableConstants::RISK_TABLE_COLUMNS))
            ->orderBy($request->get('sort_by', 'risk_name'), $request->get('sort_order', 'ASC'));

        return Excel::download(new RiskExport($risksQuery), 'risks.xlsx');
    }

    // Fungsi untuk mengekspor data Risiko ke PDF
    public function exportToPDF(Request $request)
    {
        $risksQuery = $this->riskModel
            ->with(['user', 'division'])
            ->when($request->q, fn($query) => $this->applySearchFilter($query, $request, TableConstants::RISK_TABLE_COLUMNS))
            ->orderBy($request->get('sort_by', 'risk_name'), $request->get('sort_order', 'ASC'));

        $risks = $risksQuery->get();
        $pdf = Pdf::loadView('risk::pdf_template', compact('risks'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('risks_report.pdf');
    }

    // Fungsi untuk melihat detail risiko dalam bentuk PDF
    public function viewPdf(Risk $risk)
    {
        // Generate the PDF using the risk details
        $pdf = Pdf::loadView('risk::pdf_template', compact('risk'))
            ->setPaper('a4', 'portrait');  // Adjust orientation as needed

        // Return the generated PDF to the browser for download
        return $pdf->download("risk_detail_{$risk->id}.pdf");
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
        // Mengubah nilai checkbox 'on' menjadi integer 1, atau null/off menjadi 0
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

    private function paginateRisks($risksQuery, $limit)
    {
        return $risksQuery->paginate($limit)->through(fn($risk) => $risk->setAttribute(
            'user_name',
            $risk->user ? $risk->user->name : 'Tidak Diketahui'
        )->setAttribute(
                'division_name',
                $risk->division ? $risk->division->name : 'Tidak Ada Divisi'
            ));
    }

    public function create()
    {
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
            // Validasi dan ambil data dari request
            $riskData = $request->validated();

            // // Menangani unggah file jika ada
            // if ($request->hasFile('document')) {
            //     $file = $request->file('document');
            //     $originalFileName = $file->getClientOriginalName();

            //     // Pastikan file disimpan di folder 'documents'
            //     $filePath = $file->storeAs('documents', $originalFileName, 'public');

            //     // Menyimpan path file ke dalam data risiko
            //     $riskData['document'] = $filePath;

            //     // Log path file untuk memastikan data sudah ada
            //     Log::info('File path saved:', ['file_path' => $filePath]);
            // }

            // // Log data risiko sebelum disimpan
            // Log::info('Risk data before saving:', ['riskData' => $riskData]);

            // // Periksa apakah 'document' ada dalam $riskData
            // if (!isset($riskData['document'])) {
            //     Log::error('File path not set in risk data');
            // }

            // Menetapkan user_id dan division_id
            $userId = Auth::id();
            if (!$userId) {
                throw new \Exception('Tidak ada pengguna yang terautentikasi');
            }

            $riskData['user_id'] = $userId;
            $riskData['division_id'] = $request->get('division_id') ?? Auth::user()->division_id;
            $riskData['reminder_date'] = $request->get('reminder_date') ?: null;

            // Simpan Risiko baru ke dalam database
            Risk::create($riskData);

            // Redirect ke halaman indeks risiko dengan pesan sukses
            return redirect()->route('risks.index')->with('success', 'Risiko berhasil dibuat.');
        } catch (\Exception $e) {
            // Log error jika terjadi kesalahan
            Log::error('Error creating risk: ' . $e->getMessage(), [
                'request_data' => $request->except('_token'),
                'trace' => $e->getTraceAsString(),
            ]);

            // Redirect ke halaman form input dengan pesan error
            return redirect()->route('risks.create')
                ->withInput()
                ->with('error', 'Gagal membuat risiko: ' . $e->getMessage());
        }
    }

    public function edit(Risk $risk)
    {
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
            // Validasi dan ambil data dari request
            $riskData = $request->validated();

            // // Menangani unggah file jika ada
            // if ($request->hasFile('document')) {
            //     // Hapus file lama jika ada
            //     if ($risk->document) {
            //         Storage::disk('public')->delete($risk->document);
            //     }

            //     // Menyimpan file baru
            //     $file = $request->file('document');
            //     $originalFileName = $file->getClientOriginalName();

            //     // Simpan file di folder 'documents'
            //     $filePath = $file->storeAs('documents', $originalFileName, 'public');

            //     // Simpan path file baru ke dalam data risiko
            //     $riskData['document'] = $filePath;

            //     // Log file path untuk memverifikasi apakah sudah benar
            //     Log::info('File path saved:', ['file_path' => $filePath]);
            // }

            // // Log data sebelum update ke database
            // Log::info('Risk data before updating:', ['riskData' => $riskData]);

            // // Periksa apakah 'document' ada dalam $riskData
            // if (!isset($riskData['document'])) {
            //     Log::error('File path not set in risk data');
            // }

            // Update data risiko dengan data baru
            $risk->update($riskData);

            // Redirect ke halaman indeks risiko dengan pesan sukses
            return redirect()->route('risks.index')->with('success', 'Risiko berhasil diperbarui.');
        } catch (\Exception $e) {
            // Log error jika terjadi kesalahan
            Log::error('Error updating risk: ' . $e->getMessage(), [
                'request_data' => $request->except('_token'),
                'trace' => $e->getTraceAsString(),
            ]);

            // Redirect kembali ke halaman form input dengan pesan error
            return redirect()->route('risks.index')
                ->with('error', 'Gagal memperbarui risiko: ' . $e->getMessage());
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
