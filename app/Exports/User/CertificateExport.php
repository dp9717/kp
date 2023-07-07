<?php

namespace App\Exports\User;

use Maatwebsite\Excel\Concerns\FromCollection;

class CertificateExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
}
