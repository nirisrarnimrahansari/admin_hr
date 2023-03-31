<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
          /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'user_permission',
        'deleted_date',
    ];
    public function slug_info(){
        return $this->hasOne('App\Models\UserPermission', 'id', 'user_permission');
    }
}
