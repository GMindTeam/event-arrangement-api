<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResponseDetail extends Model
{
    //
    protected $fillable = [
        'responseid',
        'optionid',
        'answer' ,
    ];
}
