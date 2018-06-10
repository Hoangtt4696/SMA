<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Mockery\Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchTerms = (object)[];

        $searchTerms->fields = $request->query('fields')? explode(',',$request->query('fields')) : null ;

        $searchTerms->ids = $request->query('ids');
        $searchTerms->name = $request->query('name');
        $searchTerms->authors = $request->query('authors');

        try {
            $product = Product::query()
                ->when($searchTerms->fields, function ($query) use ($searchTerms) {
                    return $query->select($searchTerms->fields);
                })
                ->when($searchTerms->ids, function ($query) use ($searchTerms) {
                    return $query->whereIn('id', [$searchTerms->ids]);
                })
                ->when($searchTerms->name, function ($query) use ($searchTerms) {
                    return $query->where('name', $searchTerms->name);
                })
                ->when($searchTerms->authors, function ($query) use ($searchTerms) {
                    return $query->whereIn('author', [$searchTerms->authors]);
                })
                ->get();
            return response()->json($product, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
    }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = new Product();
        $data = $request->all();
        $book->fill($data);
        if(!$book->validate($data)){
            return response()->json($book->errors(),422);
        }

        try{
            $book->save();
        }catch (Exception $ex){
            return response()->json($ex->getMessage(),500);
        }

        return response()->json($book,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Product::with('productType:id')->find($id);
        if(!$book)
            return response()->json("Product not found",404);

        return response()->json($book,200);
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
        $book = Product::find($id);
        if(!$book)
            return response()->json("Data not found",404);

        $book->fill($request->all());
        if(!$book->validate($request->all())){
            return response()->json($book->errors(),422);
        }

        try{
            $book->save();
        }catch (Exception $ex){
            return response()->json($ex->getMessage(),500);
        }
        return response()->json($book,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Product::find($id);
        if(!$book)
            return response()->json("Data not found",404);
        try{
            $book->delete();
        }catch (Exception $ex){
            return response()->json($ex->getMessage(),500);
        }
        return response()->json("Delete success",200);

    }
}
