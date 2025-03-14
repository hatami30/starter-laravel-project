<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('risks', function (Blueprint $table) {
            $table->id();

            // Reporter Details
            $table->string('reporters_name');  // Required
            $table->string('reporters_position');  // Required
            $table->string('contact_no', 15);  // If phone numbers are limited to 15 characters

            // Risk Details
            $table->string('risk_name', 255);  // Limiting length for performance
            $table->text('risk_description');  // Required

            // Status
            $table->enum('risk_status', ['Provisional', 'Open', 'Open (Not Published)', 'Closed', 'Re-Opened']);  // Required
            $table->date('date_opened');  // Required
            $table->date('next_review_date');  // Required

            // Reminder Period
            $table->enum('reminder_period', [
                'Do Not Send Reminder',
                'On The Due Date',
                '1 day before the Due Date',
                '2 days before the Due Date',
                '3 days before the Due Date',
                '4 days before the Due Date',
                '5 days before the Due Date',
                '6 days before the Due Date',
                '1 week before the Due Date',
                '2 weeks before the Due Date',
                '1 Month (30 Days) before the Due Date',
                '2 Months (60 Days) before the Due Date',
                '3 Months (90 Days) before the Due Date',
                '6 Months (180 Days) before the Due Date',
                '1 Year (365 Days) before the Due Date'
            ]);  // Required
            $table->date('reminder_date');  // Required

            // Classification
            $table->enum('type_of_risk', ['Corporate Risk', 'Hospital Risk', 'Project Risk', 'Emerging Risk']);  // Required
            $table->enum('category', [
                'Business Process and System',
                'Consumer Quality and Safety and Environment',
                'Health and Safety',
                'Reputation and Mission',
                'Service Delivery'
            ]);  // Required
            $table->string('location', 100);  // Required
            $table->string('unit', 100);  // Required
            $table->enum('relevant_committee', [
                'Antimicroba Resistency Control',
                'Ethics',
                'Health Promotion',
                'Infection Control',
                'MDGs',
                'Medical',
                'Medical Record',
                'Medical Record Extermination',
                'Medical - Ethico Legal',
                'Nursing',
                'Occupational Health and Safety',
                'Pain Management',
                'Patient Safety',
                'Pharmacy and Therapatical',
                'PONEK',
                'Quality',
                'Quality and Patient Safety',
                'TB Dots',
                'Nil'
            ]);  // Required

            // Key Personnel
            $table->string('accountable_manager');  // Required
            $table->string('responsible_supervisor');  // Required
            $table->enum('notify_of_associated_incidents', ['Yes', 'No']);  // Required

            // Causes, Consequences, and Controls
            $table->text('causes');  // Required
            $table->text('consequences');  // Required
            $table->text('controls');  // Required
            $table->enum('control', ['Minimal', 'Minor', 'Moderate', 'Major', 'Serious']);  // Required
            $table->enum('control_hierarchy', [
                'Risk Avoidance',
                'Risk Acceptance',
                'Reduction of Likelihood of Occurrence',
                'Reduction of Consequence',
                'Transference of Risks',
                'Elimination',
                'Substitution',
                'Isolation',
                'Engineering',
                'Administrative',
                'Personal Protective Equipment'
            ]);  // Required
            $table->decimal('control_cost', 10, 2)->nullable();  // Nullable and with precision
            $table->date('effective_date');  // Required
            $table->string('last_reviewed_by');  // Required
            $table->date('last_reviewed_on');  // Required
            $table->enum('assessment', [
                'Review Pending',
                'Review Underway',
                'Ineffective',
                'Partial Effectiveness Only',
                'Effective but should be improved',
                'Effective - No Change Required'
            ]);  // Required
            $table->enum('overall_control_assessment', ['Excellent', 'Good', 'Moderate', 'Poor']);  // Required

            // Residual Risk
            $table->string('residual_consequences');  // Required
            $table->enum('residual_likelihood', ['Frequent', 'Likely', 'Possible', 'Unlikely', 'Rare']);  // Required
            $table->decimal('residual_score', 5, 2);  // Numeric score with two decimal places
            $table->text('residual_risk');  // Required

            // Source of Assurance
            $table->text('source_of_assurance');  // Required
            $table->enum('assurance_category', [
                'Activity Throughout',
                'Audit and Finance Committee',
                'Audit Processes',
                'Audit Reports',
                'Claims',
                'Complaints',
                'Credentialling',
                'Education and Training Records',
                'Employee Engagement',
                'External Audit',
                'Finance Report',
                'H&S Committee',
                'Incidents',
                'Inspection Reports',
                'Internal Audit',
                'Key Performance Indicator',
                'Legislative and Regulatory',
                'Milestone Reached',
                'Monitoring',
                'OHS Reports',
                'Project Control',
                'Quality Committee',
                'Recruitment, Retention and Sick Leave Rates'
            ]);  // Required

            // Actions
            $table->text('actions');  // Required
            $table->date('action_assigned_date');  // Required
            $table->date('action_by_date');  // Required
            $table->text('action_description');  // Required
            $table->string('allocated_to')->nullable();  // Nullable
            $table->date('completed_on')->nullable();  // Nullable
            $table->text('action_response')->nullable();  // Nullable

            // Progress Note and Document
            $table->text('progress_note');  // Required
            $table->text('journal_type');  // Required
            $table->text('journal_description')->nullable();  // Nullable
            $table->timestamp('date_stamp')->nullable();  // Nullable
            $table->json('file_paths')->nullable();  // Nullable

            // Foreign Keys
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Required
            $table->foreignId('division_id')->constrained()->onDelete('cascade');  // Required

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risks');
    }
};
