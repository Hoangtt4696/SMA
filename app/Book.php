<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';

    protected $primaryKey = 'book_id';

    public $fillable = [
        'book_name',
        'book_price',
        'book_image',
        'book_description',
        'book_amount',
        'book_status',
        'book_data',
        'book_author',
        'book_year',
        'category_id'
    ];

    public function category(){
        return $this->belongsTo("App\Category", "category_id", "category_id");
    }
}
