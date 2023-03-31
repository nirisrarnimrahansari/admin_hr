<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferLetter extends Model
{
    use HasFactory;
    protected $table = 'offer_latters';
    protected $fillable = [
         'subject',
         'description',
         'content',
         'deleted_date',
     ];
}