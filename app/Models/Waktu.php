<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waktu extends Model
{
    use HasFactory;
    protected $table = 'waktu_studio';
    protected $primaryKey = 'id';

    protected $guarded = ['id'];
    public $timestamps = false;
}
