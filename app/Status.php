<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'status';
    
    protected $fillable = [
          'alias',
          'description'
    ];
    

    public static function boot()
    {
        parent::boot();

        Status::observe(new UserActionsObserver);
    }
    
    
    
    
}