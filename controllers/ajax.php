<?php
require_once $_SERVER['DOCUMENT_ROOT']."/models/delivery.php";
$res=GetInput();

echo json_encode($res);




function GetInput()
{
    //if(!empty($_REQUEST))
   // {
        //if(function_exists($_REQUEST['task']))
        //{
            $data=getData();//filter_input_array(INPUT_GET, $_GET);
           // unset($data['task']);
            return call_user_func($data['task'],$data);
        //}
   // }
}

function getData() : array{
    $method=$_SERVER['REQUEST_METHOD'];
    $_vars=[];
    switch ($method){
        case 'GET':
            $_vars=requestGet();
            break;
        case 'POST':
            $_vars=requestPost();
            break;
    }
    return $_vars;
}

    function requestGet() : array{
        return $_GET;
    }
    function requestPost() : array{
        return json_decode($_POST['data'],true);
    }

function chng_deliveryzone_price($data)
{
    $model=new delivery();
    $arr= $model->getGeoJSON();
    $id=$data['id'];

    $filteredItems = array_filter($arr['GEOJSON']['features'], function($elem) use($id){
        return $elem['id'] == $id;
    });

    $key=current(array_keys($filteredItems));

    $arr['GEOJSON']['features'][$key]['properties']['price']=$data['price'];

    $model->updGeoJSON(json_encode($arr['GEOJSON']));

    $arr_n= $model->getGeoJSON();



    return $arr_n;
}