<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaktuOperasional extends Model
{
    use HasFactory;
    protected $table = 'waktu_operasional';
    protected $primaryKey = 'id';

    protected $guarded = ['id'];
    public $timestamps = false;
}
