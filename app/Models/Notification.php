<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'type', 'message', 'is_read'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $primaryKey = 'id_notification';

    //untuk dapatkan notifikasi
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

}
