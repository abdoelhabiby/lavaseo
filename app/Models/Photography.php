<?php

namespace App\Models;


use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photography extends Model
{
    use  HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $table = 'photography';


    protected $guarded = [];


    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s',strtotime($value));


    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s',strtotime($value));

    }


    public function getPhotoAttribute($value)
    {
        $path = base_path("public") . "/" . $value;

        if (File::exists($path)) {
            return  url($value);
        }

        return null;
    }

}
