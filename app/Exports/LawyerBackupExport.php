<?php

namespace App\Exports;

use App\Exports\Sheets\CasesSheet;
use App\Exports\Sheets\ClientsSheet;
use App\Exports\Sheets\LawyerInfoSheet;
use App\Models\Lawyer;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LawyerBackupExport implements WithMultipleSheets
{
    public function __construct(protected Lawyer $lawyer)
    {
    }

    public function sheets(): array
    {
        return [
            new LawyerInfoSheet($this->lawyer),
            new ClientsSheet($this->lawyer),
            new CasesSheet($this->lawyer),
        ];
    }
}
