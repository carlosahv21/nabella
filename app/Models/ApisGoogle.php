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

        return array_slice(array_map(function ($prediction) {
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

    public function getDistance($origin = null, $destination = null, $arrivalTimestamp = null)
    {
        // Validar que los parámetros no sean nulos y tengan la estructura esperada
        if (
            !is_array($origin) || !isset($origin['lat'], $origin['lng']) ||
            !is_array($destination) || !isset($destination['lat'], $destination['lng']) ||
            empty($arrivalTimestamp)
        ) {
            return ['distance' => 0, 'duration' => 0];
        }

        $_origin = "{$origin['lat']},{$origin['lng']}";
        $_destination = "{$destination['lat']},{$destination['lng']}";

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$_origin&destinations=$_destination&key={$this->api_key}&units=imperial&arrival_time={$arrivalTimestamp}";

        $response = @file_get_contents($url); // Utiliza @ para evitar warnings si la API no responde

        if ($response === false) {
            return ['distance' => 0, 'duration' => 0]; // Manejo de error si la API falla
        }

        $data = json_decode($response, true);

        // Validar si la respuesta de la API es correcta
        if (
            isset($data['status']) && $data['status'] == 'OK' &&
            isset($data['rows'][0]['elements'][0]['status']) &&
            $data['rows'][0]['elements'][0]['status'] == 'OK'
        ) {

            $distance = $data['rows'][0]['elements'][0]['distance']['text'];
            $duration = $data['rows'][0]['elements'][0]['duration']['text'];

            $this->distance = explode(' ', $distance)[0];
            $this->duration = $this->convertToMinutes($duration);

            return ['distance' => $this->distance, 'duration' => $this->duration];
        } else {
            return ['distance' => 0, 'duration' => 0]; // Respuesta predeterminada en caso de error
        }
    }


    function convertToMinutes($timeString)
    {
        $totalMinutes = 0;

        // Expresiones regulares para extraer horas y minutos
        preg_match('/(\d+)\s*hour/', $timeString, $hoursMatch);
        preg_match('/(\d+)\s*min/', $timeString, $minutesMatch);

        if (!empty($hoursMatch)) {
            $totalMinutes += intval($hoursMatch[1]) * 60;
        }

        if (!empty($minutesMatch)) {
            $totalMinutes += intval($minutesMatch[1]);
        }
        return $totalMinutes;
    }
}