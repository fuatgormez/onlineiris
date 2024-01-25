<?php
defined('BASEPATH') or exit('No direct script access allowed');


//bu kismi sonra kullanacam simdilik iptal

class Geoip
{
    protected $ip;

    function __construct()
    {
        $this->ip = $this->getVisIpAddr();
        if ($this->ip == "127.0.0.1" || $this->ip == "::1") {
            $this->ip = "80.187.108.223"; //Almanya Kodu
            // $ip = "91.132.139.117"; //Türkiye Kodu
            // $ip = "198.27.103.76"; //Canada Kodu
        }
        
        return $this->geolocalization( $this->ip );
    }

    public function geolocalization($ip = null)
    {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (isset($ipdat->geoplugin_countryCode)) {
            echo $ipdat->geoplugin_countryCode ;
        }
    }

    public  function getVisIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}
