<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingDetail;
use App\Charts\PaymentMethodChart;
use Illuminate\Support\Facades\Log;

class CalculationController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan nilai start_date dan end_date dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Inisialisasi query untuk BookingDetail
        $query = BookingDetail::query();

        // Jika tidak ada input start_date dan end_date, ambil tanggal awal dan akhir dari data di database
        if (empty($startDate) || empty($endDate)) {
            $firstRecord = BookingDetail::orderBy('created_at', 'asc')->first();
            $lastRecord = BookingDetail::orderBy('created_at', 'desc')->first();

            if ($firstRecord) {
                $defaultStartDate = $firstRecord->created_at->format('Y-m-d');
            }
            if ($lastRecord) {
                $defaultEndDate = $lastRecord->created_at->format('Y-m-d');
            }

            if (empty($startDate)) {
                $startDate = $defaultStartDate ?? null;
            }
            if (empty($endDate)) {
                $endDate = $defaultEndDate ?? null;
            }
        }

        // Menambahkan filter tanggal jika ada
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Menyusun data berdasarkan filter
        $count = (clone $query)->where('paymentMethod_ticket', '=', 'Cash')->sum('qty_ticket');
        $cashMoney = (clone $query)->where('paymentMethod_ticket', '=', 'Cash')->sum('totalPayment_ticket');
        $ticket = (clone $query)->sum('qty_ticket');
        $domestic = (clone $query)->where('visitor', '=', 'Domestic')->sum('qty_ticket');
        $foreign = (clone $query)->where('visitor', '=', 'Foreign')->sum('qty_ticket');
        $globaltix = (clone $query)->where('paymentMethod_ticket', '=', 'GlobalTix')->sum('qty_ticket');
        $globaltixMoney = (clone $query)->where('paymentMethod_ticket', '=', 'GlobalTix')->sum('totalPayment_ticket');
        $card = (clone $query)->where('paymentMethod_ticket', '=', 'Card')->sum('qty_ticket');
        $cardMoney = (clone $query)->where('paymentMethod_ticket', '=', 'Card')->sum('totalPayment_ticket');
        $qris = (clone $query)->where('paymentMethod_ticket', '=', 'Qris')->sum('qty_ticket');
        $qrisMoney = (clone $query)->where('paymentMethod_ticket', '=', 'Qris')->sum('totalPayment_ticket');
        $transfer = (clone $query)->where('paymentMethod_ticket', '=', 'Transfer')->sum('qty_ticket');
        $transferMoney = (clone $query)->where('paymentMethod_ticket', '=', 'Transfer')->sum('totalPayment_ticket');
        $paid = (clone $query)->where('paymentMethod_ticket', '=', 'Paid')->sum('qty_ticket');
        $paidMoney = (clone $query)->where('paymentMethod_ticket', '=', 'Paid')->sum('totalPayment_ticket');
        $add = (clone $query)->sum('qty_add');

        return view('pages.calculation', [
            'count' => $count, 
            'cashMoney' => $cashMoney,
            'ticket' => $ticket, 
            'domestic' => $domestic, 
            'foreign' => $foreign,
            'globaltix' => $globaltix,
            'globaltixMoney' => $globaltixMoney,
            'card' => $card,
            'cardMoney' => $cardMoney,
            'qris' => $qris,
            'qrisMoney' => $qrisMoney,
            'transfer' => $transfer,
            'transferMoney' => $transferMoney,
            'paid' => $paid,
            'paidMoney' => $paidMoney,
            'add' => $add,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
    

    // Fungsi kalkulasi di halmana calculations
    public function calculate(Request $request, PaymentMethodChart $paymentMethodChart)
    {
        // Filter pencarian
        $search = $request->query('search');
        
        // Inisialisasi variabel data
        $data = BookingDetail::sortable()->paginate(9);
        
        if (!empty($search)) {
            $data = BookingDetail::sortable()
                ->where('paymentMethod_ticket', 'LIKE', '%'.$search.'%')
                ->orWhere('name', 'LIKE', '%'.$search.'%')
                ->orWhere('id_booking', 'LIKE', '%'.$search.'%')
                ->orWhere('nationality', 'LIKE', '%'.$search.'%')
                ->orWhere('qty_ticket', 'LIKE', '%'.$search.'%')
                ->orWhere('hostelry', 'LIKE', '%'.$search.'%')
                ->orWhere('phone_number', 'LIKE', '%'.$search.'%')
                ->orWhere('email', 'LIKE', '%'.$search.'%')
                ->orWhere('visitor', 'LIKE', '%'.$search.'%')
                ->orWhere('price_ticket', 'LIKE', '%'.$search.'%')
                ->orWhere('totalPayment_ticket', 'LIKE', '%'.$search.'%')
                ->orWhere('qty_add', 'LIKE', '%'.$search.'%')
                ->orWhere('price_add', 'LIKE', '%'.$search.'%')
                ->orWhere('totalPayment_add', 'LIKE', '%'.$search.'%')
                ->orWhere('paymentMethod_add', 'LIKE', '%'.$search.'%')
                ->orWhere('name_receiver', 'LIKE', '%'.$search.'%')
                ->orWhere('type_receiver', 'LIKE', '%'.$search.'%')
                ->orWhere('phone_receiver', 'LIKE', '%'.$search.'%')
                ->orWhere('carPlate_receiver', 'LIKE', '%'.$search.'%')
                ->orWhere('nominal_cms', 'LIKE', '%'.$search.'%')
                ->orWhere('total_cms', 'LIKE', '%'.$search.'%')
                ->orWhere('created_at', 'LIKE', '%'.$search.'%');
        }
    
        // Hitung total jumlah tiket dan metode pembayaran
        $count = BookingDetail::where('paymentMethod_ticket', '=', 'Cash')->sum('qty_ticket');
        $cashMoney = BookingDetail::where('paymentMethod_ticket', '=', 'Cash')->sum('totalPayment_ticket');
        $ticket = BookingDetail::sum('qty_ticket');
        $domestic = BookingDetail::where('visitor', '=', 'Domestic')->sum('qty_ticket');
        $foreign = BookingDetail::where('visitor', '=', 'Foreign')->sum('qty_ticket');
        $globaltix = BookingDetail::where('paymentMethod_ticket', '=', 'GlobalTix')->sum('qty_ticket');
        $card = BookingDetail::where('paymentMethod_ticket', '=', 'Card')->sum('qty_ticket');
        $qris = BookingDetail::where('paymentMethod_ticket', '=', 'Qris')->sum('qty_ticket');
        $transfer = BookingDetail::where('paymentMethod_ticket', '=', 'Transfer')->sum('qty_ticket');
        $paid = BookingDetail::where('paymentMethod_ticket', '=', 'Paid')->sum('qty_ticket');
        $add = BookingDetail::sum('qty_add');

        // Buat grafik metode pembayaran
        $paymentMethodChart->paymentMethodChart = $paymentMethodChart->build();
    
        // Kirim data ke view
        return view('pages.calculation', [
            'count' => $count,
            'cashMoney' => $cashMoney, 
            'ticket' => $ticket, 
            'domestic' => $domestic, 
            'foreign' => $foreign,
            'globaltix' => $globaltix,
            'card' => $card,
            'qris' => $qris,
            'transfer' => $transfer,
            'paid' => $paid,
            'add' => $add,
            'data' => $data,
            'search' => $search,
            'paymentMethodChart' => $paymentMethodChart,
        ]);
    }
    
}
