<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'id_ticket';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'price_ticket'

    ];
}
