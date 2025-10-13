<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoboothPhoto extends Model
{
    use HasFactory;
    protected $table = 'photobooth_photos';
    protected $primaryKey = 'id';

    protected $guarded = ['id'];
}
