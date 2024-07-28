<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingDetail extends Model
{
    use HasFactory;
    use Sortable;
    use SoftDeletes;

    protected $table = 'booking_details';
    protected $dates = ['deleted_at'];

    // Jika ada kolom tambahan, sesuaikan sesuai kebutuhan
    protected $fillable = [
        'id_booking',
        'name', 
        'phone_number', 
        'email', 
        'nationality', 
        'visitor', 
        'hostelry',
        'title', 
        'qty_ticket', 
        'price_ticket', 
        'totalPayment_ticket', 
        'paymentMethod_ticket', 
        'name_add',
        'qty_add', 
        'price_add', 
        'totalPayment_add', 
        'paymentMethod_add', 
        'name_receiver', 
        'type_receiver', 
        'phone_receiver', 
        'carPlate_receiver', 
        'nominal_cms',
        'total_cms',
        'username',
        'document',
        'created_at',
        'updated_at'
    ];

    public $sortable = [
        'id_booking', 'name_receiver', 'type_receiver', 
        'name', 'qty_ticket', 'total_cms'
    ];
}
