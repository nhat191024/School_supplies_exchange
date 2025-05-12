<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        Review::create([
            'bill_id' => $request->bill_id,
            'product_id' => $request->product_id,
            'buyer_id' => $userId,
            'seller_id' => $request->seller_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json('success', 201);
    }
}
