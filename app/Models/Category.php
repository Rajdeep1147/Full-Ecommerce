<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public const ACTIVE ='1';
    public const DEACTIVE ='0';

    protected $fillable = [
        'name',
        'status',
        'slug',
        'image',
        'vehicle'
    ];
}
