<?php

namespace App\Exports\Concerns;

use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

trait StylesWorksheet
{
    /**
     * Apply the shared "well designed, colourful" look to a sheet:
     * merged title + subtitle banner, coloured header row, zebra-striped
     * bordered data rows, a summary footer row, print footer, freeze + filter.
     */
    protected function styleSheet(
        AfterSheet $event,
        string $title,
        string $subtitle,
        string $lastCol,
        int $headingRow,
        ?string $summaryText = null,
        bool $boldFirstColumn = false,
    ): void {
        $sheet = $event->sheet->getDelegate();
        $highestRow = $sheet->getHighestDataRow();
        $lastColIndex = Coordinate::columnIndexFromString($lastCol);
        $dataStart = $headingRow + 1;

        // ---- Title banner (row 1) ----
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->setCellValue('A1', $title);
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E293B']],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'indent' => 1],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(32);

        // ---- Subtitle (row 2) ----
        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->setCellValue('A2', $subtitle);
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 10, 'color' => ['rgb' => 'CBD5E1']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '334155']],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'indent' => 1],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(20);

        // ---- Header row ----
        $sheet->getStyle("A{$headingRow}:{$lastCol}{$headingRow}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'indent' => 1],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '1D4ED8']]],
        ]);
        $sheet->getRowDimension($headingRow)->setRowHeight(24);

        // ---- Data rows: borders, zebra stripes, vertical centre ----
        if ($highestRow >= $dataStart) {
            $range = "A{$dataStart}:{$lastCol}{$highestRow}";
            $sheet->getStyle($range)->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E2E8F0']]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'indent' => 1, 'wrapText' => true],
                'font' => ['size' => 10, 'color' => ['rgb' => '1E293B']],
            ]);

            for ($r = $dataStart; $r <= $highestRow; $r++) {
                if (($r - $dataStart) % 2 === 1) {
                    $sheet->getStyle("A{$r}:{$lastCol}{$r}")->getFill()
                        ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F1F5F9');
                }
                $sheet->getRowDimension($r)->setRowHeight(20);
            }

            if ($boldFirstColumn) {
                $sheet->getStyle("A{$dataStart}:A{$highestRow}")->getFont()->setBold(true);
                $sheet->getStyle("A{$dataStart}:A{$highestRow}")->getFont()->getColor()->setRGB('0F172A');
            }
        }

        // ---- Summary footer row ----
        if ($summaryText !== null) {
            $summaryRow = $highestRow + 1;
            $sheet->mergeCells("A{$summaryRow}:{$lastCol}{$summaryRow}");
            $sheet->setCellValue("A{$summaryRow}", $summaryText);
            $sheet->getStyle("A{$summaryRow}")->applyFromArray([
                'font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0F172A']],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_RIGHT, 'indent' => 1],
            ]);
            $sheet->getRowDimension($summaryRow)->setRowHeight(22);
        }

        // ---- Freeze header, autofilter, print footer, tab colour ----
        $sheet->freezePane('A' . ($headingRow + 1));
        if ($highestRow >= $headingRow) {
            $sheet->setAutoFilter("A{$headingRow}:{$lastCol}{$highestRow}");
        }
        $sheet->getHeaderFooter()->setOddFooter('&LLawConnect Backup&C&D&RPage &P of &N');
        $sheet->getTabColor()->setRGB('2563EB');

        // Default font for the whole used range
        $sheet->getParent()->getDefaultStyle()->getFont()->setName('Calibri');
    }
}
