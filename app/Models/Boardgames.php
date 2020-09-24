<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boardgames extends Model
{
    use HasFactory;

    protected $table = 'boardgames';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'negociation',
        'price',
        'condition',
        'edition',
        'language',
        'language_dependency',
        'description',
        'owner',
        'owner_contact',
        'wishlist',
    ];
}
