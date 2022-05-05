<?php

class Kladr
{
    private $api_key;

    public function __construct()
    {
        //$this->api_key = KLADRAPIKEY; //не понадобился
    }

    public function getStreet($street){
        $res=$this->request($street, "street", "2300000600000");

        return $res;
    }

    private function request($adress, $type, $cityid)
    {
        $res=[];
        $base_url = "https://kladr-api.ru/api.php?";
        $query_data = [
        //    'token'  => $this->api_key,
            'query'  => $adress,
            'contentType'   => !empty($type) ? $type : "street",
            'cityId' => !empty($cityid) ? $cityid : "2900000100000",
        ];
        $data_get = http_build_query($query_data);
        $url = $base_url.$data_get;
        //query=Ломоносова &contentType=street &cityId=2900000100000
       // $url="https://kladr-api.ru/api.php?query=Анапск&contentType=street&cityid=2900000100000&limit=5";

        $ch = curl_init();
        $defaults = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
            CURLOPT_HTTPGET => true,
            CURLOPT_TIMEOUT => 10,
        ];

        $curl = curl_init();
        curl_setopt_array($curl, $defaults);
        $response = json_decode(curl_exec($curl), true);

        $curlErrorNumber = curl_errno($curl);

        if ($curlErrorNumber) {
            $res['error']['msg'] = 'Error curl';
            $res['error']['uri'] = $url;
            $res['error']['curl_n'] = $curlErrorNumber;
            curl_close($curl);

        } else {
            $res = curl_exec($curl);
            curl_close($curl);
        }



        return $res;

    }
}