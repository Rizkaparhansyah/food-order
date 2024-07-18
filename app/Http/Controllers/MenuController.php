<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = [
            [
                'name' => 'Redvelvet',
                'image_url' => 'https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'description' => 'Delicious Redvelvet drink',
                'price' => '70.999',
                'original_price' => '99.999',
            ],
        ];

        $product = null;
        foreach ($products as $p) {
            if (stripos($p['name'], $query) !== false) {
                $product = $p;
                break;
            }
        }

        if ($product) {
            return response()->json([
                'status' => 'success',
                'product' => $product,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ]);
        }
    }
}
