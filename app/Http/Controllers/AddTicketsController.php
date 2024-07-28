<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class AddTicketsController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        return view('pages.products', compact('tickets'));
    }

    public function create()
    {
        return view('pages.addtickets');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price_ticket' => 'required|numeric',
        ]);

        $ticket = Ticket::create($request->all());

        Notification::create([
            'id' => Auth::id(),
            'type' => 'success',
            'message' => 'A new product was successfully created with ID number ' . $ticket->id_ticket,
        ]);

        return redirect()->route('products.index')->with('success', 'Ticket created successfully.');
    }

    public function edit($id_ticket)
    {
        $ticket = Ticket::findOrFail($id_ticket);
        return view('pages.edit-addtickets', compact('ticket'));
    }

    public function update(Request $request, $id_ticket)
    {
        $request->validate([
            'id_ticket' => 'required|integer',
            'title' => 'required|string|max:255',
            'price_ticket' => 'required|numeric',
        ]);

        $ticket = Ticket::findOrFail($id_ticket);
        $ticket->update($request->all());

        Notification::create([
            'id' => Auth::id(),
            'type' => 'update',
            'message' => 'Updates have been made to product with ID number ' . $ticket->id_ticket,
        ]);

        return redirect()->route('products.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy($id_ticket)
    {
        $ticket = Ticket::findOrFail($id_ticket);
        $ticket->delete();

        Notification::create([
            'id' => Auth::id(),
            'type' => 'delete',
            'message' => 'A deletion has been made to product with ID number ' . $ticket->id_ticket,
        ]);

        return redirect()->route('products.index')->with('success', 'Ticket deleted successfully.');
    }

    // Fungsi Restore Tickets
    public function getDeletedTickets()
    {
        $deletedTickets = Ticket::onlyTrashed()->get();
        return view('pages.restore', compact('deletedTickets'));
    }

    public function restore($id_ticket)
    {
        $ticket = Ticket::withTrashed()->findOrFail($id_ticket);
        $ticket->restore();

        Notification::create([
            'id' => Auth::id(),
            'type' => 'restore',
            'message' => 'Data has been restored to product with ID number ' . $ticket->id_ticket,
        ]);

        return redirect()->back()->with('success', 'Ticket restored successfully.');
    }

    public function getTicketPrice($id_ticket)
    {
        $ticket = Ticket::find($id_ticket);
        if ($ticket) {
            return response()->json(['price_ticket' => $ticket->price_ticket]);
        }
        return response()->json(['error' => 'Ticket not found'], 404);
    }
}
