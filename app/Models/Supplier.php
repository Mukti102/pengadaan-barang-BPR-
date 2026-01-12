<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $guarded = ['id'];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function procrument(){
        return $this->belongsTo(ProcrumentRequest::class);
    }
}
