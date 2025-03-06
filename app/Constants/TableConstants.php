<?php

namespace App\Constants;

class TableConstants
{
    public const USER_TABLE_COLUMNS = [
        'id',
        'name',
        'roles',
        'username',
        'email',
        'phone',
        'division_name',
        'status',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    public const ROLE_AND_PERMISSION_TABLE_COLUMNS = [
        'id',
        'name',
        'permissions',
        'created_at',
        'updated_at',
    ];

    public const DIVISION_TABLE_COLUMNS = [
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    public const RISK_TABLE_COLUMNS = [
        'id',
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
        'user_name',
        'division_name',
        'created_at',
        'updated_at',
        // 'deleted_at',
    ];

    // Add more table columns as needed
}