<?php

namespace App\Http\Controllers;

use App\Exports\ExportBooking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingDetail;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function report(Request $request)
    {
        $search = $request->query('search');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $searchColumns = $request->input('search_columns', []);
        $searchKeywords = $request->input('search_keywords', []);
        $itemsPerPage = $request->input('items_per_page', 10); // Default to 10 items per page

        $query = BookingDetail::sortable();

        // General search filter
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('paymentMethod_ticket', 'LIKE', '%'.$search.'%')
                ->orWhere('name', 'LIKE', '%'.$search.'%')
                ->orWhere('id_booking', 'LIKE', '%'.$search.'%')
                ->orWhere('nationality', 'LIKE', '%'.$search.'%')
                ->orWhere('qty_ticket', 'LIKE', '%'.$search.'%')
                ->orWhere('hostelry', 'LIKE', '%'.$search.'%')
                ->orWhere('phone_number', 'LIKE', '%'.$search.'%')
                ->orWhere('email', 'LIKE', '%'.$search.'%')
                ->orWhere('visitor', 'LIKE', '%'.$search.'%')
                ->orWhere('qty_ticket', 'LIKE', '%'.$search.'%')
                ->orWhere('price_ticket', 'LIKE', '%'.$search.'%')
                ->orWhere('totalPayment_ticket', 'LIKE', '%'.$search.'%')
                ->orWhere('document', 'LIKE', '%'.$search.'%')
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
                ->orWhere('created_at', 'LIKE', '%'.$search.'%')
                ->orWhere('updated_at', 'LIKE', '%'.$search.'%');
            });
        }

        // Apply search criteria
        if (!empty($searchColumns) && !empty($searchKeywords)) {
            foreach ($searchColumns as $index => $column) {
                if (!empty($searchKeywords[$index])) {
                    if ($column == 'created_at') {
                        $start_date = $searchKeywords[$index]['start_date'] ?? null;
                        $end_date = $searchKeywords[$index]['end_date'] ?? null;

                        if ($start_date && $end_date) {
                            $query->whereBetween($column, [Carbon::parse($start_date), Carbon::parse($end_date)->endOfDay()]);
                        } elseif ($start_date) {
                            $query->whereDate($column, '>=', $start_date);
                        } elseif ($end_date) {
                            $query->whereDate($column, '<=', $end_date);
                        }
                    } else {
                        $query->where($column, 'LIKE', '%'.$searchKeywords[$index].'%');
                    }
                }
            }
        }

        if (!empty($startDate) && !empty($endDate)) {
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Ensure columns are selected correctly
        $columns = $request->input('columns', []);
        if (!empty($columns)) {
            $query->select($columns);
        }

        $reports = $query->paginate($itemsPerPage);

        // Calculate the starting number for each page
        $page = $request->input('page', 1);
        $startNumber = ($page - 1) * $itemsPerPage;

        return view('pages/reports')->with([
            'reports' => $reports,
            'search' => $search,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'startNumber' => $startNumber,
            'searchColumns' => $searchColumns,
            'searchKeywords' => $searchKeywords,
            'itemsPerPage' => $itemsPerPage,
        ]);
    }

    // Fungsi export file
    public function export_excel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $columns = $request->input('columns', []); // Dapatkan kolom yang dipilih oleh user

        $query = BookingDetail::query();

        if (!empty($startDate) && !empty($endDate)) {
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query = $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Pilih hanya kolom yang dipilih oleh user
        if (!empty($columns)) {
            $query = $query->select($columns);
        } else {
            // Default ke semua kolom jika tidak ada kolom yang dipilih
            $query = $query->select('*');
        }

        $reports = $query->get();

        // Dapatkan tanggal saat ini dalam format yang diinginkan
        $currentDate = Carbon::now()->format('Y-m-d');

        // Sertakan tanggal regenerasi dalam nama file
        $fileName = "Report_TicketingKecak_{$currentDate}.xlsx";

        // Tambahkan judul untuk export
        $title = "Laporan Tiket Kecak";

        // Format tanggal untuk laporan
        $reportDate = Carbon::now()->format('Y-m-d');
        $formattedStartDate = $startDate ? Carbon::parse($startDate)->format('Y-m-d') : 'N/A';
        $formattedEndDate = $endDate ? Carbon::parse($endDate)->format('Y-m-d') : 'N/A';

        $sumColumns = ['qty_ticket', 'totalPayment_ticket', 'qty_add', 'totalPayment_add', 'total_cms'];

        return Excel::download(new ExportBooking($reports, $title, $reportDate, $formattedStartDate, $formattedEndDate, $sumColumns), $fileName);
    }

}
