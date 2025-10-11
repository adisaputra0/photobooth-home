<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarBando extends Model
{
    use HasFactory;
    protected $table = 'gambar_bando';
    protected $primaryKey = 'id';

    protected $guarded = ['id'];
}
