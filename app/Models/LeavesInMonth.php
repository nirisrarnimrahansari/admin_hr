<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeavesInMonth extends Model
{
    use HasFactory;
    protected $table = 'leaves_in_month';
    protected $fillable = [
        'employee_id',
        'm_y',
        'leaves',
    ];
}
