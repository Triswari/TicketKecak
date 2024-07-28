<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Additional;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class AdditionalsController extends Controller
{
    public function index()
    {
        $additionals = Additional::all();
        return view('pages.products', compact('additionals'));
    }

    public function create()
    {
        return view('pages.additionals');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_add' => 'required',
            'price_add' => 'required|numeric',
        ]);

        $additional = Additional::create($request->all());

        Notification::create([
            'id' => Auth::id(),
            'type' => 'success',
            'message' => 'A new product was successfully created with ID number ' . $additional->id_add,
        ]);

        return redirect()->route('products.index')->with('success', 'Additional created successfully.');
    }

    public function edit($id_add)
    {
        $additional = Additional::findOrFail($id_add);
        return view('pages.edit-additionals', compact('additional'));
    }

    public function update(Request $request, $id_add)
    {
        $request->validate([
            'id_add' => 'required|integer',
            'name_add' => 'required',
            'price_add' => 'required|numeric',
        ]);

        $additional = Additional::findOrFail($id_add);
        $additional->update($request->all());

        // Kirim notifikasi update
        Notification::create([
            'id' => Auth::id(),
            'type' => 'update',
            'message' => 'Updates have been made to product with ID number ' . $additional->id_add,
        ]);

        return redirect()->route('products.index')->with('success', 'Additional updated successfully.');
    }

    public function destroy($id_add)
    {
        $additional = Additional::findOrFail($id_add);
        $additional->delete();

        // Kirim notifikasi delete
        Notification::create([
            'id' => Auth::id(),
            'type' => 'delete',
            'message' => 'A deletion has been made to product with ID number ' . $additional->id_add,
        ]);

        return redirect()->route('products.index')->with('success', 'Additional deleted successfully.');
    }

    // Fungsi Restore Add
    public function getDeletedAdd()
    {
        $deletedAdd = Additional::onlyTrashed()->get();
        return view('pages.restore', compact('deletedAdd'));
    }

    public function restore($id_add)
    {
        $add = Additional::withTrashed()->findOrFail($id_add);
        $add->restore();

        Notification::create([
            'id' => Auth::id(),
            'type' => 'restore',
            'message' => 'Data has been restored to product with ID number ' . $add->id_add,
        ]);

        return redirect()->back()->with('success', 'Ticket restored successfully.');
    }

    public function getAdditionalPrice($id_add)
    {
        $additional = Additional::find($id_add);
        if ($additional) {
            return response()->json(['price_add' => $additional->price_add]);
        }
        return response()->json(['error' => 'Additional not found'], 404);
    }
}
