<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    public $fillable = [
        'title', 'is_borrowed', 'author_id'
    ];

    /**
     * Author relationship
     */
    function author() {
        return $this->belongsTo(Author::class);
    }
}
