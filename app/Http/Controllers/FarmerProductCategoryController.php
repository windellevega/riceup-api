<?php

namespace App\Http\Controllers;

use App\FarmerProductCategory;
use Illuminate\Http\Request;

class FarmerProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fpcategories = FarmerProductCategory::all();

        return response()->json($fpcategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
     * @param  \App\FarmerProductCategory  $farmerProductCategory
     * @return \Illuminate\Http\Response
     */
    public function show(FarmerProductCategory $farmerProductCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FarmerProductCategory  $farmerProductCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(FarmerProductCategory $farmerProductCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FarmerProductCategory  $farmerProductCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FarmerProductCategory $farmerProductCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FarmerProductCategory  $farmerProductCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(FarmerProductCategory $farmerProductCategory)
    {
        //
    }
}
