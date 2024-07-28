<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Additional;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class RestoreController extends Controller
{
    public function index()
    {
        $deletedTickets = Ticket::onlyTrashed()->get();
        $deletedAdd = Additional::onlyTrashed()->get();
        $deletedBookings = Booking::onlyTrashed()
            ->join('customers', 'bookings.id_customer', '=', 'customers.id_customer')
            ->select('bookings.deleted_at', 'bookings.paymentMethod_ticket', 'bookings.id_booking', 'customers.name', 'customers.nationality', 'bookings.qty_ticket', 'customers.hostelry', 'bookings.created_at')
            ->get();
        $deletedUser = User::onlyTrashed()->get();
    
        return view('pages.restore', compact('deletedTickets', 'deletedAdd', 'deletedBookings', 'deletedUser'));
    }

    // Fungsi notif restore ticket
    public function restoreTicket($id_ticket)
    {
        $ticket = Ticket::withTrashed()->findOrFail($id_ticket);
        $ticket->restore();

        Notification::create([
            'id' => Auth::id(),
            'type' => 'restore',
            'message' => 'Data has been restored to product with ID number ' . $ticket->id_ticket,
        ]);

        return redirect()->route('restore.index')->with('success', 'Ticket restored successfully.');
    }

    // Fungsi notif restore Add
    public function restoreAdd($id_add)
    {
        $add = Additional::withTrashed()->findOrFail($id_add);
        $add->restore();

        Notification::create([
            'id' => Auth::id(),
            'type' => 'restore',
            'message' => 'Data has been restored to product with ID number ' . $add->id_add,
        ]);

        return redirect()->route('restore.index')->with('success', 'Additional restored successfully.');
    }

    // Fungsi notif restore booking
    public function restoreBookings($id_booking)
    {
        $bookings = Booking::withTrashed()->findOrFail($id_booking);
        $bookings->restore();
    
        Notification::create([
            'id' => Auth::id(),
            'type' => 'restore',
            'message' => 'Data has been restored to booking with ID number ' . $bookings->id_booking,
        ]);
    
        return redirect()->route('restore.index')->with('success', 'Booking restored successfully.');
    }

    // fungsi notif restore user
    public function restoreUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
    
        Notification::create([
            'id' => Auth::id(),
            'type' => 'restore',
            'message' => 'Data has been restored to booking with ID number ' . $user->id, 
        ]);
    
        return redirect()->route('restore.index')->with('success', 'Booking restored successfully.');
    }
}
