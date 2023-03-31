<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveManagement extends Model
{
    use HasFactory;
 /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'employee_id',
        'leave_type', 
        'leave_date',
        'deleted_date',
    ];
    public function employee_info(){
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id');
    }
    public function leave_info(){
        return $this->hasOne('App\Models\LeaveStatus', 'id', 'leave_type');
    }
}
