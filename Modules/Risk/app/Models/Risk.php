<?php

namespace Modules\Risk\Models;

use Modules\User\Models\User;
// use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Risk\Database\Factories\RiskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Risk extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     * 
     * Menambahkan kolom-kolom yang bisa diisi secara massal
     */
    protected $fillable = [
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
        'document'
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
     * Menentukan factory untuk model ini
     */
    protected static function newFactory(): RiskFactory
    {
        return RiskFactory::new();
    }

    /**
     * Relasi dengan User untuk accountable_manager
     * 
     * Misalkan kita ingin menghubungkan kolom 'accountable_manager' dengan model 'User'
     */
    // public function accountableManager()
    // {
    //     return $this->belongsTo(User::class, 'accountable_manager');
    // }

    /**
     * Fungsi untuk memeriksa apakah risiko perlu ditinjau ulang berdasarkan tanggal tinjauan
     */
    public function isDueForReview()
    {
        return $this->next_review_date <= now();
    }

    /**
     * Fungsi untuk memeriksa apakah risiko membutuhkan tindakan lebih lanjut
     */
    public function needsAction()
    {
        return $this->risk_status !== 'Closed';
    }

    public function getFormattedNameAttribute()
    {
        return strtoupper($this->name);
    }

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }
}
