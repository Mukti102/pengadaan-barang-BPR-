<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcrumentRequest extends Model
{
    protected $guarded = ['id'];


    public  function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(Procrument_item::class);
    }

    public function approvals(){
        return $this->hasOne(Approvals::class,'procrument_request_id');
    }
}
