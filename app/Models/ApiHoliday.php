<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiHoliday extends Model
{
    use HasFactory;

    public $api_key = '0a20ae64f61d46a583956c86895843ff';
    public $url = 'https://holidays.abstractapi.com/v1/';
    public $country = 'US';

    public function getHolidays($date)
    {
        $date = explode('-', $date);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];

        $url = "{$this->url}?api_key={$this->api_key}&country={$this->country}&year={$year}&month={$month}&day={$day}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}