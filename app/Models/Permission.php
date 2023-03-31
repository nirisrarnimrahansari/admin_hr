<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{ use HasFactory;
    /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
      protected $fillable = [
          'employee_id',
          'manager_id',
          'deleted_date',
      ];
      
    public function employee_info(){
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id');
    } 
    public function manager_info(){
        return $this->hasOne('App\Models\User', 'id', 'manager_id');
    }
}
