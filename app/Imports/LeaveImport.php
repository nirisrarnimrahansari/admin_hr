<?php

namespace App\Imports;

use App\Models\LeaveManagement;
use Maatwebsite\Excel\Concerns\ToModel;

class LeaveImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        echo "<pre>";
        print_r($row);
         return new LeaveManagement([
            //
        ]);
    }
}
