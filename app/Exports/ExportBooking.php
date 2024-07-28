<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportBooking implements FromCollection, WithHeadings, WithStyles, WithTitle, WithEvents
{
    protected $reports;
    protected $title;
    protected $reportDate;
    protected $startDate;
    protected $endDate;
    protected $sumColumns;

    public function __construct($reports, $title, $reportDate, $startDate, $endDate, $sumColumns = [])
    {
        $this->reports = $reports;
        $this->title = $title;
        $this->reportDate = $reportDate;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->sumColumns = $sumColumns;
    }

    public function collection()
    {
        $numberedReports = $this->reports->map(function ($report, $index) {
            return array_merge(['No' => $index + 1], $report->toArray()); // Menambahkan kolom penomoran
        });

        return collect($numberedReports);
    }

    public function headings(): array
    {
        $originalHeadings = array_keys($this->reports->first()->toArray());
        $customHeadings = [
            'id_booking' => 'ID Booking',
            'name' => 'Name',
            'phone_number' => 'Phone Number' ,
            'email' => 'Email',
            'nationality' => 'Nationality',
            'visitor' => 'Visitor',
            'hostelry' => 'Hostelry',
            'title' => 'Ticket',
            'qty_ticket' => 'Qty. Ticket', 
            'price_ticket' => 'Ticket Price', 
            'totalPayment_ticket' => 'Total Payment',
            'paymentMethod_ticket' => 'Payment Method', 
            'name_add' => 'Baverage',
            'qty_add'  => 'Qty Baverage',
            'price_add'  => 'Baverage Price', 
            'totalPayment_add' => 'Total Payment', 
            'paymentMethod_add' => 'Payment Method',
            'name_receiver' => 'Name Receiver',
            'type_receiver' => 'Type Receiver',
            'phone_receiver' => 'Phone Receiver',
            'carPlate_receiver' => 'Car Plate',
            'nominal_cms' => 'Nominal Commission',
            'total_cms' => 'Total Commission',
            'username' => 'Admin',
            'document' => 'Proof of Payment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
        
        $headings = array_map(function($heading) use ($customHeadings) {
            return $customHeadings[$heading] ?? $heading;
        }, $originalHeadings);
        
        array_unshift($headings, 'No'); // Menambahkan header kolom penomoran
        return $headings;
    }


    public function styles(Worksheet $sheet)
    {
        // Hitung jumlah kolom dari data
        $columnCount = count(array_keys($this->reports->first()->toArray())) + 1; // +1 untuk kolom No
        $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnCount);

        // Gaya untuk header
        $headerStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'font' => [
                'bold' => true,
                'color' => ['argb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];

        // Gaya untuk sel
        $cellStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];

        // Terapkan gaya pada sheet
        $sheet->getStyle("A5:{$lastColumn}5")->applyFromArray($headerStyle);
        $sheet->getStyle("A6:{$lastColumn}" . ($this->reports->count() + 5))->applyFromArray($cellStyle);

        return [];
    }

    public function title(): string
    {
        return $this->title;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
    
                // Menggabungkan sel untuk informasi tambahan dan judul
                $columnCount = count(array_keys($this->reports->first()->toArray())) + 1; // +1 untuk kolom No
                $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnCount);
    
                // Tambahkan informasi tambahan di baris 1-3
                $sheet->mergeCells("A1:{$lastColumn}1");
                $sheet->setCellValue("A1", "Report Date: " . $this->reportDate);
    
                $sheet->mergeCells("A2:{$lastColumn}2");
                $sheet->setCellValue("A2", "Start Date: " . $this->startDate);
    
                $sheet->mergeCells("A3:{$lastColumn}3");
                $sheet->setCellValue("A3", "End Date: " . $this->endDate);
    
                // Tambahkan judul di baris 4
                $sheet->mergeCells("A4:{$lastColumn}4");
                $sheet->setCellValue("A4", $this->title);
    
                // Gaya untuk judul
                $titleStyle = [
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                        'color' => ['argb' => '000000'],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ];
    
                // Terapkan gaya untuk judul
                $sheet->getStyle("A4:{$lastColumn}4")->applyFromArray($titleStyle);
    
                // Menyesuaikan posisi header dan data
                $headings = $this->headings();
                $sheet->fromArray($headings, null, 'A5');
                $sheet->fromArray($this->collection()->toArray(), null, 'A6');
    
                // Mengatur lebar kolom agar sesuai dengan isi
                foreach (range('A', $lastColumn) as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
    
                // Menambahkan total dan grand total jika kolom ditentukan
                $rowCount = $this->reports->count() + 6; // +6 karena header berada di baris ke-5 dan data mulai di baris ke-6
    
                foreach ($this->sumColumns as $columnName) {
                    $columnIndex = array_search($columnName, array_keys($this->reports->first()->toArray())) + 2; // +2 karena kolom No dan 0-based index
                    if ($columnIndex !== false) {
                        $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex);
                        $totalFormula = "=SUM({$columnLetter}6:{$columnLetter}{$rowCount})";
    
                        $totalRow = $rowCount + 1;
                        $sheet->setCellValue("A{$totalRow}", "Total");
                        $sheet->setCellValue("{$columnLetter}{$totalRow}", $totalFormula);
    
                        // Gaya untuk total dan grand total
                        $totalStyle = [
                            'font' => [
                                'bold' => true,
                                'color' => ['argb' => '000000'],
                            ],
                            'alignment' => [
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            ],
                        ];
    
                        // Terapkan gaya untuk total
                        $sheet->getStyle("A{$totalRow}:{$columnLetter}{$totalRow}")->applyFromArray($totalStyle);
                    }
                }
            },
        ];
    }    
}
