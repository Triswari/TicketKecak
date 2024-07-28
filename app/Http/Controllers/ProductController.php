<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Additional;

class ProductController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        $additionals = Additional::all();
        return view('pages.products', compact('tickets', 'additionals'));
    }
}
