<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingDetail;
use Illuminate\Support\Facades\Lang;
use App\Charts\PaymentMethodChart;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request, PaymentMethodChart $paymentMethodChart)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $searchColumns = $request->input('search_columns', []);
        $searchKeywords = $request->input('search_keywords', []);
        $itemsPerPage = $request->input('items_per_page', 10); // Default to 10 items per page
    
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
    
        $query = BookingDetail::query();
    
        if (!empty($start_date) && !empty($end_date)) {
            $end_date = Carbon::parse($end_date)->endOfDay();
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }
    
        if (!empty($searchColumns) && !empty($searchKeywords)) {
            foreach ($searchColumns as $index => $column) {
                $keyword = $searchKeywords[$index];
                if ($column == 'created_at') {
                    $start_date = $keyword['start_date'] ?? null;
                    $end_date = $keyword['end_date'] ?? null;
    
                    if ($start_date && $end_date) {
                        $query->whereBetween($column, [$start_date, Carbon::parse($end_date)->endOfDay()]);
                    } elseif ($start_date) {
                        $query->whereDate($column, '>=', $start_date);
                    } elseif ($end_date) {
                        $query->whereDate($column, '<=', $end_date);
                    }
                } else {
                    $query->where($column, 'LIKE', '%' . $keyword . '%');
                }
            }
        }
    
        $data = $query->orderBy('created_at', 'desc')->sortable()->paginate($itemsPerPage);
    
        // Copy the query builder for each calculation
        $countQuery = clone $query;
        $cashMoneyQuery = clone $query;
        $ticketQuery = clone $query;
        $domesticQuery = clone $query;
        $foreignQuery = clone $query;
        $globaltixQuery = clone $query;
        $globaltixMoneyQuery = clone $query;
        $cardQuery = clone $query;
        $qrisQuery = clone $query;
        $transferQuery = clone $query;
        $paidQuery = clone $query;
        $delayQuery = clone $query;
        $totalDelayQuery = clone $query;
        $totalPaymentQuery = clone $query;
        $otherPaymentQuery = clone $query;
        $addQuery = clone $query;
        $totalAddQuery = clone $query;
        $cmsQuery = clone $query;
        $cmsTicketQuery = clone $query;
    
        $count = $countQuery->where('paymentMethod_ticket', '=', 'Cash')->sum('qty_ticket');
        $cashMoney = $cashMoneyQuery->where('paymentMethod_ticket', '=', 'Cash')->sum('totalPayment_ticket');
        $ticket = $ticketQuery->sum('qty_ticket');
        $domestic = $domesticQuery->where('visitor', '=', 'Domestic')->sum('qty_ticket');
        $foreign = $foreignQuery->where('visitor', '=', 'Foreign')->sum('qty_ticket');
        $globaltix = $globaltixQuery->where('paymentMethod_ticket', '=', 'GlobalTix')->sum('qty_ticket');
        $globaltixMoney = $globaltixMoneyQuery->where('paymentMethod_ticket', '=', 'GlobalTix')->sum('totalPayment_ticket');
        $card = $cardQuery->where('paymentMethod_ticket', '=', 'Card')->sum('qty_ticket');
        $qris = $qrisQuery->where('paymentMethod_ticket', '=', 'Qris')->sum('qty_ticket');
        $transfer = $transferQuery->where('paymentMethod_ticket', '=', 'Transfer')->sum('qty_ticket');
        $paid = $paidQuery->where('paymentMethod_ticket', '=', 'Paid')->sum('qty_ticket');
        $delay = $delayQuery->where('paymentMethod_ticket', '=', 'Delay')->sum('qty_ticket');
        $totalDelay = $totalDelayQuery->where('paymentMethod_ticket', '=', 'Delay')->sum('totalPayment_ticket');
        $totalPayment = $totalPaymentQuery->whereIn('paymentMethod_ticket', ['Cash', 'Card', 'Qris', 'Transfer', 'Paid', 'Delay'])->sum('totalPayment_ticket');
        $otherPayment = $otherPaymentQuery->whereIn('paymentMethod_ticket', ['Card', 'Qris', 'Transfer', 'Paid'])->sum('totalPayment_ticket');
        $add = $addQuery->sum('qty_add');
        $totalAdd = $totalAddQuery->sum('totalPayment_add');
        $cms = $cmsQuery->sum('total_cms');
        $cmsTicket = $cmsTicketQuery->whereNotNull('total_cms')->sum('qty_ticket');
    
        $paymentMethodChart->paymentMethodChart = $paymentMethodChart->build();
    
        return view('pages.dashboard', [
            'count' => $count, 
            'cashMoney' => $cashMoney,
            'ticket' => $ticket, 
            'domestic' => $domestic, 
            'foreign' => $foreign,
            'globaltix' => $globaltix,
            'globaltixMoney' => $globaltixMoney,
            'card' => $card,
            'qris' => $qris,
            'transfer' => $transfer,
            'paid' => $paid,
            'totalDelay' => $totalDelay,
            'delay' => $delay,
            'totalPayment' => $totalPayment,
            'otherPayment' => $otherPayment,
            'add' => $add,
            'totalAdd' => $totalAdd,
            'cms' => $cms,
            'cmsTicket' => $cmsTicket,
            'data' => $data,
            'searchColumns' => $searchColumns,
            'searchKeywords' => $searchKeywords,
            'paymentMethodChart' => $paymentMethodChart,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
    


    // Fungsi untuk commission calculation di dashboard
    public function hitung(Request $request)
    {
        $request->validate([
            'ticket' => 'required|numeric',
            'price' => 'required|numeric',
            'receiver' => 'required|numeric',
            'nominal' => 'required|numeric',
        ]);

        $ticket = $request->input('ticket');
        $price = $request->input('price');
        $receiver = $request->input('receiver');
        $nominal = $request->input('nominal');

        $cash = $ticket * $price;
        $commission = $receiver * $nominal;
        $money = $cash - $commission;

        // Set session data
        session([
            'ticket' => $ticket,
            'price' => $price,
            'receiver' => $receiver,
            'nominal' => $nominal,
            'cash' => $cash,
            'commission' => $commission,
            'money' => $money,
        ]);

        return redirect()->back()->with([
            'ticket' => $ticket,
            'price' => $price,
            'receiver' => $receiver,
            'nominal' => $nominal,
            'cash' => $cash,
            'commission' => $commission,
            'money' => $money,
        ]);
    }
}
