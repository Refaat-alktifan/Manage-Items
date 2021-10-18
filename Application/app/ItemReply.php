<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemReply extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tid' ,'name' , 'message','staff'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
     ];
}
