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

class LawyerInfoSheet implements FromArray, WithTitle, WithHeadings, WithColumnWidths, WithCustomStartCell, WithEvents
{
    use StylesWorksheet;

    public function __construct(protected Lawyer $lawyer)
    {
    }

    public function array(): array
    {
        $l = $this->lawyer;
        $u = $l->user;

        return [
            ['Full Name', $u->name],
            ['Email', $u->email],
            ['Phone', $u->phone ?? '—'],
            ['Firm Name', $l->firm_name ?? '—'],
            ['Bar Number', $l->bar_number ?? '—'],
            ['License State', $l->license_state ?? '—'],
            ['Years of Experience', (string) $l->years_of_experience],
            ['Location', trim(($l->city ?? '') . ' ' . ($l->state ?? '') . ' ' . ($l->country ?? '')) ?: '—'],
            ['Specializations', $l->specializations->pluck('name')->implode(', ') ?: '—'],
            ['Verified', $l->is_verified ? 'Yes' : 'No'],
            ['Total Clients', (string) $l->clients()->count()],
            ['Total Cases', (string) $l->cases()->count()],
            ['Total Team Members', (string) $l->teamMembers()->count()],
            ['Total Reviews', (string) $l->reviews()->count()],
            ['Backup Generated', now()->format('d M Y, h:i A')],
        ];
    }

    public function headings(): array
    {
        return ['Field', 'Details'];
    }

    public function title(): string
    {
        return 'Lawyer Profile';
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function columnWidths(): array
    {
        return ['A' => 28, 'B' => 64];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->styleSheet(
                    $event,
                    'LAWYER PROFILE — ' . $this->lawyer->user->name,
                    'LawConnect data backup · generated ' . now()->format('d M Y, h:i A'),
                    'B',
                    3,
                    null,
                    boldFirstColumn: true,
                );
            },
        ];
    }
}
