<?php

namespace App\Models;

use App\Models\Travel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = [
    ];

    public function travel(){
        return $this->belongsTo(Travel::class, 'travel_id', 'id');
    }
}
