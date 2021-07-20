<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['title', 'description', 'url'];
}
