<?php

namespace Modules\Risk\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Modules\Risk\Http\Requests\RiskStoreRequest;
use Modules\Risk\Http\Requests\RiskUpdateRequest;
use App\Http\Requests\StoreTableSettingsRequest;
use Modules\Risk\Models\Risk;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Risk\Models\RiskExport;
use Spatie\Permission\Models\Role;
use Modules\User\Models\User;
use Modules\Division\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\TableSettings;
use App\Constants\TableConstants;
use Barryvdh\DomPDF\Facade\Pdf;

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

            // Ensure user is authenticated and has a division
            if (!$user || !$user->division) {
                Log::warning('User without division tried to access risks index', [
                    'user_id' => $user ? $user->id : 'not authenticated'
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

            // Start building the query
            $risksQuery = $this->riskModel->with(['user', 'division']); // Eager load relationships

            // Restrict access based on division
            $isQualityDivision = $user->division->name === 'Mutu' || $user->division->name === 'Quality';

            if (!$isQualityDivision) {
                // Non-Quality users can only see risks from their own division
                $risksQuery->where('division_id', $user->division_id);
                Log::info('User restricted to their own division risks', [
                    'user_id' => $user->id,
                    'division_id' => $user->division_id,
                    'division_name' => $user->division->name
                ]);
            } else {
                // Quality division users can see all risks
                Log::info('Quality division user accessing all risks', [
                    'user_id' => $user->id
                ]);
            }

            // Apply search filter and sorting
            $risksQuery->when($request->q, fn($query) => $this->applySearchFilter($query, $request, $queryColumns))
                ->orderBy($sortBy, $sortOrder);

            // Paginate the results
            $risks = $this->paginateRisks($risksQuery, $limit);

            // Debugging log
            Log::debug('Risks query completed', [
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
                'canViewAllRisks' => $isQualityDivision // Flag for Quality division users
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
            // Validate and get validated data from the request
            $riskData = $request->validated();

            // Log validated data
            Log::info('Validated Risk Data: ', $riskData);

            // Explicitly set required user and division IDs
            $userId = Auth::id();
            if (!$userId) {
                throw new \Exception('No authenticated user found');
            }

            // Set user_id manually (ensure this is in fillable array in Risk model)
            $riskData['user_id'] = $userId;

            // Set division_id with fallback to user's division
            $riskData['division_id'] = $request->get('division_id') ?? Auth::user()->division_id;

            // Set optional fields (ensure reminder_date is nullable if not provided)
            $riskData['reminder_date'] = $request->get('reminder_date') ?: null;

            // Debug data before creating
            Log::info('Creating risk with data: ', $riskData);

            // Create a new Risk instance and save it explicitly
            $risk = new Risk();
            // Loop through each attribute and set it directly
            foreach ($riskData as $key => $value) {
                $risk->$key = $value;
            }

            // Ensure user_id is set again as a safeguard
            $risk->user_id = $userId;

            // Save the model
            $risk->save();

            Log::info('Risk created successfully with ID: ' . $risk->id);

            return redirect()->route('risks.index')->with('success', 'Risiko berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Error creating risk: ' . $e->getMessage(), [
                'request_data' => $request->except('_token'),
                'trace' => $e->getTraceAsString(),
                'exception' => $e
            ]);

            // Redirect back to the form with more specific error information
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
