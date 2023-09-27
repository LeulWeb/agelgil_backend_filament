<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'thumbnail',
        'story',
        'endorsed'
    ];


    public function author(){
        return $this->belongsTo(User::class);
    }
}
