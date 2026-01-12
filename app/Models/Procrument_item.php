<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procrument_item extends Model
{
    protected $guarded = ['id'];

    public function requests(){
        return $this->belongsTo(ProcrumentRequest::class,'procrument_request_id');
    }
}
