<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageUploadModel extends Model
{
    use HasFactory;


    public $table='image_upload';
    protected $fillable = ['flag'];
    public $timestamps = false;
}
