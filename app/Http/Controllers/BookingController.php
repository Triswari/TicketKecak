<?php

namespace App\Http\Controllers;

use App\Exports\ExportBooking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Customer;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Additional;
use App\Models\Commission;
use App\Models\Notification;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function booking(Request $request)
    {
        $sortField = $request->input('sort_field', 'id_booking');
        $sortDirection = $request->input('sort_direction', 'desc');
        $searchColumns = $request->input('search_columns', []);
        $searchKeywords = $request->input('search_keywords', []);
        $itemsPerPage = $request->input('items_per_page', 10); // Default to 10 items per page

        $bookings = Booking::join('customers', 'bookings.id_customer', '=', 'customers.id_customer')
            ->join('commissions', 'bookings.id_cms', '=', 'commissions.id_cms')
            ->select('bookings.paymentMethod_ticket', 'bookings.id_booking', 'customers.name', 'customers.nationality', 'bookings.qty_ticket', 'customers.hostelry', 'bookings.created_at', 'commissions.name_receiver');

        if (!empty($searchColumns) && !empty($searchKeywords)) {
            foreach ($searchColumns as $index => $column) {
                $keyword = $searchKeywords[$index] ?? '';
                if (!empty($column) && !empty($keyword)) {
                    if ($column == 'created_at') {
                        // If the column is 'created_at' and keyword is an array, we handle it differently
                        if (is_array($keyword)) {
                            $start_date = $keyword['start_date'] ?? null;
                            $end_date = $keyword['end_date'] ?? null;
                            if ($start_date && $end_date) {
                                // Ensure dates are in the same format
                                $start_date = \Carbon\Carbon::parse($start_date)->startOfDay();
                                $end_date = \Carbon\Carbon::parse($end_date)->endOfDay();
                                $bookings->whereBetween('bookings.' . $column, [$start_date, $end_date]);
                            } elseif ($start_date) {
                                $start_date = \Carbon\Carbon::parse($start_date)->startOfDay();
                                $bookings->where('bookings.' . $column, '>=', $start_date);
                            } elseif ($end_date) {
                                $end_date = \Carbon\Carbon::parse($end_date)->endOfDay();
                                $bookings->where('bookings.' . $column, '<=', $end_date);
                            }
                        } else {
                            $bookings->where('bookings.' . $column, 'like', '%' . $keyword . '%');
                        }
                    } else {
                        $bookings->where($column, 'like', '%' . $keyword . '%');
                    }
                }
            }
        }            

        $bookings = $bookings->orderBy(DB::raw("CAST(bookings.$sortField AS UNSIGNED)"), $sortDirection)
            ->paginate($itemsPerPage);

        return view('pages.bookings', compact('bookings', 'sortField', 'sortDirection', 'searchColumns', 'searchKeywords', 'itemsPerPage'));
    }

    public function index()
    {
        return view('pages/tickets');
    }


    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'nationality' => 'nullable|string|max:255',
            'visitor' => 'nullable|string|max:255',
            'hostelry' => 'nullable|string|max:255',
            'name_receiver' => 'nullable|string|max:255',
            'type_receiver' => 'nullable|string|max:255',
            'phone_receiver' => 'nullable|string|max:255',
            'carPlate_receiver' => 'nullable|string|max:255',
            'nominal_cms' => 'nullable|numeric',
            'id_ticket' => 'required|integer|exists:tickets,id_ticket',
            'id_add' => 'nullable|integer|exists:additionals,id_add',
            'id' => 'required|integer',
            'qty_ticket' => 'required|numeric',
            'totalPayment_ticket' => 'nullable|numeric',
            'paymentMethod_ticket' => 'nullable|string|max:255',
            'qty_add' => 'nullable|numeric',
            'totalPayment_add' => 'nullable|numeric',
            'paymentMethod_add' => 'nullable|string|max:255',
            'total_cms' => 'nullable|numeric',
            'document' => 'nullable|file|mimes:pdf,doc,docx,png|max:2048', // validasi file
        ]);
    
        \Log::info('Store method called', ['request' => $request->all()]);
    
        // Memulai transaksi
        DB::beginTransaction();
    
        try {
            // Simpan file yang diupload
            $documentPath = null;
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $documentPath = $file->storeAs(
                    'documents',
                    time() . '_' . $file->getClientOriginalName(),
                    'public'
                );
                \Log::info('File uploaded successfully', ['path' => $documentPath]);
            } else {
                \Log::info('No file uploaded');
            }
    
            // Simpan data ke tabel customers
            $customer = Customer::create([
                'name' => $validatedData['name'],
                'phone_number' => $validatedData['phone_number'],
                'email' => $validatedData['email'],
                'nationality' => $validatedData['nationality'],
                'visitor' => $validatedData['visitor'],
                'hostelry' => $validatedData['hostelry'],
            ]);
    
            // Simpan data ke tabel commissions
            $commission = Commission::create([
                'name_receiver' => $validatedData['name_receiver'],
                'type_receiver' => $validatedData['type_receiver'],
                'phone_receiver' => $validatedData['phone_receiver'],
                'carPlate_receiver' => $validatedData['carPlate_receiver'],
                'nominal_cms' => $validatedData['nominal_cms'],
            ]);
    
            // Simpan data ke tabel bookings
            $booking = Booking::create([
                'id_customer' => $customer->id_customer,
                'id_cms' => $commission->id_cms,
                'id_ticket' => $validatedData['id_ticket'],
                'id_add' => $validatedData['id_add'],
                'id' => $validatedData['id'],
                'qty_ticket' => $validatedData['qty_ticket'],
                'totalPayment_ticket' => $validatedData['totalPayment_ticket'],
                'paymentMethod_ticket' => $validatedData['paymentMethod_ticket'],
                'qty_add' => $validatedData['qty_add'],
                'totalPayment_add' => $validatedData['totalPayment_add'],
                'paymentMethod_add' => $validatedData['paymentMethod_add'],
                'total_cms' => $validatedData['total_cms'],
                'document' => $documentPath, // simpan path file ke database
            ]);
    
            Notification::create([
                'id' => Auth::id(),
                'type' => 'success',
                'message' => 'A new booking was successfully created with ID number ' . $booking->id_booking,
            ]);
    
            // Commit transaksi
            DB::commit();
    
            return redirect()->back()->with('success', 'Data has been saved successfully.');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
    
            \Log::error('Failed to make booking', ['error' => $e->getMessage()]);
    
            Notification::create([
                'id' => Auth::id(),
                'type' => 'error',
                'message' => 'Failed to make booking: ' . $e->getMessage(),
            ]);
    
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to save data. ']);
        }
    }

    // Fungsi Chart
    public function getVisitorData(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Format tanggal jika ada
        if ($startDate) {
            $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
        }
        if ($endDate) {
            $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();
        }
    
        // Query untuk mendapatkan data visitor
        $visitorDataQuery = BookingDetail::selectRaw('nationality, SUM(qty_ticket) as total_qty_ticket')
            ->groupBy('nationality');
    
        // Apply date filters if both dates are present
        if ($startDate && $endDate) {
            $visitorDataQuery->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $visitorDataQuery->where('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $visitorDataQuery->where('created_at', '<=', $endDate);
        }
    
        $visitorData = $visitorDataQuery->get();
    
        // Log the data to check if it's correct
        \Log::info('Visitor Data:', $visitorData->toArray());
    
        return response()->json($visitorData);
    }
        
    // Fungsi get data ticket & add untuk form
    public function getNamePriceAdd($id_add)
    {
        $additional = Additional::find($id_add); 
        if ($additional) {
            return response()->json([
                'name_add' => $additional->name_add,
                'price_add' => $additional->price_add
            ]);
        } else {
            return response()->json([
                'error' => 'Additional not found'
            ], 404);
        }
    }

    public function getTitlePriceTicket($id_ticket)
    {
        $ticket = Ticket::find($id_ticket);
        
        if ($ticket) {
            return response()->json([
                'title' => $ticket->title,
                'price_ticket' => $ticket->price_ticket
            ]);
        } else {
            return response()->json([
                'error' => 'Ticket not found'
            ], 404);
        }
    }


}
