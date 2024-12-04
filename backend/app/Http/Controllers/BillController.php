<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function store(Request $request)
    {
        $bill = Bill::create($request->all());
        return response()->json($bill, 201);
    }

    public function index(Request $request)
    {
        $authId = $request->query('auth_id', auth()->id());

        $billsQuery = Bill::with(['buyer', 'seller', 'product']);

        if ($authId) {
            $billsQuery->where(function ($query) use ($authId) {
                $query->where('buyer_id', $authId)
                    ->orWhere('seller_id', $authId);
            });
        }

        $bills = $billsQuery->get();

        return response()->json($bills);
    }

    public function show($id)
    {
        $bill = Bill::findOrFail($id);
        return response()->json($bill);
    }

    public function update(Request $request, $id)
    {
        $bill = Bill::findOrFail($id);
        $bill->update($request->all());
        return response()->json($bill);
    }

    public function destroy($id)
    {
        $bill = Bill::findOrFail($id);
        $bill->delete();
        return response()->json(null, 204);
    }
}
