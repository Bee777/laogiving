<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Calculation\DateTime;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithTitle;

class AllVolunteersExport extends DefaultValueBinder implements FromView, WithTitle, WithCustomValueBinder, ShouldAutoSize, WithEvents
{
    protected $data;
    protected $coors_dates = [];
    protected $coors_times = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function setDatesCoordinate($coors_dates)
    {
        $this->coors_dates = $coors_dates;
    }

    public function setTimeCoordinate($coors_times)
    {
        $this->coors_times = $coors_times;
    }

    public function title(): string
    {
        return $this->data['sheet_name'];
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('generate.users.all-volunteer-signup-excel', $this->data);
    }

    public function bindValue(Cell $cell, $value)
    {
        $coord = $cell->getCoordinate();
        if (is_numeric($value)) {

            $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);

            return true;
        }
        if (in_array($coord, $this->coors_dates, true)) {
            $dDate = Date::stringToExcel($value);
            $cell->setValueExplicit($dDate, DataType::TYPE_NUMERIC);
            return true;
        }
        if (in_array($coord, $this->coors_times, true)) {
            $dTime = DateTime::TIMEVALUE($value);
            $cell->setValueExplicit($dTime, DataType::TYPE_NUMERIC);
            return true;
        }
        // else return default behavior
        return parent::bindValue($cell, $value);
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
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->styleCells(
                    'A1:B1',
                    [
                        'alignment' => [
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        ],
                        'font' => [
                            'name' => 'Phetsarath OT',
                            'size' => 11,
                            'bold' => true,
                            'color' => ['argb' => '000000'],
                        ]
                    ]
                );
                $event->sheet->styleCells(
                    'A2',
                    [
                        'alignment' => [
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        ],
                        'font' => [
                            'name' => 'Phetsarath OT',
                            'size' => 11,
                            'bold' => true,
                            'color' => ['argb' => '000000'],
                        ]
                    ]
                );
                $event->sheet->styleCells(
                    'A3',
                    [
                        'alignment' => [
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        ],
                        'font' => [
                            'name' => 'Phetsarath OT',
                            'size' => 11,
                            'bold' => true,
                            'color' => ['argb' => '000000'],
                        ]
                    ]
                );
                $event->sheet->styleCells(
                    'A5:G5',
                    [
                        'alignment' => [
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        ],
                        'font' => [
                            'name' => 'Phetsarath OT',
                            'size' => 11,
                            'bold' => true,
                            'color' => ['argb' => '000000'],
                        ]
                    ]
                );
                //set title style
                //set content style
                $start_row = 6;
                $records = $this->data['volunteers'];
                foreach ($records as $coord => $item) {
                    $event->sheet->styleCells(
                        'A' . ($start_row + $coord) . ':E' . ($start_row + $coord),
                        [
                            'alignment' => [
                                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                            ],
                            'font' => [
                                'name' => 'Phetsarath OT',
                                'size' => 11,
                                'color' => ['argb' => '000000'],
                            ]
                        ]
                    );
                }
                //set content style
                //start set date time
                foreach ($this->coors_dates as $coors_date) {
                    $event->sheet->getStyle($coors_date)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                    $event->sheet->styleCells(
                        $coors_date,
                        [
                            'alignment' => [
                                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                            ]
                        ]
                    );
                }
                foreach ($this->coors_times as $coors_time) {
                    $event->sheet->getStyle($coors_time)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_TIME1);
                    $event->sheet->styleCells(
                        $coors_time, [
                            'alignment' => [
                                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                            ]
                        ]
                    );
                }
                //end set date time
                $event->sheet->getRowDimension('1')->setRowHeight(26);//set row first header height
                $event->sheet->getRowDimension('2')->setRowHeight(26);//set row first header height
            },
        ];
    }
}
