<?php

namespace App\Models;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Travel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = [

    ];

    public function galleries(){
        return $this->hasMany(Gallery::class, 'travel_id', 'id');
    }

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
}