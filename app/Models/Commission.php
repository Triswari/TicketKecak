<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_cms';

    protected $fillable = [
        'name_receiver',
        'type_receiver',
        'phone_receiver',
        'carPlate_receiver',
        'nominal_cms'

    ];
}
