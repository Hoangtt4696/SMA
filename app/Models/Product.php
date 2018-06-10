<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Product extends Model
{
    protected $table = 'product_tbl';

    protected $dates = ['created_date', 'updated_date'];

    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';

    protected $fillable = [
        'name',
        'price',
        'picture',
        'description',
        'amount',
        'author',
        'publish_year',
    ];

    protected $rules = [
        'name' => 'required',
        'price' => 'required|numeric',
        'amount' => 'numeric|max:11',
        'publish_year' => 'numeric|digits:4'
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


    public function productType(){
        return $this->belongsTo(ProductType::class);
    }
}
