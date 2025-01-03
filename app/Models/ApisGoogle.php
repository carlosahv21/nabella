<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApisGoogle extends Model
{
    use HasFactory;

    public $api_key = 'AIzaSyD5fI1XDVwgpIKBeoLXVnmCLLNPGazX3gE';

    public function getPlacePredictions($query)
    {
        $query = urlencode($query);
        $url = "https://maps.googleapis.com/maps/api/place/autocomplete/json?input=$query&components=country:US&key={$this->api_key}";

        $response = file_get_contents($url);
        $predictions = json_decode($response, true)['predictions'];

        return array_slice(array_map(function($prediction) {
            return $prediction['description'];
        }, $predictions), 0, 5);
    }

    public function getCoordinates($address)
    {
        $address = urlencode($address);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$this->api_key}";

        $response = file_get_contents($url);
        $data = json_decode($response, true);
        if ($data['status'] == 'OK') {
            return ['lat' => $data['results'][0]['geometry']['location']['lat'], 'lng' => $data['results'][0]['geometry']['location']['lng']];
        } else {
            return false;
        }
    }

    public function getDistance($origin, $destination, $arrivalTimestamp)
    {
        $_origin = "{$origin['lat']},{$origin['lng']}";
        $_destination = "{$destination['lat']},{$destination['lng']}"; 

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$_origin&destinations=$_destination&key={$this->api_key}&units=imperial&arrival_time={$arrivalTimestamp}";

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if ($data['status'] == 'OK' && $data['rows'][0]['elements'][0]['status'] == 'OK') {
            $distance = $data['rows'][0]['elements'][0]['distance']['text'];
            $duration = $data['rows'][0]['elements'][0]['duration']['text'];

            $this->distance = explode(' ', $distance)[0];
            $this->duration = explode(' ', $duration)[0];

            return array('distance' => $this->distance, 'duration' => $this->duration);
        } else {
            return array('distance' => 0, 'duration' => 0);
        }
    }
}