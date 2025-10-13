<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoboothTemplate extends Model
{
    use HasFactory;
    protected $table = 'photobooth_templates';
    protected $primaryKey = 'id';

    protected $guarded = ['id'];
}
