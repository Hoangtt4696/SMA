<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Book extends Model
{
    protected $table = 'book';

    protected $primaryKey = 'book_id';

    protected $dates = ['book_date'];

    protected $dateFormat = 'Y-m-d H:i:s';

    public $timestamps = false;

    protected $fillable = [
        'book_name',
        'book_price',
        'book_image',
        'book_description',
        'book_amount',
        'book_status',
        'book_year',
    ];

    protected $rules = [
        'book_name' => 'required',
        'book_price' => 'required|numeric',
        'book_image' => 'required',
        'book_amount' => 'numeric',
        'book_year' => 'numeric|digits:4'
    ];

    protected $errors ;

    public function validate($data){
        $v = Validator::make($data, $this->rules);
        if($v->fails()){
            $this->errors = $v->errors();
            return false;
        }
        return true;
    }

    public function errors(){
        return $this->errors;
    }


    public function category(){
        return $this->belongsTo("App\Category", "category_id", "category_id");
    }
}
