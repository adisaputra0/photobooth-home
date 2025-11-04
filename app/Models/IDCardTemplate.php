<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IDCardTemplate extends Model
{
    use HasFactory;
    protected $table = 'idcard_templates';
    protected $primaryKey = 'id';

    protected $guarded = ['id'];
}
