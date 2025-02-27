<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

use Exception;

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

        try {
            $response = @file_get_contents($url); // Usa '@' para evitar warnings en caso de fallo
            if ($response === false) {
                throw new Exception("Error al conectar con Google Geocode.");
            }

            $data = json_decode($response, true);

            // Verificar si la estructura del JSON es válida
            if (!isset($data['status'])) {
                throw new Exception("Respuesta inválida de Google Geocode.");
            }

            // Manejo de estados de respuesta
            switch ($data['status']) {
                case 'OK':
                    return [
                        'lat' => $data['results'][0]['geometry']['location']['lat'],
                        'lng' => $data['results'][0]['geometry']['location']['lng']
                    ];

                case 'ZERO_RESULTS':
                    throw new Exception("No se encontraron coordenadas para la dirección proporcionada.");

                case 'REQUEST_DENIED':
                    throw new Exception("La solicitud fue denegada. Verifica tu clave API.");

                case 'OVER_QUERY_LIMIT':
                    throw new Exception("Límite de solicitudes excedido. Intenta más tarde.");

                case 'UNKNOWN_ERROR':
                    throw new Exception("Error desconocido en la API de Google Geocode. Intenta de nuevo.");

                default:
                    throw new Exception("Error en la solicitud: " . $data['status']);
            }
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
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
            return ['error' => 'Parámetros inválidos: origen, destino o timestamp incorrecto.'];
        }

        $_origin = "{$origin['lat']},{$origin['lng']}";
        $_destination = "{$destination['lat']},{$destination['lng']}";

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$_origin&destinations=$_destination&key={$this->api_key}&units=imperial&arrival_time={$arrivalTimestamp}";

        try {
            // Evitar warnings en caso de fallo con @file_get_contents()
            $response = Http::get($url);
            if ($response->failed()) {
                throw new Exception("Error en la solicitud: " . $response->status());
            }

            $data = $response->json();

            // Validar estructura de la respuesta
            if (!isset($data['status'])) {
                throw new Exception("Respuesta inválida de la API de Google Distance Matrix.");
            }

            // Manejo de respuestas de la API
            switch ($data['status']) {
                case 'OK':
                    // Verificar si los datos están disponibles
                    if (
                        isset($data['rows'][0]['elements'][0]['status']) &&
                        $data['rows'][0]['elements'][0]['status'] == 'OK'
                    ) {
                        $distance = $data['rows'][0]['elements'][0]['distance']['text'];
                        $duration = $data['rows'][0]['elements'][0]['duration']['text'];

                        return [
                            'distance' => explode(' ', $distance)[0],
                            'duration' => $this->convertToMinutes($duration)
                        ];
                    } else {
                        throw new Exception("No se pudo calcular la distancia entre los puntos.");
                    }

                case 'ZERO_RESULTS':
                    throw new Exception("No hay rutas disponibles entre los puntos seleccionados.");

                case 'REQUEST_DENIED':
                    throw new Exception("La solicitud fue denegada. Verifica tu clave API.");

                case 'OVER_QUERY_LIMIT':
                    throw new Exception("Límite de solicitudes a Google Maps excedido. Intenta más tarde.");

                case 'INVALID_REQUEST':
                    throw new Exception("Solicitud inválida. Verifica los parámetros enviados.");

                case 'UNKNOWN_ERROR':
                    throw new Exception("Error desconocido en la API de Google. Intenta nuevamente.");

                default:
                    throw new Exception("Error en la solicitud: " . $data['status']);
            }
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }



    function convertToMinutes($timeString)
    {
        $total = 0;
        // Maneja días, horas, minutos, segundos
        preg_match_all('/(\d+)\s*(d|days|h|hour|hr|m|min|minute|s|sec)/', $timeString, $matches);
        foreach ($matches[1] as $key => $value) {
            $unit = $matches[2][$key];
            switch ($unit) {
                case 'd': case 'day': $total += $value * 1440; break;
                case 'h': case 'hour': case 'hr': $total += $value * 60; break;
                case 'm': case 'min': case 'minute': $total += $value; break;
                // Opcional: manejar segundos si es necesario
                case 's': case 'sec': $total += ceil($value / 60); break; 
            }
        }
        return $total ?: 0; // Asegura retornar al menos 0
    }
}
