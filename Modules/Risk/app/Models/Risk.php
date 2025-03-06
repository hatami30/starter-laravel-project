<?php

namespace Modules\Risk\Models;

use Modules\User\Models\User;
use Modules\Division\Models\Division;
use App\Models\TableSettings;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Risk\Database\Factories\RiskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yogameleniawan\SearchSortEloquent\Traits\Searchable;
use Yogameleniawan\SearchSortEloquent\Traits\Sortable;

class Risk extends Model
{
    use HasFactory, Notifiable, Searchable, Sortable, SoftDeletes;

    /**
     * Menentukan factory untuk model ini
     */
    protected static function newFactory(): RiskFactory
    {
        return RiskFactory::new();
    }

    /**
     * The attributes that are mass assignable.
     * 
     * Menambahkan kolom-kolom yang bisa diisi secara massal
     */
    protected $fillable = [
        'user_id',           // Ensure this is included
        'division_id',
        'reporters_name',
        'reporters_position',
        'contact_no',
        'risk_name',
        'risk_description',
        'risk_status',
        'date_opened',
        'next_review_date',
        'reminder_period',
        'reminder_date',
        'type_of_risk',
        'category',
        'location',
        'unit',
        'relevant_committee',
        'accountable_manager',
        'responsible_supervisor',
        'notify_of_associated_incidents',
        'causes',
        'consequences',
        'controls',
        'control',
        'control_hierarchy',
        'control_cost',
        'effective_date',
        'last_reviewed_by',
        'last_reviewed_on',
        'assessment',
        'overall_control_assessment',
        'residual_consequences',
        'residual_likelihood',
        'residual_score',
        'residual_risk',
        'source_of_assurance',
        'assurance_category',
        'actions',
        'action_assigned_date',
        'action_by_date',
        'action_description',
        'allocated_to',
        'completed_on',
        'action_response',
        'progress_note',
        'journal_type',
        'journal_description',
        'date_stamp',
        'document',
    ];

    /**
     * Tentukan kolom yang bertipe tanggal dan waktu untuk diproses oleh Carbon
     */
    protected $dates = [
        'date_opened',
        'next_review_date',
        'reminder_date',
        'effective_date',
        'last_reviewed_on',
        'action_assigned_date',
        'action_by_date',
        'completed_on',
        'date_stamp',
        'deleted_at',
    ];

    /**
     * Relasi dengan Division (Divisi terkait)
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Relasi dengan User yang melaporkan risiko (user_id)
     */
    public function user()
    {
        return $this->belongsTo(User::class);  // This establishes the relationship with the User model
    }

    /**
     * Relasi dengan User untuk accountable_manager
     */
    // public function accountableManager()
    // {
    //     return $this->belongsTo(User::class, 'accountable_manager');
    // }

    /**
     * Relasi dengan User untuk responsible_supervisor
     */
    // public function responsibleSupervisor()
    // {
    //     return $this->belongsTo(User::class, 'responsible_supervisor');
    // }

    /**
     * Fungsi untuk memeriksa apakah risiko perlu ditinjau ulang berdasarkan tanggal tinjauan
     */
    // public function isDueForReview()
    // {
    //     return $this->next_review_date <= now();
    // }

    /**
     * Fungsi untuk memeriksa apakah risiko membutuhkan tindakan lebih lanjut
     */
    // public function needsAction()
    // {
    //     return $this->risk_status !== 'Closed';
    // }

    /**
     * Fungsi untuk memeriksa apakah risiko sudah selesai
     */
    // public function isCompleted()
    // {
    //     return $this->completed_on !== null;
    // }

    /**
     * Formatkan nama risiko untuk ditampilkan
     */
    public function getFormattedNameAttribute()
    {
        return strtoupper($this->risk_name);
    }

    /**
     * Formatkan created_at untuk tampilan
     */
    // public function getCreatedAtAttribute($value)
    // {
    //     return Carbon::parse($value)->format('F d, Y h:i A');
    // }

    /**
     * Formatkan updated_at untuk tampilan
     */
    // public function getUpdatedAtAttribute($value)
    // {
    //     return Carbon::parse($value)->format('F d, Y h:i A');
    // }

    /**
     * Formatkan deleted_at untuk tampilan
     */
    // public function getDeletedAtAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format('F d, Y h:i A') : null;
    // }

    /**
     * Relasi dengan pengaturan tabel
     */
    // public function tableSettings()
    // {
    //     return $this->hasOne(TableSettings::class);
    // }

    /**
     * Set atribut dokumen
     */
    public function setDocumentAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['document'] = $value->store('documents', 'public');
        }
    }
}
