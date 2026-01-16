<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
    'artist_id',
    'title',
    'description',
    'price',
    'pricing_type',
    'status',
];


    public function artist()
    {
        return $this->belongsTo(User::class, 'artist_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
