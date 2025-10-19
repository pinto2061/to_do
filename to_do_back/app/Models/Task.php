<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'finish_date',
        'status',
        'category_id',
        'user_id',
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'id_municipio');
    }
}
