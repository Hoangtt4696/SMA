<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Mockery\Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Book::with('category:category_id,category_name')->get();
        return $products;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = new Book();
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
        $book = Book::with('category:category_id,category_name')->find($id);
        if(!$book)
            return response()->json("Data not found",404);

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
        $book = Book::find($id);
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
        $book = Book::find($id);
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
