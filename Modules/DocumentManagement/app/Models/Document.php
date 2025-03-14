<?php

namespace Modules\DocumentManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Models\User;
use Modules\Division\Models\Division;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Yogameleniawan\SearchSortEloquent\Traits\Searchable;
use Yogameleniawan\SearchSortEloquent\Traits\Sortable;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory, Notifiable, Searchable, Sortable, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'file_paths' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * User relation (owner of the document)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Division relation (which division uploaded the document)
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Linked division relation (for the division this document is assigned to)
     */
    public function linkedDivision()
    {
        return $this->belongsTo(Division::class, 'linked_division_id');
    }

    /**
     * Get the formatted name of the document
     */
    public function getFormattedNameAttribute()
    {
        return strtoupper($this->title);
    }

    /**
     * Get the human-readable category label
     */
    public function getCategoryLabelAttribute()
    {
        $categories = [
            'pedoman_manual' => 'Pedoman Manual',
            'kebijakan_program' => 'Kebijakan/Program',
            'regulasi' => 'Regulasi',
            'jadwal_on_call_dan_internal_extension' => 'Jadwal On-Call dan Internal Extension',
            'struktur_organisasi' => 'Struktur Organisasi',
            'master_dokumen' => 'Master Dokumen',
        ];

        return $categories[$this->category] ?? 'Unknown';
    }

    /**
     * Get the file URLs for each file stored in the 'file_paths' attribute
     */
    public function getFileUrlsAttribute()
    {
        $filePaths = is_array($this->file_paths) ? $this->file_paths : [];
        return collect($filePaths)->map(fn($path) => asset('storage/' . $path))->toArray();
    }

    /**
     * Store the file paths when new files are uploaded
     */
    public function setFilePathsAttribute($value)
    {
        if (is_array($value)) {
            $filePaths = [];

            foreach ($value as $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('documents', $filename, 'public');
                    $filePaths[] = $path;
                } else {
                    $filePaths[] = $file;
                }
            }

            $this->attributes['file_paths'] = json_encode($filePaths);
        }
    }

    /**
     * Get the file paths stored in the 'file_paths' attribute
     */
    public function getFilePathsAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    /**
     * Delete old document files from storage
     */
    public function deleteOldDocuments()
    {
        $oldDocuments = $this->getFilePathsAttribute($this->attributes['file_paths']);

        if (!empty($oldDocuments) && is_array($oldDocuments)) {
            foreach ($oldDocuments as $oldDocument) {
                if (Storage::disk('public')->exists($oldDocument)) {
                    Storage::disk('public')->delete($oldDocument);
                }
            }
        }
    }

    /**
     * Accessor for linked_division_id attribute (if applicable)
     */
    public function getLinkedDivisionIdAttribute()
    {
        return $this->linked_division_id;
    }

    /**
     * Mutator to set linked division id
     */
    public function setLinkedDivisionIdAttribute($value)
    {
        $this->attributes['linked_division_id'] = $value;
    }
}
