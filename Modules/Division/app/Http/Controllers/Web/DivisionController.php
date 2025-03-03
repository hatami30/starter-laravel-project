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
    public function index(Request $request)
    {
        $savedSettings = $this->_getTableSettingsForModel(Division::class);

        $limits = [5, 10, 20, 50, 100];
        $limit = $request->get('limit', $savedSettings->limit ?? 10);
        $sortBy = $request->get('sort_by', $savedSettings->sort_by ?? 'name');
        $sortOrder = $request->get('sort_order', $savedSettings->sort_order ?? 'ASC');

        [$allColumns, $visibleColumns] = $this->_getColumnsForTable();

        $excludedSortColumns = ['created_at', 'updated_at'];

        $query = Division::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search, $visibleColumns) {
                foreach ($visibleColumns as $column) {
                    if (!in_array($column, ['id', 'created_at', 'updated_at'])) {
                        $q->orWhere($column, 'LIKE', "%{$search}%");
                    }
                }
            });
        }

        $divisions = $query->orderBy($sortBy, $sortOrder)
            ->paginate($limit)
            ->withQueryString();

        $showNumbering = $savedSettings->show_numbering ?? true;

        return view('division::index', compact(
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
        return view('division::edit', compact('division'));
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
