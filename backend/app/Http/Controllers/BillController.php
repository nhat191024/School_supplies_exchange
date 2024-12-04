<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    public function store(Request $request)
    {
        $bill = Bill::create($request->all());
        return response()->json($bill, 201);
    }

    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $bills = Bill::where('buyer_id', $user_id)->with(['buyer', 'seller', 'product'])->get();
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
