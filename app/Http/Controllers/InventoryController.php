<?php

namespace App\Http\Controllers;

use App\DataTables\InventoryDataTable;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(InventoryDataTable $datatable)
    {
        if (!Auth::user()->can('read inventory')) {
            abort(403, 'UNAUTHORIZE');
        }
        $title = 'Inventory';
        return $datatable->render('admin.inventory', ['title' => $title]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'code' => 'required|max:255',
            'name' => 'required|max:255',
            'price' => 'required',
            'stock' => 'required|numeric|min:0',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['status' => 0, 'error' => $validatedData->errors()]);
        }

        $inventory =  Inventory::create([
            'name' => $request->name,
            'code' => $request->code,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return response()->json(['status' => 1, 'message' => 'Data Added successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        $inventory = Inventory::all();
        return response()->json(['inventory' => $inventory]);
    }
    public function showById($id)
    {
        $inventory = Inventory::find($id);
        return response()->json(['inventory' => $inventory]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $validated = Validator::make($request->all(), [
            'code_update' => 'required|max:255',
            'name_update' => 'required|max:255',
            'price_update' => 'required',
            'stock_update' => 'required|numeric|min:0',
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 0, 'error' => $validated->errors()]);
        }

        $inventory = Inventory::where('id',  $request->id)->update([
            'name' => $request->name_update,
            'code' => $request->code_update,
            'price' => $request->price_update,
            'stock' => $request->stock_update,
        ]);

        return response()->json(['status' => 1, 'message' => 'Updated Data successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Inventory::where('id', '=', $id)->delete();
        return response()->json(['status' => true, 'message' => 'Delete data Successfully!']);
    }
}
