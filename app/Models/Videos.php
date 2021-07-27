<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['categoryId', 'title', 'description', 'url'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Categories::class, 'categoryId');
    }
}
