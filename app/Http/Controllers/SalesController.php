<?php

namespace App\Http\Controllers;

use App\DataTables\SalesDataTable;
use App\Models\Inventory;
use App\Models\Sale_detail;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SalesDataTable $datatable)
    {
        if (!Auth::user()->can('read sales')) {
            abort(403, 'UNAUTHORIZE');
        }
        $title = 'Sales';
        return $datatable->render('admin.sales', ['title' => $title]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->can('create sales')) {
            abort(403, 'UNAUTHORIZE');
        }
        $title = 'Sales';
        return view('admin.create-sales', ['title' => $title]);
    }
    public function cetak($id)
    {
        if (!Auth::user()->can('print sales')) {
            abort(403, 'UNAUTHORIZE');
        }
        $salesDetail = Sale_detail::with(['sale'])->find($id);
        $title = 'Sales';
        return view('admin.cetak-sales', ['title' => $title, 'sales_detail' => $salesDetail]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $validatedData = Validator::make($request->all(), [
            'inventory_id.*' => 'required|max:255',
            'qty.*' => 'required|max:255',
            'price.*' => 'required',
            'date' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['status' => 0, 'error' => $validatedData->errors()]);
        }
        $lastSales = Sales::latest()->first();

        if ($lastSales) {
            // Lakukan sesuatu dengan data terakhir, misalnya:
            $number = $lastSales->number + 1;
            // ...
        } else {
            $number = 0;
        }
        $arrayIdSales = [];
        foreach ($request->inventory_id as $key => $value) {
            $number++;
            $sales =  Sales::create([
                'number' => $number,
                'date' => $request->date,
                'user_id' => $userId,
            ]);
            Sale_detail::create([
                'sale_id' => $sales->id,
                'inventory_id' => $request->inventory_id[$key],
                'qty' => $request->qty[$key],
                'price' => $request->price[$key],

            ]);
            $arrayIdSales[] = $sales->id;
            $decrementInventory = Inventory::where('id', $request->inventory_id[$key])->increment('stock', $request->qty[$key]);
        }

        $detailSales = Sales::with(['user'])->where('user_id', $userId)->first();
        $arraySales = Sale_detail::with(['inventory'])->whereIn('sale_id', $arrayIdSales)->get();
        return response()->json(['status' => 1, 'detailsales' => $detailSales, 'arraysales' => $arraySales, 'message' => 'Data Added successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sales $sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sales $sales)
    {
        $validated = Validator::make($request->all(), [
            'inventory_id' => 'required|max:255',
            'qty' => 'required|max:255',
            'price' => 'required',
            'date' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 0, 'error' => $validated->errors()]);
        }
        $salesDetail = Sale_detail::where('id',  $request->id)->first();
        Inventory::where('id', $request->inventory_id)->decrement('stock',  $salesDetail->qty);
        $sales = Sales::where('id',  $salesDetail->sale_id)->update([
            'date' => $request->date,
        ]);
        $salesDetail->update([
            'inventory_id' => $request->inventory_id,
            'qty' => $request->qty,
            'price' => $request->price,
        ]);
        Inventory::where('id', $request->inventory_id)->increment('stock',  $request->qty);
        return response()->json(['status' => 1, 'message' => 'Updated Data successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Sales::where('id', '=', $id)->delete();
        $salesDetail = Sale_detail::where('sale_id', '=', $id)->first();
        Inventory::where('id', $salesDetail->inventory_id)->decrement('stock',  $salesDetail->qty);
        $salesDetail->delete();
        return response()->json(['status' => true, 'message' => 'Delete data Successfully!']);
    }
}
