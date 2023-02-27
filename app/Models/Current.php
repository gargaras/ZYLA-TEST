<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Current extends Model
{
    use HasFactory;

    //protected $guarded =[];
    protected $fillable = [
        "observation_time",
        "temperature",
        "weather_code",
        "weather_icons",
        "weather_descriptions",
        "wind_speed",
        "wind_degree",
        "wind_dir",
        "pressure",
        "precip",
        "humidity",
        "cloudcover",
        "feelslike",
        "uv_index",
        "visibility",
        "is_day"
    ];

    public function locations(){
        return  $this->morphOne('App\Models\Location', 'locationable');
    }

}
