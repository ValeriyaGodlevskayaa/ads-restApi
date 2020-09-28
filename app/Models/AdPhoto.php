<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdPhoto extends Model
{
    use HasFactory;

    const MAIN_IMAGE = 1;

    protected $fillable = [
        'link',
        'main',
        'ad_id'
    ];

    public $timestamps = false;

    public function ad()
    {
        return $this->belongsTo('App\Models\Ad');
    }
}
