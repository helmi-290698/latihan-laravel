<?php

namespace App\Http\Controllers;

use App\DataTables\PurchaseDataTable;
use App\Models\Inventory;
use App\Models\Purchase;
use App\Models\Purchase_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PurchaseDataTable $datatable)
    {
        $title = 'Purchase';
        return $datatable->render('admin.purchase', ['title' => $title]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Purchase';
        return view('admin.create-purchase', ['title' => $title]);
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
        $lastPurchase = Purchase::latest()->first();

        if ($lastPurchase) {
            // Lakukan sesuatu dengan data terakhir, misalnya:
            $number = $lastPurchase->number + 1;
            // ...
        } else {
            $number = 0;
        }
        $arrayIdPurchase = [];
        foreach ($request->inventory_id as $key => $value) {
            $number++;
            $purchase =  Purchase::create([
                'number' => $number,
                'date' => $request->date,
                'user_id' => $userId,
            ]);
            Purchase_detail::create([
                'purchase_id' => $purchase->id,
                'inventory_id' => $request->inventory_id[$key],
                'qty' => $request->qty[$key],
                'price' => $request->price[$key],

            ]);
            $arrayIdPurchase[] = $purchase->id;
            $decrementInventory = Inventory::where('id', $request->inventory_id[$key])->decrement('stock', $request->qty[$key]);
        }

        $detailPurchase = Purchase::with(['user'])->where('user_id', $userId)->first();
        $arrayPurchase = Purchase_detail::with(['inventory'])->whereIn('purchase_id', $arrayIdPurchase)->get();
        return response()->json(['status' => 1, 'detailpurchase' => $detailPurchase, 'arraypurchase' => $arrayPurchase, 'message' => 'Data Added successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
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

        $purchaseDetail = Purchase_detail::where('id',  $request->id)->first();
        Inventory::where('id', $request->inventory_id)->increment('stock',  $purchaseDetail->qty);
        $purchase = Purchase::where('id',  $purchaseDetail->purchase_id)->update([
            'date' => $request->date,
        ]);
        $purchaseDetail->update([
            'inventory_id' => $request->inventory_id,
            'qty' => $request->qty,
            'price' => $request->price,
        ]);
        Inventory::where('id', $request->inventory_id)->decrement('stock',  $request->qty);
        return response()->json(['status' => 1, 'message' => 'Updated Data successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Purchase::where('id', '=', $id)->delete();
        $purchaseDetail = Purchase_detail::where('purchase_id', '=', $id)->first();;
        Inventory::where('id', $purchaseDetail->inventory_id)->increment('stock',  $purchaseDetail->qty);
        $purchaseDetail->delete();
        return response()->json(['status' => true, 'message' => 'Delete data Successfully!']);
    }
}
