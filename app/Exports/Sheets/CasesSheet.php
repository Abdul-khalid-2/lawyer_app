<?php

namespace App\Exports\Sheets;

use App\Exports\Concerns\StylesWorksheet;
use App\Models\Lawyer;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class CasesSheet implements FromArray, WithTitle, WithHeadings, WithColumnWidths, WithCustomStartCell, WithEvents
{
    use StylesWorksheet;

    protected int $count = 0;

    public function __construct(protected Lawyer $lawyer)
    {
    }

    public function array(): array
    {
        $cases = $this->lawyer->cases()
            ->with('client.user')
            ->latest()
            ->get();

        $this->count = $cases->count();

        return $cases->values()->map(function ($case, $i) {
            return [
                $i + 1,
                $case->case_number ?? '—',
                $case->title,
                $case->client?->user?->name ?? '—',
                ucfirst($case->type),
                $case->court_name ?? '—',
                ucfirst(str_replace('_', ' ', $case->status)),
                optional($case->filed_date)->format('d M Y') ?? '—',
                optional($case->next_hearing_date)->format('d M Y') ?? '—',
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return ['#', 'Case No.', 'Title', 'Client', 'Type', 'Court', 'Status', 'Filed', 'Next Hearing'];
    }

    public function title(): string
    {
        return 'Cases';
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function columnWidths(): array
    {
        return ['A' => 6, 'B' => 16, 'C' => 38, 'D' => 24, 'E' => 12, 'F' => 26, 'G' => 14, 'H' => 14, 'I' => 14];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->styleSheet(
                    $event,
                    'CASES — ' . $this->lawyer->user->name,
                    'All legal cases handled by this lawyer',
                    'I',
                    3,
                    'Total Cases: ' . $this->count,
                );
            },
        ];
    }
}
