<?php

namespace App\Exports;

use App\Models\Child;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Sheet;
use PHPExcel_Style_Border;

class ChildrenExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithEvents
{
    public function collection()
    {
        return Child::all();
    }

    /**
    * @var Child $child
    */
    public function map($child): array
    {
        return [
            $child->number,
            $child->holy_name,
            $child->name,
            $child->date_of_birth,
            $child->gender,
            $child->phone,
            $child->baptism,
            $child->holy_eucharist,
            $child->confirmation,
            $child->father,
            $child->mother,
            $child->address,
            $child->parish,
            $child->diocese,
        ];
    }

    public function headings(): array
    {
        return config('common.export.heading');
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });

        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells('B1:D1');
                $event->sheet->getDelegate()->mergeCells('B2:D2');
                $event->sheet->getDelegate()->mergeCells('B3:D3');
                $event->sheet->getDelegate()->mergeCells('E3:J4');
                $event->sheet->getDelegate()->mergeCells('A5:C5');
                $event->sheet->getDelegate()->mergeCells('J7:L7');
                $event->sheet->getDelegate()->mergeCells('M7:N7');
                $event->sheet->getDelegate()->mergeCells('A7:A8');
                $event->sheet->getDelegate()->mergeCells('B7:B8');
                $event->sheet->getDelegate()->mergeCells('C7:C8');
                $event->sheet->getDelegate()->mergeCells('D7:D8');
                $event->sheet->getDelegate()->mergeCells('E7:E8');
                $event->sheet->getDelegate()->mergeCells('F7:F8');
                $event->sheet->getDelegate()->mergeCells('G7:G8');
                $event->sheet->getDelegate()->mergeCells('H7:H8');
                $event->sheet->getDelegate()->mergeCells('I7:I8');

                $highestRow = $event->sheet->getHighestRow();
                $highestColumn = $event->sheet->getHighestColumn();
                $maxCell = $highestColumn . $highestRow;

                $event->sheet->styleCells(
                    'A1:' . $maxCell ,
                    [
                        'alignment' => [
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                        'font' => [
                            'name'      =>  'Calibri',
                            'size' => '12',
                        ],
                    ]
                );

                $event->sheet->styleCells(       // doan nay chi add border cho tung cell dc thoi a
                    'A9:' . $maxCell,
                    [
                        'borders' => [
                            'allborder' => [
                                'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => 'FFFF0000'],
                            ],
                        ]
                    ]
                );

                $event->sheet->styleCells(
                    'E3',
                    [
                        'font' => [
                            'name'      =>  'Calibri',
                            'size' => '14',
                        ],
                    ]
                );
            },
        ];
    }
}
