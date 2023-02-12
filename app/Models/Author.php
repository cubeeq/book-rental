<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    public $fillable = [
        'name', 'surname', 'book_id'
    ];
    
    /**
     * Books relationship
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
