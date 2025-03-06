<?php

namespace Modules\Risk\Models;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Facades\Auth;

class RiskExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithDrawings
{
  protected $risksQuery;

  public function __construct($risksQuery)
  {
    $this->risksQuery = $risksQuery;
  }

  public function collection()
  {
    return $this->risksQuery->get();
  }

  public function headings(): array
  {
    return [
      // ['Logo'],
      [],
      [],
      ['Risk Report'],
      [],
      // ['Nama Penginput: ' . Auth::user()->name],
      ['Divisi: ' . Auth::user()->division->name],
      // ['Risk Number: ' . $this->risksQuery->first()->id . ' (Unique)', 'Date: ' . now()->format('Y-m-d')],
      [],
      [
        'Risk ID',
        'Reporters Name',
        'Position',
        'Contact No',
        'Risk Name',
        'Risk Description',
        'Risk Status',
        'Date Opened',
        'Next Review Date',
        'Reminder Period',
        'Reminder Date',
        'Type of Risk',
        'Category',
        'Location',
        'Unit',
        'Relevant Committee',
        'Accountable Manager',
        'Responsible Supervisor',
        'Notify of Associated Incidents',
        'Causes',
        'Consequences',
        'Controls',
        'Control',
        'Control Hierarchy',
        'Control Cost',
        'Effective Date',
        'Last Reviewed By',
        'Last Reviewed On',
        'Assessment',
        'Overall Control Assessment',
        'Residual Consequences',
        'Residual Likelihood',
        'Residual Score',
        'Residual Risk',
        'Source of Assurance',
        'Assurance Category',
        'Actions',
        'Action Assigned Date',
        'Action By Date',
        'Action Description',
        'Allocated To',
        'Completed On',
        'Action Response',
        'Progress Note',
        'Journal Type',
        'Journal Description',
        'Date Stamp',
        'Document',
        'User Name',
        'Division Name',
        'Created At',
        'Updated At',
        'Deleted At'
      ]
    ];
  }

  public function styles($sheet)
  {
    $sheet->getStyle('A1:H1')->getFont()->setBold(true);
    $sheet->getStyle('A1:H1')->getFont()->setSize(14);
    $sheet->getStyle('A5:Z5')->getFont()->setBold(true);

    return [
      1 => ['font' => ['bold' => true, 'size' => 12]],
      5 => ['font' => ['bold' => true, 'size' => 10]],
      'A1:A3' => [
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ]
      ],
    ];
  }

  public function title(): string
  {
    return 'Risks Report';
  }

  public function drawings()
  {
    $drawing = new Drawing();
    $drawing->setName('Logo');
    $drawing->setDescription('Logo');
    $drawing->setPath(public_path('img/kemenkes-hor.png')); // Path to logo image
    $drawing->setHeight(36);
    $drawing->setCoordinates('A1');
    return $drawing;
  }
}