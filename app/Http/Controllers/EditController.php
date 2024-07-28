<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EditController extends Controller
{
    public function read($id_booking)
    {
        $booking = Booking::with('customer', 'commission')->findOrFail($id_booking);
        return view('/pages/edit', compact('booking'));
    }

    public function update(Request $request, $id_booking)
    {
        // Validasi data
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'username' => 'required|string|max:255',
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
            'qty_ticket' => 'nullable|numeric',
            'totalPayment_ticket' => 'nullable|numeric',
            'paymentMethod_ticket' => 'nullable|string|max:255',
            'qty_add' => 'nullable|numeric',
            'totalPayment_add' => 'nullable|numeric',
            'paymentMethod_add' => 'nullable|string|max:255',
            'total_cms' => 'nullable|numeric',
            'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);
    
        // Memulai transaksi
        DB::beginTransaction();
    
        try {
            // Temukan data yang ingin diubah
            $booking = Booking::findOrFail($id_booking);
            $customer = Customer::findOrFail($booking->id_customer);
    
            // Perbarui data customers
            $customer->update([
                'name' => $validatedData['name'],
                'phone_number' => $validatedData['phone_number'],
                'email' => $validatedData['email'],
                'nationality' => $validatedData['nationality'],
                'visitor' => $validatedData['visitor'],
                'hostelry' => $validatedData['hostelry'],
            ]);
    
            // Perbarui data commissions jika ada
            if ($booking->id_cms) {
                $commission = Commission::findOrFail($booking->id_cms);
                $commission->update([
                    'name_receiver' => $validatedData['name_receiver'],
                    'type_receiver' => $validatedData['type_receiver'],
                    'phone_receiver' => $validatedData['phone_receiver'],
                    'carPlate_receiver' => $validatedData['carPlate_receiver'],
                    'nominal_cms' => $validatedData['nominal_cms'],
                ]);
            }
    
            // Perbarui data bookings
            $booking->update([
                'id_ticket' => $validatedData['id_ticket'],
                'id_add' => $validatedData['id_add'],
                'qty_ticket' => $validatedData['qty_ticket'],
                'totalPayment_ticket' => $validatedData['totalPayment_ticket'],
                'paymentMethod_ticket' => $validatedData['paymentMethod_ticket'],
                'qty_add' => $validatedData['qty_add'],
                'totalPayment_add' => $validatedData['totalPayment_add'],
                'paymentMethod_add' => $validatedData['paymentMethod_add'],
                'total_cms' => $validatedData['total_cms'],
            ]);
    
            // Update user data
            $user = User::findOrFail($validatedData['id']);
            $user->update([
                'username' => $validatedData['username'],
            ]);
    
            // Proses upload dokumen
            if ($request->hasFile('document')) {
                $document = $request->file('document');
                $documentPath = $document->storeAs(
                    'documents',
                    time() . '_' . $document->getClientOriginalName(),
                    'public'
                );
    
                // Hapus dokumen lama jika ada
                if ($booking->document_path) {
                    Storage::disk('public')->delete($booking->document);
                }
    
                // Simpan path dokumen baru
                $booking->update(['document' => $documentPath]);
            }
    
            Notification::create([
                'id' => Auth::id(),
                'type' => 'update',
                'message' => 'Updates have been made to bookings with ID number ' . $booking->id_booking,
            ]);
    
            // Commit transaksi
            DB::commit();
    
            return redirect()->back()->with('success', 'Data has been saved successfully.');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
    
            Notification::create([
                'id' => Auth::id(),
                'type' => 'error',
                'message' => 'Failed to update: ' . $e->getMessage(),
            ]);
    
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to save data. ' . $e->getMessage()]);
        }
    }
    
    
    public function delete($id_booking)
    {
        $booking = Booking::find($id_booking);

        if (!$booking) {
            return redirect()->back()->with('error', 'Data not found.');
        }

        $booking->delete(); // Ini akan melakukan soft delete

        Notification::create([
            'id' => Auth::id(),
            'type' => 'delete',
            'message' => 'A deletion has been made to bookings with ID numbers ' . $booking->id_booking,
        ]);

        return redirect()->route('bookings')->with('success', 'Data deleted successfully.');
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
