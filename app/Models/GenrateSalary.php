<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenrateSalary extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'leave_type',
        'basic_salary',
        'current_salary',
        'deleted_date',
    ];
    public function leave_info(){
        return $this->hasOne('App\Models\LeaveStatus', 'id', 'leave_type');
    }
}
