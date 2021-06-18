<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Slotslist extends Model {

    protected $connection = 'mongodb';
    protected $collection = 'slotslist';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'n', 'desc', 'p', 'f', 'UID'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

}
