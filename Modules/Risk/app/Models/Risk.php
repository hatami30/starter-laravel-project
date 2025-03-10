<?php

namespace Modules\Risk\Models;

use Modules\User\Models\User;
use Modules\Division\Models\Division;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Modules\Risk\Database\Factories\RiskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yogameleniawan\SearchSortEloquent\Traits\Searchable;
use Yogameleniawan\SearchSortEloquent\Traits\Sortable;

class Risk extends Model
{
    use HasFactory, Notifiable, Searchable, Sortable, SoftDeletes;

    protected static function newFactory(): RiskFactory
    {
        return RiskFactory::new();
    }

    protected $fillable = [
        'user_id',
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
        'documents',
    ];

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

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedNameAttribute()
    {
        return strtoupper($this->risk_name);
    }

    public function setDocumentsAttribute($value)
    {
        if (!is_array($value)) {
            return;
        }

        $filePaths = [];

        foreach ($value as $document) {
            if (is_file($document)) {
                $filePaths[] = $document->store('documents', 'public');
            }
        }

        $this->attributes['documents'] = !empty($filePaths) ? json_encode($filePaths) : null;
    }

    public function getDocumentsAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function deleteOldDocuments()
    {
        $oldDocuments = $this->documents;

        if (empty($oldDocuments)) {
            return;
        }

        foreach ($oldDocuments as $oldDocument) {
            Storage::disk('public')->delete($oldDocument);
        }
    }

    public function isDueForReview()
    {
        return $this->next_review_date && $this->next_review_date <= now();
    }

    public function needsAction()
    {
        return $this->risk_status !== 'Closed';
    }
}
