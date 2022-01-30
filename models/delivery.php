<?php

class delivery
{
    public function __construct()
    {
        return true;
    }

    function getGeoJSON(){

        $file_path='/geojson/delivery.geojson';

        if(!empty($file_path)){
            $data=file_get_contents($_SERVER['DOCUMENT_ROOT'].$file_path);
        }
        else{
            $result['error'][]='No file geojson path';
            return $result;
        }

        if(!empty($data)){
            $result['GEOJSON'] = json_decode($data, true);
        }
        else{
            $result['error'][]='Empty file geojson';
            return $result;
        }


    return $result;
    }

    function updGeoJSON($data){
        $file_path=$_SERVER['DOCUMENT_ROOT'].'/geojson/delivery.geojson';
        file_put_contents($file_path, $data);
    }
}