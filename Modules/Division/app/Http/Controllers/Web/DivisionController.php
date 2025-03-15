<?php

namespace Modules\Division\Http\Controllers\Web;

use App\Constants\TableConstants;
use App\Http\Controllers\Controller;
use Modules\Division\Models\Division;
use App\Models\TableSettings;
use App\Http\Requests\StoreTableSettingsRequest;
use Modules\Division\Http\Requests\DivisionStoreRequest;
use Modules\Division\Http\Requests\DivisionUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DivisionController extends Controller
{
    /**
     * Get pagination limit from request or saved settings
     */
    protected function getLimit(Request $request, $savedSettings)
    {
        $limits = [10, 25, 50, 100];
        $limit = $request->get('limit', $savedSettings->limit ?? $limits[0]);
        return in_array($limit, $limits) ? $limit : $limits[0];
    }

    public function index(Request $request)
    {
        $title = 'Daftar Divisi';

        // Get saved table settings
        $savedSettings = $this->_getTableSettingsForModel(Division::class);

        // Define pagination limits
        $limits = [10, 25, 50, 100];

        // Get current limit, sort column and order
        $limit = $this->getLimit($request, $savedSettings);
        $sortBy = $request->get('sort_by', $savedSettings->sort_by ?? 'name');
        $sortOrder = $request->get('sort_order', $savedSettings->sort_order ?? 'ASC');

        // Get columns configuration
        [$allColumns, $visibleColumns] = $this->_getColumnsForTable();

        // Define excluded sort columns
        $excludedSortColumns = ['created_at', 'updated_at'];

        // Build query
        $query = Division::query();

        // Apply search if provided
        if ($request->has('q') && !empty($request->q)) {
            $search = $request->q;
            $query->where(function ($q) use ($search, $visibleColumns) {
                foreach ($visibleColumns as $column) {
                    if (!in_array($column, ['id', 'created_at', 'updated_at'])) {
                        $q->orWhere($column, 'LIKE', "%{$search}%");
                    }
                }
            });
        }

        // Apply sorting
        if (!in_array($sortBy, $excludedSortColumns)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Get paginated results
        $divisions = $query->paginate($limit)->withQueryString();

        // Get show numbering setting
        $showNumbering = $savedSettings->show_numbering ?? true;

        // Return view with data
        return view('division::index', compact(
            'title',
            'divisions',
            'allColumns',
            'visibleColumns',
            'limits',
            'savedSettings',
            'limit',
            'sortBy',
            'sortOrder',
            'showNumbering',
            'excludedSortColumns'
        ));
    }

    public function create()
    {
        return view('division::create', [
            'title' => 'Divisi Baru',
        ]);
    }

    public function store(DivisionStoreRequest $request)
    {
        try {
            $validatedData = $request->validated();
            Division::create($validatedData);

            return redirect()->route('divisions.index')->with('success', 'Divisi berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Error saat membuat divisi: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('divisions.index')->with('error', 'Gagal membuat divisi. Silakan coba lagi.');
        }
    }

    public function show(Division $division)
    {
        return view('division::show', compact('division'));
    }

    public function edit(Division $division)
    {
        return view('division::edit', compact('division'))->with('title', 'Edit Divisi');
    }

    public function update(DivisionUpdateRequest $request, Division $division)
    {
        try {
            $division->update($request->validated());

            return redirect()->route('divisions.index')->with('success', 'Divisi berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui divisi: ' . $e->getMessage(), [
                'division_id' => $division->id,
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('divisions.index')->with('error', 'Gagal memperbarui divisi. Silakan coba lagi.');
        }
    }

    public function destroy(Division $division)
    {
        try {
            $name = $division->name;
            $division->delete();

            return redirect()->route('divisions.index')->with('success', "Divisi '{$name}' berhasil dihapus.");
        } catch (\Exception $e) {
            Log::error('Error saat menghapus divisi: ' . $e->getMessage(), [
                'division_id' => $division->id,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('divisions.index')->with('error', 'Gagal menghapus divisi. Silakan coba lagi.');
        }
    }

    public function saveTableSettings(StoreTableSettingsRequest $request)
    {
        try {
            $modelClass = Division::class;
            $modelInstance = app($modelClass)->newInstance();

            $tableName = $modelInstance->getTable();
            $modelName = get_class($modelInstance);

            $columns = $request->input('columns', []);
            $showNumbering = $request->has('show_numbering');

            $sortBy = $request->input('sort_by', 'name');
            $sortOrder = $request->input('sort_order', 'ASC');
            $limit = $request->input('limit', 10);

            TableSettings::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'table_name' => $tableName,
                    'model_name' => $modelName,
                ],
                [
                    'visible_columns' => json_encode($columns),
                    'limit' => $limit,
                    'show_numbering' => $showNumbering,
                    'sort_by' => $sortBy,
                    'sort_order' => $sortOrder,
                ]
            );

            return redirect()->back()->with('success', 'Pengaturan tabel berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan pengaturan tabel: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Gagal menyimpan pengaturan tabel. Silakan coba lagi.');
        }
    }

    private function _getColumnsForTable(): array
    {
        // Mendapatkan kolom yang dapat ditampilkan pada tabel
        $allColumns = TableConstants::DIVISION_TABLE_COLUMNS;
        $tableSettings = $this->_getTableSettingsForModel(Division::class);

        $visibleColumns = $tableSettings && !empty($tableSettings->visible_columns)
            ? json_decode($tableSettings->visible_columns, true)
            : $allColumns;

        return [$allColumns, $visibleColumns];
    }

    private function _getTableSettingsForModel(string $modelClass)
    {
        $modelInstance = app($modelClass)->newInstance();
        $tableName = $modelInstance->getTable();

        return TableSettings::where('user_id', auth()->id())
            ->where('model_name', $modelClass)
            ->where('table_name', $tableName)
            ->first();
    }
}
