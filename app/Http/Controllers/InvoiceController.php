<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BookingDetail;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function show($id_booking)
    {
        $tanggalSekarang = date("Y-m-d");
        $data = BookingDetail::where('id_booking', $id_booking)->first();


        return view('pages/invoice', compact('tanggalSekarang', 'data'));
    }
    
}
