<?php

namespace App\Imports;

use App\Models\Email;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmailsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Email([
            "subject" => $row['subject'],
            "recipient" => $row['recipient'],
            "body" => $row['body'],
            "state" => $row['state'],
            "user_id" => $row['user_id'],
        ]);
    }
}

                                                                                                                                                                                                                                                                                                                                                    