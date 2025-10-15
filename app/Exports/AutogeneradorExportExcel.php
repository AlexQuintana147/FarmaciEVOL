<?php

namespace App\Exports;

use App\Models\AutogeneradorLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AutogeneradorExportExcel implements 
    FromCollection, 
    WithHeadings, 
    WithMapping, 
    WithTitle, 
    WithStyles,
    ShouldAutoSize,
    WithEvents
{
    protected $logs;
    protected $metrics;

    public function __construct($logs, $metrics = null)
    {
        $this->logs = $logs;
        $this->metrics = $metrics;
    }

    public function collection()
    {
        return $this->logs;
    }

    public function title(): string
    {
        return 'Registros de Autogeneración';
    }
    //test
    public function headings(): array
    {
        return [
            'ID',
            'Título',
            'Descripción',
            'Trabajador',
            'Fecha de Creación',
            'Última Actualización'
        ];
    }

    public function map($log): array
    {
        return [
            $log->id,
            $log->titulo,
            substr($log->descripcion, 0, 100) . (strlen($log->descripcion) > 100 ? '...' : ''),
            $log->trabajador->usuario ?? 'N/A',
            $log->created_at->format('d/m/Y H:i'),
            $log->updated_at->format('d/m/Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Establecer propiedades del documento
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->getPageMargins()->setTop(0.75);
        $sheet->getPageMargins()->setRight(0.3);
        $sheet->getPageMargins()->setLeft(0.3);
        $sheet->getPageMargins()->setBottom(0.75);

        // Estilo para el título del reporte
        $sheet->insertNewRowBefore(1, 3);
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'REGISTROS DE AUTOGENERACIÓN - ' . now()->format('d/m/Y'));
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '2C3E50']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Mover los encabezados a la fila 4
        $sheet->fromArray($this->headings(), null, 'A4');

        // Estilo para los encabezados
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '3498DB']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => '2980B9']
                ]
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
                'wrapText' => true
            ]
        ];
        $sheet->getStyle('A4:F4')->applyFromArray($headerStyle);

        // Estilo para las celdas de datos
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => 'E0E0E0']
                ]
            ],
            'alignment' => [
                'vertical' => 'center',
                'wrapText' => true
            ]
        ];
        $lastRow = $this->logs->count() + 4;
        $sheet->getStyle('A5:F' . $lastRow)->applyFromArray($dataStyle);

        // Agregar métricas resumidas con mejor formato
        $summaryRow = $lastRow + 2;
        $sheet->setCellValue('A' . $summaryRow, 'RESUMEN DE REGISTROS');
        $sheet->mergeCells('A' . $summaryRow . ':B' . $summaryRow);
        $sheet->getStyle('A' . $summaryRow)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => '2C3E50']
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => 'F8F9FA']
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => 'medium',
                    'color' => ['rgb' => '3498DB']
                ]
            ]
        ]);
        
        // Estilo para las etiquetas del resumen
        $summaryLabelStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '5D6D7E']
            ],
            'alignment' => [
                'horizontal' => 'right'
            ]
        ];
        
        // Estilo para los valores del resumen
        $summaryValueStyle = [
            'font' => [
                'color' => ['rgb' => '2C3E50']
            ],
            'alignment' => [
                'horizontal' => 'left'
            ]
        ];
        
        // Aplicar estilos a las celdas del resumen
        $sheet->setCellValue('A' . ($summaryRow + 1), 'Total de Registros:');
        $sheet->setCellValue('B' . ($summaryRow + 1), $this->metrics['total_logs']);
        
        $sheet->setCellValue('A' . ($summaryRow + 2), 'Fecha del Reporte:');
        $sheet->setCellValue('B' . ($summaryRow + 2), $this->metrics['fecha_reporte']);
        
        $sheet->getStyle('A' . ($summaryRow + 1) . ':A' . ($summaryRow + 2))->applyFromArray($summaryLabelStyle);
        $sheet->getStyle('B' . ($summaryRow + 1) . ':B' . ($summaryRow + 2))->applyFromArray($summaryValueStyle);

        // Agregar distribución por trabajador
        if (!empty($this->metrics['logs_por_trabajador'])) {
            $trabajadorRow = $summaryRow + 4;
            $sheet->setCellValue('A' . $trabajadorRow, 'DISTRIBUCIÓN POR TRABAJADOR');
            $sheet->mergeCells('A' . $trabajadorRow . ':B' . $trabajadorRow);
            $sheet->getStyle('A' . $trabajadorRow)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => '2C3E50']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'F8F9FA']
                ],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => 'medium',
                        'color' => ['rgb' => '3498DB']
                    ]
                ]
            ]);
            
            $trabajadorRow++;
            $sheet->setCellValue('A' . $trabajadorRow, 'Trabajador');
            $sheet->setCellValue('B' . $trabajadorRow, 'Cantidad');
            $sheet->getStyle('A' . $trabajadorRow . ':B' . $trabajadorRow)->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'ECF0F1']
                ]
            ]);
            
            $trabajadorRow++;
            foreach ($this->metrics['logs_por_trabajador'] as $trabajador => $cantidad) {
                $sheet->setCellValue('A' . $trabajadorRow, $trabajador);
                $sheet->setCellValue('B' . $trabajadorRow, $cantidad);
                $trabajadorRow++;
            }
        }

        // Ajustar el alto de las filas
        foreach (range(4, $lastRow) as $row) {
            $sheet->getRowDimension($row)->setRowHeight(22);
        }
        
        // Congelar paneles para mejor navegación
        $sheet->freezePane('A5');
        
        // Aplicar filtros a los encabezados
        $sheet->setAutoFilter('A4:F4');
        
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:F1')->getFont()->setSize(16);
                
                // Agregar logo o imagen corporativa
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo Corporativo');
                $drawing->setPath(public_path('images/logo.png'));
                $drawing->setCoordinates('A2');
                $drawing->setHeight(50);
                $drawing->setWorksheet($event->sheet->getDelegate());
                
                // Ajustar ancho de columnas específicas
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(60);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(25);
                
                // Establecer zoom al 85% para mejor visualización
                $event->sheet->getDelegate()->getSheetView()->setZoomScale(85);
            },
        ];
    }
}