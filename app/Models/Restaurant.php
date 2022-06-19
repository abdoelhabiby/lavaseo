<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use  HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $table = 'restaurants';


    protected $guarded = [];


    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s',strtotime($value));


    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s',strtotime($value));

    }


}
