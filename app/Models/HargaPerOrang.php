<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaPerOrang extends Model
{
    use HasFactory;
    protected $table = 'harga_per_orang';
    protected $primaryKey = 'id';

    protected $guarded = ['id'];
}
