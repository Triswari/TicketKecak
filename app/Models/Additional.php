<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Additional extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'id_add';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name_add',
        'price_add'

    ];
}
