<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function store(Request $request)
    {

        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
            $path = 'images/products/' . $imageName;
            $data['image'] = $path;
        }

        $product = Product::create($data);

        return response()->json($product, 201);
    }

    public function index(Request $request)
    {
        $query = $request->query('query');
        $productsQuery = Product::where('status', 1)->with('user', 'category', 'reviews', 'reviews.buyer');

        if ($query) {
            $productsQuery->where('category_id', $query);
        }

        $products = $productsQuery->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'category_id' => $product->category_id,
                'user' => $product->user->name,
                'name' => $product->name,
                'purchase_date' => $product->purchase_date,
                'condition' => $product->condition,
                'price' => $product->price,
                'description' => $product->description,
                'status' => $product->status,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'image' => $product->image ? url($product->image) : null,
                'reviews' => $product->reviews->map(function ($review) {
                    return [
                        'id' => $review->id,
                        'user' => $review->buyer->name,
                        'rating' => $review->rating,
                        'comment' => $review->comment,
                        'created_at' => $review->created_at,
                    ];
                }),
            ];
        });

        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id)->load('user', 'reviews', 'reviews.buyer');

        $productData = [
            'id' => $product->id,
            'category_id' => $product->category_id,
            'user' => $product->user->name,
            'address' => $product->user->address,
            'phone' => $product->user->phone,
            'name' => $product->name,
            'purchase_date' => $product->purchase_date,
            'condition' => $product->condition,
            'price' => $product->price,
            'description' => $product->description,
            'status' => $product->status,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
            'image' => $product->image ? url($product->image) : null,
            'reviews' => $product->reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'user' => $review->buyer->name,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at,
                ];
            }),
        ];

        return response()->json($productData);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            if (File::exists($product->image)) {
                File::delete($product->image);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
            $path = 'images/products/' . $imageName;
            $data['image'] = $path;
        }

        $product->update($data);
        $product->save();

        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }

    public function postByUser(Request $request)
    {
        $userId = $request->user()->id;
        $products = Product::where('user_id', $userId)->with('user', 'category')->get();

        $products = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'category' => $product->category->name,
                'user' => $product->user->name,
                'name' => $product->name,
                'purchase_date' => $product->purchase_date,
                'condition' => $product->condition,
                'price' => $product->price,
                'description' => $product->description,
                'status' => $product->status,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'image' => $product->image ? url($product->image) : null,
            ];
        });

        return response()->json($products);
    }
}
