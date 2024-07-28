<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'id_booking';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id_customer',
        'id',
        'id_ticket',
        'id_add',
        'id_cms',
        'qty_ticket',
        'totalPayment_ticket',
        'paymentMethod_ticket',
        'qty_add',
        'totalPayment_add',
        'paymentMethod_add',
        'total_cms',
        'document',
        'created_at',
        'updated_at'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }

    public function add()
    {
        return $this->belongsTo(Addtional::class, 'id_add');
    }

    public function commission()
    {
        return $this->belongsTo(Commission::class, 'id_cms');
    }

}
