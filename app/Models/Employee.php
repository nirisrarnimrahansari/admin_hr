<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;  /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $fillable = [
       'name',
       'father_name', 
       'select_id',
       'id_proof',
       'upload_pan_card',
       'pan_number',
       'designation_id',
       'email_id',
       'whatsapp_no',
       'dob',
       'joining_date',
       'basic_salary',
       'basic_salary_ed',
       'shift_id',
       'shift_ed',
       'type',
       'permanent_date',
       'casual_leave',
       'earn_leave',
       'department_id',
       'biometric_id',
       'deleted_date',
   ];
   public function designation_info(){
    return $this->hasOne('App\Models\Designation', 'id', 'designation_id');
   }
   public function shift_info(){
    return $this->hasOne('App\Models\Shift', 'id', 'shift_id');
   }
   public function department_info(){  
      return $this->hasOne('App\Models\Department', 'id', 'department_id');
   }

}
