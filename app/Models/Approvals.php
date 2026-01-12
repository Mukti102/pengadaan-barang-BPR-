<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approvals extends Model
{
    protected $guarded = ['id'];

    public function procrument(){
        return $this->belongsTo(ProcrumentRequest::class,'procrument_request_id');
    }

    public function approver(){
        return $this->belongsTo(User::class,'approved_by');
    }
}
