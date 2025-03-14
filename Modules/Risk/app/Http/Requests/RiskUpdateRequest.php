<?php

namespace Modules\Risk\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RiskUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'reporters_name' => 'nullable|string|max:255',
            'reporters_position' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:20',
            'risk_name' => 'nullable|string|max:255',
            'risk_description' => 'nullable|string|max:1000',
            'risk_status' => 'nullable|in:Provisional,Open,Open (Not Published),Closed,Re-Opened',
            'date_opened' => 'nullable|date',
            'next_review_date' => 'nullable|date',
            'reminder_period' => 'nullable|in:Do Not Send Reminder,On The Due Date,1 day before the Due Date,2 days before the Due Date,3 days before the Due Date,4 days before the Due Date,5 days before the Due Date,6 days before the Due Date,1 week before the Due Date,2 weeks before the Due Date,1 Month (30 Days) before the Due Date,2 Months (60 Days) before the Due Date,3 Months (90 Days) before the Due Date,6 Months (180 Days) before the Due Date,1 Year (365 Days) before the Due Date',
            'reminder_date' => 'nullable|date',
            'type_of_risk' => 'nullable|in:Corporate Risk,Hospital Risk,Project Risk,Emerging Risk',
            'category' => 'nullable|in:Business Process and System,Consumer Quality and Safety and Environment,Health and Safety,Reputation and Mission,Service Delivery',
            'location' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'relevant_committee' => 'nullable|in:Antimicroba Resistency Control,Ethics,Health Promotion,Infection Control,MDGs,Medical,Medical Record,Medical Record Extermination,Medical - Ethico Legal,Nursing,Occupational Health and Safety,Pain Management,Patient Safety,Pharmacy and Therapatical,PONEK,Quality,Quality and Patient Safety,TB Dots,Nil',
            'accountable_manager' => 'nullable|string|max:255',
            'responsible_supervisor' => 'nullable|string|max:255',
            'notify_of_associated_incidents' => 'nullable|in:Yes,No',
            'causes' => 'nullable|string|max:1000',
            'consequences' => 'nullable|string|max:1000',
            'controls' => 'nullable|string|max:1000',
            'control' => 'nullable|in:Minimal,Minor,Moderate,Major,Serious',
            'control_hierarchy' => 'nullable|in:Risk Avoidance,Risk Acceptance,Reduction of Likelihood of Occurrence,Reduction of Consequence,Transference of Risks,Elimination,Substitution,Isolation,Engineering,Administrative,Personal Protective Equipment',
            'control_cost' => 'nullable|numeric',
            'effective_date' => 'nullable|date',
            'last_reviewed_by' => 'nullable|string|max:255',
            'last_reviewed_on' => 'nullable|date',
            'assessment' => 'nullable|in:Review Pending,Review Underway,Ineffective,Partial Effectiveness Only,Effective but should be improved,Effective - No Change Required',
            'overall_control_assessment' => 'nullable|in:Excellent,Good,Moderate,Poor',
            'residual_consequences' => 'nullable|string|max:255',
            'residual_likelihood' => 'nullable|in:Frequent,Likely,Possible,Unlikely,Rare',
            'residual_score' => 'nullable|numeric',
            'residual_risk' => 'nullable|string|max:1000',
            'source_of_assurance' => 'nullable|string|max:1000',
            'assurance_category' => 'nullable|in:Activity Throughout,Audit and Finance Committee,Audit Processes,Audit Reports,Claims,Complaints,Credentialling,Education and Training Records,Employee Engagement,External Audit,Finance Report,H&S Committee,Incidents,Inspection Reports,Internal Audit,Key Performance Indicator,Legislative and Regulatory,Milestone Reached,Monitoring,OHS Reports,Project Control,Quality Committee,Recruitment,Retention and Sick Leave Rates',
            'actions' => 'nullable|string|max:1000',
            'action_assigned_date' => 'nullable|date',
            'action_by_date' => 'nullable|date',
            'action_description' => 'nullable|string|max:1000',
            'allocated_to' => 'nullable|string|max:255',
            'completed_on' => 'nullable|date',
            'action_response' => 'nullable|string|max:1000',
            'progress_note' => 'nullable|string|max:1000',
            'journal_type' => 'nullable|string|max:255',
            'journal_description' => 'nullable|string|max:1000',
            'date_stamp' => 'nullable|date_format:Y-m-d\TH:i',
            'formatted_date_stamp' => 'nullable|date_format:Y-m-d H:i:s',
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xlsx,xls,csv|max:10240',
            'user_id' => 'nullable|exists:users,id',
            'division_id' => 'nullable|exists:divisions,id',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute tidak boleh kosong.',
            'in' => ':attribute harus salah satu dari pilihan yang tersedia.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'numeric' => ':attribute harus berupa angka.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'mimes' => ':attribute harus berupa file dengan format: :values.',
            'nullable' => ':attribute boleh kosong.',
            'exists' => ':attribute tidak ditemukan.',
        ];
    }

    public function attributes(): array
    {
        return [
            'reporters_name' => 'Nama Pelapor',
            'reporters_position' => 'Jabatan Pelapor',
            'contact_no' => 'Nomor Kontak',
            'risk_name' => 'Nama Risiko',
            'risk_description' => 'Deskripsi Risiko',
            'risk_status' => 'Status Risiko',
            'date_opened' => 'Tanggal Dibuka',
            'next_review_date' => 'Tanggal Tinjauan Selanjutnya',
            'reminder_period' => 'Periode Pengingat',
            'reminder_date' => 'Tanggal Pengingat',
            'type_of_risk' => 'Tipe Risiko',
            'category' => 'Kategori Risiko',
            'location' => 'Lokasi',
            'unit' => 'Unit',
            'relevant_committee' => 'Komite Terkait',
            'accountable_manager' => 'Manajer yang Bertanggung Jawab',
            'responsible_supervisor' => 'Pengawas yang Bertanggung Jawab',
            'notify_of_associated_incidents' => 'Pemberitahuan Insiden Terkait',
            'causes' => 'Penyebab',
            'consequences' => 'Konsekuensi',
            'controls' => 'Kontrol',
            'control' => 'Kontrol Risiko',
            'control_hierarchy' => 'Hierarki Kontrol',
            'control_cost' => 'Biaya Kontrol',
            'effective_date' => 'Tanggal Efektif',
            'last_reviewed_by' => 'Diperiksa Terakhir Oleh',
            'last_reviewed_on' => 'Tanggal Pemeriksaan Terakhir',
            'assessment' => 'Penilaian',
            'overall_control_assessment' => 'Penilaian Kontrol Keseluruhan',
            'residual_consequences' => 'Konsekuensi Residual',
            'residual_likelihood' => 'Kemungkinan Residual',
            'residual_score' => 'Skor Residual',
            'residual_risk' => 'Risiko Residual',
            'source_of_assurance' => 'Sumber Jaminan',
            'assurance_category' => 'Kategori Jaminan',
            'actions' => 'Tindakan',
            'action_assigned_date' => 'Tanggal Penugasan Tindakan',
            'action_by_date' => 'Tanggal Tindakan Selesai',
            'action_description' => 'Deskripsi Tindakan',
            'allocated_to' => 'Dialokasikan Kepada',
            'completed_on' => 'Tanggal Penyelesaian',
            'action_response' => 'Respons Tindakan',
            'progress_note' => 'Catatan Progres',
            'journal_type' => 'Jenis Jurnal',
            'journal_description' => 'Deskripsi Jurnal',
            'date_stamp' => 'Stempel Waktu',
            'documents' => 'Dokumen',
            'user_id' => 'ID Pengguna',
            'division_id' => 'ID Divisi',
        ];
    }
}
