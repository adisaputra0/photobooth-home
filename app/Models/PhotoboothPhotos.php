<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoboothPhotos extends Model
{
    use HasFactory;
    protected $table = 'photobooth_photos';
    protected $primaryKey = 'id';

    protected $guarded = ['id'];
}
