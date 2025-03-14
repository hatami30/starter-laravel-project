<?php

namespace Modules\DocumentManagement\Http\Controllers\Web;

use App\Constants\TableConstants;
use App\Models\TableSettings;
use App\Http\Requests\StoreTableSettingsRequest;
use App\Http\Controllers\Controller;
use Modules\User\Models\User;
use Modules\DocumentManagement\Models\Document;
use Modules\Division\Models\Division;
use Modules\DocumentManagement\Http\Requests\DocumentStoreRequest;
use Modules\DocumentManagement\Http\Requests\DocumentUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DocumentManagementController extends Controller
{
    public function __construct()
    {
        Log::info('DocumentManagementController accessed', [
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    /**
     * Get the linked division name for documents
     */
    // private function getLinkedDivisionName($document)
    // {
    //     if ($document->linked_division_id) {
    //         $linkedDivision = Division::find($document->linked_division_id);
    //         return $linkedDivision ? $linkedDivision->name : 'Not Available';
    //     }
    //     return 'Not Linked';
    // }

    /**
     * Display a listing of documents.
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();

            // Ensure the user is authenticated before accessing their properties
            if ($user) {
                $userDivision = $user->division ? $user->division->name : 'No Division';

                Log::info('Accessing document list', [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'division' => $userDivision,
                    'ip_address' => $request->ip()
                ]);
            } else {
                $userDivision = 'No Division';
                Log::warning('Attempt to access document list without authentication');
            }

            $tableSettings = $this->getTableSettingsForUser(Document::class);
            $limit = $request->get('limit', optional($tableSettings)->limit ?? 10);
            $sortBy = $request->get('sort_by', 'title');
            $sortOrder = $request->get('sort_order', 'ASC');

            [$allColumns, $visibleColumns] = $this->getColumnsForTable();
            $excludedColumns = [];
            $queryColumns = array_diff($visibleColumns, $excludedColumns);

            $documentQuery = Document::with(['user', 'division']);

            if ($request->q) {
                $documentQuery->where(function ($query) use ($request, $queryColumns) {
                    foreach ($queryColumns as $column) {
                        $query->orWhere($column, 'LIKE', '%' . $request->q . '%');
                    }
                });
            }

            $documentQuery->orderBy($sortBy, $sortOrder);

            $documents = $documentQuery->paginate($limit)->through(function ($document) {
                return $document
                    ->setAttribute('user_name', $document->user ? $document->user->name : 'Tidak Diketahui')
                    ->setAttribute('division_name', $document->division ? $document->division->name : 'Tidak Ada Divisi');
            });

            Log::info('Documents retrieved', [
                'user_id' => $user ? $user->id : 'guest',
                'count' => $documents->count(),
                'limit' => $limit,
                'search' => $request->q ?? ''
            ]);

            $columnLabels = [
                'pedoman_manual' => 'Pedoman Manual',
                'kebijakan_program' => 'Kebijakan/Program',
                'regulasi' => 'Regulasi',
                'jadwal_on_call_dan_internal_extension' => 'Jadwal On-Call dan Internal Extension',
                'struktur_organisasi' => 'Struktur Organisasi',
                'master_dokumen' => 'Master Dokumen',
            ];

            return view('document::index', [
                'documents' => $documents,
                'columns' => $allColumns,
                'visibleColumns' => $visibleColumns,
                'limits' => [10, 25, 50, 100],
                'savedSettings' => $tableSettings,
                'sortBy' => $sortBy,
                'sortOrder' => $sortOrder,
                'excludedSortColumns' => $excludedColumns,
                'columnLabels' => $columnLabels,
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading document list: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat daftar dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new document.
     * Only users from divisi Mutu can create/upload documents.
     */
    public function create()
    {
        $user = Auth::user();

        // Fetch all divisions
        $divisions = Division::all();

        Log::info('Accessing document creation page', [
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : null,
            'division' => $user && $user->division ? $user->division->name : null,
        ]);

        // Only Mutu division users can upload documents
        if (!$this->isQualityDivision($user)) {
            Log::warning('Unauthorized access to document creation', [
                'user_id' => $user ? $user->id : 'guest'
            ]);
            return redirect()->route('documents.index')->with('error', 'Hanya divisi Mutu yang dapat mengupload dokumen.');
        }

        return view('documentmanagement::create', [
            'title' => 'Tambah Dokumen Baru',
            'divisions' => $divisions // Pass divisions to the view
        ]);
    }

    /**
     * Store a newly created document.
     */
    public function store(DocumentStoreRequest $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validated();

            // Log the validated data
            Log::info('Validated Data: ', $validatedData);

            // Set user_id and division_id
            $user = Auth::user();
            $validatedData['user_id'] = $user->id;
            $validatedData['division_id'] = $request->division_id;

            // Set default values for version and is_public
            $validatedData['version'] = 1;
            $validatedData['is_public'] = $request->has('is_public') ? $request->is_public : false;

            // Handle file uploads and store paths
            // if ($request->hasFile('file_paths')) {
            //     $filePaths = [];
            //     foreach ($request->file('file_paths') as $file) {
            //         $filePaths[] = $file->store('documents', 'public');
            //     }
            //     $validatedData['file_paths'] = json_encode($filePaths);
            // }

            // Create the document
            $document = Document::create($validatedData);

            return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Error creating document: ' . $e->getMessage());
            return redirect()->route('documents.index')->with('error', 'Gagal membuat dokumen. Silakan coba lagi.');
        }
    }


    /**
     * Display the specified document.
     */
    public function show(Document $document)
    {
        // Check if the user is authenticated
        $user = Auth::user();
        if ($user) {
            // Log information for authenticated users
            Log::info('Accessing document details', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'document_id' => $document->id,
                'title' => $document->title
            ]);
        } else {
            // Log information for guest users
            Log::info('Accessing document details (guest)', [
                'document_id' => $document->id,
                'title' => $document->title
            ]);
        }

        return view('document::show', compact('document'));
    }

    /**
     * Show the form for editing the specified document.
     */
    public function edit(Document $document)
    {
        $user = Auth::user();
        Log::info('Accessing document edit page', [
            'user_id' => $user ? $user->id : null,
            'document_id' => $document->id,
            'title' => $document->title
        ]);

        // Fetch all divisions to show in the form
        $divisions = Division::all();

        return view('document::edit', compact('document', 'divisions'));
    }

    /**
     * Update the specified document.
     */
    public function update(DocumentUpdateRequest $request, Document $document)
    {
        try {
            $user = Auth::user();
            $oldData = $document->toArray();

            // Update document data (use validated data from the request)
            $validatedData = $request->validated();

            // Set the new division_id from the request, if available
            if ($request->has('division_id')) {
                $validatedData['division_id'] = $request->division_id;
            }

            // // Handle file updates if new files are uploaded
            // $filePaths = json_decode($document->file_paths, true) ?? [];
            // if ($request->hasFile('document_files')) {
            //     // Delete old files
            //     foreach ($filePaths as $oldFilePath) {
            //         Storage::delete('public/' . $oldFilePath);
            //     }
            //     // Upload new files
            //     $newFilePaths = [];
            //     foreach ($request->file('document_files') as $file) {
            //         $newFilePaths[] = $file->store('documents', 'public');
            //     }
            //     $document->file_paths = json_encode($newFilePaths);
            // }

            // Update the document with the validated data
            $document->update($validatedData);

            // Update 'is_public' if present in the request, otherwise keep the old value
            $document->is_public = $request->has('is_public') ? $request->is_public : $document->is_public;

            // Increment the version number each time the document is updated
            $document->version = $document->version + 1; // Increment version

            // Save the document after all updates
            $document->save();

            Log::info('Document updated successfully', [
                'document_id' => $document->id,
                'title' => $document->title,
                'user_id' => $user->id,
                'old_data' => $oldData,
                'new_data' => $document->toArray()
            ]);

            return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating document: ' . $e->getMessage(), [
                'document_id' => $document->id,
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('documents.index')->with('error', 'Gagal memperbarui dokumen. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified document.
     */
    public function destroy(Document $document)
    {
        try {
            $filePaths = json_decode($document->file_paths, true) ?? [];
            foreach ($filePaths as $filePath) {
                Storage::delete('public/' . $filePath);
            }
            $documentData = $document->toArray();
            $document->delete();

            Log::info('Document deleted successfully', [
                'document_id' => $document->id,
                'title' => $document->title,
                'user_id' => Auth::id(),
                'deleted_data' => $documentData
            ]);

            return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting document: ' . $e->getMessage(), [
                'document_id' => $document->id,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('documents.index')->with('error', 'Gagal menghapus dokumen. Silakan coba lagi.');
        }
    }

    /**
     * Save table settings.
     */
    public function saveTableSettings(StoreTableSettingsRequest $request)
    {
        try {
            $user = Auth::user();
            Log::info('Saving document table settings', [
                'user_id' => $user ? $user->id : null,
                'settings' => [
                    'visible_columns' => $request->input('visible_columns', []),
                    'limit' => $request->input('limit', 10),
                    'show_numbering' => $request->has('show_numbering')
                ]
            ]);

            $showNumbering = $request->has('show_numbering') ? 1 : 0;

            TableSettings::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'table_name' => (new Document)->getTable(),
                    'model_name' => Document::class,
                ],
                [
                    'visible_columns' => json_encode($request->input('visible_columns', [])),
                    'limit' => $request->input('limit', 10),
                    'show_numbering' => $showNumbering,
                ]
            );

            return redirect()->back()->with('success', 'Pengaturan tabel berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Error saving document table settings: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Gagal menyimpan pengaturan tabel. Silakan coba lagi.');
        }
    }

    /**
     * Get table columns for documents.
     */
    private function getColumnsForTable(): array
    {
        $allColumns = TableConstants::DOCUMENT_TABLE_COLUMNS;
        $tableSettings = $this->getTableSettingsForUser(Document::class);
        $visibleColumns = $tableSettings && !empty($tableSettings->visible_columns)
            ? json_decode($tableSettings->visible_columns, true)
            : $allColumns;

        return [$allColumns, $visibleColumns];
    }

    /**
     * Retrieve table settings for the current user and model.
     */
    private function getTableSettingsForUser(string $modelClass)
    {
        $user = Auth::user();
        if (!$user) {
            return null;
        }
        return TableSettings::where('user_id', $user->id)
            ->where('model_name', $modelClass)
            ->where('table_name', (new Document)->getTable())
            ->first();
    }

    /**
     * Check if the user belongs to the Mutu division.
     */
    private function isQualityDivision($user): bool
    {
        return $user && $user->division && $user->division->name === 'Mutu';
    }

    /**
     * Display the public document page with division and category filters.
     */
    /**
     * Display public documents index page with divisions and documents.
     */
    public function publicIndex(Request $request)
    {
        try {
            // Fetch divisions that have public documents
            $divisions = Division::whereHas('documents', function ($query) {
                $query->where('is_public', true);
            })
                ->with([
                    'documents' => function ($query) {
                        $query->where('is_public', true);
                    }
                ])
                ->get();

            // Fetch documents count (for display purposes)
            $documentsCount = Document::where('is_public', true)->count();

            // Log divisions fetched
            Log::info('Fetched divisions with public documents', [
                'division_count' => $divisions->count(),
                'division_names' => $divisions->pluck('name')->toArray(),
            ]);

            // Return the view with both divisions and document count
            return view('documentmanagement::public.index', compact('divisions', 'documentsCount'));
        } catch (\Exception $e) {
            Log::error('Error loading public document page: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Gagal memuat halaman dokumen publik.');
        }
    }

    /**
     * Fetch categories for a specific division.
     */
    public function fetchCategories($divisionId)
    {
        try {
            $division = Division::findOrFail($divisionId);

            // Fetch categories for the documents in this division
            $categories = Document::where('division_id', $divisionId)
                ->where('is_public', true)
                ->distinct()
                ->pluck('category');

            return response()->json($categories);
        } catch (\Exception $e) {
            Log::error('Error fetching categories for division: ' . $e->getMessage(), ['division_id' => $divisionId]);
            return response()->json(['error' => 'Kategori tidak ditemukan.'], 404);
        }
    }

    /**
     * Fetch document details for a specific category.
     */
    public function fetchDocumentDetails($categoryId)
    {
        try {
            // Fetch documents for the selected category
            $documents = Document::where('category', $categoryId)
                ->where('is_public', true)
                ->get();

            if ($documents->isEmpty()) {
                return response()->json(['error' => 'No documents found for this category.'], 404);
            }

            // Prepare the document data with file paths
            $documentsWithFiles = $documents->map(function ($document) {
                // Check if file_paths is already an array (no need to decode)
                $filePaths = is_array($document->file_paths) ? $document->file_paths : [];

                // Get file details (name, type)
                $fileDetails = [];
                foreach ($filePaths as $filePath) {
                    $fileDetails[] = [
                        'file_name' => basename($filePath),
                        'file_path' => asset('storage/' . $filePath),  // URL untuk mengakses file
                        'file_type' => pathinfo($filePath, PATHINFO_EXTENSION),
                    ];
                }
                return [
                    'document' => $document,
                    'files' => $fileDetails,
                ];
            });

            return response()->json($documentsWithFiles);
        } catch (\Exception $e) {
            Log::error('Error fetching document details: ' . $e->getMessage(), ['category_id' => $categoryId]);
            return response()->json(['error' => 'Failed to fetch documents.'], 500);
        }
    }

    // Controller Method to Serve Document Download
    public function downloadFile($documentId, $fileName)
    {
        try {
            // Find the document
            $document = Document::findOrFail($documentId);
            $filePaths = json_decode($document->file_paths, true);

            // Find the requested file in the paths
            $filePath = collect($filePaths)->first(function ($path) use ($fileName) {
                return basename($path) === $fileName;
            });

            if (!$filePath) {
                return response()->json(['error' => 'File not found'], 404);
            }

            // Return the file for download
            return response()->download(storage_path('app/public/' . $filePath));
        } catch (\Exception $e) {
            Log::error('Error downloading document: ' . $e->getMessage(), ['document_id' => $documentId]);
            return response()->json(['error' => 'Failed to download document'], 500);
        }
    }

    // Controller Method to Show Document File
    public function viewFile($documentId, $fileName)
    {
        try {
            // Find the document
            $document = Document::findOrFail($documentId);
            $filePaths = json_decode($document->file_paths, true);

            // Find the requested file in the paths
            $filePath = collect($filePaths)->first(function ($path) use ($fileName) {
                return basename($path) === $fileName;
            });

            if (!$filePath) {
                return response()->json(['error' => 'File not found'], 404);
            }

            // Return the file to be viewed
            return response()->file(storage_path('app/public/' . $filePath));
        } catch (\Exception $e) {
            Log::error('Error viewing document: ' . $e->getMessage(), ['document_id' => $documentId]);
            return response()->json(['error' => 'Failed to view document'], 500);
        }
    }

    public function downloadMultiple(Request $request)
    {
        try {
            // Get the selected document IDs from the request
            $documentIds = $request->input('document_ids');

            // Retrieve the documents from the database using the IDs
            $documents = Document::whereIn('id', $documentIds)->get();

            // Create a new ZIP file
            $zip = new ZipArchive;
            $zipFileName = 'documents_' . time() . '.zip';
            $zipFilePath = storage_path('app/public/' . $zipFileName);

            if ($zip->open($zipFilePath, ZipArchive::CREATE) !== TRUE) {
                return response()->json(['error' => 'Failed to create ZIP file.'], 500);
            }

            // Loop through the documents and add each file to the ZIP
            foreach ($documents as $document) {
                $filePaths = json_decode($document->file_paths, true);
                foreach ($filePaths as $filePath) {
                    if (Storage::exists('public/' . $filePath)) {
                        $zip->addFile(storage_path('app/public/' . $filePath), basename($filePath));
                    }
                }
            }

            $zip->close();

            // Return the ZIP file for download
            return response()->download($zipFilePath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            Log::error('Error downloading multiple documents: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while downloading the documents.'], 500);
        }
    }
}