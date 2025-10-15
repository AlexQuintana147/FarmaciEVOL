<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductoMetricsExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $productos;
    protected $metrics;

    public function __construct($productos, $metrics = null)
    {
        $this->productos = $productos;
        $this->metrics = $metrics;
    }

    public function collection()
    {
        return $this->productos;
    }

    public function title(): string
    {
        return 'Catálogo de Productos';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Título',
            'Categoría',
            'Descripción',
            'Trabajador',
            'Fecha de Creación'
        ];
    }

    public function map($producto): array
    {
        return [
            $producto->id,
            $producto->titulo,
            $producto->categoria,
            $producto->descripcion,
            $producto->trabajador->nombre_completo ?? 'N/A',
            $producto->created_at->format('d/m/Y H:i')
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
        $sheet->setCellValue('A1', 'CATÁLOGO DE PRODUCTOS - ' . now()->format('d/m/Y'));
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

        // Ajustar ancho de columnas
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(50);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(20);

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
        $lastRow = $this->productos->count() + 4;
        $sheet->getStyle('A5:F' . $lastRow)->applyFromArray($dataStyle);
        
        // Aplicar colores alternados a las filas para mejor legibilidad
        for ($row = 5; $row <= $lastRow; $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':F' . $row)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('F8F9FA');
            }
        }
        
        // Agregar resumen de métricas si está disponible
        if ($this->metrics) {
            $summaryRow = $lastRow + 2;
            $sheet->setCellValue('A' . $summaryRow, 'RESUMEN DEL CATÁLOGO');
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
            $sheet->setCellValue('A' . ($summaryRow + 1), 'Total de Productos:');
            $sheet->setCellValue('B' . ($summaryRow + 1), $this->productos->count());
            
            if (isset($this->metrics['productos_por_categoria'])) {
                $categoryRow = $summaryRow + 3;
                $sheet->setCellValue('A' . $categoryRow, 'PRODUCTOS POR CATEGORÍA');
                $sheet->mergeCells('A' . $categoryRow . ':B' . $categoryRow);
                $sheet->getStyle('A' . $categoryRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                        'color' => ['rgb' => '2C3E50']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => 'F8F9FA']
                    ],
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => 'thin',
                            'color' => ['rgb' => '3498DB']
                        ]
                    ]
                ]);
                
                $row = $categoryRow + 1;
                foreach ($this->metrics['productos_por_categoria'] as $categoria => $count) {
                    $sheet->setCellValue('A' . $row, $categoria . ':');
                    $sheet->setCellValue('B' . $row, $count);
                    $sheet->getStyle('A' . $row)->applyFromArray($summaryLabelStyle);
                    $sheet->getStyle('B' . $row)->applyFromArray($summaryValueStyle);
                    $row++;
                }
            }
            
            $sheet->getStyle('A' . ($summaryRow + 1))->applyFromArray($summaryLabelStyle);
            $sheet->getStyle('B' . ($summaryRow + 1))->applyFromArray($summaryValueStyle);
        }

        // Ajustar el alto de las filas
        foreach (range(4, $lastRow) as $row) {
            $sheet->getRowDimension($row)->setRowHeight(22);
        }
        
        // Congelar paneles para mejor navegación
        $sheet->freezePane('A5');
        
        // Aplicar filtros a los encabezados
        $sheet->setAutoFilter('A4:F4');
        
        // Ajustar el zoom para mejor visualización
        $sheet->getSheetView()->setZoomScale(90);
        
        return [];
    }
}