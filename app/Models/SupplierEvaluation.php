<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierEvaluation extends Model
{
    protected $guarded = ['id'];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function procrumentRequest(){
        return $this->belongsTo(ProcrumentRequest::class);
    }

}
