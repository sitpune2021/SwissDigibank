<?php

namespace App\Exports;

use App\Models\LoanAgainstApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LoanAgainstExport implements FromCollection, WithHeadings
{
   public function collection()
    {
        // Sirf id aur status column fetch karenge
        return LoanAgainstApplication::select('id', 'status')->get();
    }

    public function headings(): array
    {
        return [
            'LOAN APPLICATION NO',
            'LOAN APPLICATION STATUS',
            'LOAN ACCOUNT NO',
            'LOAN ACCOUNT STATUS',
            'PROPERTY TYPE',
            'EXPECTED VALUE',
            'REGISTERED',
        ];
    }
}
