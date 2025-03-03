<?php

namespace Modules\Risk\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Risk\Models\Risk;

class RiskFactory extends Factory
{
    protected $model = Risk::class;

    public function definition()
    {
        return [
            // Reporter Details
            'reporters_name' => $this->faker->name,
            'reporters_position' => $this->faker->jobTitle,
            'contact_no' => $this->faker->phoneNumber,

            // Risk Details
            'risk_name' => $this->faker->word,
            'risk_description' => $this->faker->paragraph,

            // Status
            'risk_status' => $this->faker->randomElement(['Provisional', 'Open', 'Open (Not Published)', 'Closed', 'Re-Opened']),
            'date_opened' => $this->faker->date(),
            'next_review_date' => $this->faker->date(),

            // Reminder Period
            'reminder_period' => $this->faker->randomElement([
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
            ]),
            'reminder_date' => $this->faker->date(),

            // Classification
            'type_of_risk' => $this->faker->randomElement(['Corporate Risk', 'Hospital Risk', 'Project Risk', 'Emerging Risk']),
            'category' => $this->faker->randomElement([
                'Business Process and System',
                'Consumer Quality and Safety and Environment',
                'Health and Safety',
                'Reputation and Mission',
                'Service Delivery'
            ]),
            'location' => $this->faker->word,
            'unit' => $this->faker->word,
            'relevant_committee' => $this->faker->randomElement([
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
            ]),

            // Key Personnel
            'accountable_manager' => $this->faker->name,
            'responsible_supervisor' => $this->faker->name,
            'notify_of_associated_incidents' => $this->faker->randomElement(['Yes', 'No']),

            // Causes, Consequences, and Controls
            'causes' => $this->faker->paragraph,
            'consequences' => $this->faker->paragraph,
            'controls' => $this->faker->paragraph,
            'control' => $this->faker->randomElement(['Minimal', 'Minor', 'Moderate', 'Major', 'Serious']),
            'control_hierarchy' => $this->faker->randomElement([
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
            ]),
            'control_cost' => $this->faker->randomNumber(3),
            'effective_date' => $this->faker->date(),
            'last_reviewed_by' => $this->faker->name,
            'last_reviewed_on' => $this->faker->date(),
            'assessment' => $this->faker->randomElement([
                'Review Pending',
                'Review Underway',
                'Ineffective',
                'Partial Effectiveness Only',
                'Effective but should be improved',
                'Effective - No Change Required'
            ]),
            'overall_control_assessment' => $this->faker->randomElement(['Excellent', 'Good', 'Moderate', 'Poor']),

            // Residual Risk
            'residual_consequences' => $this->faker->word,
            'residual_likelihood' => $this->faker->randomElement(['Frequent', 'Likely', 'Possible', 'Unlikely', 'Rare']),
            'residual_score' => $this->faker->randomNumber(2),
            'residual_risk' => $this->faker->paragraph,

            // Source of Assurance
            'source_of_assurance' => $this->faker->paragraph,
            'assurance_category' => $this->faker->randomElement([
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
            ]),

            // Actions
            'actions' => $this->faker->paragraph,
            'action_assigned_date' => $this->faker->date(),
            'action_by_date' => $this->faker->date(),
            'action_description' => $this->faker->paragraph,
            'allocated_to' => $this->faker->name,
            'completed_on' => $this->faker->date(),
            'action_response' => $this->faker->paragraph,

            // Progress Note and Document
            'progress_note' => $this->faker->paragraph,
            'journal_type' => $this->faker->word,
            'journal_description' => $this->faker->paragraph,
            'date_stamp' => $this->faker->dateTimeThisYear(),
            'document' => $this->faker->filePath(),
        ];
    }
}
