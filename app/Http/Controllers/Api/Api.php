<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App;
use Carbon\Carbon;

class ApiController extends Controller
{

    public function checkSecret($secret){

        $tokens = DB::select('select * from api_tokens');

        for($i = 0; $i < sizeof($tokens); $i++){
            if($secret == $tokens[$i]->token){
                $today = date("Y-m-d");
                if($tokens[$i]->first_session == $today){
                    if($tokens[$i]->sessions < 1000){
                        // Aumentamos el numero de sesiones en 1
                        $counter = (int) $tokens[$i]->sessions;
                        $counter = $counter + 1;
                        DB::table('api_tokens')->where('token', $secret)->update(['sessions' => $counter]);
                        return true;
                    }
                } else {
                    // Ponemos el numero de sesiones a 1
                    DB::table('api_tokens')->where('token', $secret)->update(['sessions' => 1]);
                    // Ponemos al día de hoy la session
                    DB::table('api_tokens')->where('token', $secret)->update(['first_session' => $today]);
                    return true;
                }
            }
        }
        return false;
    }

    // Cambios de moneda

    public function allCurrencies($secret){

        $auth = true;

        if($secret != 'common_user'){
            $auth = $this->checkSecret($secret);
        }

        if($auth == true){
            $currencies = DB::select('select * from currencies');
            // return view('welcome', compact('currencies'));

            $data = array();
            for($i = 0; $i < sizeof($currencies); $i++){
                $info = $currencies[$i]->CURRENCY;
                $info1 = $currencies[$i]->EUR_TO_CURRENCY;
                $info2 = $currencies[$i]->USD_TO_CURRENCY;
                $data[$info] = array(
                    'Currency' => $info,
                    'Eur_to_currency' => $info1,
                    'Usd_to_currency' => $info2
                );
            }
            return $data;
        } else {
            echo "Token incorrecto o límite de peticiones alcanzado";
        }
    }

    // Ciudades con salario medio (para dibujar en el mapa)

    public function salaryCities($secret){

        $auth = true;

        if($secret != 'common_user'){
            $auth = $this->checkSecret($secret);
        }

        if($auth == true){
            $salaryCities = DB::select('select * from salaries');
            
            $data = array();
            for($i = 0; $i < sizeof($salaryCities); $i++){
                $info = $salaryCities[$i]->CITY_NAME;
                $info1 = $salaryCities[$i]->SALARY;
                $info2 = $salaryCities[$i]->QLI;
                $info3 = $salaryCities[$i]->LONGITUDE;
                $info4 = $salaryCities[$i]->LATITUDE;
                $color = '#ffffff';
                if((float)$info2 > 80) {
                    $color = '#0d9600';
                } else if((float)$info2 > 70){
                    $color = '#1de500';
                } else if((float)$info2 > 60){
                    $color = '#a7e300';
                } else if((float)$info2 > 50){
                    $color = '#f9fb00';
                } else if((float)$info2 > 50){
                    $color = '#ff9200';
                } else {
                    $color = '#ff4b00';
                }
                $data[$info] = array(
                    'City_name' => $info,
                    'Salary' => $info1,
                    'Qli' => $info2,
                    'Longitude' => $info3,
                    'Latitude' => $info4,
                    'Color_qli' => $color
                );
            }
            return $data;

        } else {
            echo "Token incorrecto o límite de peticiones alcanzado";
        }
    }

    // Buscar datos de una ciudad (y su salario medio)
    
    public function cityData($city, $country, $secret){

        $auth = true;

        if($secret != 'common_user'){
            $auth = $this->checkSecret($secret);
        }

        if($auth == true){
            $city_name = $city . ", " . $country;
            $cityData = DB::table('cities_data')->where('CITY_NAME', $city_name)->first();

            $info = $cityData->CITY_NAME;
            
            $info1 = 0;

            $salario = DB::table('salaries')->where('CITY_NAME', $city_name)->first();
            if($salario != null){
                $info1 = (float) $salario->SALARY;
            } else {
                $info1 = (float) $cityData->SALARY;
            }

            $info2 = (float) $cityData->INFRAESTRUCTURE;
            $info3 = (float) $cityData->ENVIRONMENT;
            $info4 = (float) $cityData->POLLUTION;
            $info5 = (float) $cityData->SAFETY;
            $info5 = 100 - (float) $info5;
            $info6 = (float) $cityData->QLI;
            $info7 = (float) $cityData->HEALTH;
            $info8 = (float) $cityData->WOMAN;
            $info9 = (float) $cityData->RENT;
            $info10 = (float) $cityData->LONGITUDE;
            $info11 = (float) $cityData->EMPLOYMENT;
            $info12 = (float) $cityData->DIVERSITY;
            $info13 = (float) $cityData->LATITUDE;
            $info14 = (float) $cityData->TRAFFIC;
            $info15 = (float) $cityData->PURCHASING;
            $info16 = (float) $cityData->CPI;
            $data[$info] = array(
                'City_name' => $info,
                'Salary' => $info1,
                'Infraestructure' => $info2,
                'Environment' => $info3,
                'Pollution' => $info4,
                'Safety' => $info5,
                'Qli' => $info6,
                'Health' => $info7,
                'Woman' => $info8,
                'Rent' => $info9,
                'Longitude' => $info10,
                'Employment' => $info11,
                'Diversity' => $info12,
                'Latitude' => $info13,
                'Traffic' => $info14,
                'Purchasing' => $info15,
                'Cpi' => $info16
            );

            return $data;
        } else {
            echo "Token incorrecto o límite de peticiones alcanzado";
        }
    }

    // Buscar los datos del país de la cuidad

    public function countryData($country, $secret){

        $auth = true;

        if($secret != 'common_user'){
            $auth = $this->checkSecret($secret);
        }

        if($auth == true){
            $country_data = DB::table('countries_data')->where('COUNTRY', $country)->first();
        
            $info = $country_data->COUNTRY;
            $info1 = (float) $country_data->SALARY;
            $info2 = (float) $country_data->CPI;
            $info3 = (float) $country_data->PURCHASING_POWER;
            $info4 = (float) $country_data->POLLUTION;
            $info5 = (float) $country_data->SAFETY;
            $info6 = (float) $country_data->TRAFFIC;
            $info7 = (float) $country_data->HEALTH;
            $data[$info] = array(
                'Country' => $info,
                'Salary' => $info1,
                'Cpi' => $info2,
                'Purchasing_power' => $info3,
                'Pollution' => $info4,
                'Safety' => $info5,
                'Traffic' => $info6,
                'Health' => $info7
            );

            return $data;
        } else {
            echo "Token incorrecto o límite de peticiones alcanzado";
        }
    }

    // Ciudades del mundo (Función de Autocompletar)

    public function worldCities($text, $secret){

        $auth = true;

        if($secret != 'common_user'){
            $auth = $this->checkSecret($secret);
        }

        if($auth == true){
            $cities = DB::table('world_cities')->where('CITY_NAME', 'like', $text.'%')->get();

            return $cities;
        } else {
            echo "Token incorrecto o límite de peticiones alcanzado";
        }
    }

    // Connection: Client ID: 1 Client secret: yBeFAW0xRAAgbkkFvzgUo6QKWmBDjC8GASgFc7q6
    // Connection: Client ID: 2 Client secret: MGxVsC8wwITUGfu0rvM7clo0PgtZI6jGlOVfFqlv
}