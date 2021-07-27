<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['title', 'color'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany(Videos::class, 'categoryId');
    }
}
