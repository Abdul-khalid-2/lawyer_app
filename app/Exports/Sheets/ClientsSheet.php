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

class ClientsSheet implements FromArray, WithTitle, WithHeadings, WithColumnWidths, WithCustomStartCell, WithEvents
{
    use StylesWorksheet;

    protected int $count = 0;

    public function __construct(protected Lawyer $lawyer)
    {
    }

    public function array(): array
    {
        $clients = $this->lawyer->clients()
            ->with('user')
            ->withCount('cases')
            ->latest()
            ->get();

        $this->count = $clients->count();

        return $clients->values()->map(function ($client, $i) {
            return [
                $i + 1,
                $client->user?->name ?? '—',
                $client->user?->email ?? '—',
                $client->phone ?? '—',
                $client->cnic ?? '—',
                $client->city ?? '—',
                $client->cases_count,
                $client->is_active ? 'Active' : 'Inactive',
                optional($client->created_at)->format('d M Y') ?? '—',
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return ['#', 'Name', 'Email', 'Phone', 'CNIC', 'City', 'Cases', 'Status', 'Joined'];
    }

    public function title(): string
    {
        return 'Clients';
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function columnWidths(): array
    {
        return ['A' => 6, 'B' => 26, 'C' => 30, 'D' => 16, 'E' => 18, 'F' => 16, 'G' => 8, 'H' => 12, 'I' => 14];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->styleSheet(
                    $event,
                    'CLIENTS — ' . $this->lawyer->user->name,
                    'All clients managed by this lawyer',
                    'I',
                    3,
                    'Total Clients: ' . $this->count,
                );
            },
        ];
    }
}
