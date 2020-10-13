<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ad
 * @package App\Models
 */
class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
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
