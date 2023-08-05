<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class AllProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Products=Products::where('status', '=', '1')
                            //   ->where('rating', '>=', '3')
                            //   ->orderBy('created_at', 'desc')
                            //   ->limit(4)
                              ->get();
        return view('all_product')->with('Products', $Products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function fetchSortedProducts(Request $request)
    {
        // Get the selected sorting criteria from the query parameters
        $sortBy = $request->input('sort_by');
        $searchTerm = $request->input('search_term');

        // Perform database query based on the selected sorting criteria
        $query = Products::where('status', '=', '1');

        if ($searchTerm) {
            // If there's a search term, add a search condition to the query
            $query->where('category', 'like', "%$searchTerm%");
        }

        // Perform sorting based on the selected sorting criteria
        if ($sortBy === 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif ($sortBy === 'price_high') {
            $query->orderBy('price', 'desc');
        } elseif ($sortBy === 'newest') {
            $query->orderBy('created_at', 'desc');
        }

        // Execute the query and get the sorted products
        $products = $query->get();

        // Return the sorted product data in JSON format
        return response()->json($products->toArray());
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
