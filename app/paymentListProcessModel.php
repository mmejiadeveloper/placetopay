<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class paymentListProcessModel extends Model
{
    //
    protected $table = 'paymentListProccess';
    protected $primaryKey = 'codpayment';
    public $timestamps = false;
    protected $fillable  = [
        "requestId",
        "referenceValue",
        "status",
        "processUrl",
    ];
}
