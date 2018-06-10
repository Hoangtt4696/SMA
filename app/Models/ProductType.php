<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'product_type_tbl';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';

    protected $dates = ['created_date', 'updated_date'];

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        name
    ];

    protected $rules = [
        'name' => 'required'
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

    public function product(){
        return $this->hasMany(Product::class, 'product_type_id');
    }
}
