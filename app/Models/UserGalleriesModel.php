<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGalleriesModel extends Model
{
    use HasFactory;

    public $table='user_galleries';
    public $timestamps = false;
}
