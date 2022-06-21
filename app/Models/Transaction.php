<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = [

    ];

    public function details(){
        return $this->hasMany(TransactionDetail::class, 'transaction_id', 'id');
    }

    public function travel(){
        return $this->belongsTo(Travel::class, 'travel_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
