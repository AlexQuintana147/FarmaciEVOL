<?php

namespace App\Exports;

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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ChatbotMetricsExport implements 
    FromCollection, 
    WithHeadings, 
    WithMapping, 
    WithTitle, 
    WithStyles, 
    ShouldAutoSize,
    WithColumnFormatting,
    WithEvents
{
    protected $logs;
    protected $summary;

    public function __construct($logs, $summary)
    {
        $this->logs = $logs;
        $this->summary = $summary;
    }

    public function collection()
    {
        return $this->logs;
    }

    public function title(): string
    {
        return 'Registros de Chat';
    }

    public function headings(): array
    {
        return [
            'ID',
            'USUARIO',
            'TIPO DE USUARIO',
            'PREGUNTA',
            'RESPUESTA',
            'FECHA DE CREACIÓN',
            'ÚLTIMA ACTUALIZACIÓN'
        ];
    }

    public function map($log): array
    {
        // Verificar si el trabajador está cargado y tiene nombre
        $nombreUsuario = 'Invitado';
        if ($log->es_autenticado && $log->trabajador) {
            // Usar nombre_completo del modelo Trabajador
            $nombreUsuario = $log->trabajador->nombre_completo ?? 'Trabajador';
            // Agregar apellidos si existen
            if (isset($log->trabajador->apellidos)) {
                $nombreUsuario .= ' ' . $log->trabajador->apellidos;
            }
        }

        return [
            $log->id,
            $nombreUsuario,
            $log->es_autenticado ? 'Autenticado' : 'Invitado',
            $log->pregunta,
            $log->respuesta,
            $log->created_at,
            $log->updated_at
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Establecer el ancho de las columnas
        $sheet->getColumnDimension('A')->setWidth(8);  // ID
        $sheet->getColumnDimension('B')->setWidth(25); // Usuario
        $sheet->getColumnDimension('C')->setWidth(20); // Tipo de Usuario
        $sheet->getColumnDimension('D')->setWidth(40); // Pregunta
        $sheet->getColumnDimension('E')->setWidth(40); // Respuesta
        $sheet->getColumnDimension('F')->setWidth(20); // Fecha Creación
        $sheet->getColumnDimension('G')->setWidth(20); // Fecha Actualización

        // Ajustar el alto de las filas para mejor visualización
        $sheet->getDefaultRowDimension()->setRowHeight(20);
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Estilo para el encabezado
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4361ee'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'DDDDDD'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);

        // Estilo para el contenido
        $lastRow = $sheet->getHighestRow();
        if ($lastRow > 1) {
            $contentStyle = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'EEEEEE'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_TOP,
                    'wrapText' => true,
                ],
            ];
            
            $sheet->getStyle('A2:G' . $lastRow)->applyFromArray($contentStyle);
            
            // Alternar colores de fila para mejor legibilidad
            foreach(range(2, $lastRow) as $row) {
                $fillColor = $row % 2 == 0 ? 'FFFFFF' : 'F8F9FA';
                $sheet->getStyle('A' . $row . ':G' . $row)
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB($fillColor);
            }
            
            // Alinear columnas específicas
            $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C2:C' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F2:G' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            
            // Ajustar el alto de las filas según el contenido
            foreach(range('D', 'E') as $col) {
                for ($i = 2; $i <= $lastRow; $i++) {
                    $sheet->getRowDimension($i)->setRowHeight(-1); // Autoajustar altura
                }
            }
        }
    }
    
    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY . ' ' . NumberFormat::FORMAT_DATE_TIME3,
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY . ' ' . NumberFormat::FORMAT_DATE_TIME3,
        ];
    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Congelar la primera fila (encabezados)
                $event->sheet->getDelegate()->freezePane('A2');
                
                // Añadir filtros a los encabezados
                $event->sheet->setAutoFilter(
                    $event->sheet->calculateWorksheetDimension()
                );
                
                // Añadir un título al informe
                $event->sheet->insertNewRowBefore(1, 3);
                
                $event->sheet->setCellValue('A1', 'REPORTE DE INTERACCIONES DEL CHATBOT');
                $event->sheet->mergeCells('A1:G1');
                
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                        'color' => ['rgb' => 'FFFFFF']
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '2C3E50']
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ]
                ]);
                
                // Añadir información del informe
                $event->sheet->setCellValue('A2', 'Generado el: ' . now()->format('d/m/Y H:i:s'));
                $event->sheet->mergeCells('A2:G2');
                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'italic' => true,
                        'size' => 10,
                        'color' => ['rgb' => '666666']
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_RIGHT
                    ]
                ]);
                
                // Ajustar el alto de las filas de encabezado
                $event->sheet->getRowDimension(1)->setRowHeight(30);
                $event->sheet->getRowDimension(4)->setRowHeight(25);
                
                // Mover los encabezados a la fila 4
                $event->sheet->getStyle('A4:G4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                        'size' => 12,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4361ee'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'DDDDDD'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);
                
                // Ajustar las referencias para el contenido
                $lastRow = $event->sheet->getHighestRow();
                if ($lastRow > 4) {
                    $event->sheet->getStyle('A5:G' . $lastRow)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'EEEEEE'],
                            ],
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_TOP,
                            'wrapText' => true,
                        ],
                    ]);
                    
                    // Aplicar estilo de filas alternadas
                    foreach(range(5, $lastRow) as $row) {
                        $fillColor = $row % 2 == 1 ? 'FFFFFF' : 'F8F9FA';
                        $event->sheet->getStyle('A' . $row . ':G' . $row)
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB($fillColor);
                    }
                    
                    // Ajustar alineación de columnas
                    $event->sheet->getStyle('A5:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $event->sheet->getStyle('C5:C' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $event->sheet->getStyle('F5:G' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }
                
                // Ajustar el ancho de las columnas después de añadir el contenido
                foreach(range('A', 'G') as $columnID) {
                    $event->sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
            },
        ];
    }
}
