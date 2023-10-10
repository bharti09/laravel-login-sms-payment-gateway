<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
   // use HasFactory;
    protected $table = 'payment';
    protected $guarded = ['id'];
}
