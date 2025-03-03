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
            $table->string('reporters_name');
            $table->string('reporters_position');
            $table->string('contact_no');

            // Risk Details
            $table->string('risk_name');
            $table->text('risk_description');

            // Status
            $table->enum('risk_status', ['Provisional', 'Open', 'Open (Not Published)', 'Closed', 'Re-Opened']);
            $table->date('date_opened');
            $table->date('next_review_date');

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
            ]);
            $table->date('reminder_date');

            // Classification
            $table->enum('type_of_risk', ['Corporate Risk', 'Hospital Risk', 'Project Risk', 'Emerging Risk']);
            $table->enum('category', [
                'Business Process and System',
                'Consumer Quality and Safety and Environment',
                'Health and Safety',
                'Reputation and Mission',
                'Service Delivery'
            ]);
            $table->string('location');
            $table->string('unit');
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
            ]);

            // Key Personnel
            $table->string('accountable_manager');
            $table->string('responsible_supervisor');
            $table->enum('notify_of_associated_incidents', ['Yes', 'No']);

            // Causes, Consequences, and Controls
            $table->text('causes');
            $table->text('consequences');
            $table->text('controls');
            $table->enum('control', ['Minimal', 'Minor', 'Moderate', 'Major', 'Serious']);
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
            ]);
            $table->string('control_cost')->nullable();  // Nullable jika tidak ada biaya terkait
            $table->date('effective_date');
            $table->string('last_reviewed_by');
            $table->date('last_reviewed_on');
            $table->enum('assessment', [
                'Review Pending',
                'Review Underway',
                'Ineffective',
                'Partial Effectiveness Only',
                'Effective but should be improved',
                'Effective - No Change Required'
            ]);
            $table->enum('overall_control_assessment', ['Excellent', 'Good', 'Moderate', 'Poor']);

            // Residual Risk
            $table->string('residual_consequences');
            $table->enum('residual_likelihood', ['Frequent', 'Likely', 'Possible', 'Unlikely', 'Rare']);
            $table->string('residual_score');
            $table->text('residual_risk');

            // Source of Assurance
            $table->text('source_of_assurance');
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
            ]);

            // Actions
            $table->text('actions');
            $table->date('action_assigned_date');
            $table->date('action_by_date');
            $table->text('action_description');
            $table->string('allocated_to')->nullable();  // Nullable jika tidak ada alokasi
            $table->date('completed_on')->nullable();  // Nullable karena tidak selalu ada
            $table->text('action_response')->nullable();  // Nullable karena tidak selalu ada respons

            // Progress Note and Document
            $table->text('progress_note');
            $table->text('journal_type');
            $table->text('journal_description')->nullable();  // Nullable, tergantung kebutuhan
            $table->timestamp('date_stamp')->nullable();  // Nullable karena tidak semua entri membutuhkan timestamp
            $table->string('document')->nullable();  // Nullable karena tidak semua entri memiliki dokumen yang diupload

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
