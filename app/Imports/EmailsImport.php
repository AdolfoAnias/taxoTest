<?php

namespace App\Imports;

use App\Models\ImportExcel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\{Importable, ToModel, WithHeadingRow};

class EmailsImport implements ToModel, WithHeadingRow
{
    use Importable;
    
    public function model(array $row)
    {
        return new ImportExcel([
            "subject" => $row['subject'],
            "recipient" => $row['recipient'],
            "body" => $row['body'],
            "state" => $row['state'],
            "user_id" => $row['user_id'],
        ]);
    }
}

                                                                                                                                                                                                                                                                                                                                                    