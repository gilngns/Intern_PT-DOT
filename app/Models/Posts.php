<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $table = 'post';

    protected $fillable = ['title', 'content', 'categories_id']; 

    public function category()
    {
        return $this->belongsTo(Categories::class, 'categories_id');
    }
}
