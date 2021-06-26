<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class PokerSessions extends Model {

    protected $connection = 'mongodb';
    protected $collection = 'pokersessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_id', 'user', 'session', 'time'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

}
