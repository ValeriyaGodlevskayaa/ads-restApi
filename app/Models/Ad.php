<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function photos()
    {
        return $this->hasMany('App\Models\AdPhoto');
    }
}
